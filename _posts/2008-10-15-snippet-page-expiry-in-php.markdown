---
layout: "post"
title: "Snippet: Page expiry in PHP"
time: 20:37:04
categories: 
- misc
---
This is the first of what I hope will be a series of posts showing snippets of code from my personal library. My intention is to highlight useful techniques I've developed or picked up over the years. Comments, questions, suggestions and requests are welcomed.

This first snippet is a simple function to set appropriate expiry headers. Simply pass it a time period in seconds or a unix timestamp to set the expiry to some time in the future, or 0 to expire the page immediately.

<pre name="code" class="php">
function PageExpiry($age = 0)
{
  if (!headers_sent())
  {
    if ($age == 0)
    {
      // Expire immediately
      header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");    // Date in the past
      header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
      // always modified
      header("Cache-Control: no-store, no-cache, must-revalidate");  // HTTP/1.1
      header("Cache-Control: post-check=0, pre-check=0", false);
      header("Pragma: no-cache");                          // HTTP/1.0
    }
    else
    {
      // Expire in the future
      header('Cache-Control: PUBLIC, max-age='.$age.', must-revalidate');
      header('Expires: '.gmdate('r', ($age &gt; time() ? $age : time() + $age)).' GMT');
    }
  }
}
</pre>

Note that since this function sets headers you must not call it after output has been sent to the browser. If headers have already been sent (i.e. output has occurred) this function will <b>silently</b> have no effect.

Some example usage...

<pre name="code" class="php">
// Expire the page immediately
PageExpiry();
// or
PageExpiry(0);
</pre>

<pre name="code" class="php">
// Expire the page tomorrow
PageExpiry(86400);
</pre>

<pre name="code" class="php">
// Expire the page at the end of this year
PageExpiry(strtotime(date('Y').'-12-31 23:59:59'));
</pre>

<pre name="code" class="php">
// Expire the page in 2038
PageExpiry(strtotime('2038-01-01 00:00:00'));
</pre>