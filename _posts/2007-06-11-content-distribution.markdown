---
layout: "post"
title: "Content distribution"
time: 21:26:51
categories: 
- misc
---
A little while ago I mentioned a Google Tech Talk by Van Jacobson describing <a href="http://stut.net/blog/2007/05/06/linkdump-may-6th-2007/" title="Linkdump - May 6th, 2007">a new way to look at networking</a>. It got me thinking about content distribution on a whole new level.
<p align="left">The basic idea is to treat data as packets. For example, the front page of the BBC News homepage would be given a unique identifier when updated by the BBC, kinda like a URL but unique forever. It would be signed by the BBC in such a way that its source and contents could be verified such that you can trust that it came from the BBC. That chunk of data can then be copied and stored by any server on the internet. This means that requests don't end up at the source server unless it's very new or relatively old, thus removing the so-called slashdot effect.</p>
I <strong>love</strong> this idea, but I think it's going to be a very hard sell to the corporations who create and control the content. The current war between those corporations and peer-to-peer technologies shows the lengths companies are willing to go to in order to protect their product. Are they really going to be happy just putting their content out there and losing that control? I don't think so.

On the other hand I think there are a great many publishers, both big and small, who would see this as a great opportunity. I hope it the research continues - I can easily see this being the future of content distribution.