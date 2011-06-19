---
layout: "post"
title: "PHP Snippet: Array element access"
time: 11:03:28
categories:
- technology
tags:
- php
- snippet
---
A common logic pattern that's seen when dealing with GET and POST parameters in PHP is to check whether the array element exists, then set another variable to that or a default. It usually looks something like this...

<pre class="brush: php">
$var = (isset($_GET['var']) ? $_GET['var']) : '');
</pre>

If you don't develop with notices turned on (WHICH YOU SHOULD!) you probably haven't seen the problem that this code gets around. Simply referring to <code>$_GET['var']</code> will produce a notice if it does not exist.

Code littered with the example above does not aid readability. To work around this I define a simple function that I use instead of the above block. I call it <code>V</code> but it is more commonly known as <code>ifsetor</code>.

<pre class="brush: php">
function V(&$a, $e, $d = '')
{
  return (isset($a[$e]) ? $a[$e] : $d);
}
</pre>

Using this function, the above example looks like this...

<pre class="brush: php">
V($_GET, 'var', '');
</pre>

And you can actually drop the last parameter because the default default is an empty string.

This can be used with any array, whether one of the superglobals or user-defined.