# Resource Counter block for Moodle 2.x

(c) 2012 Paul Vaughan, paulvaughan@southdevon.ac.uk
Released under GPL 3.0

A quick and dirty Moodle 2.x block which counts the number of modules / resources in a course, and across all courses in your Moodle installation.

Note that all activities and resources are counted, not just those of the 'resource' module type.

In the 0.2 release, the user needs the 'moodle/course:update' capability (essentially an editing teacher) in order to see the number of resources, and the user needs the 'moodle/site:config' capability (site admin) to see the 'top n' list.