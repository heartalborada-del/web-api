<?php
header('content-type:application/json;charset=utf8');
header('Access-Control-Allow-Origin:*');
function bilud_json($origin_str){
    $json_obj = json_decode($origin_str);
    $json_str = json_encode($json_obj, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
    return $json_str;
}
$tag=@$_REQUEST["tag"];
$url='https://api.lolicon.app/setu/v2?r18=2&size=small&size=original';
$json=bilud_json(file_get_contents($url));
$Djson = json_decode($json);
echo $json;
echo !empty($json->data);
?>