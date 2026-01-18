<?php

namespace App\Enum\Auth;

enum PermissionsEnum: string
{
    // case NAMEINAPP = 'name-in-database';

    case TEST_PERMISSION = 'test permission';
    case CREATE_ACADEMIC_YEAR_SEMESTER = 'create academic-year-semesters';
    case LIST_ACADEMIC_YEAR_SEMESTER = 'list academic-year-semesters';
    case SHOW_ACADEMIC_YEAR_SEMESTER = 'show academic-year-semesters';
    case EDIT_ACADEMIC_YEAR_SEMESTER = 'edit academic-year-semesters';
    case DELETE_ACADEMIC_YEAR_SEMESTER = 'delete academic-year-semesters';

    case CREATE_ADMIN = 'create admins';
    case LIST_ADMIN = 'list admins';
    case EDIT_ADMIN = 'edit admins';
    case SHOW_ADMIN = 'show admins';

    case DELETE_ADMIN = 'delete admins';

    case CREATE_CLASSROOM_COURSE_TEACHER = 'create classroom-course-teachers';
    case LIST_CLASSROOM_COURSE_TEACHER = 'list classroom-course-teachers';
    case SHOW_CLASSROOM_COURSE_TEACHER = 'show classroom-course-teachers';
    case EDIT_CLASSROOM_COURSE_TEACHER = 'edit classroom-course-teachers';

    case DELETE_CLASSROOM_COURSE_TEACHER = 'delete classroom-course-teachers';

    case CREATE_CLASSROOM = 'create classrooms';
    case LIST_CLASSROOM = 'list classrooms';
    case SHOW_CLASSROOM = 'show classrooms';
    case EDIT_CLASSROOM = 'edit classrooms';

    case DELETE_CLASSROOM = 'delete classrooms';

    case CREATE_COURSE = 'create courses';
    case LIST_COURSE = 'list courses';
    case SHOW_COURSE = 'show courses';
    case EDIT_COURSE = 'edit courses';
    case DELETE_COURSE = 'delete courses';

    case CREATE_DEPARTMENT = 'create departments';
    case LIST_DEPARTMENT = 'list departments';
    case SHOW_DEPARTMENT = 'show departments';
    case EDIT_DEPARTMENT = 'edit departments';
    case DELETE_DEPARTMENT = 'delete departments';

    case CREATE_EXAM = 'create exams';
    case LIST_EXAM = 'list exams';
    case SHOW_EXAM = 'show exams';
    case EDIT_EXAM = 'edit exams';
    case DELETE_EXAM = 'delete exams';
    case LIST_EXAM_SCHEDULE = 'list exams schedule';

    case CREATE_LECTURE = 'create lectures';
    case LIST_LECTURE = 'list lectures';
    case SHOW_LECTURE = 'show lectures';
    case EDIT_LECTURE = 'edit lectures';
    case DELETE_LECTURE = 'delete lectures';

    case CREATE_MEETINGS = 'create meetings';
    case LIST_MEETINGS = 'list meetings';
    case SHOW_MEETINGS = 'show meetings';
    case EDIT_MEETINGS = 'edit meetings';
    case DELETE_MEETINGS = 'delete meetings';

    case CREATE_OPEN_COURSE_REGISTERATION = 'create open-course-registerations';
    case LIST_OPEN_COURSE_REGISTERATION = 'list open-course-registerations';
    case SHOW_OPEN_COURSE_REGISTERATION = 'show open-course-registerations';
    case EDIT_OPEN_COURSE_REGISTERATION = 'edit open-course-registerations';
    case DELETE_OPEN_COURSE_REGISTERATION = 'delete open-course-registerations';

    case CREATE_STUDENT = 'create students';
    case LIST_STUDENT = 'list students';
    case SHOW_STUDENT = 'show students';
    case EDIT_STUDENT = 'edit students';
    case DELETE_STUDENT = 'delete students';

    case CREATE_TEACHER = 'create teachers';
    case LIST_TEACHER = 'list teachers';
    case SHOW_TEACHER = 'show teachers';
    case EDIT_TEACHER = 'edit teachers';
    case DELETE_TEACHER = 'delete teachers';

    // filter header permissions
    case LIST_ACADEMIC_YEAR_SEMESTER_LIST = 'list academic-year-semesters list';
    case LIST_DEPARTMENT_LIST = 'list departments list';

    // student permissions
    case LIST_STUDENT_OPEN_COURSE_REGISTERATION_THIS_SEMESTER = 'list student open-course-registerations this-semester';
    case LIST_STUDENT_OPEN_COURSE_REGISTERATION = 'list student open-course-registerations';
    case LIST_STUDENT_OPEN_COURSE_REGISTERATION_MARKS_THIS_SEMESTER = 'list student open-course-registerations marks this-semester';
    case LIST_STUDENT_OPEN_COURSE_REGISTERATION_MARKS = 'list student open-course-registerations marks';
    case LIST_STUDENT_OPEN_COURSE_REGISTERATION_SCHEDULE = 'list student open-course-registerations schedule';

    case CREATE_STUDENT_OPEN_COURSE_REGISTERATION = 'create student open-course-registerations';
    case DELETE_STUDENT_OPEN_COURSE_REGISTERATION = 'delete student open-course-registerations';

    /**
     * @return PermissionsEnum[]
     **/
    public static function get_academic_year_semesters_permissions()
    {
        return
            [
                self::CREATE_ACADEMIC_YEAR_SEMESTER,
                self::EDIT_ACADEMIC_YEAR_SEMESTER,
                self::LIST_ACADEMIC_YEAR_SEMESTER,
                self::SHOW_ACADEMIC_YEAR_SEMESTER,
                self::DELETE_ACADEMIC_YEAR_SEMESTER,
            ];
    }

    /**
     * @return PermissionsEnum[]
     **/
    public static function get_admin_permissions()
    {
        return
            [
                self::CREATE_ADMIN,
                self::EDIT_ADMIN,
                self::LIST_ADMIN,
                self::SHOW_ADMIN,
                self::DELETE_ADMIN,
            ];
    }

    /**
     * @return PermissionsEnum[]
     **/
    public static function get_classroom_course_teachers_permissions()
    {
        return
            [
                self::CREATE_CLASSROOM_COURSE_TEACHER,
                self::EDIT_CLASSROOM_COURSE_TEACHER,
                self::LIST_CLASSROOM_COURSE_TEACHER,
                self::SHOW_CLASSROOM_COURSE_TEACHER,
                self::DELETE_CLASSROOM_COURSE_TEACHER,
            ];
    }

    /**
     * @return PermissionsEnum[]
     **/
    public static function get_classrooms_permissions()
    {
        return
            [
                self::CREATE_CLASSROOM,
                self::EDIT_CLASSROOM,
                self::LIST_CLASSROOM,
                self::SHOW_CLASSROOM,
                self::DELETE_CLASSROOM,
            ];
    }

    /**
     * @return PermissionsEnum[]
     **/
    public static function get_courses_permissions()
    {
        return
            [
                self::CREATE_COURSE,
                self::EDIT_COURSE,
                self::LIST_COURSE,
                self::SHOW_COURSE,
                self::DELETE_COURSE,
            ];
    }

    /**
     * @return PermissionsEnum[]
     **/
    public static function get_departments_permissions()
    {
        return
            [
                self::CREATE_DEPARTMENT,
                // self::EDIT_DEPARTMENT,
                self::LIST_DEPARTMENT,
                self::SHOW_DEPARTMENT,
                self::DELETE_DEPARTMENT,
            ];
    }

    /**
     * @return PermissionsEnum[]
     **/
    public static function get_exams_permissions()
    {
        return
            [
                self::CREATE_EXAM,
                self::EDIT_EXAM,
                self::LIST_EXAM,
                self::SHOW_EXAM,
                self::DELETE_EXAM,
                self::LIST_EXAM_SCHEDULE,
                // self::SHOW_EXAM_SCHEDULE,
            ];
    }

    /**
     * @return PermissionsEnum[]
     **/
    public static function get_lectures_permissions()
    {
        return
            [
                self::CREATE_LECTURE,
                self::EDIT_LECTURE,
                self::LIST_LECTURE,
                self::SHOW_LECTURE,
                self::DELETE_LECTURE,
            ];
    }

    /**
     * Summary of get_meetings_permissions
     *
     * @return PermissionsEnum[]
     */
    public static function get_meetings_permissions(): array
    {
        return [
            self::CREATE_MEETINGS,
            self::EDIT_MEETINGS,
            self::LIST_MEETINGS,
            self::SHOW_MEETINGS,
            self::DELETE_MEETINGS,
        ];
    }

    /**
     * @return PermissionsEnum[]
     **/
    public static function get_open_course_registerations_permissions()
    {
        return
            [
                self::CREATE_OPEN_COURSE_REGISTERATION,
                self::EDIT_OPEN_COURSE_REGISTERATION,
                self::LIST_OPEN_COURSE_REGISTERATION,
                self::SHOW_OPEN_COURSE_REGISTERATION,
                self::DELETE_OPEN_COURSE_REGISTERATION,
            ];
    }

    /**
     * @return PermissionsEnum[]
     **/
    public static function get_students_permissions()
    {
        return
            [
                self::CREATE_STUDENT,
                self::EDIT_STUDENT,
                self::LIST_STUDENT,
                self::SHOW_STUDENT,
                self::DELETE_STUDENT,
            ];
    }

    /**
     * @return PermissionsEnum[]
     **/
    public static function get_teachers_permissions()
    {
        return
            [
                self::CREATE_TEACHER,
                self::EDIT_TEACHER,
                self::LIST_TEACHER,
                self::SHOW_TEACHER,
                self::DELETE_TEACHER,
            ];
    }

    /**
     * @return PermissionsEnum[]
     **/
    public static function get_filter_header_permissions()
    {
        return
            [
                self::LIST_ACADEMIC_YEAR_SEMESTER_LIST,
                self::LIST_DEPARTMENT_LIST,
            ];
    }

    /**
     * @return PermissionsEnum[]
     **/
    public static function get_student_permissions()
    {
        return
            [
                self::LIST_STUDENT_OPEN_COURSE_REGISTERATION_THIS_SEMESTER,
                self::LIST_STUDENT_OPEN_COURSE_REGISTERATION,
                self::LIST_STUDENT_OPEN_COURSE_REGISTERATION_MARKS_THIS_SEMESTER,
                self::LIST_STUDENT_OPEN_COURSE_REGISTERATION_MARKS,
                self::LIST_STUDENT_OPEN_COURSE_REGISTERATION_SCHEDULE,
                self::CREATE_STUDENT_OPEN_COURSE_REGISTERATION,
                self::DELETE_STUDENT_OPEN_COURSE_REGISTERATION,
            ];
    }

    /**
     * Summary of oneOfMiddleware
     *
     * @param  PermissionsEnum[]  $roles
     */
    public static function oneOfPermissionsMiddleware(...$permissions): string
    {
        $permissions_count = count($permissions);

        $permissions_collections = collect($permissions);

        return
            $permissions_collections
                ->implode('|');

    }

    public static function onePermissionOnlyMiddleware(PermissionsEnum $permission): string
    {
        return 'permission:'.$permission->value;
    }
}
