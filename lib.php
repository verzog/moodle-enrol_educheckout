<?php
// This file is part of Moodle - https://moodle.org/
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
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

/**
 * EduCheckout enrolment plugin main library.
 *
 * Derived from the Moodle core manual enrolment plugin, trimmed to the
 * subset required by the local_educheckout storefront (cart-driven enrolment).
 *
 * @package    enrol_educheckout
 * @copyright  2010 Petr Skoda {@link http://skodak.org}
 * @copyright  2015 Thomas Threadgold, LearningWorks Ltd
 * @copyright  2026 Vernon Spain
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * EduCheckout enrolment plugin implementation.
 */
class enrol_educheckout_plugin extends enrol_plugin {
    /** @var stdClass|null cached enroller user */
    protected $lastenroller = null;

    /** @var int instance id the cached enroller belongs to */
    protected $lastenrollerinstanceid = 0;

    /**
     * Roles may be tweaked by managers after enrolment.
     *
     * @return bool
     */
    public function roles_protected() {
        return false;
    }

    /**
     * Users with the enrol capability may enrol others.
     *
     * @param stdClass $instance
     * @return bool
     */
    public function allow_enrol(stdClass $instance) {
        return true;
    }

    /**
     * Users with the unenrol capability may unenrol others.
     *
     * @param stdClass $instance
     * @return bool
     */
    public function allow_unenrol(stdClass $instance) {
        return true;
    }

    /**
     * Users with the manage capability may tweak period and status.
     *
     * @param stdClass $instance
     * @return bool
     */
    public function allow_manage(stdClass $instance) {
        return true;
    }

    /**
     * Use the standard core enrolment instance editing UI.
     *
     * @return bool
     */
    public function use_standard_editing_ui() {
        return true;
    }

    /**
     * Link to add a new instance (one instance per course only).
     *
     * @param int $courseid
     * @return moodle_url|null
     */
    public function get_newinstance_link($courseid) {
        global $DB;

        $context = context_course::instance($courseid, MUST_EXIST);

        if (!has_capability('moodle/course:enrolconfig', $context) || !has_capability('enrol/educheckout:config', $context)) {
            return null;
        }

        if ($DB->record_exists('enrol', ['courseid' => $courseid, 'enrol' => 'educheckout'])) {
            return null;
        }

        return new moodle_url('/enrol/editinstance.php', ['type' => 'educheckout', 'courseid' => $courseid]);
    }

    /**
     * Add a default instance using admin-configured defaults.
     *
     * @param stdClass $course
     * @return int|null instance id
     */
    public function add_default_instance($course) {
        $expirynotify = $this->get_config('expirynotify', 0);
        if ($expirynotify == 2) {
            $expirynotify = 1;
            $notifyall = 1;
        } else {
            $notifyall = 0;
        }
        $fields = [
            'status' => $this->get_config('status'),
            'roleid' => $this->get_config('roleid', 0),
            'enrolperiod' => $this->get_config('enrolperiod', 0),
            'expirynotify' => $expirynotify,
            'notifyall' => $notifyall,
            'expirythreshold' => $this->get_config('expirythreshold', 86400),
        ];
        return $this->add_instance($course, $fields);
    }

    /**
     * Add a new instance. Only one educheckout instance is allowed per course.
     *
     * @param stdClass $course
     * @param array|null $fields
     * @return int|null instance id
     */
    public function add_instance($course, ?array $fields = null) {
        global $DB;

        if ($DB->record_exists('enrol', ['courseid' => $course->id, 'enrol' => 'educheckout'])) {
            return null;
        }

        return parent::add_instance($course, $fields);
    }

    /**
     * Status options for the instance edit form.
     *
     * @return array
     */
    protected function get_status_options() {
        return [
            ENROL_INSTANCE_ENABLED => get_string('yes'),
            ENROL_INSTANCE_DISABLED => get_string('no'),
        ];
    }

    /**
     * Expiry notify options for the instance edit form.
     *
     * @return array
     */
    protected function get_expirynotify_options() {
        return [
            0 => get_string('no'),
            1 => get_string('expirynotifyenroller', 'core_enrol'),
            2 => get_string('expirynotifyall', 'core_enrol'),
        ];
    }

    /**
     * Build the instance edit form.
     *
     * @param stdClass $instance
     * @param MoodleQuickForm $mform
     * @param context $context
     * @return void
     */
    public function edit_instance_form($instance, MoodleQuickForm $mform, $context) {
        $mform->addElement('select', 'status', get_string('status', 'enrol_educheckout'), $this->get_status_options());

        $roles = $this->extend_assignable_roles($context, $instance->roleid);
        $mform->addElement('select', 'roleid', get_string('defaultrole', 'enrol_educheckout'), $roles);

        $mform->addElement(
            'duration',
            'enrolperiod',
            get_string('enrolperiod', 'enrol_educheckout'),
            ['optional' => true, 'defaultunit' => 86400]
        );

        $mform->addElement(
            'select',
            'expirynotify',
            get_string('expirynotify', 'core_enrol'),
            $this->get_expirynotify_options()
        );

        $mform->addElement(
            'duration',
            'expirythreshold',
            get_string('expirythreshold', 'core_enrol'),
            ['optional' => false, 'defaultunit' => 86400]
        );
        $mform->hideIf('expirythreshold', 'expirynotify', 'eq', 0);

        if (enrol_accessing_via_instance($instance)) {
            $mform->addElement(
                'static',
                'selfwarn',
                get_string('instanceeditselfwarning', 'core_enrol'),
                get_string('instanceeditselfwarningtext', 'core_enrol')
            );
        }
    }

    /**
     * Validate the instance edit form.
     *
     * @param array $data
     * @param array $files
     * @param stdClass $instance
     * @param context $context
     * @return array errors
     */
    public function edit_instance_validation($data, $files, $instance, $context) {
        $errors = [];

        if (!empty($data['expirynotify']) && $data['expirythreshold'] < 86400) {
            $errors['expirythreshold'] = get_string('errorthresholdlow', 'core_enrol');
        }

        return $errors;
    }

    /**
     * Scheduled-task entry point: expire educheckout enrolments.
     *
     * @param progress_trace $trace
     * @param int|null $courseid limit to one course, null means all
     * @return int 0 ok, 2 plugin disabled
     */
    public function sync(progress_trace $trace, $courseid = null) {
        global $DB;

        if (!enrol_is_enabled('educheckout')) {
            $trace->finished();
            return 2;
        }

        core_php_time_limit::raise();
        raise_memory_limit(MEMORY_HUGE);

        $trace->output('Verifying educheckout enrolment expiration...');

        $params = [
            'now' => time(),
            'useractive' => ENROL_USER_ACTIVE,
            'courselevel' => CONTEXT_COURSE,
        ];
        $coursesql = '';
        if ($courseid) {
            $coursesql = 'AND e.courseid = :courseid';
            $params['courseid'] = $courseid;
        }

        $action = $this->get_config('expiredaction', ENROL_EXT_REMOVED_KEEP);

        if ($action == ENROL_EXT_REMOVED_UNENROL) {
            $instances = [];
            $sql = "SELECT ue.*, e.courseid, c.id AS contextid
                      FROM {user_enrolments} ue
                      JOIN {enrol} e ON (e.id = ue.enrolid AND e.enrol = 'educheckout')
                      JOIN {context} c ON (c.instanceid = e.courseid AND c.contextlevel = :courselevel)
                     WHERE ue.timeend > 0 AND ue.timeend < :now
                           $coursesql";
            $rs = $DB->get_recordset_sql($sql, $params);
            foreach ($rs as $ue) {
                if (empty($instances[$ue->enrolid])) {
                    $instances[$ue->enrolid] = $DB->get_record('enrol', ['id' => $ue->enrolid]);
                }
                $instance = $instances[$ue->enrolid];
                $ras = ['userid' => $ue->userid, 'contextid' => $ue->contextid, 'component' => '', 'itemid' => 0];
                role_unassign_all($ras, true);
                $this->unenrol_user($instance, $ue->userid);
                $trace->output("unenrolling expired user $ue->userid from course $instance->courseid", 1);
            }
            $rs->close();
            unset($instances);
        } else if ($action == ENROL_EXT_REMOVED_SUSPENDNOROLES || $action == ENROL_EXT_REMOVED_SUSPEND) {
            $instances = [];
            $sql = "SELECT ue.*, e.courseid, c.id AS contextid
                      FROM {user_enrolments} ue
                      JOIN {enrol} e ON (e.id = ue.enrolid AND e.enrol = 'educheckout')
                      JOIN {context} c ON (c.instanceid = e.courseid AND c.contextlevel = :courselevel)
                     WHERE ue.timeend > 0 AND ue.timeend < :now
                           AND ue.status = :useractive
                           $coursesql";
            $rs = $DB->get_recordset_sql($sql, $params);
            foreach ($rs as $ue) {
                if (empty($instances[$ue->enrolid])) {
                    $instances[$ue->enrolid] = $DB->get_record('enrol', ['id' => $ue->enrolid]);
                }
                $instance = $instances[$ue->enrolid];
                if ($action == ENROL_EXT_REMOVED_SUSPENDNOROLES) {
                    $ras = ['userid' => $ue->userid, 'contextid' => $ue->contextid, 'component' => '', 'itemid' => 0];
                    role_unassign_all($ras, true);
                    $this->update_user_enrol($instance, $ue->userid, ENROL_USER_SUSPENDED);
                    $trace->output("suspending expired user $ue->userid in course $instance->courseid, roles unassigned", 1);
                } else {
                    $this->update_user_enrol($instance, $ue->userid, ENROL_USER_SUSPENDED);
                    $trace->output("suspending expired user $ue->userid in course $instance->courseid, roles kept", 1);
                }
            }
            $rs->close();
            unset($instances);
        }

        $trace->output('...educheckout enrolment updates finished.');
        $trace->finished();
        return 0;
    }

    /**
     * The user responsible for educheckout enrolments in the given instance.
     *
     * @param int $instanceid
     * @return stdClass user record
     */
    protected function get_enroller($instanceid) {
        global $DB;

        if ($this->lastenrollerinstanceid == $instanceid && $this->lastenroller) {
            return $this->lastenroller;
        }

        $instance = $DB->get_record('enrol', ['id' => $instanceid, 'enrol' => $this->get_name()], '*', MUST_EXIST);
        $context = context_course::instance($instance->courseid);

        if ($users = get_enrolled_users($context, 'enrol/educheckout:manage')) {
            $users = sort_by_roleassignment_authority($users, $context);
            $this->lastenroller = reset($users);
            unset($users);
        } else {
            $this->lastenroller = parent::get_enroller($instanceid);
        }

        $this->lastenrollerinstanceid = $instanceid;
        return $this->lastenroller;
    }

    /**
     * User enrolment actions (edit / unenrol) via the core enrolment pages.
     *
     * @param course_enrolment_manager $manager
     * @param stdClass $ue
     * @return array
     */
    public function get_user_enrolment_actions(course_enrolment_manager $manager, $ue) {
        $actions = [];
        $context = $manager->get_context();
        $instance = $ue->enrolmentinstance;
        $params = $manager->get_moodlepage()->url->params();
        $params['ue'] = $ue->id;

        if ($this->allow_unenrol_user($instance, $ue) && has_capability('enrol/educheckout:unenrol', $context)) {
            $url = new moodle_url('/enrol/unenroluser.php', $params);
            $actions[] = new user_enrolment_action(
                new pix_icon('t/delete', ''),
                get_string('unenrol', 'core_enrol'),
                $url,
                ['class' => 'unenrollink', 'rel' => $ue->id]
            );
        }
        if ($this->allow_manage($instance) && has_capability('enrol/educheckout:manage', $context)) {
            $url = new moodle_url('/enrol/editenrolment.php', $params);
            $actions[] = new user_enrolment_action(
                new pix_icon('t/edit', ''),
                get_string('edit'),
                $url,
                ['class' => 'editenrollink', 'rel' => $ue->id]
            );
        }
        return $actions;
    }

    /**
     * Restore an enrolment instance.
     *
     * @param restore_enrolments_structure_step $step
     * @param stdClass $data
     * @param stdClass $course
     * @param int $oldid
     * @return void
     */
    public function restore_instance(restore_enrolments_structure_step $step, stdClass $data, $course, $oldid) {
        global $DB;

        if ($instances = $DB->get_records('enrol', ['courseid' => $data->courseid, 'enrol' => 'educheckout'], 'id')) {
            $instance = reset($instances);
            $instanceid = $instance->id;
        } else {
            $instanceid = $this->add_instance($course, (array) $data);
        }
        $step->set_mapping('enrol', $oldid, $instanceid);
    }

    /**
     * Restore a user enrolment.
     *
     * @param restore_enrolments_structure_step $step
     * @param stdClass $data
     * @param stdClass $instance
     * @param int $userid
     * @param int $oldinstancestatus
     * @return void
     */
    public function restore_user_enrolment(
        restore_enrolments_structure_step $step,
        $data,
        $instance,
        $userid,
        $oldinstancestatus
    ) {
        global $DB;

        $ue = $DB->get_record('user_enrolments', ['enrolid' => $instance->id, 'userid' => $userid]);
        $enrol = false;
        if ($ue && $ue->status == ENROL_USER_ACTIVE) {
            if ($data->status == ENROL_USER_ACTIVE) {
                if ($data->timestart > $ue->timestart) {
                    $data->timestart = $ue->timestart;
                    $enrol = true;
                }
                if ($data->timeend == 0) {
                    if ($ue->timeend != 0) {
                        $enrol = true;
                    }
                } else if ($ue->timeend == 0) {
                    $data->timeend = 0;
                } else if ($data->timeend < $ue->timeend) {
                    $data->timeend = $ue->timeend;
                    $enrol = true;
                }
            }
        } else {
            if ($instance->status == ENROL_INSTANCE_ENABLED && $oldinstancestatus != ENROL_INSTANCE_ENABLED) {
                $data->status = ENROL_USER_SUSPENDED;
            }
            $enrol = true;
        }

        if ($enrol) {
            $this->enrol_user($instance, $userid, null, $data->timestart, $data->timeend, $data->status);
        }
    }

    /**
     * Restore a role assignment.
     *
     * @param stdClass $instance
     * @param int $roleid
     * @param int $userid
     * @param int $contextid
     * @return void
     */
    public function restore_role_assignment($instance, $roleid, $userid, $contextid) {
        role_assign($roleid, $userid, $contextid, '', 0);
    }

    /**
     * Restore group membership.
     *
     * @param stdClass $instance
     * @param int $groupid
     * @param int $userid
     * @return void
     */
    public function restore_group_member($instance, $groupid, $userid) {
        global $CFG;
        require_once($CFG->dirroot . '/group/lib.php');

        groups_add_member($groupid, $userid);
    }

    /**
     * Can the instance be deleted via the standard UI?
     *
     * @param stdClass $instance
     * @return bool
     */
    public function can_delete_instance($instance) {
        $context = context_course::instance($instance->courseid);
        return has_capability('enrol/educheckout:config', $context);
    }

    /**
     * Can the instance be hidden/shown via the standard UI?
     *
     * @param stdClass $instance
     * @return bool
     */
    public function can_hide_show_instance($instance) {
        $context = context_course::instance($instance->courseid);
        return has_capability('enrol/educheckout:config', $context);
    }
}
