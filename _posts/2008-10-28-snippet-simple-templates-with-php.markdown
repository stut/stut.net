---
layout: "post"
title: "Snippet: Simple templates with PHP"
time: 21:36:09
categories:
- misc
---
Several templating systems exist for PHP, but since PHP was originally created as a templating language I've never understaood why more developers don't use pure PHP in their view layer. The following snippet is a small function that facilitates precisely that.

The only setup required is to simply define TPL_DIR to point to the root directory of your templates. You can then call the function, passing it the relative path to a template file in that directory, an array of variables to be used by the template and you can optionally have it return the results rather than sending them to the browser.

{% highlight php startinline %}
function & TPL($____filename, &$____data = array(), $____return = false)
{
  $____retval = '';

  $____tplfilename = TPL_DIR.'/'.$____filename;

  if (file_exists($____tplfilename))
  {
    if ($____return) ob_start();

    extract($____data);

    require $____tplfilename;

    if ($____return) $____retval = ob_get_clean();
  }
  else
  {
    trigger_error('Template not found: '.$____filename, E_USER_ERROR);
  }

  return $____retval;
}
{% endhighlight %}

As an example let's take a simple hello world (you saw that coming right?!). First the template...

{% highlight php %}
<html>
  <head>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8">
    <title><?php echo htmlentities($title, ENT_QUOTES, 'UTF-8'); ?></title>
  </head>
  <body>
    <h1>Hello <?php echo htmlentities($name['first'], ENT_QUOTES, 'UTF-8'); ?> <?php echo htmlentities($name['last'], ENT_QUOTES, 'UTF-8'); ?></h1>
  </body>
</html>
{% endhighlight %}

Now let's use it...

{% highlight php startinline %}
define('TPL_DIR', '/var/www/public_html/templates');

$data = array();
$data['title'] = 'Hello World Example';
$data['name'] = array('first' => 'Joe', 'last' => 'Bloggs');

TPL('homepage/hello.tpl.php', $data);
{% endhighlight %}

That's all there is to it. From this simple yet powerful base I've built fully-featured classes that handle all aspects of template management and processing, it's an extremely stable foundation.

Comments, suggestions, requests and abuse are all welcomed.
