---
layout: "post"
title: "Turn off wrapping in Nano"
time: 23:00:00
categories:
- misc
---
I'm posting this so I don't have to ask Jared again. To globally turn off word-wrapping for Nano (on FreeBSD - other OS's may vary), do this...

{% highlight bash %}
echo 'set nowrap' &gt; /usr/local/etc/nanorc
{% endhighlight %}

Now I never need to ask again!.