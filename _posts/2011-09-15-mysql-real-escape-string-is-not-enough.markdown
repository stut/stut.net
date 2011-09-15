---
layout: "post"
title: "mysql_real_escape_string is not enough"
categories:
- technology
---

Most developers worth their income knows this already, but I've never seen it explained as well as it was by Alex Nikitin on the PHP-General mailing list yesterday.

<blockquote>
This was fine in the days of ASCII, but the tubes are hardly ASCII anymore, with Unicode, UTF-16, i have 1,112,064 code points, they are not even called characters anymore, because they really aren't. And if you are familiar with best-fit mapping, you would know that there are now dozens of characters that can represent any single symbol in ASCII, meaning that using the above type of blocking mechanisms is silly and technically insecure.
</blockquote>

Alex goes on to suggest a couple of ways around this problem, so the full email is well worth reading: <a href="http://marc.info/?l=php-general&m=131603743606025&w=2">http://marc.info/?l=php-general&m=131603743606025&w=2</a>
