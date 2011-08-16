---
layout: "post"
title: "Fortune's Tower in PHP"
categories:
- projects
- technology
---

When I get bored while working I choose something from a list of things I want to have a go at someday. Some things are "read this blog post", or "learn about this technology", but most are along the lines of "make this". Today I picked a "make this" item... to implement the game Fortune's Tower.

I came across this game in the <a href="http://en.wikipedia.org/wiki/Fable_II_Pub_Games">Fable&reg; II Pub Games</a> on my Xbox. I have never actually played Fable&reg; II, and I've barely touched the other pub games in the Xbox Live Arcade Pub Games, err, game, but I keep returning to Fortune's Tower. While playing it I've tried various strategies but always wanted an automated way to test whether my strategies are actually any good. The best way to do that is to write some code that can play the game, so that's what I did.

Since I was doing Ruby at the time I decided to switch to PHP for this quick project. I had previously sketched out the rules of the game (I do that a lot - yup, I've killed a lot of trees in my time), so I got straight into the coding and had a working solution about half an hour later. After a few refinements, a couple of nasty bugs quashed and some display tweaking I had something that played the game and called out to a function after each row to get a decision as to whether to take the row or chance the next one.

Here's a video of the code in action...

<center><iframe width="640" height="390" src="http://www.youtube.com/embed/djTP0Y7v9fw" frameborder="0" allowfullscreen></iframe></center>

I've put <a href="https://github.com/3ft9/fortunestower">the quick 'n' dirty code up on GitHub</a>. Run it by executing play.php. It uses very simple logic to make decisions...

<ul>
<li>If we've used the gate card, accept the offer if it's greater than 15.</li>
<li>Accept the offer if it's greater than 25.</li>
<li>Reject the offer.</li>
</ul>

I've spent some time playing around with the logic in the getDecision function, but I'm sure it could be improved. I've also played with the cost per game to see what effect that has and 15, the value used in the Xbox game, seems to be the Goldilocks value.

Anyway, feel free to play and let me know how many rounds you can reach. My maximum so far with the code as it is on GitHub is 254, but it tends to be closer to 20 most of the time.
