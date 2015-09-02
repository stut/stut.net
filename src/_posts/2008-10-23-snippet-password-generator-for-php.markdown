---
layout: "post"
title: "Snippet: Password generator for PHP"
time: 00:47:38
categories:
- misc
---
Really short snippet today - a password generator. Not much to say about this one since it's pretty simple. Pass it the length of password you want and optionally a string of valid characters it can use and it'll give you a random string back.

{% highlight php startinline %}
function GeneratePassword($len, $allowedchars = false)
{
  if ($allowedchars === false)
    $allowedchars = 'abcdefghijklmnopqrstuvwxyz01234567890';
  $retval = '';
  $maxidx = strlen($allowedchars)-1;
  for ($i = 0; $i < $len; $i++)
  {
    $retval .= $allowedchars[rand(0,$maxidx)];
  }
  return $retval;
}
{% endhighlight %}

I've got something a bit meatier lined up for the next snippet so I recommend subscribing to <a href="http://feeds.feedburner.com/Stut">the RSS feed</a> to make sure you don't miss it. As always comments, questions, suggestions and requests are welcomed.
