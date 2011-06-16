---
layout: "post"
title: "Validating domains and email addresses"
time: 20:56:35
categories: 
- misc
tags: 
- php
---
This is a very common situation. You're taking input from the user, including their email address. You want to make sure that they're not feeding you a load of crap, so you want to validate their email address. The best way to do this is with a regular expression, but it's not a simple task.

<a href="http://iamcal.com/">Cal Henderson</a> (of <a href="http://flickr.com/">Flickr</a> fame) wrote an excellent article a little while ago where he wrote a regular expression against the specification document that defines these things. As Cal points out, that specification is RFC822. Now this potentially has its problems because it was written in 1982 and the rules regarding valid characters in domain names have changed since then, but as far as I can tell his solution has then covered.

Check out his article: <a href="http://iamcal.com/publish/articles/php/parsing_email/">http://iamcal.com/publish/articles/php/parsing_email/</a>

Hopefully Cal won't mind if I reproduce the end result of his work here...
<pre name="code" class="php">function is_valid_email_address($email)
{
$qtext = '[^\\x0d\\x22\\x5c\\x80-\\xff]';
$dtext = '[^\\x0d\\x5b-\\x5d\\x80-\\xff]';
$atom = '[^\\x00-\\x20\\x22\\x28\\x29\\x2c\\x2e\\x3a-\\x3c'.
 	'\\x3e\\x40\\x5b-\\x5d\\x7f-\\xff]+';
$quoted_pair = '\\x5c[\\x00-\\x7f]';
$domain_literal = "\\x5b($dtext|$quoted_pair)*\\x5d";
$quoted_string = "\\x22($qtext|$quoted_pair)*\\x22";
$domain_ref = $atom;
$sub_domain = "($domain_ref|$domain_literal)";
$word = "($atom|$quoted_string)";
$domain = "$sub_domain(\\x2e$sub_domain)*";
$local_part = "$word(\\x2e$word)*";
$addr_spec = "$local_part\\x40$domain";
return preg_match("!^$addr_spec$!", $email) ? 1 : 0;
}</pre>
For a recent project I needed a function to just validate a domain name, so I extracted the relevant parts and created the following function...
<pre name="code" class="php">function is_valid_domain($domainname)
{
$dtext = '[^\\x0d\\x5b-\\x5d\\x80-\\xff]';
$atom = '[^\\x00-\\x20\\x22\\x28\\x29\\x2c\\x2e\\x3a-\\x3c'.
 	'\\x3e\\x40\\x5b-\\x5d\\x7f-\\xff]+';
$quoted_pair = '\\x5c[\\x00-\\x7f]';
$domain_literal = "\\x5b($dtext|$quoted_pair)*\\x5d"; 

$domain_ref = $atom;
$sub_domain = "($domain_ref|$domain_literal)";
$domain = "$sub_domain(\\x2e$sub_domain)*";
return preg_match("/^$domain$/i", $domainname) ? true : false;
}</pre>