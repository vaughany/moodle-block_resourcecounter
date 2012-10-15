<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Resource Counter block for Moodle 2.0 and onwards
 *
 * @package    block_resourcecounter
 * @copyright  2012 onwards Paul Vaughan, paulvaughan@southdevon.ac.uk
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class block_resourcecounter extends block_base {

    public function init() {
        $this->title = get_string('pluginname', 'block_resourcecounter');
    }

    public function applicable_formats() {
        return array('all' => true);
    }

    public function has_config() {
        return false;
    }

    public function instance_allow_multiple() {
        return false;
    }

    public function get_content() {
        global $CFG, $DB;

        if (isloggedin() && !isguestuser()) {

            $build = '';

            // This course - editing teachers only.
            if (has_capability('moodle/course:update', get_context_instance(CONTEXT_COURSE, $this->page->course->id))) {

                $sql1 = "SELECT count(*) AS cs
                            FROM {course_sections}
                            WHERE course = :courseid";

                $sql2 = "SELECT count(*) AS cm
                            FROM {course_modules}
                            WHERE course = :courseid";

                $params = array('courseid' => $this->page->course->id);
                $res1 = $DB->get_record_sql($sql1, $params);
                $res2 = $DB->get_record_sql($sql2, $params);

                $build .= '<p>'.get_string('coursehas', 'block_resourcecounter').
                    ($res1->cs - 1).' ('.$res1->cs.')'.get_string('sections', 'block_resourcecounter').
                    $res2->cm.get_string('resources', 'block_resourcecounter')."</p>\n";

            }

            // All courses - admins only.
            if (has_capability('moodle/site:config', get_context_instance(CONTEXT_COURSE, $this->page->course->id))) {

                $sql = "SELECT {course}.id AS cid, {course}.shortname, {course_modules}.course AS courseid, count( module ) AS modules
                        FROM {course}, {course_sections}, {course_modules}
                        WHERE {course}.id = {course_sections}.course
                            AND {course_sections}.id = {course_modules}.section
                        GROUP BY courseid
                        ORDER BY modules DESC";

                $resources = $DB->get_records_sql($sql, null, 0, 20);

                $build .= "<p>\n";
                foreach ($resources as $resource) {
                    $build .= '<a href="'.$CFG->wwwroot.'/course/view.php?id='.$resource->cid.'">'.
                        $resource->shortname.'</a> - '.$resource->modules.get_string('modules', 'block_resourcecounter')."<br>\n";
                }
                $build .= "</p>\n";
            }

            $this->content          = new stdClass;
            $this->content->text    = $build;
            $this->content->footer  = '';

            return $this->content;

        } // End of if (isloggedin() && !isguestuser()) statement.

    } // End of get_content() function.

}
