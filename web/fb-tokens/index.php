<?php

//$test='';
//$client_id = '940214735998249';
//$secret = 'fcf5623af71275b7d67e411157fb8970';
//$pageID = '1542806685977419';
//$uri = 'http://localhost/app_dev.php/face_tokens';
//$scope = 'manage_pages,offline_access,publish_stream,publish_actions';
//
//$url = 'https://www.facebook.com/dialog/oauth?client_id=' . $client_id . '&redirect_uri=' . urlencode($uri) . '&scope=' . $scope . '&response_type=token';
//
//$ch = curl_init();
//curl_setopt($ch, CURLOPT_URL, $url);
//curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//curl_setopt($ch, CURLOPT_HEADER, 1);
//$data = curl_exec($ch);
//$curl_info = curl_getinfo($ch);
//
//// Get the headers and then the HTTP code
//$headers = substr($data, 0, $curl_info['header_size']);
//$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
//
//// Make sure that the HTTP redirects to a location that has an access token in the URL
//if ($code == 302) {
//    preg_match("!\r\n(?:Location|URI): *(.*?) *\r\n!", $headers, $matches);
//    $break = explode("access_token=", $matches[1]);
//
//    if (count($break) == 2) {
//        // Split the URL once more to get the access token value
//        $exp = explode("&", $break[1]);
//        $token = $exp[0];
//    } else {
//        $token = 'Failed';
//    }
//} else {
//    $token = 'Failed';
//}
//echo $token;
var_dump($_GET);
?>