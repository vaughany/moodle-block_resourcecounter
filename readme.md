# Resource Counter block for Moodle 2.x

&copy; 2012 Paul Vaughan, paulvaughan@southdevon.ac.uk. 

Released under GPL 3.0. 

## Description

A quick, basic Moodle 2.x block which (for teachers) counts the number of modules / resources in a course, and (for site admins) across all courses in your Moodle installation.

Note that all activities and resources are counted, not just those of the 'resource' module type.

## Release History

In the 0.1 (alpha) release, counts everything and dumps the information onto the screen as a Moodle block.

In the 0.2 (beta) release, the user needs the 'moodle/course:update' capability (essentially an editing teacher) in order to see the number of resources, and the user needs the 'moodle/site:config' capability (site admin) to see the 'top n' list.

In the 0.2.1 release, made the code generally better. Irrelevant commented-out code removed, added better SQL code, that sort of thing.

In the 0.2.2 release, I moved strings in the code to the en_uk language pack. There's not many, to be honest...

In the 0.2.3 release, various changes and better code.  One thing to note however, is the resource count at the top (the teachers) may not match exactly the resource count at the bottom (the admins). I've used two different SQL queries: the bottom one is pretty much the same as how Moodle gets a course's resources, but the top one queries one of Moodle's tables directly, which may show extra entries for modules which are hidden from the course but which have been used in the past.  In our case, the OU Blog has entries in the course, but because it is hidden site-wide, it doesn't show in the bottom count, so the top count shows four more.

In the 0.2.4 release, cleared up (hopefully) the confusion around the different counts of resources. Teachers and admins will now see something like the following:

    "This course has 15 (16) sections containing 84 (90) resources."

* The 15 relates to the number of sections (topics, weeks etc) added to the course (the default is 10).
* The 16 relates to the total number of sections (topics, weeks etc) including the top, undeleteable section. This number will always be one greater than the first number.
* The 84 relates to the number of resources on the course, visible or hidden.
* The 90 relates to the total number of resources attached to the course, as they appear in Moodle's database. In this case, we have turned off the OU Blog plugin site-wide, but it still has six resources attached to the course, which is why this number is six higher than the previous number. (Hiding a plugin site-wide does not remove the instances of that plugin attached to courses, but hides them instead.)
