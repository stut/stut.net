---
layout: "post"
title: "Inconsiderate shared hosting customers"
time: 17:45:25
categories: 
- grr
---
In a message to the <a href="http://php.net/mailing-lists.php" title="PHP Mailing Lists">php-general mailing list</a>, someone named <a href="http://marc.info/?l=php-general&amp;m=118636019632615&amp;w=2" title="Let your provider worry about it!">Jan Reiter made a frightening statement</a>...
<blockquote>But if it's a rented server, apache overhead isn't your concern, so go on and let your provider worry about it! :-D</blockquote>
As someone who runs a shared hosting provider this comment made me cringe. I'm assuming that by "rented server" (s)he means shared hosting since in a dedicated server context it makes no sense.

Regardless of what you're doing (<a href="http://marc.info/?t=118629651400001&amp;r=1&amp;w=2" title="Problems with file_get_contents() and local PHP file">read the full thread</a> to find out what this particular user wanted) it is important to consider the environment in which your website will be running. If you are a resource hog most hosts have terms and conditions that allow them to terminate your account. But more importantly you need to consider the effect you are having on the users you share that server with.

If your site suddenly started slowing down because another user was hogging all the resource on the server you'd be complaining before I could say "it's good to share". If your site gets to the the point where it's using too many resources for you to continue on a shared server, congratulations you should now graduate to a dedicated server, but don't take concious steps to use more resources than you need to. It will likely have a detrimental effect on your site nevermind the rest of the server.

And so I appeal to all shared hosting customers everywhere, remember that you're sharing your physical home in the ether. Be considerate, don't play loud music too late and don't start monopolising the space.

Rant over.