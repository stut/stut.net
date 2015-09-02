---
layout: "post"
title: "OAuth and Twitter: Realistic expectations"
time: 19:43:37
categories:
- grr
- technology
---
<div style="float:right;background-color:black;color:white;padding:4px;margin-left:1em;margin-bottom:0.25em;text-align:center;"><a href="http://www.flickr.com/photos/7913872@N03/2964858067" title="View 'Closed, keep off' on Flickr.com"><img src="http://farm4.static.flickr.com/3144/2964858067_fc3af26d40_m.jpg" alt="Closed, keep off" border="0" width="240" height="160" align="right" /></a></div><a href="http://twitter.com/">Twitter</a> promised OAuth support a l-o-o-ong time ago, and it would appear to finally be here. <a href="http://al3x.net/">Alex Payne</a> sent a "<a href="http://groups.google.com/group/twitter-development-talk/browse_thread/thread/42486bd3d7d136d0/f0e89b742bf0033e?show_docid=f0e89b742bf0033e&pli=1">Call for OAuth beta participants</a>" to the developers list yesterday and had an overwhelming response. This predictably triggered a deluge of tweets and blog posts, but the one that caught my eye was on <a href="http://www.readwriteweb.com/">ReadWriteWeb</a> titled "<a href="http://www.readwriteweb.com/archives/why_twitters_new_oauth_matters.php">Why Twitter's New Security Solution Could Pave the Way to a Future Web of Mashups</a>".

A number of things disturbed me about this post so I posted <a href="http://www.readwriteweb.com/archives/why_twitters_new_oauth_matters.php#comment-124285">a comment or two</a> but I believe the issues involved deserve more attention.

First of all the post asserts that sharing our Twitter password with other websites and applications "makes a lot of us very uncomfortable". If doing that makes you feel uncomfortable, don't do it. And this is my main criticism regarding this post. OAuth is being hailed as a solution to sharing your password with third parties, and it is, but it doesn't protect your account once you've given a third party access. And surely the more important message is that if you care at all about the security of your Twitter account you should not be sharing your password with anyone but the Twitter site, an even then only after you've checked and double-checked that you're on the actual Twitter site.

OAuth partially solves the problem in that third parties don't get your password, but they still get access rights to your account. They'll still be able to read your direct messages and post tweets and direct messages on your behalf.

The point here is that even with OAuth you are still giving a third party access to your account albeit slightly more limited access. We're yet to see any details regarding the Twitter implementation of OAuth, and a lot will depend on how fine-grained the permissions system is and how their side of the user experience looks and works, but I think my point is easier to explain with an analogy.

<div style="float:left;background-color:black;color:white;padding:4px;margin-right:1em;margin-bottom:0.25em;text-align:center;"><a href="http://www.flickr.com/photos/7913872@N03/481929512" title="View 'Online 2' on Flickr.com"><img src="http://farm1.static.flickr.com/172/481929512_f76fa4d5c9_m.jpg" alt="Online 2" border="0" width="240" height="149" align="left" /></a></div>The common analogy used with OAuth is that of a valet key for your car. These are special keys that only allow your car to be drive a few miles at most - just enough to be parked and then brought back to you, essentially giving limited access to the valet. However, consider that you're still leaving your car with the valet unattended for maybe a few hours. They can get into the car. They can drive it on to a car transporter. They can then take it anywhere they want where they can take it apart to disable whatever security you have until they get full access. You've not made your car "secure", you've limited the damage that can be done and made it harder to take it away from you, but if they're determined you still may never see your car again.

Ok, so the analogy doesn't completely work since you can't take a persons Twitter account away with OAuth and gain full access given enough time, but the basic point remains. You're still giving someone access to your account therefore implying you trust them.

This is known as security theatre which is another way of saying it gives people the illusion of security where the benefits are actually minimal.

OAuth comes with risks as well as benefits, and these are rarely covered. Let's say I'm a "bad guy" and I want to collect Twitter users passwords. Pre-OAuth it's pretty easy, you just come up with a viral application and work hard to get people using it. Post-OAuth it's a little more difficult but how much more depends on how Twitter have imlemented it.

<div style="float:right;background-color:black;color:white;padding:4px;margin-left:1em;margin-bottom:0.25em;text-align:center;"><a href="http://www.flickr.com/photos/7913872@N03/2965707606" title="View 'Just fishin'' on Flickr.com"><img src="http://farm4.static.flickr.com/3014/2965707606_ab1b2255fc_m.jpg" alt="Just fishin'" border="0" width="240" height="160" align="right" /></a></div> Let's take the worst-case scenario in which Twitter have used a plain login page for OAuth authentication. I as the "bad guy" write my application so it appears to be taking users to Twitter to authenticate, but in actuality the login page is still on my website. It looks like Twitter, it acts like Twitter, and most enough users will believe it's Twitter to make it work. Once they enter their username and password I can simulate a login against the actual Twitter site to confirm they're correct, store them away and take the user to my application just as if they'd signed in on the real Twitter site.

The simple fact that OAuth redirects the user to the Twitter site for authentication allows this phishing attack to be pretty successful.

Now, Twitter can prevent this from happening using a personalisation feature such as allowing the user to upload a secret image that's then shown to them on the login page. Because only Twitter has that image when a user sees that they know they're on the real site - various OpenID providers use this system. Let's hope Twitter has implemented something similar.

Ok, so having read all that you might get the impression I'm anti-OAuth. I'm certainly not. I believe that OAuth will be a great thing for Twitter, but I feel it's important that all the coverage it's getting also highlights that there's still trust involved between the user and the third party. It's about setting realistic expectations, because believing something is secure can be far more dangerous than it actually being insecure.

I've been accepted into the OAuth private beta and I'm excited to see what Twitter have implemented.

Finally I just want to state that I have great respect for Marshall Kirkpatrick and the work he does over at RWW. I wish I could blog as often as he does and stay interesting. Maybe in 2009 I should try it. Hmmm...