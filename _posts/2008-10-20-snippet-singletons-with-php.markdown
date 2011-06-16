---
layout: "post"
title: "Snippet: Singletons with PHP"
time: 20:09:00
categories: 
- misc
---
Today's snippet describes the singleton pattern. The singleton pattern is a method of creating a class that statically maintains an instance of itself and ensures that no other instances can be created. This is useful for classes that implement app-wide services such as logging, DB access and other shared resources.

The basic requirements for a singleton class are as follows...

<ul>
	<li><strong>The constructor is private</strong><br />This ensures that nothing outside the class can create instances.</li>
	<li><strong>A static method exists that returns <em>the</em> instance</strong><br />When first called the method creates a statically stored instance of the class. Subsequent calls return the existing instance.</li>
	<li><strong>Magic methods to prevent the instance from being cloned or serialized <snall><em>(PHP-specific)</em></small></strong><br />PHP provides functionality to clone and serialize objects. By adding simple implementations of the <em>__clone</em> and <em>__wakeup</em> magic methods we can prevent this from happening.
</ul>

That's basically it. Here's a simple example...

<pre name="code" class="php">
class Singleton
{
  static private $_instance = null;

  public static function & Instance()
  {
    if (is_null(self::$_instance))
    {
      self::$_instance = new self();
    }
    return self::$_instance;
  }

  private function __construct()
  {
    // Do normal instance initialisation here
    // Nothing singleton-related should be present
  }

  public function __destruct()
  {
    // This is just here to remind you that the
    // destructor must be public even in the case
    // of a singleton.
  }

  public function __clone()
  {
    trigger_error('Cloning instances of this class is forbidden.', E_USER_ERROR);
  }

  public function __wakeup()
  {
    trigger_error('Unserializing instances of this class is forbidden.', E_USER_ERROR);
  }

  private $var = '';

  public function SetVar($val)
  {
    $this-&gt;var = $val;
  }

  public function GetVar()
  {
    return $this-&gt;var;
  }
}
</pre>

This is an extremely simple example but it demonstrates all of the core concepts. You use this class as follows...

<pre name="code" class="php">
$obj1 = Singleton::Instance();
$obj1-&gt;SetVar('some value');

$obj2 = Singleton::Instance();
echo $obj2-&gt;GetVar(); // This will echo 'some value'
</pre>

If you attempt to clone or unserialize an instance your script will fail with an error.

I use this pattern all over the place and definitely recommend using it where it makes sense in your applications. An alternative would be to implement the entire class statically and to be honest I'm not sure whether there are advantages to either implementation. If someone knows please share in the comments.

That's it for this snippet, stay tuned for more. As always comments, questions, suggestions and requests are welcomed.