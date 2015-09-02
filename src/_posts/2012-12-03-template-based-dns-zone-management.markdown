---
layout: "post"
title: "Template-based DNS Zone Management"
time: 14:16:00
categories:
- technology
tags:
- sysadmin
- dns
published: true
---
I own nearly 100 domain names, which is a pretty modest number against some people and organisations I know. Most of them are currently registered with <a href="https://www.gandi.net/">Gandi.net</a> and I've always found their service to be good value for money and that's still true today.

Most of the DNS for those domain names is also hosted with Gandi. Why? Because it's included in the registration cost. However, their zone management tool, while it had a major overhaul in the last year which has made it a lot better, it's still a major pain to use. Unfortunately this seems to be a common theme with DNS management interfaces.

I've recently been setting up a number of development systems for a couple of clients, and these have needed DNS changes so I've been using that tool a lot more lately than I would normally, and it's frustrating.

When I look at my zones I see a lot of duplication. Nearly all my email is with Google Apps, so most zones have the same MX records. I don't have a huge number of servers so most of the rest breaks down into a few small groups where the details are the same.

The duplication means that if I wanted to change my email provider it would be a major pain to change all of the MX records. I decided that this can't just be me and that there must be a zone management solution out there that manages domains based on a set of templates rather than individually. Either my Googling skills are waning or this doesn't exist outside an ISP control panel, and even then I'm not sure they're actually providing what I want.

So, what do I want? This calls for some bullet points:

<ul>
  <li>To define a set of zone templates, with descriptive names like "Google Apps MX records".</li>
  <li>With simple variable substitution. Some variables would be pre-defined based on the zone or other expected data, others would be completely custom.</li>
  <li>To define a set of zones, then build the zone information from a combination of other zones, templates and individual entries.</li>
  <li>It would also be nice to be able to organise zones into categories, with the ability to set variables on the category for use in templates.</li>
</ul>

That way I could define a zone as:

<ul>
   <li>Standard site on b.3ft9.com with a static server at xyz on Rackspace CloudFiles with CDN enabled.</li>
  <li>Google Apps MX records.</li>
</ul>

This would set up @ and www to point at the IP for b.3ft9.com, and static as a CNAME to xyz.rackcdn.com, and MX records for Google Apps complete with SPF TXT entry.

Now, let's say 40 of my domains are on b.3ft9.com and all follow this same pattern so they all have similar zones. Then I decide to switch from Rackspace CloudFiles to Amazon S3 it's simply a case of changing the "Standard site" template. The same applies if I decide to change my mail provider Simples.

The management interface would let me see both the templates that a particular zone is using and the zones that are using a particular template. That way I can be sure that I know what I'm affecting when I change a template.

If such a thing exists please tell me before I decide to go ahead and implement it myself. I find it hard to believe that this doesn't already exist in some form or another!

If I were to build it I'd be inclined to do it as a set of CLI tools that work on files, that way you could store your templates and zones in a version control system and generate standard zone files.

Very interested to hear opinions on this. I recently tried Amazon's Route 53 interface having already decided that they would have built something that could cope with users managing hundreds of domains, but apparently I was wrong. I guess my use case is specific to the independent developer who has a lot of ideas on the go at once, not the enterprise which probably has very few domains and rarely changes their hosting arrangements.

I still think there's a need for something similar to what I describe. Another one for the to do list.
