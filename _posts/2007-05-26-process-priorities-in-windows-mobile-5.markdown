---
layout: "post"
title: "Process priorities in Windows Mobile 5"
time: 17:48:53
categories: 
- misc
---
I've had several <a href="http://www.microsoft.com/windowsmobile/" title="Microsoft Windows Mobile">Windows Mobile</a> phones in my time, and I'm confused about a "feature" I've seen on every one that was running Windows Mobile 5. When it needs to play a notification sound it stutters if it's busy. This is most noticable when it's checking mail, because the notification comes as soon as it knows there is new mail, so it's still talking to the server.

I'm sure I don't fully understand the issues involved, but it seems to me that there is a fairly easily defined priority order for processes in a mobile phone. If I were designing an OS, user notifications would be right at the top of this list, and I would ensure that when a notification was needed it got whatever it needed to make it happen quickly. In addition I would make sure that depending on the nature of the notification the phone would be ready to deal with the users response. For example, if the notification was to ring because a call was incoming, the phone would be ready to answer it. Sounds obvious doesn't it?

Apparently not to the designers/developers of Windows Mobile 5. My current phone is the <a href="http://uk.samsungmobile.com/wcms/products/phones/phonedata/features/UK-SGH-I600.jsp" title="Samsung SGH-i600 Mobile Phone">Samsung i600</a>, and it suffers from this problem for both mail notifications and when ringing. Mail notifications stutter, and when it rings it can take a few seconds to respond to pressing the answer key.

It's nowhere near as bad on this phone as it was on my previous one. I used to have an <a href="http://www.clubimate.com/t-DETAILS_JASJAR.aspx" title="iMate JasJar PDA and Mobile Phone">iMate JasJar</a>, and in every possible way it was the best PDA I'd ever had, but as a phone it really sucked. I missed a fair number of calls because it didn't respond quickly enough when I went to answer it. This was not helped by the very short and unchangable period of time <a href="http://www.orange.co.uk/" title="Orange">Orange</a> allowed for a call to be answered. I'd estimate that 3 in 5 calls would time out at the network end and get forwarded to the voicemail before the phone managed to answer it.

I've never come across problems like this with any other phone I've had. Maybe it's a side-effect of the way Windows Mobile was developed, but to me it's fundamental that a phone performs the job of being a phone well, and it's also pretty important that user notifications happen when they get triggered, and that it responds quickly to the users reaction to those notifications.

I've not seen Windows Mobile 6 in action yet, but here's hoping they've improved things.