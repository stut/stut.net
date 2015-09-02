---
layout: "post"
title: "PHP Job Queue"
time: 21:26:58
categories:
- misc
---
One of the pillars of a scalable website is ensuring that only activity which is required to build a page should be performed during the processing of a page request. Activities that fall under this category commonly include sending emails, recording statistics and general housekeeping such as removing temporary files.

Back when I started working on sites big enough for these activities to cause a problem I went down the obvious route of making a PHP CLI script for each job that needed doing and getting it to run using cron. This worked for a while but as the sites I was working on got bigger and more complex it quickly became clear that this was becoming difficult to manage, so I started to consider alternatives.

At the time all this happened I was mainly working with a site that ran on <a href="http://www.zend.com/en/products/platform/" target="_blank">Zend Platform</a>. One of the recent additions at the time was a module called <a href="http://www.zend.com/en/products/platform/product-comparison/job-queues" target="_blank">Job Queue</a> which appeared to do exactly what I needed. Unfortunately after spending a fair amount of time developing the infrastructure required to make it run the jobs I discovered that it really wasn't very well tested; it was far from production quality <a href="#fn1">[1]</a> and nowhere near reliable enough so I went back to the drawing board.

<h3>Time passes...</h3>

After thinking about what I needed from such a system and what I had available I came up with an architecture I've been using ever since with great success.

The core of the system is a DB table and a PHP script. The table contains the definition of jobs that need running and the script, erm, runs them.

I won't go into the details of the table because the only important parts as far as this system go are the run_at, processor_pid and schedule_* fields.

The <em>run_at</em> field is a timestamp that simply indicates the time when that job should be executed.

The <em>processor_pid</em> field is an unsigned integer that defaults to 0 and will indicate the process that's running a job if any.

The <em>schedule_*</em> fields specify how often the job should be executed. There are a number of ways of organising these depending on what your requirements are, but they fall into two general categories.

<ul>
	<li>
		<strong>Periodic only</strong><br />
		If you only need to say "run again in <em>n</em> seconds" then this is the one for you. Use a single field called <em>schedule</em> and put <em>n</em> in there.
	</li>
	<li><strong>Complex</strong><br />
		If you need something more flexible then you'll need to use a number of fields (or a single field you can parse) to specify how to calculate the next run_at time. For example a period (daily, weekly, monthly or anually) and a day/time field allows you to configure any of the following...
		<ul>
			<li>Every day at 10am</li>
			<li>Every Monday at 1am</li>
			<li>The 1st of every month at midnight</li>
			<li>Every year on February 14th at 8pm</li>
			<li>etc...</li>
		</ul>
	</li>
</ul>

Before I move on to the script I apparently need to cover something that I missed when I first wrote this. <strong>You need to specify what to run in this table!</strong> I though this was pretty obvious but based on initial feedback I was wrong.

This can take any number of forms and will depend greatly on your specific application. Over the years I've used a number of different methods including a PHP script name, a CLI command and a method in a static class. Whatever you use you'll want to make sure you do sufficient checks to ensure it's secure.

Ok, on to the script which is designed to be run by cron according to a schedule that allows it to keep up with the size of the job queue you anticipate.

The following is a list of the basic steps the script performs. For this example I'm continuing with the assumption that the job queue is a table in a database.

<ol>
	<li>
		Get the pid and put it in $pid.
	</li>
	<li>
		Execute this SQL query...<br />
{% highlight sql %}
update `job_queue`
set `processor_pid` = "$pid"
where `run_at` <= unix_timestamp()
  and `processor_pid` = 0
order by run_at asc
limit 1
{% endhighlight %}
	</li>
	<li>
		Check mysql_affected_rows() and exit if 0.
	</li>
	<li>
		Execute this SQL query...<br />
		<div style="padding-left: 1.5em; font-family: monospace;">
			select * from `job_queue`<br />
			where `processor_pid` = "$pid"
			order by `run_at`
			limit 1
		</div>
		Note that these SQL statements (step 2 and this one) atomically grab a job and lock it. If you're using a different storage system for your queue you'll need to lock it while you select a job to run and then mark it as in progress.
	</li>
	<li>
		Run the job. As mentioned already this can mean any number of things and will depend on your particular application. One of the useful things you can do here is to set up a clean, safe environment for the job to run in, along with ways to capture errors and other outputs so you can do something useful with them.
	</li>
	<li>
		As soon as the job has finished executing we mark it as completed and record the success or failure status.
	</li>
	<li>
		If the job has a schedule (i.e. it's a recurring job) we create a new job by effectively cloning the job we've just run. We now calculate the time it should be run according to the schedule definition and save that in the run_at field of the new job. Finally we set the <em>processor_pid</em> of the new job to 0 so it's then available to step 2 of this process.
	</li>
	<li>
		Depending on the job configuration and status we now either remove the completed job from the queue or archive it complete with errors and output for later inspection.
	</li>
	<li>
		If this processor has been running for > 60 minutes it exits, otherwise it goes back to step 2 and looks for another job to run.
	</li>
</ol>

To get this to do something useful we configure it to run via cron every <em>n</em> minutes where <em>n</em> depends upon the anticipated size of your job queue. For example running it every minute will automatically scale it up to 60 concurrent jobs at any one time. Running it every 5 minutes will reduce this to 12, and so on. There's also nothing stopping you putting more than one line into the crontab so it runs two processes every minute which increases concurrent processors to 120.

Assuming your job queue is network accessible this system also scales across multiple machines with minimal changes. In fact the only change that's required it to incorporate a machine identifier into the <em>processor_pid</em> field. This could be as simple as <em>&lt;machine&gt;_&lt;pid&gt;</em>; the key thing is that it's guaranteed to be unique to a given process across your entire infrastructure.

<h3>Crashed jobs</h3>

One problem you may need to deal with is how to handle crashed jobs. This will happen, you can't get away from it and you'll need a way to detect and deal with it when it does. Luckily the job queue makes detection fairly straightforward.

On a single machine you can implement a script (either run via cron separately or indeed run by the job queue) that will check that for each job that has a <em>processor_pid</em> > 0 there is a PHP process running with that PID.

If and when you've scaled across multiple machines this script essentially remains the same except that you need to run it on every machine that runs the job queue and filter the PIDs you check.

As far as what to do when you find a crashed job that's really something you need to consider on a case-by-case basis. At the very basic level the script could simply reset the <em>processor_pid</em> field to 0 so it gets run again. At the other end of the spectrum in a very flexible system you could have a way to run a job with a flag to indicate that it had previously crashed; each job can then deal with crashes in their own custom way.

<h3>Potential additions</h3>

The components described above is just the core of a job queue system; you can add a lot of useful stuff above and around it to make it easier to manage and provide better feedback from your periodic tasks.

<ul>
	<li>
		<strong>Performance metrics</strong><br />
		Since you're running all your jobs from a central script adding code around the actual execution to record execution time, load and possibly memory usage too is pretty simple. You then have the ability to compare the time a job took to previous executions of that job to detect potential errors.
	</li>
	<li>
		<strong>Management interface</strong><br />
		Since you have all the information regarding the jobs in the queue, what's running right now and the status of jobs that have previously been executed it's a pretty small leap to build a UI that will let you view and manage the whole thing. This can be especially useful for presenting error messages and performance metrics.
	</li>
</ul>

<h3>Final thoughts</h3>

I hope that's useful to someone, I've certainly found it applicable to most web applications I now deal with. As I mentioned a few times you can implement the various parts in a number of ways, in particular how jobs are specified and how the scheduling works.

As an example of this flexibility I'll make a passing mention to one implementation I've done that only needed to be able to execute scripts daily, hourly or every 15 minutes. To accomplish this I simply created a folder for the scripts, and three folders named <em>15min</em>, <em>hourly</em> and <em>daily</em> within that. The processor script uses a custom locking system and CLI arguments to run each set of scripts according the the directories they're in.

This system has proven to work very well and will continue to do everything that site needs until we need to execute something at a specific time; a requirement that has not yet surfaced.

One of the many side projects I'm working on is a reusable version of this system. At the moment it's a fairly messy combination of scripts that doesn't work very well so far, but as soon as I have something worth sharing I'll definitely do so on this blog. Stay tuned.

If you have an questions or suggestions for improvement please don't hesitate to leave a comment or <a href="/who#contact">contact me privately</a>.

<a name="fn1"></a> [1] <small>This was a few years back and I've heard that the Job Queue module has received some attention since then so is now a lot better, but I no longer use Zend Platform so I'm not in a position to comment. If budget is not an issue for you I'd recommend checking it out.</small>