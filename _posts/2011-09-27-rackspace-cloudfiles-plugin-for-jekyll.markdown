---
layout: "post"
title: "Rackspace CloudFiles plugin for Jekyll"
categories:
- projects
- technology
tags:
- jekyll
---

I posted a few months ago about <a href="http://stut.net/2011/06/19/stut-net-now-powered-by-jekyll/">the conversion of Stut.net to Jekyll</a>. In that post I mentioned that I was planning to use it for a few other sites. One of those is <a href="http://stuartdallas.com/">my Photography site</a>, and that's where the requirement for this plugin came from.

If you're a regular reader you've probably noticed that most of the sites I design have very few images which only leaves Javascript and CSS assets. These tend to be limited in number and size, so the use of a CDN doesn't make much sense. The same can't be said for a photography site. Rather than manage this manually (ouch!) I decided to write a plugin to automate as much as possible.

<a href="https://github.com/3ft9/jekyll-rackspacecloudfiles">The plugin is up on GitHub</a>. It's a single file and is pretty simple, but I thought I'd lay out my thinking behind what it does and how it works.

These were my requirements...

* Implement a way of decorating the URLs so I can control which assets get pushed to the CDN rather than automatic processing of all assets
* As far as possible remove all caching issues
* Minimize operations and traffic to the CloudFiles service (both are charged by usage)
* Allow the use of a CNAME, otherwise use the CDN URL provided by CloudFiles
* Allow me to specify a prefix so I can organise the container
* Clean up any unused objects in the container that match the prefix
* Enable use of both the US and UK datacentres
* Allow the plugin to be disabled, and when disabled ensure that the generated site still works

The plugin implements a tag for the Liquid templating system called <tt>cloud_files</tt> which tells the plugin to process a filename and replace it with the CDN URL. That takes care of the second requirement.

It uses the SHA1 hash of the file contents as the filename while retaining the source file's extension. Since that means that changes to the file will change the filename, there won't be any caching issues.

The plugin keeps track of the files and SHA1 hashes that it has already uploaded which ensures it limits it's interactions with the server to those that are actually required. I've just realised there's an additional optimisation I can make here by fetching the list of existing objects on initialisation and consulting that instead of asking the server whether each individual object is there. That could potentially lead to unnecessary uploads, but is more likely to simply reduce the number of operations it performs.

You can configure a CNAME, and it will fall back to the CDN URL provided by CloudFiles. You can specify a prefix that will get added to the name of the object. You can specify the datacentre your account is on, and it defaults to the US.

You can disable the plugin which will simply return the text (the URL) that was passed in. To make this work I had to require that all URLs are absolute, meaning they start with a / and exist at that location relative to the Jekyll project directory. I don't see this as a great issue, but it's not ideal.

The only requirement I haven't yet met is that of cleaning up unused objects. There doesn't seem to be a way to have something run when Jekyll has finished generating the site. I've implemented the code that will do the cleanup, but it's useless and untested until I can find a way to call it at the right time.

Other than that it does everything I wanted. <a href="https://github.com/3ft9/jekyll-rackspacecloudfiles">Take a look</a> and <a href="http://twitter.com/stut">let me know what you think</a>.