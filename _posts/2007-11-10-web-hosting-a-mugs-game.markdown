---
layout: "post"
title: "Web hosting - a mugs game"
time: 04:06:26
categories: 
- technology
---

<blockquote>It is with great regret that I must inform you that SharedServer.net will cease trading at the end of this year. This has been a difficult decision to make, but for various reasons it is not practical to continue.</blockquote>
I wrote this in an email to my customers last weekend. After 10 years of running a web hosting service as "a hobby" I've decided that it's no longer practical to continue with it.  I've had several customers reply wanting to know why, most also saying that they were very happy with the service which is always nice to hear. I can't go into some of the reasons yet - I'll post those when I am able to - but hopefully the following will go some way to explaining my decision.<!--more-->

Let's start with a graph...
<p style="text-align: center"><img src="http://stut.net/blog/wp-content/uploads/2007/11/email-year.png" alt="Yearly email for SharedServer.net" /></p>
This shows the average number of emails processed sampled every 5 minutes. The green part is total emails, the blue line indicates how many of those were spam. As you can see there has been a gradual increase in spm over the past 4-5 months. What this graph doesn't show is the processing power needed to check these emails for viruses, spam and against several blacklists.

As should be obvious from the graph the current mail server was provisioned in early December 2006. For a while it was more than adequate for the load, but recently it's been showing signs of a breakdown.

Annoyingly I saw this coming a while ago and ordered a new server, but that didn't go as smoothly as I'd hoped.

Shortly after the server, called Dogbert for fairly boring reasons, was provisioned I had reason to reboot it. Unfortunately it did not come back up. After badgering the support desk for a while they admitted to me that their engineer had made a mistake when (s)he configured it, but don't worry it's all sorted now. Not a good sign.

A few weeks later, after installing my default software setup and moving my this blog and stut.net to it for testing purposes I got a text message from my monitoring systems telling me my site wasn't responding. I immediately jumped on to the server to find out what was wrong.

It turned out that the HDD had automatically re-mounted itself as read-only. If you know anything about websites you'll know this will cause some pretty major problems. In addition I found that /var/log/messages was now a binary file. To top it all off I found I couldn't run the reboot command because that expects to be able to write to a few places.

I googled around for a while and finally found a way to reboot a CentOS machine without needing write access to the filesystem so I was able to reboot the system. When it came back up nothing seemed damaged. Even /var/log/messages was back to normal and didn't seem to have lost any data. At this point I was very confused.

I told the host about this and they basically told me it was clearly a software problem. They apparently have lots of other servers running the same configuration as this one (SATA RAID 1 on CentOS 5) and they weren't having any problems, so it must be something I've done. If you ask me this screamed out "driver issue", but my opinion was ignored.

Not that I had much of a choice in the matter I decided to give them the benefit of the doubt and left it running just those two sites for a while longer. Shock horror - it did it again. I raised another support ticket, and again I was told it must be something I caused. I pushed... HARD... another option.

I got them to replace the RAID card. If they think it's a hardware issue then I need to prove to them that it's not. A few days after the new RAID card went in the same problem occurred again. Another ticket and another discussion centred around their position that it must be a software issue. They finally offered to replace all of the hardware - basically give me a new server. I think they thought this would prove their case once and for all. To me it would prove nothing if the problem recurred because it could still be a fundamental issue with the hardware/OS combination they're providing, but I went with it as there were no other options on the table.

So, with a new server and a lot of hours wasted re-installing everything I transferred this blog and stut.net again but again I didn't take it any further because I still didn't trust it enough. You'll never guess what happened a few days later.... yup, it happened again. I told the host again and they maintained that because they'd swapped out all the hardware this was definitely something I'd done. I fumed. I then started to look for a new host, and that's when I made a stupid mistake.

Rather than telling the host I no longer wanted this new server I went off to search for a new host in order to avoid having to move the blog and stut.net twice. I figured I'd find a new host quickly, get a new server up and running within a few days, transfer them over and then cancel it. Big mistake.

It took a while but I finally found a host I was happy to commit to. I came across Redstation first from Google and then later I found out that some friends had a fair few servers there and they were very happy with it. They weren't cheap but after the problems I'd been having I was more than happy to pay a bit extra to get decent support, so I placed an order. To my surprise they told me they'd order the server from Dell and it would arrive in 10-14 days. I took this as a mixed sign.

Firstly, and primarily, I was a little frustrated because I wanted to get it sorted quicker, but I was also encouraged that they didn't have a huge number of servers sitting around waiting for customers. This was a gut reaction and one I can't logically back up. For some reason I feel that's a sign of a host that isn't just a box-shifter. This partly explained why they're a bit more expensive than a lot of other hosts.

Anyway, about 2 weeks later the server arrived, they set it up and sent me the details. I was straight on there to get it set up. Almost immediatey I ran into a problem. My usual configuration steps involve changing the system settings (hostname, network stuff, setting up users and installing basic software like screen, bash, etc). After this I reboot the server. I know this is not actually necessary but it gives me a false sense of a cleaner server - it's just one of my odd habits. In addition it shows that the machine will be ok when it comes back after a failure that requires a reset.

So I did all that to Dilbert (yes, it's a theme now), rebooted it and waited patiently for it to boot. Nothing after 10 minutes - a definite sign that something is very wrong. On the positive side this gave me a chance to play with the DRAC that came with the server. The DRAC is the Dell Remote Access Card and this was the only host to offer it as a standard part of every server - I'm certain this saves them a lot of support calls. The DRAC provides a number of management services, but the core of it is a virtual console. This gives you a virtual keyboard, mouse and display to the server even when it's not responding - invaluable.

Using the DRAC I found out that the server was bootable off both hard drives, and the problem was down to it booting off the wrong one. Not being sure exactly how they'd set it up I raised my first support ticket with this new host. I got a response very quickly saying they'd looked, worked out what it was and fixed it. They also apologised for causing the problem - this was a new experience for me, I've never had a host apologise to me without anvil-shaped prompting.

Shortly after getting over the shock I finished configuring Dilbert and transferred the two sites without incident. Since then all has been well and I even started transferring customers over to Dilbert.

Which leads me back to the purpose of this post. Oh, hang on a minute, I forgot about Brian.

Brian is a server based in the US that I've had for over three years. He's a backup server mainly for DNS and MX but also for a number of critical files from other servers. I also have a couple of friends with accounts on him. Anyone with any experience with servers will know that over three years is a mammoth amount of time for a heavily used server to last without having harware issues, and you'd be right. The only problem I've ever has was with the hard drive running out of space, but even that was over two years ago. In an extraordinarily painful sequence of events... the hard drive failed a couple of weeks ago.

I woke up one morning to find a message from my monitoring system telling me Brian had stopped responding. I checked a few things to confirm this then raised a ticket with that host to get them to hit the reset button. About 20 minutes later I got a reply saying that someone had hit the button and it should be back up shortly. I waited... no response. I waited some more... still no response. This was starting to feel worryingly familiar. I asked the host to take a look, fully knowing that they would charge for this time if it turns out to be a software problem, but it had to be done.

They responded instantly which is a bit out of character for this host. The note simply said "I'm going to have a look now. I did notice the hard drive was making a loud clicking sound when I rebooted it".

You what? And this didn't seem important enough to investigate further? Or at the very least mention in your reply to the ticket? The mind boggles.

This is turning into a mammoth post, so the long story short is that the hard drive had completely failed and they recommended a replacement (free) and OS reinstallation ($65). I asked about data recovery but was told it was highly unlikely but they were happy to charge me an extortionate hourly rate to have a go with no guarantee of anything but a big fat bill. No thanks I said.

Brian did seem to recover himself for a while and I took the opportunity to transfer as much as possible over to Dilbert so very little data was lost, but it's still a pain in the rear end. Brian has now been cancelled - may he rest in peace for he served me very well right up to the end.

Dogbert has now also been cancelled, and after a fierce battle with the host I managed to get a fair chunk of what I'd paid refunded. Unfortunately I lost 3 months-worth because of my stupid mistake mentioned earlier.

The upshot of all that is the loss of any profits I was expecting to make this year have gone . . . and then some! On reflection I finally came to the realisation that the time and effort involved in running a small web host "as a hobby" is not worth the return, especially when things go wrong. My day job has been suffering because I've been preoccupied with keeping the hosting going and resolving these problems, and that has to end.

I'd like to finish by saying I've greatly enjoyed running SharedServer.net and will miss it a lot. I've met some fantastic people and I wish my customers all the best for the future. As mentioned in the email I sent all of the servers will be switched off on or soon after January 1st, 2008 after which point it will not be possible to access any of the data they contain. It is very important that you have all made alternative arrangements by that date allowing enough of a crossover for DNS changes to take effect.

I should also repeat that these server issues are not my only reason for this decision, but they were a big part of it. I can't talk about the other reason yet but stay tuned to this blog if you care.

As for me I have a few other things that will happily take up a lot of my spare time but I'm definitely looking forward to lightening my plate for at least a few months into 2008. If you're interested in what I have planned feel free to come back to this site often as this is where I will be discussing my future adventures.

Comments on SharedServer.net, good and bad memories and general slagging off of the shoddy service I have provided for the past ten years are welcomed and appreciated. It's been a wild ride.