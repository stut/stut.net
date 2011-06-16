---
layout: "post"
title: "Centralised Calendar"
time: 00:00:00
categories: 
- misc
---
I've recently been thinking that I need some sort of centralised calendar. I don't have a particularly scheduled life, but I'm finding more and more that there are dates I need to keep track of. In the past I've tried several options including PDAs, phones and for a little while I used a file-o-fax. Nothing stuck.

I'm really not sure why. They all did the job, but each had flaws or annoying habits that caused me to stop using them. PDA's tend to be bulky (relatively speaking) and are something extra to carry in addition to a phone. Phones have an extremely crap interface, especially when it comes to the calendar. Finally file-o-faxes are also bulky, are also something extra to carry around and, frankly speaking, are a bit old fashioned for me to be seen using!

The best solution I've found so far is <a href="http://www.backpackit.com/">Backpack</a> from <a href="http://www.37signals.com/">37signals</a>. I've been using it for a few months now and so far it's been perfectly usable as both a note-keeper and a calendar. However, it tends to be a bit slow, and since it's a web app there is no offline access to it.

Now I don't think I'm asking for a lot, and I can't believe nobody else has the same or very similar requirements. The basic requirements are centrally located, easily backed up and accessible from pretty much anywhere. For me this requires support for XP, Ubuntu Linux and OSX. Ideally it would also be accessible through a standard web browser (IE/Firefox minimum).

I already have this for my email using IMAP mailboxes and I use Thunderbird and SquirrelMail for access. It occurred to me that the IMAP protocol is ideally suited to accessing a calendar database, all it needs is a decent cross-platform client and a web interface.

A calendar item is stored in the IMAP account as a message. The title of the entry is stored in the subject header, the start date in the date header, other info in X-Cal-* headers and notes in the body. For example...

<code>Message-Id: &lt;20070806000000.167709E1844@stut.net&gt;
Subject: Mum's birthday
Date: Mon, 06 Aug 2007 00:00:00 +0000 (GMT)
From: cal@stut.net
To: cal@stut.net
Content-Type: text/plain
X-Cal-Duration: 1 day
X-Cal-Recurrance: 1 year
X-Cal-Status: normal
X-Cal-Signature: vkljsdhnfvlajksdhfgla8hi8aw4hwiwoafn4fnawh38</code>

Obviously there are lots of possible X-Cal-* headers, but you get the idea. Since it's IMAP you could also implement a Microsoft Exchange-like appointments system where other people can send items to your calendar with options for you to select from. That is one potential use for the X-Cal-Status header. The X-Cal-Signature is intended to contain an authentication value - clients will only trust certain other X-Cal-* headers (e.g. Status) if the signature is correct. This ensures that items coming in from unknown sources are handled appropriately.An alternative to this way of storing the data, the email format could be used to simply store information in the <a href="http://www.ietf.org/rfc/rfc2445.txt">iCalendar</a> format. To aid searching the mailbox it would be prudent to duplicate some information into the headers, specifically the date and title (subject).

As should be obvious from the discussion so far, one of my goals here is to create a system that needs nothing special on the server-side. This system should function perfectly well with any standard IMAP4 server. This puts a lot of responsibility on the client. For example, the message shown above is marked as recurring every 1 year. The client needs to handle creating future instances of this item. The way I currently see this happening is through a client preference that specifies how far into the future items will be created. Once the next instance of the above item has been created it would be modified to 'point' at that instance, thereby creating a chain from any given instance forwards in time and preventing duplicate future items from being created.

Of course, IMAP4 is not the only possible access protocol. Any protocol for accessing email should work, but IMAP does seem to be the best option for access from multiple locations. As far as clients go I'm thinking the easiest way might be to duplicate the IMAP part of <a href="http://www.mozilla.com/thunderbird/">Thunderbird</a> and modify that. That would mean all of the communications stuff, and the local data storage would already be done. The only thing needed would be a new interface.

The Mozilla project has a couple of <a href="http://www.mozilla.org/projects/calendar/">calendar-related projects</a> on the go. <a href="http://www.mozilla.org/projects/calendar/sunbird/">Sunbird</a> is their standalone offering, and <a href="http://www.mozilla.org/projects/calendar/lightning/">Lightning</a> is a plugin for Thunderbird. Both of these support remote calendars in the form of subscription (read-only, e.g. .ics files) and <a href="http://www.caldav.org/">CalDAV</a> (read/write). Unfortunately the read/write option, CalDAV, requires additional configuration of the server. While this is not a particular problem, I feel it will be a while before ISPs support it as ubiquitously as they support IMAP4 and POP3.

Interface-wise, Sunbird looks promising. It's a shame that didn't carry through to Lightning - it has several features that make is suck... badly. To mention just one element of suckage, possibly the most annoying suckiness, when you have it installed it forces the mailbox tree pane to a minimum width. Try to reduce it below that size and it snaps to the left, hiding the pane completely. Has the developer who decided that was reasonable behaviour never heard of scroll bars? That's all it really needs. Anyway, that's really not the point.

If you ignore the several sucky features, it's actually not that bad. So what I'm imagining is something that takes the IMAP module from Thunderbird and uses it as the data source for the Lightning plugin. I don't see that being particularly difficult, but unfortunately I lack the time to learn how Thunderbird is implemented, nevermind the time needed to implement that meld.

So I'm putting the idea out there. I'm not really expecting someone to read this and then dedicate their time to implementing it, I just thought it would be worth getting the thoughts written down so they stop spinning around my head. I'll keep using Backpack as it fits all of my essential requirements, and apart from being slow it's actually pretty funky - I suggest you check it out.

I have lots of thoughts like this spinning, so expect more posts like this as I slowly realise I'm never going to find the time to try them all. Can't promise they'll all be winners, but you never know!