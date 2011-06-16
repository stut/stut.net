---
layout: "post"
title: "TweetMeme Live Test Video from April 2009"
time: 01:14:10
categories: 
- cool
- projects
- technology
---
The other day I was continuing my long-term quest to sort through all the flotsam and jetsam of accumulated crap on my hard drive when I came across the following video (click through if you don't see the video below). Recorded in April 2009, it shows the first version of the <a href="http://www.tweetmeme.com/">TweetMeme</a> Live functionality without any rate or minimum retweet restrictions. As you can see it moved pretty quickly.

<!--more--><p style="text-align:center;"><center><object width="500" height="405"><param name="movie" value="http://www.youtube-nocookie.com/v/IdzvCoNncgY&hl=en_US&fs=1&color1=0x3a3a3a&color2=0x999999&border=0"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube-nocookie.com/v/IdzvCoNncgY&hl=en_US&fs=1&color1=0x3a3a3a&color2=0x999999&border=0" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="500" height="405"></embed></object></center></p>

Bear in mind that these are unique URLs, not simply repeats of URLs already seen. Between seeing a URL in a tweet and it appearing on this page the system has followed any redirects, grabbed and parsed the contents of the page and stuffed it into a database, and it does it all in near-realtime. Pretty impressive stuff if you ask me.

The live functionality on <a href="http://www.tweetmeme.com/">TweetMeme.com</a> has now been removed, but it was great fun to develop and demonstrated the rate at which the site discovered and processed new URLs back in April 2009; you can bet the rate is far higher now given the explosion in the popularity of <a href="http://www.twitter.com/stut">Twitter</a> since then.

The implementation used long-polling requests connected to an nginx module which internally checked a queue for new items. While it didn't get a huge number of concurrent viewers during the time it was up on the site it scaled incredibly well for such a simple solution.

It's a shame that it's not available on the site anymore; it would be interesting to see how much the rate has increased in the past ten months.