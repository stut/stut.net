---
layout: "post"
title: "Sessionless Sessions"
time: 20:11:47
categories:
- misc
tags:
- session
- php
---
Ok, so the title is a little misleading, but hopefully only until I explain what I mean. The first <i>session</i> refers to PHP sessions, and the second refers to the concept of sessions. Maybe it needs a little more explanation than that.

<h3>Do what?</h3>

There aren't many PHP applications (or indeed web applications) out there that don't need to maintain some form of user state between page requests. This functionality is commonly known as sessions, and most web development languages provide a built-in mechanism for managing them, and PHP is no exception. It's probably safe to assume that most people reading this probably know what sessions are and how they work, but I think it's worth taking a moment to spell it out.

The basic idea of sessions is to retain data between page requests without exposing that data to the client. The common way to do this is to store an ID in a cookie that gets passed between the browser and the server as part of every request. If cookies are unavailable then the ID can be added to all internal URLs as GET or POST variables. On the server site this ID refers to some sort of data storage, whether it be a file, a row in a database or an item in Memcache. To restore the session the application simply reads the data corresponding to the ID it's been passed, and when the request ends it writes it back with any changes.

Sessions time out in two ways. The cookie will usually live until the user closes their browser. Most implementations will also clean sessions from the server if they are not used for a period of time.

<h3>The issues</h3>

The default implementation of sessions in PHP (file-based) is perfectly adequate for most applications. However, as an application scales you will almost certainly need to spread the load across multiple servers which creates issues for session management.

One solution is known as sticky sessions. This is where the load balancer keeps track of which session ID's are on which server and routes subsequent requests accordingly. This creates a shedload more work for the load balancer and depending on usage patterns can lead to an uneven distribution of load.

Another solution is to store the session data in a shared resource such as a database or Memcache. This can create excessive load on that shared resource since sessions will generally be accessed on every page request. If you're lucky enough to need to scale beyond the point where a single database server can handle that load then you're looking at solutions such as sharding the sessions across multiple database servers and things start to look decidedly over-complicated. That's the problem that the architecture this post describes aims to solve.

<h3>Motivation</h3>

Last year (mid-late 2007) we were lucky enough to be faced these issues at <a href="http://uk.freeads.net/">Freeads Classifieds</a> so I set about finding a solution that would scale without causing further complications. My motivation was simple... I wanted a system that required near-zero maintenance, and a complex session management system was not going to help achieve that.

<h3>Analysis</h3>

I started with an analysis of how our application was using sessions. I should note that I inherited this site in early 2007. While it was pretty solid it was clear it had evolved rather than being designed and the way it was using sessions reflected this. I should also note that it's no longer like that!

The main points I emerged with were...

<ul>
	<li>A session is created whenever a user logs in.</li>
	<li>Most of the time there is very little data stored in the session.</li>
	<li>A lot of the data that's stored in the session is the same for all users.</li>
	<li>A lot of the data that's stored in the session is easily (and efficiently) obtained from other places.</li>
</ul>

It occurred to me that fundamentally the only thing the session actually needs to contain is the user ID. Everything else can be obtained from the database as needed. However, effective scalability requires that database usage is kept to a minimum, and this led me on to consider how user data is utilised while the user is browsing around the site.

As with most sites it has two distinct parts, the public site and the users area.

The public site has few user-specific data requirements.

<ul>
	<li>We show a small menu on every page when a user is logged in that includes the users name.</li>
	<li>The menu also states how many messages the user has and how many of those are unread.</li>
	<li>Various forms around the site are pre-filled with the users name, email address and phone number.</li>
</ul>

So that gives us a need for the users name, email address, phone number and message count for the majority of the site.

In the users area practically every page needs to access the database to provide CRUD functionality. The only thing that ties all that together is the user ID, so let's add that to our list.

I thought for a long time about whether there was any point in caching more in the session when in the users area, but I came to the conclusion that it wasn't worth it. If the session becomes too large then it has to be stored server-side rather than being passed with each request, and that takes us back to the issues discussed above. If we'd need to resort to storing the data in a database why not just get the data from where it normally lives rather than duplicating it?!

<h3>Implementation</h3>

So I now had a limited amount of data I wanted to store between page requests, all I had to do was figure out where. It didn't take long to realise that I could easily put it where PHP would normally put the session ID - a cookie. Note that you could also pass it as a GET or POST variable if required, but Freeads has always required cookies and it's never been a problem in the past.

Clearly the cookie needs to be encrypted - we don't want malicious users to be able to change its contents. For this I turned to the <a href="http://php.net/mcrypt">Mcrypt</a> extension. I'd used it before for server-side encryption and have found it to be reliable and performant so it ticked all the boxes.

My user implementation is a class, but I only intend to show some extracts. Hopefully it will be clear where stuff like <i>self::LoginTokenKey</i> and <i>self::TokenCookieName</i> are coming from.

{% highlight php startinline %}
public function CreateLoginToken()
{
	$iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
	$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
	$token = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, self::LoginTokenKey, serialize($GLOBALS['__USER__']), MCRYPT_MODE_ECB, $iv);
	Cookies::Set(self::TokenCookieName, base64_encode($token));
}
{% endhighlight %}

The encrypted value is not limited to printable characters so I base64_encode it before sticking it in the cookie. The global variable is an array containing 4 of the 5 data elements we need to store. The message count is the only part of the set that needs to be re-read on every page request so that's done via an AJAX request so that database hit doesn't delay the page; it's not critical information, so if it doesn't show it's not the end of the world.

The second parameter to <i>mcrypt_encrypt</i> is the key. This is what <i>secures</i> the encrypted data and should be a string that's non-trivial and ideally completely unrelated to your application. No I won't tell you what we use, but I'm certain you'll never guess it!

The other side of the equation is the decryption. If the cookie exists this method decrypts the data and stuffs it into the global var.

{% highlight php startinline %}
public function TokenLogin()
{
	$retval = false;
	$c = Cookies::Get(self::TokenCookieName);
	if (strlen($c) > 0)
	{
		$iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
		$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
		$userdata = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, self::LoginTokenKey, base64_decode($c), MCRYPT_MODE_ECB, $iv);
		$GLOBALS['__USER__'] = unserialize($userdata);
		if ($GLOBALS['__USER__'])
		{
			$retval = true;
		}
		else
		{
			unset($GLOBALS['__USER__']);
		}
	}
	return $retval;
}
{% endhighlight %}

Pretty simple stuff really.

<h3>The real world</h3>

Ok, so life's never that simple. In the real implementation I also store the current time in the data and apply a separate timeout when doing a TokenLogin. Actually it's not that simple either.

I've modified it to use two cookies. The first is basically the one shown above but if the user ticks the <i>Remember Me</i> option when logging in I set the expiry for this cookie to one year. This essentially means that if a user logs in, closes their browser and the returns to the site later it will appear as if they're still logged in. We've <i>remembered</i> them.

That's great but we don't want a remembered user to have access to certain parts of the site without verifying their password, so there's a second cookie that's created when they actually log in. I call it the authenticated cookie and it expires when the browser is closed or when the timeout it contains passes. If the user has been remembered and tries to create or modify ads, edit their profile or read/send messages they are asked for their password.

This functionality is pretty simple to implement so I won't bother posting the code here. The effect is to minimise the effort required from the user to make use of most of the site while still protecting the sensitive areas.

<h3>Summary</h3>

Personally I don't think there's anything ground-breaking here, it's simply a case of thinking more carefully about how you use sessions and in particular whether you actually need to store that huge array between requests. In my experience traditional sessions can get very large very quickly which tends to slow everything down, especially when you start using a shared resource to store that data between requests.

This implementation (or rather a few iterations beyond it) has been running on <a href="http://uk.freeads.net/">Freeads Classifieds</a> since March 2008 and we're yet to have any problems with it. Database utilisation is way down and the user experience is a lot slicker. All things considered I'm pretty happy with the way it works.

As always comments are appreciated. If anyone can see any holes in this or can think of ways to improve it <a href="http://stut.net/who#contact">I'd love to hear from you</a>.
