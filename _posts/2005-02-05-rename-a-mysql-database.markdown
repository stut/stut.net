---
layout: "post"
title: "Rename a MySQL Database"
time: 00:00:00
categories:
- misc
---
 I recently needed to rename a whole bunch of MySQL databases so I created a script to do it. I hope others find it as useful as I do.

{% highlight bash %}
#!/bin/sh
mysqladmin -u$1 -p$2 create $4
mysqldump -u$1 -p$2 $3 | mysql -u$1 -p$2 $4
echo "update mysql.db set Db = '$4' where Db = '$3';" | mysql -u$1 -p$2
echo "update mysql.tables_priv set Db = '$4' where Db = '$3';" | mysql -u$1 -p$2
echo "update mysql.columns_priv set Db = '$4' where Db = '$3';" | mysql -u$1 -p$2
echo "flush privileges;" | mysql -u$1 -p$2
mysqladmin -u$1 -p$2 drop $3
{% endhighlight %}

The script should be called as follows...

{% highlight bash %}
renamedb.sh [username] [password] [olddb] [newdb]
{% endhighlight %}

The script performs the following steps...

<ol>
	<li>Create the new database</li>
	<li>Copy the structure and data</li>
	<li>Transfer all privileges</li>
	<li>Flush the privileges</li>
	<li>Drop the old database (will ask for confirmation)</li>
</ol>

Note that the script will effectively knock out any app/website that uses it until the database they point to is modified accordingly. Enjoy.