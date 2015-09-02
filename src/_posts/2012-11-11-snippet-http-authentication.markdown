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

{% highlight php startinline %}
function authenticate($users = array(), $realm = false)
{
  // $users should be an array of user => password.
  if (count($users) == 0) {
    // No users given, add a default.
    $users['admin'] = 'password';
  }

  // If no realm was given, add a default.
  if ($realm === false) {
    $realm = 'Restricted area';
  }

  // If we haven't been passed a username via basic auth, ask for one.
  if (!isset($_SERVER['PHP_AUTH_USER'])) {
    header('WWW-Authenticate: Basic realm="'.$realm.'"');
    header('HTTP/1.0 401 Unauthorized');
    die('<html><head><title>Unauthorised</title></head><body><h1>Unauthorised</h1><p>You are not authorised to view this page</p></body></html>');
  } elseif (!isset($users[$_SERVER['PHP_AUTH_USER']]) or $users[$_SERVER['PHP_AUTH_USER']] != $_SERVER['PHP_AUTH_PW']) {
    die('<html><head><title>Unauthorised</title></head><body><h1>Unauthorised</h1><p>You are not authorised to view this page</p></body></html>');
  }
}
{% endhighlight %}

Example usage:

{% highlight php startinline %}
$valid_users = array(
    'stuart' => 'abracadabra',
    'jim' => 'zarniwoop',
    'slartibartfast' => 'fjords',
  );
authenticate($valid_users, 'My Secure Area');
{% endhighlight %}

Note that the function doesn't return anything or throw any exceptions. If it can't validate the user it will end the script after sending back an appropriate response.
