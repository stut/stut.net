---
layout: "post"
title: "Amazon S3 SLA"
time: 13:56:21
categories: 
- technology
---
Amazon have <a href="http://aws.typepad.com/aws/2007/10/amazon-s3-at-yo.html" title="Amazon announces an SLA for S3">announced an SLA for their S3 service</a> which is, you know, good news. But like every other company on the planet they place responsibility for monitoring whether they meet it on the customer.

By definition an SLA is a company committing to a level of service. If they then expect you to monitor their availability they are essentially saying they'll only get punished for breaching it if you notice that they've breached it, and even then only if you "apply" for compensation. I'd be interested to know what percentage of people monitor their interaction with S3 to the level required to catch breaches, and how many will be adding it based on the arrival of the SLA.

In my opinion if a company commits to meeting an SLA they should be monitoring it internally and automatically apply the penalties should they breach it. Amazon must be internally monitoring the performance of their service so they almost certainly know when they don't meet the SLA. For me that would demonstrate their commitment to a specified service level more than simply publishing a document and putting a claims process in place.

I'd be interested in hearing about peoples experiences with claiming against SLAs. Do they all make you jump through hoops to avoid paying out?