---
layout: "post"
title: "Photo Blog"
time: 00:00:00
categories: 
- misc
---
[<em>This feature has been removed from Stut.net because I wasn't using it much.</em>]

I found myself with an hour to spare this lunchtime so I knocked up something I've been meaning to get around to ever since I bought a camera phone: a <a href="/photoblog/">photo blog</a>. There's not much in there yet but I'll be snapping various sights I see day to day.

For those who are interested it works like this:
<ol>
	<li>I take a photo with the phone</li>
	<li>I email this photo to a special email address</li>
	<li>Postfix (the mail server) passes emails sent to this address to a PHP script</li>
	<li>The PHP script pulls the email apart and saves any attached images into the images folder using the date, time and email subject as the filename</li>
	<li>If the subject starts with a period (.) it will rotate the image 90 degrees clockwise</li>
	<li>It then creates a thumbnail of the image</li>
	<li>The website gets a list of the files in that images directory to create the page at <a href="/photoblog/">http://stut.net/photoblog/</a> extracting the date, time and description from the filename</li>
</ol>
Lovely.