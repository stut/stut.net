---
layout: "post"
title: "Where are these backslashes coming from?"
time: 21:08:14
categories: 
- misc
tags: 
- php
---
Are you seeing backslashes (\) being inserted before quotes in the data you're using? Have you "solved" the problem using <a href="http://php.net/stripslashes">stripslashes</a>? Do you want to know where these are coming from and how to stop it? Of course you do... read on!
<!--more-->

<h2>What's causing it?</h2>

There is a configuration option called <a href="http://php.net/info#ini.magic-quotes-gpc">magic_quotes_gpc</a> that is, for historic reasons, <em>on</em> by default. It's this option that's causing the backslashes. It effectively runs the <a href="http://php.net/addslashes">addslashes</a> function on all GET, POST and COOKIE data.

The reason for this is that many years ago this was the recommended way to escape incoming data before sending it to a SQL database. Having it done automatically could be seen to be useful. Personally I hate it - I'd rather know what's happening to the data I'm dealing with and not rely on the server being configured in a certain way.

<h2>How do I stop it?</h2>

The simple answer is to turn magic_quotes_gpc off. Unfortunately not everyone has the luxury of being able to do that so the following chunk of code can be placed at the top of any file to check for and undo the addslashes on the GET, POST and COOKIE superglobals. This is pretty-much required to write run-anywhere PHP scripts.

<pre name="code" class="php">if (get_magic_quotes_gpc()) {
  function stripslashes_array($array) {
    return  is_array($array)
           ?
            array_map('stripslashes_array', $array)
           :
            stripslashes($array);
  }  

  $_COOKIE = stripslashes_array($_COOKIE);
  $_FILES = stripslashes_array($_FILES);
  $_GET = stripslashes_array($_GET);
  $_POST = stripslashes_array($_POST);
  $_REQUEST = stripslashes_array($_REQUEST);
}</pre>

Rather than placing this in every file I'd recommend putting it in a separate file that you include at the top of each file. Alternatively you could use the auto_prepend_file php.ini directive to include it for all scripts.