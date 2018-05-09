<?php
/**
 * Created by PhpStorm.
 * User: Dark Wolf
 * Date: 11/03/2016
 * Time: 1:58 PM
 */
namespace App\Libraries;


class GeneralConstant
{
    /**
     * Constant use for User
     */
    const url = 'http://localhost:8000';

    const RESULT_SUCCESS = 1000;
    const RESULT_FALSE = -1000;
    const LOGGED_IN_ALREADY = 999;
    const NOT_LOGGED_IN = -999;
    const STILL_IN_DELAY_TIME = -997;
    const IS_ACTIVE = 1;
    const IS_DEACTIVATE = 0;

    // USER ROLE
    const SUPER_USER_ROLE = 1;
    const AGENT_ROLE = 2;
    const COMPANY_ROLE = 3;
    const LECTURER_ROLE = 4;
    const STUDENT_ROLE = 5;
    const NOT_CURRENT_USER = -1001;
    const IS_CURRENT_USER = 1001;
    const NOT_EXISTED = -998;

    // TIME
    const MINUTES_IN_WEEK = 24 * 60 * 7;
    const COUNT_TIME_TO_DELAY = 3;
    const COUNT_TIME_TO_LOCK = 10;
    const DELAY_TIME = 30; // 30 second

    // APPLIED STUDENT STATE
    const WAITING_COMPANY = 10;
    const NEED_CONFIRM = 11;
    const JOINED = 12;
    const FAIL = 13;
    const CANCELED = 14;
    const WAITING_STUDENT = 15;

    // GENDER
    const IS_FEMALE = 1;
    const IS_MALE = 0;

    //Project
    const PROJECT_HIRING = 0;
    const PROJECT_IN_PROGRESS = 1;
    const PROJECT_FINISHED = 2;
    const PROJECT_NEW = 4;
    const PROJECT_PUBLISHED = 0;
    const PROJECT_STOPPED = 5;
    const PROJECT_CANCELED = 6;

    // IMAGE
    const DEFAULT_AVATAR = 'default.png';
    // Project Name
    const PROJECT_NAME = 'UIT-Portal';
    //const LINKSAVECV = '/app/public/CV/';
    const LINKSAVECV = '/storage/CV/';

    // MESSAGE CONTENT

    const MESSAGE_LOGGED_IN_ALREADY = 'Bạn đang đăng nhập!';
    const MESSAGE_DEACTIVATE = 'Tài khoản của bạn đã bị khóa!';
    const MESSAGE_WRONG_EMAIL = 'Tài khoản email này không tồn tại!';
    const MESSAGE_WRONG_PASSWORD = 'Sai mật khẩu!';

    const MESSAGE_WRONG_PASSWORD_TIME_TO_DELAY = 'Bạn sai quá 3 lần. Vui lòng chờ 30s để đăng nhập lại!';

    //Confirm project
    const CANTUPDATERESULT = 2000;
    const CANTINSERT = 2001;

    // DEFAULT VALUE
    const DEFAULT_STRING ="";

    // RATING STUDENT
    const VALUE_LECTURER_RATING = 0.4;
    const VALUE_COMPANY_RATING = 0.6;
}