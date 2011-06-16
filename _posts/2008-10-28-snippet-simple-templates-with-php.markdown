---
layout: "post"
title: "Snippet: Simple templates with PHP"
time: 21:36:09
categories: 
- misc
---
Several templating systems exist for PHP, but since PHP was originally created as a templating language I've never understaood why more developers don't use pure PHP in their view layer. The following snippet is a small function that facilitates precisely that.

The only setup required is to simply define TPL_DIR to point to the root directory of your templates. You can then call the function, passing it the relative path to a template file in that directory, an array of variables to be used by the template and you can optionally have it return the results rather than sending them to the browser.

<pre name="code" class="php">
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
</pre>

As an example let's take a simple hello world (you saw that coming right?!). First the template...

<pre name="code" class="php">
&lt;html&gt;
  &lt;head&gt;
    &lt;meta http-equiv="Content-type" content="text/html; charset=utf-8"&gt;
    &lt;title&gt;&lt;?php echo htmlentities($title, ENT_QUOTES, 'UTF-8'); ?&gt;&lt;/title&gt;
  &lt;/head&gt;
  &lt;body&gt;
    &lt;h1&gt;Hello &lt;?php echo htmlentities($name['first'], ENT_QUOTES, 'UTF-8'); ?&gt; &lt;?php echo htmlentities($name['last'], ENT_QUOTES, 'UTF-8'); ?&gt;&lt;/h1&gt;
  &lt;/body&gt;
&lt;/html&gt;
</pre>

Now let's use it...

<pre name="code" class="php">
define('TPL_DIR', '/var/www/public_html/templates');

$data = array();
$data['title'] = 'Hello World Example';
$data['name'] = array('first' =&gt; 'Joe', 'last' =&gt; 'Bloggs');

TPL('homepage/hello.tpl.php', $data);
</pre>

That's all there is to it. From this simple yet powerful base I've built fully-featured classes that handle all aspects of template management and processing, it's an extremely stable foundation.

Comments, suggestions, requests and abuse are all welcomed.