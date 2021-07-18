<?php
header('content-type:application/json;charset=utf8');
header('Access-Control-Allow-Origin:*');
function bilud_json($origin_str){
    $json_obj = json_decode($origin_str);
    $json_str = json_encode($json_obj, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
    return $json_str;
}
$UID='9824766';
if ($UID) {
    $url='https://api.bilibili.com/x/space/acc/info?mid='.$UID.'&jsonp=jsonp';
} else {
    header("HTTP/1.1 404 Not Found");
    header("Status: 404 Not Found");
    echo 'No UID!';
    exit;
}
$json=bilud_json(file_get_contents($url));
//echo $json;
$Djson = json_decode($json);
echo $json;
?>