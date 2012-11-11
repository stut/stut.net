---
layout: "post"
title: "PHP Snippet: HTTP Authentication"
time: 14:13:00
categories:
- misc
tags:
- php
published: true
---
HTTP authentication is the easiest way to make a page or area of a website secure. It's very easy to accomplish with pure PHP, so no web server configuration is required making it a lot more portable.

This function implements a very simple HTTP Basic Auth authentication system. Simply call it before you do anything else in your script, pass it an array of valid users (username => password), an optional description of what's being secured and it will do the rest.

{% highlight_file php _snippets/httpauth/function.php startinline %}

Example usage:

{% highlight_file php _snippets/httpauth/usage.php startinline %}

Note that the function doesn't return anything or throw any exceptions. If it can't validate the user it will end the script after sending back an appropriate response.
