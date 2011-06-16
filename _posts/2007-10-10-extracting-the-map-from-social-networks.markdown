---
layout: "post"
title: "Extracting the map from social networks"
time: 22:42:54
categories: 
- technology
---
One thought keeps spinning round my head and has been for a while now. There are too many social networks for global participation to be practical. The core problem is that each site has their own list of your friends. This list is usually referred to as the social map and for the idea of social networking to really become a permanent part of the Web this aspect needs to be extracted and standardised.

Social networks are the current hot topic. The concept is simple: you tell a site that you know other users of that site, and they confirm it. This creates a connection between you and opens up a world of possibilities that range from active and passive recommendation and interaction (think <a href="http://www.facebook.com/" title="Facebook">Facebook</a>) to making it easier to get introduced to friends of friends to expand your social circle (think <a href="http://www.linkedin.com/" title="LinkedIn">LinkedIn</a> in addition to Facebook).

The type of information stored about you and your connections varies from site to site, but there are common themes. These usually include basic profile details (name, email, location, etc) and for your connections the type of relationship (relative, colleague, etc). What would be great is if there was a central place where this information could be stored and shared securely between the various social networking sites. You set up your friends once and every site you use can then apply social features to your account.

One of the requirements that leads on from that is needing a unique ID that can be shared between these sites. There's already a system that works like that - it's called <a href="http://openid.net/" title="Official OpenID Website">OpenID</a>. So this is basically my idea: add the common social map aspects of social network sites to an OpenID provider and either extend the OpenID API or create a new API to enable access to that information. Your OpenID then becomes a SocialID.

So here's the sequence. You sign up for (or already have) an OpenID. You enable the SocialID extension with your provider. You connect with other SocialIDs in the same way you connect with other users on sites like Facebook. Note that there is no need for the people you're connecting with to be using the same SocialID provider. You complete your social map by adding metadata about your connections.

A new social networking site comes out that you decide to try out. You sign up using your SocialID. The site recognises that you have a social map at your SocialID provider and gives you the option of using it. You say yes and the site then grabs the SocialIDs of all the users in your social map and checks to see if they've got an account and boom, your social network is built and available with that site without needing to tell it about your connections.

Any site is free to store extra information against any of their users, but they also have a responsibility to write any info that the SocialID provider can store back to that service. Any user can update their social map using any of the sites they are members of, and potentially also with the SocialID provider themselves.

I'm no expert on OpenID, in fact I will freely admit that I only understand the basics, but I can't see anything stopping such an extension being added to it. However it should be noted that essentially all SocialID is doing here is providing the unique ID for a given user. It already has this requirement at its core so it makes sense for SocialID to take advantage of it.

Anyways, that's the thought that's been going round the back of my mind lately. What does the world think?