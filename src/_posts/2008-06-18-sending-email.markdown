---
layout: "post"
title: "Sending email"
time: 23:09:39
categories:
- misc
---
<div style="float:right;margin-left:1em;margin-bottom:0.5em;font-size:small;font-style:italic;text-align:center;line-height:1.1em;"><a href="http://flickr.com/photos/kris247/754341/" style="text-decoration:none;"><img src="http://farm1.static.flickr.com/1/754341_57c393fee5_m.jpg" border="0" style="margin:0;" /><br />"Spam with Cheese", &copy;kris247</a></div>

If you're using PHP you want <a href="http://phpmailer.sf.net/">PHPMailer</a>. If you're using something else there's probably an equivalent library (<a href="http://www.google.com/">Google is your friend</a>). However, regardless of how you do it you should always consider the impact of your email activities on your users. Unwanted email is one of the biggest problems on the Internet today and the more you can do to present your website as a responsible sender of email the better.

<h3>Content</h3>

There are essentially two types of email that you might send out to the users of your website: operational and non-operational. The purpose and content of the two differ greatly and it's important to understand the purpose of each to ensure your users understand why they're getting them and what action (if any) they need to take when they do.

<h4>Operational Emails</h4>

The term <em>operational emails</em> refers to emails that directly relate to the service you are providing the user. For example this would include welcome messages, order acknowledgements and reminders that you may send to users in response to their actions or other events.

Successful operational emails are the ones that keep it simple. You're sending them because they provide value for the user, so avoid the temptation to load them up with marketing information.

<ul>
	<li><h5>Get straight to the point</h5>
		<p>
			You're sending this email because you need to tell the user something, so tell them. If you really need to add other stuff like marketing messages be sure to do it low key and after the primary content. The worst thing that can happen with your operational emails is that your users start ignoring them because the signal-to-noise ratio is too low.
		</p>
	</li>
	<li><h5>Avoid HTML</h5>
		<p>
			Ask anyone in sales or marketing and they'll tell you that to engage people you need flashy graphics and pleasing colours, and at times they're right. However, when it comes to operational emails your users are already users - they're already engaged. Plain text is your best option. You can get the point across quickly, the message is less likely to be marked as spam and users won't get any security warnings when they open it.
		</p>
		<p>
			One thing you do need to ensure when using plain text is that your links are short to avoid them wrapping and becoming unclickable.
		</p>
		<p style="font-style:italic;">
			Note that not using HTML for these emails is probably more of a personal preference, but in my opinion while HTML email is a necessary evil for sales and marketing messages it has no place in operational emails.
		</p>
	</li>
</ul>

<h4>Sales &amp; Marketing Emails</h4>

Promotional emails can be a very effective way of reminding your users that you're there. I'm sure I have accounts on many websites I never visit and that haven't even crossed my mind lately, but it's likely if I received an occasional email from them I'd go visit them. I may just go back to delete my account, but surely that's better than account rot. On the other hand it may remind me why I signed up in the first place and I could become an active user again.

Emails can also be a great medium through which to inform your users of new features on your site, or long-standing features that aren't getting used. And don't forget that they also provide the opportunity to push the features of your site that make you money.

Evil reasons aside (because we all know sales and marketing people are an evil bunch), regular contact with your users is more likely to engage them with your website. Nothing you do on the site itself can have the same effect, but you have to do it right to prevent getting bitten by consequences.

The keys to success with sales and marketing emails differ greatly depending on the subject and audience.

<ul>
	<li><h5>Don't let the message get lost in the pretty pictures</h5>
		<p>
			While less pointed than operational emails promotional emails still carry a message to your users and it's important that they get it. If you look at an email you want to send and you can't immediately see what it's telling you chances are it will be ignored by a fair proportion of recipients. Time is precious and people are rarely willing to give emails longer than a few seconds to assert their importance.
		</p>
	</li>
	<li><h5>Use HTML but make sure it degrades well</h5>
		<p>
			You probably realise that by using HTML you can make your email more engaging, but it's all too easy to ignore the realities of the security-concious email clients that are out there. Here are some pointers to ensuring maximum compatibility...
		</p>
		<ul>
			<li>Test it in as many clients as possible.</li>
			<li>Check it with images turned off, with background images turned off, with CSS turned off and combinations of all three.</li>
			<li>If you're loading images off a remote server remember that by default most email clients will not show them without the user saying it can.</li>
			<li>Ensure all images have alt tags - including transparent images where you should set it to a single space.</li>
			<li>Make it a complete HTML page including a doctype.</li>
			<li>Provide a link at the very top of the email that goes to the email on a web server. Some people will trust that link over clicking the big scary button in their email client that makes it look like your email is trying to take over their computer.</li>
		</ul>
	</li>
</ul>

<h3>Technicalities</h3>

More important (from a potential problems point of view) than the content of the emails you send is the process and procedures you use to actually send them. Most of this should sound like common sense but I think it's important to state the obvious. The public view of commercial email, whether unsolicited or not is well-known, so unless you want to give your website a bad reputation you need to take care to do it properly.

<h4>Recipient management</h4>

Track your recipient list carefully. If someone tells you they don't want your email, don't send them email. There is no commercial value in sending email to someone who doesn't want it, but the potential damage it can cause is extensive.

<h5>Unsubscribes</h5>

You'll already know that you need to provide unsubscribe instructions in each email you send. For operational emails it may be as simple as "you have an account and to use it you need to get these emails". For promotional emails you need to provide a way for people to unsubscribe from them but continue to receive operational emails.

When someone does unsubscribe, honour it. In my opinion it's a good idea to keep a separate list of addresses that have unsubscribed as well as noting it against the user on your website. Whenever you send an email you should check to see if the recipient is in that separate unsubscribed list first.

<h5>Bounces</h5>

Track these too. Email can bounce for a variety of reasons. It could be that the address really doesn't exist, or it could be because the mailbox is full. Either way you need to have a procedure in place to deal with addresses that bounce.

Given that not all bounces mean the address is not valid it's a good idea to have a bounce threshold. Record bounces and when you get more than 1 (or more than 2 if you want to be more tolerant) for a given address mark them as bounced and stop sending email to it. This will prevent your mail server from having to do more work than it needs to.

I've heard several people suggest that it's a good idea to periodically flush bounced addresses. The argument centres around the possibility that you might mark perfectly valid addresses as bounced in fairly rare circumstances. The idea is that you unmark bounced addresses after some random period of time, thereby getting back any that were incorrectly marked as bounced. Personally I don't think it's worth it, but if your bounce rate is low it can't hurt. Just be sure not to apply the same logic to unsubscribed addresses!

<h4>Email structure</h4>

Well-behaved emails are those that have proper well-formed headers. The following list highlights the really important ones...

<ul>
	<li><h5>Envelope sender</h5>
		<p>
			A carefully crafted envelope sender is the best way to identify bounces when they come in. Take the following address...
		</p>
		<p><tt>bounce+listname+messageid+john=doe.com@listserver.com</tt></p>
		<p>
			Set up an alias called bounce that passes the email to a script. That script then does the following...
			<ul>
				<li>Remove the @ and everything after it.</li>
				<li>Split what remains by + with a maximum of 3 elements. Limiting it to 3 elements allows for + signs in the users email address.</li>
				<li>The first element is the name of the list they're bouncing from.</li>
				<li>The second element is the message ID they're bouncing from. This part can be removed if you have no need to tie bounces to individual messages.</li>
				<li>The last element is the email address in question encoded by replacing the @ with an =. To decode it ensure that you only change the last = to an @ as an = is perfectly valid in the user part.</li>
				<li>Take whatever steps are required to mark that email address as bounced from that list.</li>
			</ul>
		</p>
		<p>
			Technically you can probably remove the need for the list name and message ID because if an address bounces for one list it's no different to it bouncing from another list. The same goes for the message ID. I use this to record events against a given message, but that's only for metrics - it serves no functional purpose.
		</p>
	</li>
	<li><h5>Content</h5>
		<p>
			If you're sending HTML be sure to send a plain text alternative along with it. It doesn't need to be the same content, it can be as simple as...
		</p>
		<p><tt>This email is in HTML format which your email client is not displaying. To view this email click on this link.</tt></pre>
		<p><tt>http://url.to/web/based/version/of/the/email</tt></p>
		<p>
			Keep the URL as short as possible to avoid wrapping. Make sure you also include the unsubscribe instructions in the plain text content.
		</p>
	</li>
</ul>

<h3>Sending email with PHP</h3>

Yeah, I know, most of the rest of this article has had nothing to do with PHP, but here's where it comes on-topic. First let's get one thing straight... the built-in <a href="http://php.net/mail">mail</a> function sucks.

<a href="http://phpmailer.sf.net/">PHPMailer</a> is a great bit of code that simplifies creating and sending properly formed emails and I always recommend it unless you really understand email. If you know what you're doing you can easily do everything yourself.

The one piece of advice I'd give is to make sure the SMTP server you're dumping the messages to in the first instance will accept them with minimal delay. As long as you've set up your envelope sender as described above you're far better off allowing the MTA to decide to bounce messages in its own time than you are waiting for it to do it as your script is sending them.

<h3>Other tips</h3>

Here are a few things to think about when sending bulk email.

<h4>Don't over-complicate your unsubscribe process</h4>

If someone wants to unsubscribe from your list you need to make it as easy as possible. They don't want your email - there's no commercial value in keeping them subscribed. Your unsubscribe process should ideally take just one-click and certainly no more than two.

Don't delay removing them from the list. Nothing grates me more in this area than a list that states it may take a few weeks for an unsubscribe request to be honoured. There's never a valid reason why it would take that long.

<h4>Explain why you have their email address</h4>

You got their email address from somewhere. Hopefully they gave it to you willingly. In every email you send remind them why you have it. Put that right next to the unsubscribe instructions. It shows them that you're not blindly flinging messages out without caring where they're going.

<h4>Don't ever use purchased lists</h4>

If you didn't gather the addresses you're sending to then you're a spammer in my book regardless of the content of your emails. In addition you'll find it difficult to justify why you sent them email if anyone complains (see the next point). If you have something to say that people want to hear you shouldn't have any trouble gathering the email addresses of willing users.

<h4>Deal with spam complaints properly</h4>

If you get people complaining that you're spamming them (and you will), make sure you respond to each one personally. If you can trace why their email address was used tell them. Provide details of the unsubscribe procedure and also offer to unsubscribe their address for them if they simply reply to you requesting that. If you're doing everything else right these complaints should be quite rare, but I think it's worth putting in the small amount of effort it takes to deal with them properly and personally. One of the lists I manage contains over 600,000 addresses and we've never had more than 4 spam complaints from any one message sent.

It's important to note that complaints of this nature are usually sent through or copied to your hosting provider or ISP. Get too many and they'll start to take notice and there may be damaging consequences so deal with them quickly and keep all parties informed.

<h3>That's all folks</h3>

I hope this article has given you some pointers to help you on your way to being a good citizen in the world of bulk email. Feel free to leave a comment if you have any questions or you think I've missed something.
