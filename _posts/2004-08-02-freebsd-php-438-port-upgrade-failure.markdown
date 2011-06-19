---
layout: "post"
title: "FreeBSD: PHP 4.3.8 port upgrade failure"
time: 23:00:00
categories:
- misc
---
In his infinite wisdom the FreeBSD PHP4 port maintainer has decided to modify the way it gets installed (again!!). After breaking nearly every website on the server for a few minutes, I found the solution here: <a href="http://www.moundalexis.com/archives/000045.php" target="_blank">http://www.moundalexis.com/archives/000045.php</a>.

In short, edit the makefile in the port dir and remove the --disable-all from the configure flags. Then do the port upgrade.

That'll teach me to read the CHANGES file before upgrading.