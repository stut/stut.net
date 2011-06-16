---
layout: "post"
title: "Twitter unfollows: too much information?"
time: 00:54:19
categories: 
- misc
---
<img src="http://stut.net/wp-content/uploads/2009/01/dont-follow-me-sign.gif" border="0" alt="dont_follow_me_sign.gif" width="310" height="310" align="right" />A couple of days ago I released a new <a href="http://twitapps.com/">TwitApps</a> tool called <a href="http://twitapps.com/follows/">Follows</a>. I know I haven't talked about TwitApps on this blog yet - that post is coming - but if you <a href="http://twitter.com/stut">follow me on Twitter</a> you should be aware of it.

The Follows service monitors your followers on Twitter and sends you a daily, weekly or monthly email telling you who's followed and who's unfollowed you since your last email. Twitter itself has the facility to send you an email every time someone starts following you but does not offer any sort of notification when they stop.

I can see why Twitter have done it this way. When someone starts following you it's likely you'll want to check out their tweets and you might decide to follow them back. The same logic doesn't really apply to when people stop following you, or does it?
<!--more-->
I built the Follows service primarily as a technical exercise, but also because I was curious to get some visibility on people who stop following me.

A while back a service called <a href="http://useqwitter.com/">Qwitter</a> appeared on the scene that offered an unfollow notification service so I signed up. Unfortunately it stopped working shortly after that for unknown reasons, but in the few days while it did work it was quite enlightening. By paying attention to both follow and unfollow notifications it was possible to spot some interesting trends.

By a strange coincidence it would appear that shortly after I launched my Follows service Qwitter started working again, but so far it doesn't appear to be particularly reliable. It attempts to match an unfollow event to one of your tweets, effectively trying to find the cause of the action. This is daft primarily because there's not always a single reason why people stop following you but also because they can't possibly monitor your followers continuously - <a href="http://apiwiki.twitter.com/REST+API+Documentation#RateLimiting">the Twitter API has limits</a> that would prevent that - so it's likely the tweet they attribute the action to was not your latest tweet at the time.

Since Follows went live I've been keeping track of what people tweet about it and Qwitter and I've noticed some interesting behaviour in response to notifications.

Quite a few users react to people unfollowing them by calling them out with a public tweet asking them why. I can understand the desire to get an explanation but doing it publicly seems a bit ... well I dunno really, but it certainly isn't the best way to go about asking the question.

The other common reaction is the realisation that their self-esteem can't take being informed when people stop finding them interesting. Again I can understand this to a certain extent but it's not something you can take personally and remain well-balanced. It's the constant battle between the need for validation and the bliss of ignorance - part of the "human condition".

Another interesting side-effect has been some comments from other Twitterers to the effect that such a service is pointless and/or purely egotistical, but I'm convinced there's great value in getting visibility of the ongoing changes to your follower list.

I use the daily emails I get from Follows to do two things. First of all I check every new follower to see if it's worth following them back, just like I did when I was getting the individual notifications from Twitter but now I only do it once a day which is far more efficient.

The second thing I do is have a look at every ex follower and if I'm following them I consider whether it's worth continuing to follow them despite their decision to stop following me. I would never ask them about it because if someone has a problem with what I'm saying, whether it's frequency or content, I would hope they'd tell me about it. It's difficult to learn without feedback.

For me Twitter is not a popularity contest and it's not an ego broadcasting outlet. It's a conversation. If someone decides to stop following me I take that to mean they no longer want to participate in conversations with me. That's fine, but it doesn't necessarily mean I no longer want to participate in conversations with them, or that I'm no longer interested in what they have to say, but knowing they have made that decision is empowering.

What do you think? Do you see value in knowing if and when people stop following you or is it too much information?