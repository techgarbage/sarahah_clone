<?php

namespace App\Lib;
//require_once ROOT . DS . 'vendor' . DS . 'aws' . DS . 'aws-autoloader.php';
//use Moment\Moment;
use App\Models\MachieruPage;
use App\Models\NavigationMenu;
use App\Lib\FIREBASE_CONFIG;
use DateTime;

use DateTimeZone;

use Illuminate\Support\Facades\Request;
use Image;

use Sunra\PhpSimple\HtmlDomParser;

//PUSH

class Utils
{
    //=========== PUSH ============================================
    /*
    * Created by AnhNT
    *
    */
    static function pushNotification($params)
    {

//      rg_ids, notification_id, type, title

        $msg = array
        (
            "message" => $params['msg'],
        );

        $fields = array
        (
            'registration_ids' 	=> $params['rg_ids'],
            'data'			=> $msg
        );

        $headers = array
        (
            'Authorization: key=' . FIREBASE_CONFIG::PUSH_API_KEY,
            'Content-Type: application/json'
        );

        $ch = curl_init();
        curl_setopt( $ch,CURLOPT_URL, 'https://android.googleapis.com/gcm/send' );
        curl_setopt( $ch,CURLOPT_POST, true );
        curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
        curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
        $result = curl_exec($ch );
        $err = curl_error($ch);
        curl_close( $ch );
        if($err){
            return array(
                'error'=> $err,
                'result' => null
            );
        }

        return array(
            'error'=> null,
            'result' => 'ok'
        );
    }

    static function genCode($length = 12, $type = 'all'){
        $randomString = "";
        switch($type){
            case 'number':
                $randomString = "1234567890";
                break;
            case 'char':
                $randomString = "QWERTYUIOPASDFGHJKLZXCVBNM";
                break;
            case 'alpha':
                $randomString = "QWERTYUIOPASDFGHJKLZXCVBNMqwertyuiopasdffghjklzxcvbnm1234567890";
                break;
            default:
                $randomString = 'QWERTYUIOPASDFGHJKLZXCVBNM1234567890';
        }
        $str = "";
        for($i=1; $i<=$length; $i++){
            $str .=substr($randomString, rand(0,strlen($randomString)-1),1);
        }
        return $str;
    }
    static function resultForResponse($result_code, $result_detail, $result_error = null)
    {
        if ($result_code != "0") {
            //        console.log_error("ERRORRRRR",$result_detail);
        }
        $objToJson = array();
        if (!$result_error) {
            $objToJson['result_code'] = $result_code;
            $objToJson['result_detail'] = $result_detail;
        } else {
            $objToJson['result_code'] = $result_code;
            $objToJson['result_detail'] = $result_detail;
            $objToJson['result_error'] = $result_error;
        }

        return response()->json($objToJson);
    }
    static function getResult($error, $result = null)
    {
        return array(
            'error' => $error,
            'result' => $result
        );
    }
    static function getResultEvent($error, $result = null, $event)
    {
        return array(
            'error' => $error,
            'result' => $result,
            'event' => $event
        );
    }
    static function sanitize($string, $force_lowercase = true, $anal = false)
    {
        $strip = array("~", "`", "!", "@", "#", "$", "%", "^", "&", "*", "(", ")", "_", "=", "+", "[", "{", "]",
            "}", "\\", "|", ";", ":", "\"", "'", "&#8216;", "&#8217;", "&#8220;", "&#8221;", "&#8211;", "&#8212;",
            "â€”", "â€“", ",", "<", ".", ">", "/", "?");
        $clean = trim(str_replace($strip, "", strip_tags($string)));
        $clean = preg_replace('/\s+/', "-", $clean);
        $clean = ($anal) ? preg_replace("/[^a-zA-Z0-9]/", "", $clean) : $clean ;

        return ($force_lowercase) ?
            (function_exists('mb_strtolower')) ?
                mb_strtolower($clean, 'UTF-8') :
                strtolower($clean) :
            $clean;
    }
    static function hasKeyAssign($request, $key, $arrReceive)
    {
        if ($request->has($key) || $request->input($key) == null) {
            $arrReceive[$key] = $request->input($key);
        }

        return $arrReceive;
    }
    static function uploadFile($folder, $file, $name, $size = null, $flag_extentsion = null)
    {
        // setup dir names absolute and relative
        $destinationPath = public_path() . '/uploads/' . $folder;
        // create the folder if it does not exist
        if (!is_dir($destinationPath)) {
            mkdir($destinationPath);
        }

        $fileType = $file->getClientOriginalExtension();
        if($flag_extentsion){
            $fileName = $name . '.'. $fileType;
        }else{
            $fileName = $name . '_' . substr(sha1(mt_rand()), 0, 5) . '.' . $fileType;
        }


        if(!$size) {
            $img = $file->move($destinationPath, $fileName);
        }else{
            $img = $file->move($destinationPath, $fileName);
//            $img = Image::make($file->getRealPath());
//            $img->resize($size['width'], $size['height'], function ($constraint) {
////            $constraint->aspectRatio();
//            })->save($destinationPath.'/'.$fileName);
        }

        if (!$img) {
            return array(
                'error' => 'upload fail',
                'result' => null
            );
        }

        return array(
            'error' => null,
            'result' => $folder . '/' . $fileName
        );
    }
    static function uploadVideo($folder, $file, $name)
    {
        // setup dir names absolute and relative
        $destinationPath = public_path() . '/uploads/' . $folder;
        // create the folder if it does not exist
        if (!is_dir($destinationPath)) {
            mkdir($destinationPath);
        }
//        $fileType = $file->getClientOriginalExtension();
//        $fileName = $name . '.' . $fileType;
//
//        if(!$size) {
//            $img = $file->move($destinationPath, $fileName);
//        }else{
//            $img = Image::make($file->getRealPath());
//            $img->resize($size['width'], $size['height'], function ($constraint) {
////            $constraint->aspectRatio();
//            })->save($destinationPath.'/'.$fileName);
//        }

//        $files = Request::file($file);
        $filename = $file->getClientOriginalName();
        $path = public_path().'/uploads/'. $folder;
        $files = $file->move($path, $filename);


        if (!$files) {
            return array(
                'error' => 'upload fail',
                'result' => null
            );
        }

        return array(
            'error' => null,
            'result' => $folder . '/' . $filename
        );
    }
    static function uploadMulti($folder, $file, $name, $size = null)
    {
        // setup dir names absolute and relative
        $destinationPath = public_path() . '/uploads/' . $folder;
        // create the folder if it does not exist
        if (!is_dir($destinationPath)) {
            mkdir($destinationPath);
        }
        $arr_file = [];
        for($i = 0; $i< count($file); $i++){
            $fileType[$i] = $file[$i]->getClientOriginalExtension();
            $fileName[$i] = $name . substr(sha1(mt_rand()), 0, 5) . '.' . $fileType[$i];

            if(!$size) {
                $img = $file[$i]->move($destinationPath, $fileName[$i]);
            }else{
                $img = $file[$i]->move($destinationPath, $fileName[$i]);
//                $img = Image::make($file[$i]->getRealPath());
//                $img->resize($size['width'], $size['height'], function ($constraint) {
//    //            $constraint->aspectRatio();
//                })->save($destinationPath.'/'.$fileName[$i]);
            }

//            array_push($arr_file, '"'."image".$i.":".$fileName[$i].'",');
            array_push($arr_file, "image".$i.":".$fileName[$i]);

        }
        $json = json_encode($arr_file);


        if (!$arr_file) {
            return array(
                'error' => 'upload fail',
                'result' => null
            );
        }

        return array(
            'error' => null,
            'result' => $json
        );
    }
    static function getListIdFromListData($list_data, $key)
    {
        $arr_id= array();
        for ($i = 0; $i < count($list_data); $i++) {
            array_push($arr_id, $list_data[$i][$key]);
        }
        return $arr_id;
    }
    static function formatStringToDate($strDate, $format = 'sql', $prefix = '-', $show_time = false){
        $t = strtotime($strDate);
        switch($format){
            case "vi":
                return $show_time? date('s:i:H d'.$prefix.'m'.$prefix.'Y', $t) : date('d'.$prefix.'m'.$prefix.'Y', $t);
            case 'en':
                return $show_time? date('m'.$prefix.'d'.$prefix.'Y H:i:s', $t) : date('m'.$prefix.'d'.$prefix.'Y', $t);
            case 'ja':
                return $show_time? date('Y'.$prefix.'m'.$prefix.'d H:i:s', $t) : date('Y'.$prefix.'m'.$prefix.'d', $t);
            default:
                return $show_time? date('Y-m-d H:i:s', $t) : date('Y-m-d', $t);
        }
    }
    static  function formatDateToString($object, $format = 'df', $prefix = '-', $show_time = false){
        switch($format){
            case "vi":
                return $show_time? date_format($object, 'H:i d'.$prefix.'m'.$prefix.'Y') : date_format($object, 'd'.$prefix.'m'.$prefix.'Y');
            case 'en':
                return $show_time? date_format($object, 'm'.$prefix.'d'.$prefix.'Y H:i:s') : date_format($object, 'm'.$prefix.'d'.$prefix.'Y');
            case 'ja':
                return $show_time? date_format($object, 'Y'.$prefix.'m'.$prefix.'d H:i:s') : date_format($object, 'Y'.$prefix.'m'.$prefix.'d') ;
            case 'sql':
                return $show_time? date_format($object, 'Y'.$prefix.'m'.$prefix.'d H:i:s') : date_format($object, 'Y'.$prefix.'m'.$prefix.'d') ;
            default:
                return $show_time? date_format($object, 'Y'.$prefix.'m'.$prefix.'d H:i') : date_format($object, 'Y'.$prefix.'m'.$prefix.'d');
        }
    }


    /**
     * get content html and convert to dom
     * @param $url (url site)
     * @param $file_name (name file to download)
     * @return \simplehtmldom_1_5\simple_html_dom
     */
    static function getDom($url, $file_name)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);// Khi thực thi lệnh sẽ k view ra trình duyệt mà lưu lại vào 1 biến kiểu string
        $content = curl_exec($ch);
        curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,5);
        if(curl_errno($ch))
        {
            return '';
        }
        curl_close($ch);
        file_put_contents(public_path() . '/uploads/event/' . $file_name, $content);
        $dom = HtmlDomParser::str_get_html($content);
        return $dom;
    }

    /**
     * compare content two file
     * @param $outer_site
     * @param $local_site
     * @return int
     */
    static function compareAllContentSite($outer_site, $local_site){
        //outer content
        $ch = curl_init($outer_site);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $outer_content = curl_exec($ch);
        curl_close($ch);
        //local content
        $local_content = file_get_contents(public_path() . '/uploads/event/'. $local_site);
        return strcmp($outer_content, $local_content);
    }

    /**
     * get content local file with dom
     * @param $url
     * @return \simplehtmldom_1_5\simple_html_dom
     */
    static function getLocalDom($url){
        $content = file_get_contents(public_path() . '/uploads/event/'. $url);
        $dom = HtmlDomParser::str_get_html($content);
        return $dom;
    }

    /**
     * compare two site by special key tag
     * @param $outer_site
     * @param $local_site
     * @param $key
     * @param int $position
     * @return int
     */
    static function compareSiteByKeyTag($outer_site, $local_site, $key, $position = 0){
        $local_page = self::getLocalDom($local_site);
        $outer_page = self::getDom($outer_site,$local_site);
        $outer_content = "";
        $local_content = "";

        if($local_page && $local_page != false){
            $local_content = $local_page->find($key, $position);
        }
        if($outer_page){
            $outer_content = $outer_page->find($key, $position);
        }
//return $outer_content;


        return strcmp($outer_content, $local_content);
    }

    static function removeNamespaceFromXML( $xml )
    {
        // Because I know all of the the namespaces that will possibly appear in
        // in the XML string I can just hard code them and check for
        // them to remove them
        $toRemove = ['rap', 'turss', 'crim', 'cred', 'j', 'rap-code', 'evic'];
        // This is part of a regex I will use to remove the namespace declaration from string
        $nameSpaceDefRegEx = '(\S+)=["\']?((?:.(?!["\']?\s+(?:\S+)=|[>"\']))+.)["\']?';

        // Cycle through each namespace and remove it from the XML string
        foreach( $toRemove as $remove ) {
            // First remove the namespace from the opening of the tag
            $xml = str_replace('<' . $remove . ':', '<', $xml);
            // Now remove the namespace from the closing of the tag
            $xml = str_replace('</' . $remove . ':', '</', $xml);
            // This XML uses the name space with CommentText, so remove that too
            $xml = str_replace($remove . ':commentText', 'commentText', $xml);
            // Complete the pattern for RegEx to remove this namespace declaration
            $pattern = "/xmlns:{$remove}{$nameSpaceDefRegEx}/";
            // Remove the actual namespace declaration using the Pattern
            $xml = preg_replace($pattern, '', $xml, 1);
        }

        // Return sanitized and cleaned up XML with no namespaces
        return $xml;
    }

    /**
     * xml to array
     * @param $xml
     * @return mixed
     */
    static function namespacedXMLToArray($xml)
    {
        // One function to both clean the XML string and return an array
        return json_decode(json_encode(simplexml_load_string(self::removeNamespaceFromXML($xml))), true);
    }

    static function file_push($url, $filename){
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);// Khi thực thi lệnh sẽ k view ra trình duyệt mà lưu lại vào 1 biến kiểu string
        $content = curl_exec($ch);
        curl_close($ch);
        file_put_contents($filename, $content);
    }

    /**
     * compare Rss
     * @param $url
     * @param $data (title, description, link, pubDate)
     * @return int
     */
    static function compareRss($url, $local_rss)
    {
        $local_rss_content = file_get_contents(public_path() . '/uploads/event/'. $local_rss);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);// Khi thực thi lệnh sẽ k view ra trình duyệt mà lưu lại vào 1 biến kiểu string
        curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,5);
        $outer_rss_content = curl_exec($ch);
        if(curl_errno($ch))
        {
            return '0';
        }
        curl_close($ch);
        file_put_contents(public_path() . '/uploads/event/'. $local_rss, $outer_rss_content);
        return strcmp($outer_rss_content, $local_rss_content);
    }

    /**
     * check content rss change
     * @param $url
     * @param $data (title, description, link, pubDate)
     * @return int
     */
    static function checkContentUpdateRssByKey($url, $data)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);// Khi thực thi lệnh sẽ k view ra trình duyệt mà lưu lại vào 1 biến kiểu string
        curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,5);
        $outer_content = curl_exec($ch);
        if(curl_errno($ch))
        {
            return '0';
        }
        $content = self::namespacedXMLToArray($outer_content);
        $check_title = 0;$check_link = 0;$check_description = 0;$check_pubDate = 0;
        if (empty($data['title'])) $check_title = 1;
        if (empty($data['description'])) $check_description = 1;
        if (empty($data['link'])) $check_link = 1;
        if (empty($data['pubDate'])) $check_pubDate = 1;

        foreach ($content['channel']['item'] as $item) {
//            if (!empty($data['title']) && $item['title'] == $data['title']) $check_title = 1;
            if (!empty($data['description']) && $item['$description'] == $data['description']) $check_description = 1;
            if (!empty($data['link']) && $item['link'] == $data['link']) $check_link = 1;
            if (!empty($data['pubDate']) && $item['pubDate'] == $data['pubDate']) $check_pubDate = 1;
        }

        if ($check_title == 0 || $check_link == 0 || $check_description == 0 || $check_pubDate == 0) {
            return 0;
        }

        return 1;
    }

    /**
     * Convert html to content parts
     *
     * @param $data
     * @return array
     */
    static function convertToContentPart($data)
    {
        $result = [];
        if ($data != '') {
            $html = HtmlDomParser::str_get_html($data);
            foreach ($html->find('.cp') as $item) {
                $arr = [];
                $arr['tag'] = $item->tag;
                $arr['attr'] = $item->attr;
                array_push($result, $arr);
            }
        }
        return $result;
    }

    /**
     * Convert content part attribute to json
     *
     * @param $data
     * @return array
     */
    static function convertContentPartToJson($data)
    {
        $result = null;
        if ($data != '') {
            $html = HtmlDomParser::str_get_html($data);
            $result = [];
            foreach ($html->find('.cp') as $item) {
                $result[] = $item->attr;
            }
        }

        return $result;
    }

    static function searchContentPartInMachieruPage($cpId)
    {
        $nms = NavigationMenu::get();
        $mps = MachieruPage::get();
        $result = [];
        foreach ($nms as $nm) {
            $pushArr = [];
            if ($nm->type == 0) {
                $arr = explode('/', $nm->link);
                $mpId = $arr[count($arr) - 1];
                foreach ($mps as $mp) {
                    if ($mp->machieru_page_id == $mpId) {
                        foreach (json_decode($mp->content_part_json) as $cp)
                        {
                            if ($cp->id == $cpId) {
                                array_push($pushArr, [
                                    'navigation_id' => $nm->navigation_id,
                                    'machieru_page_id' => $mpId,
                                    'content_part_id' => $cpId
                                ]);
                            }
                        }
                    }
                }
            }
            array_push($result, $pushArr);
        }
        return $result;
    }

//    static function pushNotification($attrId, $cpType, $message)
//    {
//        switch ($cpType) {
//            case 0:
//                $message = 'Gallery ' + $attrId + ' have been updated!';
//                break;
//            case 1:
//                $message = 'Blog ' + $attrId + ' have been updated!';
//                break;
//            case 2:
//                $message = 'Event box ' + $attrId + ' have been updated!';
//                break;
//            default:
//
//        }
//
//        return $message;
//    }

}