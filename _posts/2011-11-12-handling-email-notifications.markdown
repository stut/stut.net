---
layout: "post"
title: "Handling email notifications"
categories:
- projects
- technology
tags:
- twitter
- php
---

<em>This article has previously been published on this site, but it got lost somewhere in the middle of several site rewrites.</em>

Twitter sends notifications of new followers and direct messages by email. While you can use the API to keep track of those things it wastes hits and it's incredibly inefficient especially for accounts with minimal activity.

I run several Twitter-based services but they all share the same email address. This allowed me to use the same email handling setup to process all email coming in from Twitter. So far it's working really well but it means this script is a bit more involved than it needs to be.

I've littered the code with comments - far more than should be necessary, but it saves me from going through it step by step here. Read, learn and enjoy. If you have any questions or comments feel free to contact me <a href="http://twitter.com/stut">on Twitter</a>.

<script src="https://gist.github.com/1360403.js?file=incoming_mail.php"></script>

The script uses the <a href="http://php.net/mailparse">mailparse extension</a> so that must be available.

To use the script you just need to stick it somewhere accessible by the mail server, check the #! line will work, make it executable and add a piped alias to your aliases file - see your MTA documentation for details. My server runs Postfix and I have the following line in <tt>/etc/aliases</tt>...

<pre>twitmail: |/var/www/twitapps.com/common/incoming_mail.php</pre>

In my case I also have a line in the transport map to point the full email address including domain at that local alias. Your MTA requirements will vary.

<h3 style="color:red;">!! Be sure to keep this email address secret !!</h3>

Due to the way email works there is no real way to validate that the email came from Twitter, and as a result nor is it reasonable to assert that the user mentioned in the email actually did what it says they did. The only real way to protect against fake emails at the moment is to ensure you use an email address that nobody else knows. Apply the same rules to this email address as you would to a password and you'll be fine. It's not great security but it's what we've got and I've not heard of anyone having a problem so far but you don't want to be the first!!

<h2>Writing handlers</h2>

The last piece of this solution is the actual handler scripts. There's nothing special about them - they can do whatever you need them to do. Here's an example <em>is_following</em> handler.

<script src="https://gist.github.com/1360403.js?file=new_follower.php"></script>

From within a handler script you have a few useful variables available from the main script...

<div style="padding-left: 1.5em;">
  <div style="font-weight: bold;">$headers</div>
  <div style="padding-left: 1.5em;">
    <p>
      This is an array of all the headers from the email that started with X-Twitter.
      At the time of writing this give you access to...
    </p>
    <table class="dt">
      <tr>
        <th>Key</th>
        <th>Contains</th>
      </tr>
      <tr>
        <td>createdat</td>
        <td>When the email was created</td>
      </tr>
      <tr>
        <td>emailtype</td>
        <td>What type of notification it is, e.g. <i>is_following</i> or <i>direct_message</i></td>
      </tr>
      <tr>
        <td>senderid<br />senderscreenname<br />sendername</td>
        <td>The ID, screen name and name of the sender</td>
      </tr>
      <tr>
        <td>recipientid<br />recipientscreenname<br />recipientname</td>
        <td>The ID, screen name and name of the receipient</td>
      </tr>
    </table>
  </div>
  <div style="font-weight: bold;">$body</div>
  <div style="padding-left: 1.5em;">
    <p>
      The unmodified body of the message.
      Note that for direct messages this contains more than just the message itself.
    </p>
  </div>
  <div style="font-weight: bold;">$info</div>
  <div style="padding-left: 1.5em;">
    <p>
      This variable contains the return value from <a href="http://php.net/mailparse_msg_get_part_data">mailparse_msg_get_part_data</a>.
      The most useful part of this is the raw headers from the incoming email (<tt>$info['headers']</tt>).
    </p>
  </div>
</div>

<h2>Errors and other output</h2>

If anything goes wrong during the processing of a message an error message along with the raw incoming email will be sent to the address in <tt>$____email_address</tt> (specified near the top of the file). This includes any output from the handler scripts themselves. The script will never bounce an email due because you don't want Twitter to decide the address is not valid.

<h2>Caveat</h2>

There is one important point regarding email notifications from Twitter that you need to be aware of, and that's the fact that <strong>you may not always get a notification for every event that happens</strong>.

The reason for this is spam. Twitter is still battling against a deluge of users and bots whose only purpose is to try an spam the legitimate users of their service. One of their defenses against this is to recognise spamtastic patterns and take action to minimise the impact on other users. One of the actions they take is to not send email notifications from users flagged as possible spammers.

One important side-effect of this is that a user unfollowing you and then following again will not necessarily trigger an <em>is_following</em> notification.

For TwitApps I have a cron job that runs once a day and checks the followers using the API and "catches up" with any that have been missed. This means most users get an instant response but there's a backup process that makes minimal use of the API to ensure that if anyone does get missed they only wait up to 24 hours for a response.
