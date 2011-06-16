---
layout: "post"
title: "PHP Output Speed"
time: 23:00:00
categories: 
- misc
---
Over the past few days there's been some discussion on the <a href="http://php.net/mailing-lists.php">PHP-General mailing list</a> about the relative performance of the different ways of outputting HTML. In an attempt to answer that question I created a <a href="http://dev.stut.net/phpspeed/">PHP speed test</a> that outputs the same table using several different methods.

From the discussions that followed, and from other people trying the script on their own servers, the general conclusion that was reached is that the performance is affected more by the server load, connection speed and other coding differences than it is by the method of output used.

I would have liked to see a bit more consistency between the different methods as far as the bytecodes produced by the Zend Engine, but I'm guessing it's not that intelligent for performance reasons. If you were using a bytecode cache such as <a href="http://pecl.php.net/package/APC">APC</a> it would be better to normalise the various different methods at compilation time, but considering most servers don't use such extensions it makes sense not to waste the time. Ideally the ZE would have an option to enable further optimisation so that bytecode caches can be used to greater effect, but that's not likely to happen.