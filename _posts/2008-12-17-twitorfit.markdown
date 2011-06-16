---
layout: "post"
title: "Twitorfit"
time: 11:39:13
categories: 
- cool
- projects
tags: 
- twitter
- php
- twitorfit
---
My latest project went live on Monday this week. It's another <a href="http://twitter.com/stut">Twitter</a>-based toy along the same lines as <a title="Are you hot or not?" href="http://www.hotornot.com/">hotornot</a> but it uses your Twitter account and profile picture. Since launch it's proved very successful and has spread quickly due to its viral nature.

The site is called <a title="Are you a twit or fit?" href="http://www.twitorfit.com/">Twitorfit</a> and was the brainchild of a Twitter-based conversation between <a title="What is this tech?" href="http://www.nickhalstead.com/">Nick Halstead</a> of <a title="Your news, your views" href="http://fav.or.it/">fav.or.it</a> and <a title="Huddle" href="http://www.huddle.net/">Andy McLoughlin</a> and <a title="Girl About Web" href="http://girlaboutweb.com/">Zuzanna Pasierbinska</a> from <a title="Huddle: Online Project Management, Group Collaboration and Document Sharing" href="http://www.huddle.net/">Huddle</a>. You can read the full story on the <a title="Twitorfit - the story" href="http://blog.twitorfit.com/2008/12/15/twitorfit-–-the-story/">Twitorfit blog</a>.
<p style="text-align: center;"><a style="margin-right: 2em;" title="Twtiorfit Screenshot by Stuart Dallas, on Flickr" href="http://www.flickr.com/photos/stuartdallas/3114896083/"><img src="http://farm4.static.flickr.com/3048/3114896083_0c58fbb68a_m.jpg" alt="Twtiorfit Screenshot" width="240" height="234" /></a><a title="Twitorfit Top 10 Screenshot by Stuart Dallas, on Flickr" href="http://www.flickr.com/photos/stuartdallas/3115725548/"><img src="http://farm4.static.flickr.com/3287/3115725548_7a9bbfd516_m.jpg" alt="Twitorfit Top 10 Screenshot" width="150" height="240" /></a></p>
<p style="text-align: center;"><em>Rate users then see the top 10 "twits" and "fits"</em></p>

Development of the site took a little under 20 man-hours in total from concept to launch including several rewrites of the core architecture. I'd like to thank <a title="Proton Gun" href="http://www.protongun.com/">Daniel Saxil-Nielsen</a>, the designer at fav.or.it, for sorting out the design and <a title="Alex Forrow on Twitter" href="http://twitter.com/alexforrow">Alex Forrow</a>, their sysadmin, for sorting out the live server. They both responded to my requests quickly and efficiently leaving me able to concentrate on getting the code done.

I'm hoping to do another post with a bit more detail about how Twitorfit works, and the specific techniques I used to ensure it would stand up to the initial peak in traffic that this type of project tends to get. For now I'll just say that it's written in <a title="PHP" href="http://www.php.net/">PHP5</a>, uses a <a href="http://www.mysql.com/">MySQL database</a> and <a title="Memcached" href="http://www.danga.com/memcached/">Memcache</a>. It's running on <a title="Sun Microsystems" href="http://www.sun.com/">Sun</a> hardware provided by the <a title="Sun Startup Essentials" href="http://uk.sun.com/startupessentials/">Startup Essentials program</a>.

The site currently asks for your Twitter username and password when you log in and/or register which is less than ideal, but until they <a title="OAuth on the Twitter API Issue Tracker" href="http://code.google.com/p/twitter-api/issues/detail?id=2">release their much-awaited OAuth implementation</a> it's the most user-friendly way to authenticate Twitter users. It does not store your password and aside from login verification and the optional tweet when you register it does not make any requests against the Twitter API as you.

In summary it's been a fun little project to work on, and the feedback so far has been fantastic. If you're not on Twitter yet you should be - <a title="Sign up for Twitter" href="https://twitter.com/signup">get your account here</a>, and when you're done be sure to <a title="Are you a twit or fit?" href="http://www.twitorfit.com/">register on Twitorfit and get rating</a>!