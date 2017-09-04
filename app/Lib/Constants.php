<?php
namespace App\Lib;

class ResultCode
{
    const SUCCESS = '0';
    const ERROR_AUTHENTICATE = '8';
    const ERROR = '9';
}
class SECRECT_KEY
{
    const KEY = "machieru@123";
}
class FomatDateSQL
{
    const DATE_SQL = "YYYY-MM-DD";
    const DATE_TIME = "YYYY-MM-DD HH:mm:ss";
    const DATE_TIME_SPLASH = "YYYY/MM/DD HH:mm:ss";
    const DATE_SPLASH = "YYYY/MM/DD";
    const DATE_TIME_H = "YYYY-MM-DD HH:00:00";
    const MONTH_DAY = "MM-DD";
    const MONTH_DAY_SPLASH = "MM/DD";
    const DATE_TIME_NORMAL = "YYYYMMDDhhmmss";
}

class Constants
{
    const MIN_LENGTH_STRING = 3;
    const MIN_LENGTH_USER_ID = 4;
    const MAX_LENGTH_USER_ID = 45;
    const MIN_LENGTH_PASS = 4;
    const MAX_LENGTH_PASS = 20;
}

class FileType {
    const IMAGE_TYPE = "bmp,gif,jpeg,jpg,png";
    const VIDEO_TYPE = "flv,mov,avi,mp4,ogg,webm";
}

class FIREBASE_CONFIG
{
    const PUSH_API_KEY = "AAAAW3RuKoY:APA91bG5wZ2RLJborKEBbfJGWcr_tt9UMDvK1SLXev5Ml1jw0yilh_pTL5NiSktxdspl_7xsJhOkLxOceBhiCdihwrgibUMlHkqdfYad6OAJiHNzBSl8iEsNrDdYmaWkhfED7k2SdacK";  // server api key (cloud message)
    const TIME_TO_LIVE = '30';
}

