---
layout: "post"
title: "Remove MSN Messenger from XP"
time: 23:00:00
categories: 
- misc
---
 MSN Messenger comes installed on Windows XP. You can tell it not to load at startup but whenever Windows Update does anything it has a nasty habit of reappearing. Running the following command (Start -&gt; Run) will reportedly remove it for good.
<blockquote><code>RunDll32 advpack.dll,LaunchINFSection %windir%\INF\msmsgs.inf,BLC.Remove</code></blockquote>
I ran it just now and it appeared to do something but I'm yet to be convinced that it will not reappear next time I install an update (shouldn't have to wait too long).