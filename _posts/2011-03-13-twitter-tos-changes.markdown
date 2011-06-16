---
layout: "post"
title: "Twitter TOS changes"
time: 17:37:25
categories: 
- technology
tags: 
- twitter
---
A couple of days ago, Ryan Sarver of Twitter sent an <a href="https://groups.google.com/forum/?hl=en_US&pli=1#!topic/twitter-api-announce/yCzVnHqHIWo">email to the API developers mailing list</a> notifying us of changes to their <a href="http://dev.twitter.com/pages/api_terms">terms of service</a>. As per usual the community have exaggerated the implications of these changes to the point where it's now pure comedy. As has happened every time Twitter make any changes that may affect developers, developers are panicking, and for no good reason that I can find.

<!--more-->Techcrunch have put up an <a href="http://techcrunch.com/2011/03/12/from-businesses-to-tools-the-twitter-api-tos-changes/">excellent post highlighting the differences between the old and new terms</a>. Most of the changes are pretty straightforward, and make a reasonable amount of sense.

Part of the confusion was actually caused by the text of Ryan's email rather than the changes in the terms. I'll comment on that email after I've reviewed the TOS changes.

<h2>"businesses" => "tools"</h2>

This change, in the first paragraph of the terms, seems to have gotten everyone riled up. It's an interesting change of term, but I think it's simply clarifying Twitter's priorities. Their ultimate interest is in ensuring they themselves are profitable, whereas the previous wording implied they would do what they could to assist their partners in achieving that same goal.

This is about setting expectations, and I think they've done the right thing in making it clear where their priorities lie. They're not here to support your business, they're here to provide a platform that your tool can utilise. I don't criticise them at all for taking that position, and I applaud them for being explicit about it.

<h2>Developer responsibility</h2>

The previous terms were put in place at a time when a large number of applications were out there, all of which had been developed before there were any formal rules. The language in the third paragraph reflected that by using phrases like "If you are doing something prohibited by the Rules". These rules have now been out there for long enough that no application should still be breaking the rules.

By changing that text to "Don't do anything prohibited by the Rules" Twitter have forced developers to contact them for permission before they implement anything that might break the rules. This seems like a reasonable approach to rolling out the rules and enforcing them.

<h2>Content control (I4A)</h2>

It makes sense for Twitter to limit wrapper APIs that are then made available to the public. Restricting those APIs such that they can only serve IDs ensures that Twitter remains the only source for the actual content.

Unfortunately this extends to services that backup your tweets, since such tools would be covered by exporting to "a datastore ... or other cloud based service". However, this does appear to allow desktop tools that maintain local backups.

<h2>Trademark protection (I4D)</h2>

The scope of their marks not withstanding (the word tweet was first used by the community, not by Twitter), this is pretty standard stuff.

<h2>SMS access (I4F)</h2>

I'm not sure I see the thought behind the addition of this clause. I don't get how a premium-rate SMS service could harm Twitter's revenues unless they themselves are planning to start charging for it. I find it unlikely that such a move is in their roadmap.

<h2>The "Client" clause (I5)</h2>

This is the addition that has caused most of the confusion amongst the developer community. The essence of what they're doing here is protecting their current and future revenue streams.

They start by defining what they mean by a "Client", and it's really quite straightforward: they mean anything that provides a "standard" user experience. This would be a combination of showing the user's timeline, allowing them to post tweets, search, and basically anything else that's available within the web interface.

Let's look at each part in turn.

<blockquote>A. Your Client must use the Twitter API as the sole source for features that are substantially similar to functionality offered by Twitter. Some examples include trending topics, who to follow, and suggested user lists.</blockquote>

In other words, if you're going to show trending topics or follower suggestions you have to use the lists provided by the API so that promoted items are displayed, thus helping them get paid for the <strong>free</strong> access to the API that your app utilises.

This is somewhat unfortunate since it prevents clients from using their own algorithms to build this data, thereby preventing innovation. I'd like to see a modification that simply ensures that where such functionality is present, the Twitter-provided lists are used while not preventing the client from augmenting those lists if desired.

<blockquote>B. You may not pay, or offer to pay, third parties for distribution of your Client. This includes offering compensation for downloads (other than transactional fees), pre-installations, or other mechanisms of traffic acquisition.</blockquote>

Curious one this, since they're basically making sure that you can't use that stash of cash you sleep on at night to spread your app to the masses. Not sure they should be particularly worried about that. While there are several examples from the olden days where such strategies have worked, I'm having trouble coming up with a recent example.

<blockquoe>C. Your Client cannot frame or otherwise reproduce significant portions of the Twitter service. You should display Twitter Content from the Twitter API.</blockquote>

The point of this one is a little unclear. I think they're trying to ensure that clients don't pretend to be something they're not, and don't copy existing clients verbatim.

<blockquote>D. Do not store non-public user profile data or content.</blockquote>

User privacy is a hot topic for Twitter at the moment, and this clause simply enforces that attitude onto third-party developers. Essentially... don't be an arsehole!

<blockquote>E. You may not use Twitter Content or other data collected from end users of your Client to create or maintain a separate status update or social network database or service.</blockquote>

Shocker! They don't want you taking their data and creating a rival service. Unfortunately this probably prohibits gateways between Twitter and other networks which, while protecting user's reliance on their service, would slow uptake of a decentralised replacement system.

<h2>Content license (I6)</h2>

The data is ours, bitches, not yours; you are simply a conduit.

<h2>A "good partner" (II4)</h2>

This is essentially the same clause as I5A in that they're protecting their promoted item revenue streams. Any content retrieved via the API must be displayed as is without any changes.

And in clause F, another shock... if they think you're breaking the rules they'll kick you off.

<h2>No more warnings (V)</h2>

They've removed the thirty days notice of suspension/termination. While potentially annoying for applications with a large user base, the removal of this warning period and the opportunity to rectify any violations without losing access makes a lot of sense. The previous terms gave Twitter little room for immediately terminating access for a given app, regardless of what it was doing on the API.

The answer here is simple... don't do anything that breaks the rules and trust that the people at Twitter are just that... people. It's not in their interests to terminate access for any application unless it's doing something that threatens the privacy or platform stability for other users.

<h2><a href="https://groups.google.com/forum/?hl=en_US&pli=1#!topic/twitter-api-announce/yCzVnHqHIWo">Ryan's email</a></h2>

Ryan talks about a consistent user experience. The sentence "Twitter has to revoke literally hundreds of API tokens / apps a week as part of our trust and safety efforts, in order to protect the user experience on our platform" is quickly followed by a comment regarding clients using "comment" and "like" instead of "reply" and "favourite." Does this mean they'll revoke access for clients not using the official terms? This is not made clear, and no mention appears in the TOS.

He also talks about the way tweets are rendered. For me this is a key area of innovation. If all clients are required to render tweets in exactly the same way, what room is there for visual innovation? Again there is no mention of this in the TOS.

Ryan goes on to point out that most user interaction with Twitter happens via the website and the official clients, and that any developers considering building a client app that mimics or reproduces the "mainstream Twitter consumer client experience" should... not! Note that he doesn't say must not, and once more there is no mention of this in the TOS.

He says they will be holding developers of "client apps" to high standards to ensure that they "provide consistency in the user experience," but without the requirements being laid out in the TOS there is no way to know if you're meeting those high standards.

His ultimate goal appears to be to discourage developers from building client apps and instead to get them to build tools that do interesting things with the data. The implication here is that Twitter believe that the current clients are the pinnacle of usability and trying to make something better is a waste of time.

From a commercial point of view he has a point. Any new client app being released at this stage would need to be pretty damn phenomenal to gain any measurable user base, but rather than saying it that way Twitter have chosen to present a blanket discouragement of new clients.

The theory behind this email is logical, but I think the execution is wide of the mark. This is a shame and has led Twitter employees to field a range of questions from developers concerned about getting kicked off the API for a variety of reasons.

<h2>Summary</h2>

Developers using the Twitter API need to relax. Twitter are not out to get you, but they are a business, and you can't reasonably expect them to place your priorities above their own. At the end of the day they are providing you with <strong>free</strong> access to their platform, and that costs money.

Rather than getting your feathers all ruffled, how about appreciating the fact that they're being upfront and explicit regarding their policies (for the most part), which in turn provides a more stable environment in which to operate your business.

If you're still worried about it, don't build your business around Twitter.

Simples.