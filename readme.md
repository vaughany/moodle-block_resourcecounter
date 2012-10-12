# Resource Counter block for Moodle 2.x

(c) 2012 Paul Vaughan, paulvaughan@southdevon.ac.uk. Released under GPL 3.0. 

## Description

A quick, basic Moodle 2.x block which (for teachers) counts the number of modules / resources in a course, and (for site admins) across all courses in your Moodle installation.

Note that all activities and resources are counted, not just those of the 'resource' module type.

## Release History

In the 0.1 (alpha) release, counts everything and dumps the information onto the screen as a Moodle block.

In the 0.2 (beta) release, the user needs the 'moodle/course:update' capability (essentially an editing teacher) in order to see the number of resources, and the user needs the 'moodle/site:config' capability (site admin) to see the 'top n' list.

In the 0.2.1 release, made the code generally better. Irrelevant commented-out code removed, added better SQL code, that sort of thing.

In the 0.2.2 release, I moved strings in the code to the en_uk language pack. There's not many, to be honest...