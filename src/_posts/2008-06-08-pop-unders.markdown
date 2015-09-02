---
layout: "post"
title: "Pop-unders"
time: 21:13:20
categories:
- misc
tags:
- javascript
---
Let me start by saying I hate pop-unders. They clutter up peoples desktops and generally annoy users. Unfortunately they are one of the most effective forms of web-based advertising at the moment, although I'm not sure why. I've had a few questions over recent months about how to implement pop-unders so here it is.

Pop-ups are easy, you just call the javascript function window.open with the required parameters. To turn a pop-up into a pop-under is simple. On the page that's loaded in the pop-up, simply add the following snippet...

{% highlight html %}
<script type="text/javascript">
	self.blur();
</script>
{% endhighlight %}

That will cause the popped-up window to sink behind whatever opened it.

Note that I accept no responsibility for the complaints you'll get from users if you start doing this. You're on your own!
