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

    public function specialization() {
//        $this->title = isset($this->config->title) ?
//            format_string($this->config->title) :
//            format_string(get_string('pluginshortname', 'block_ekg'));
    }

    public function get_content() {
        global $CFG, $DB;

        if (isloggedin() && !isguestuser()) {

            $build = '';

            // This course - editing teachers only
            if (has_capability('moodle/course:update', get_context_instance(CONTEXT_COURSE, $this->page->course->id))) {

                $sql = "SELECT count( module ) AS modules
                        FROM ".$CFG->prefix."course_sections, ".$CFG->prefix."course_modules
                        WHERE ".$CFG->prefix."course_sections.id = ".$CFG->prefix."course_modules.section
                            AND ".$CFG->prefix."course_sections.course = :courseid";

                $params['courseid'] = $this->page->course->id;
                $resources = $DB->get_records_sql($sql, $params, 0, 1);

                foreach ($resources as $resource) {
                    $build .= '<p>This course has '.$resource->modules." resources.</p>\n";
                }
            } // end editing teacher only

            // All courses - admins only
            if (has_capability('moodle/site:config', get_context_instance(CONTEXT_COURSE, $this->page->course->id))) {

                $sql = "SELECT ".$CFG->prefix."course.id AS cid, ".$CFG->prefix."course.shortname, ".$CFG->prefix."course_modules.course AS courseid, count( module ) AS modules
                        FROM ".$CFG->prefix."course, ".$CFG->prefix."course_sections, ".$CFG->prefix."course_modules
                        WHERE ".$CFG->prefix."course.id = ".$CFG->prefix."course_sections.course
                            AND ".$CFG->prefix."course_sections.id = ".$CFG->prefix."course_modules.section
                        GROUP BY courseid
                        ORDER BY modules DESC";

                $resources = $DB->get_records_sql($sql, null, 0, 20);

                $build .= '<p>';
                foreach ($resources as $resource) {
                    $build .= '<a href="'.$CFG->wwwroot.'/course/view.php?id='.$resource->cid.'">'.$resource->shortname.'</a> - '.$resource->modules." mods.<br>\n";
                }
                $build .= "</p>\n";

            } // end admin only.

            // if is an admin
            // List top 20 resource users for whole Moodle.

            // This section sorts out the output to screen.
            $this->content          = new stdClass;
            $this->content->text    = $build;
            $this->content->footer  = '';

            return $this->content;

        } // End of if (isloggedin() && !isguestuser()) statement.

    } // End of get_content() function.

}
