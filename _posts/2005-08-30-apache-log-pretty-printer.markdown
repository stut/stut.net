---
layout: "post"
title: "Apache Log Pretty Printer"
time: 23:00:00
categories:
- misc
---
Here's something I knocked up a while back to pretty-print Apache log files. Written in PHP, works with combined logs, should work with common too. It was requested by Fred, so here it be for all to see.

Save as logparse.php, chmod +x it and use in a fashion similar to...

{% highlight bash %}
tail -f /var/log/httpd-access.log | logparse.php
{% endhighlight %}

Here's the code...

{% highlight php %}
#!/usr/local/bin/php
<?php
	$hostscache = '/tmp/logparsehostcache';
	if (file_exists($hostscache))
		$hosts = unserialize(file_get_contents($hostscache));
	else
		$hosts = array();

	while ($line = trim(fgets(STDIN)))
	{
		//print $line;
		preg_match('/^(.*?) \- \- \[(.*?)\/(.*?)\/(.*?):(.*?):(.*?):(.*?) .*?\] \"(.*?) (.*?) /i', $line, $matches);
		//print_r($matches);

		list($full, $ip, $day, $month, $year, $hour, $minute, $second, $method, $url) = $matches;

		if (preg_match('/(\/favicon.ico)|(\/images\/)|(\/system\/)|(\/includes\/)|(\/page\.html)/i', $url))
			continue;

		if (!isset($hosts[$ip]))
		{
			$cmd = "host $ip";
			$hosts[$ip] = trim(`$cmd`);
			if (strpos($hosts[$ip], '(') === false)
			{
				$hosts[$ip] = substr(array_pop(split(' ', $hosts[$ip])), 0, -1);
				if ($hosts[$ip] == 'reached')
					$hosts[$ip] = $ip;
			}
			else
				$hosts[$ip] = $ip;

			$len = strlen($hosts[$ip]);
			if ($len > 30)
				$hosts[$ip] = substr($hosts[$ip], $len-30);
			elseif ($len < 30)
				$hosts[$ip] = str_pad($hosts[$ip], 30, ' ', STR_PAD_LEFT);
		}

		print $hosts[$ip]." $year-$month-$day $hour:$minute:$second ";

		$len = strlen($method);
		if ($len > 4)
			print substr($method, $len-4);
		elseif ($len < 4)
			print str_pad($method, 4);
		else
			print $method;

		print " $url\n";
	}

	$fp = fopen($hostscache, 'w');
	if ($fp)
	{
		fwrite($fp, serialize($hosts));
		fclose($fp);
	}
{% endhighlight %}
