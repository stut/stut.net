---
layout: "post"
title: "Snippet: Time class for PHP"
time: 17:28:47
categories:
- misc
---
Pretty boring snippet today, but I find it immensely useful. My time class provides representations of periods from OneMinute to OneYear. It only has one method which will calculate an absolute time by adding a given time period to the current time. You can optionally provide a format intended for use by the date function to return a formatted string rather than a timestamp.

Hope you find it useful too.

{% highlight php startinline %}
class Time
{
	const OneMinute = 60;
	const FiveMinutes = 300;
	const TenMinutes = 600;
	const FifteenMinutes = 900;
	const HalfHour = 1800;
	const OneHour = 3600;
	const SixHours = 21600;
	const HalfDay = 43200;
	const OneDay = 86400;
	const SevenDays = 604800;
	const ThirtyDays = 2592000;
	const OneYear = 31536000;

	public static function GetAbsolute($time, $format = false)
	{
		if (is_numeric($time) and $time &lt; (time()-1))
		{
			$time = time() + $time;
		}
		else
		{
			$time = strtotime($time);
		}
		return (false === $format ? $time : date($format, $time));
	}
}
{% endhighlight %}

Comments, questions, suggestions and requests are welcomed as always.
