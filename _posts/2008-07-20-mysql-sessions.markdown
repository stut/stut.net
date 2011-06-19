---
layout: "post"
title: "MySQL Sessions"
time: 11:18:28
categories:
- misc
---
A share-nothing approach to web development is great for scalability, but there aren't many web applications that don't need to share anything between requests. The solution PHP (and most other web development lanugages) utilises is sessions. Sessions basically allow you to store some data between requests. That data is tied to an ID that gets passed between the browser and server in every request, using a cookie, in the URL or in GET/POST parameters.

The default data store for PHP sessions is files, and that's fine so long as you only have one server, or you can tie each user to one server. When your app scales to the point where each request from a given user could go to one of any number of servers you need to replace this storage mechanism with something accessible from all of them. A database is the obvious choice.

I wrote the code below to solve this problem for a site that get &gt; 1 million unique users per month (at the time of writing). It's designed for ease of use and maximum performance. The session table exists in its own database so it can be moved to a dedicated server if required. It would also be trivial to split the session data across several tables by hashing or modifying the session ID to indicate which shard it was on.

The code is liberally commented so I won't waste electrons describing it separately. Hopefully the way it works is straightforward and easy to understand. Don't forget to check out the <a href="http://php.net/session">session documentation on the PHP website</a> for full details about <a href="http://php.net/session-set-save-handler">putting in your own session handler</a>.

<strong>Update:</strong> Thanks to Jim Lucas for spotting some errors. I've updated the code below.

{% highlight php linenos startinline tabsize=2 %}
/***********************************************************************
	MySQL Session class

	This class encapsulates everything needed to store your PHP sessions
	in a MySQL database. To use it simply call Session::Start() instead
	of session_start().

	You'll need a table like this in your database. You can change the
	name but the fields should remain as they are defined here.

	CREATE TABLE `sessions` (
	  `id` varchar(50) NOT NULL,
	  `name` varchar(50) NOT NULL,
	  `expires` int(10) unsigned NOT NULL default '0',
	  `data` text,
	  PRIMARY KEY  (`id`, `name`)
	) TYPE=InnoDB;
***********************************************************************/
class Session
{
	private $lifetime = 900;
	private $db = false;
	private $table = 'sessions';
	private $name = 'phpsess';

	static public function Start($host = 'localhost', $username = 'root', $password = '', $db = 'sessionstore', $table = 'sessions', $lifetime = 0)
	{
		// Create the object
		$GLOBALS['_SESSION_OBJ_'] = new self($host, $username, $password, $db, $table, $lifetime);
		// Hook up the handler
		session_set_save_handler(
						array(&amp;$GLOBALS['_SESSION_OBJ_'], 'Open'),
						array(&amp;$GLOBALS['_SESSION_OBJ_'], 'Close'),
						array(&amp;$GLOBALS['_SESSION_OBJ_'], 'Read'),
						array(&amp;$GLOBALS['_SESSION_OBJ_'], 'Write'),
						array(&amp;$GLOBALS['_SESSION_OBJ_'], 'Destroy'),
						array(&amp;$GLOBALS['_SESSION_OBJ_'], 'GC')
					);
		// Start the session
		session_start();
	}

	private function __construct($host = 'localhost', $username = 'root', $password = '', $db = 'sessionstore', $table = 'sessions', $lifetime = 0)
	{
		// By default we use the session lifetime in php.ini, but this can be overridden in code
		$this-&gt;lifetime = ($lifetime == 0 ? get_cfg_var('session.gc_maxlifetime') : $lifetime);
		// This is the table where session data is to be stored
		$this-&gt;table = $table;
		// Now we connect to the database, throwing expections if anything fails
		$this-&gt;db = @mysql_connect($host, $username, $password);
		if ($this-&gt;db === false)
			throw new Exception('Failed to connect to the session store', 1);
		if (false === @mysql_select_db($db, $this-&gt;db))
			throw new Exception('Failed to select session store', 2);
	}

	public function Open($path, $name)
	{
		// Store the session name for future use, we don't have any use for the path
		$this-&gt;name = $name;
		// Everything is OK if we have a connection to the database
		return ($this-&gt;db !== false);
	}

	public function Close()
	{
		// Run the garbage collector 10% of the time
		if (rand(1, 10) == 5) $this-&gt;GC($this-&gt;lifetime);
		// Close the database connection
		return @mysql_close($this-&gt;db);
	}

	public function &amp; Read($id)
	{
		// By default we return nothing
		$retval = '';

		// Try to read an entry from the database
		$result = mysql_query('select data from `'.$this-&gt;table.'` where id = "'.mysql_real_escape_string($id, $this-&gt;db).'" and name = "'.mysql_real_escape_string($this-&gt;name, $this-&gt;db).'" and expires &gt; '.time().' order by expires desc', $this-&gt;db);
		if ($result !== false and mysql_num_rows($result) &gt; 0)
		{
			// Found one, get it
			$retval = mysql_result($result, 0, 0);
		}

		return $retval;
	}

	public function Write($id, $data)
	{
		$retval = false;
		// Build the query. We use the MySQL ON DUPLICATE KEY feature to do an insert/update in one query.
		$sql = 'insert into `'.$this-&gt;table.'` set ';
		$sql.= 'id = "'.mysql_real_escape_string($id, $this-&gt;db).'", ';
		$sql.= 'name = "'.mysql_real_escape_string($this-&gt;name, $this-&gt;db).'", ';
		$sql.= 'expires = '.(time() + $this-&gt;lifetime).', ';
		$sql.= 'data = "'.mysql_real_escape_string($data, $this-&gt;db).'" ';
		$sql.= 'on duplicate key update expires = values(expires), data = values(data)';
		// Run it and return true if it was successful
		$result = mysql_query($sql, $this-&gt;db);
		if ($result !== false and mysql_affected_rows($this-&gt;db) &gt; 0)
			$retval = true;
		@mysql_free_result($result);
		return $retval;
	}

	public function Destroy($id)
	{
		// Remove this session from the database
		$result = mysql_query('delete from `'.$this-&gt;table.'` where id = "'.mysql_real_escape_string($id, $this-&gt;db).'" and name = "'.mysql_real_escape_string($this-&gt;name, $this-&gt;db).'"', $this-&gt;db);
		if ($result !== false and mysql_affected_rows($this-&gt;db) &gt; 0)
			return true;
		return false;
	}

	public function GC($lifetime)
	{
		// Remove any sessions that have expired
		$result = mysql_query('delete from `'.$this-&gt;table.'` where expires &lt; '.time(), $this-&gt;db);
		return ($result === false ? 0 : mysql_affected_rows($this-&gt;db));
	}
}
{% endhighlight %}
