<?php
header('content-type:application/json;charset=utf8');
function bilud_json($origin_str){
    $json_obj = json_decode($origin_str);
    $json_str = json_encode($json_obj, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
    return $json_str;
}
$user_ip=@$_REQUEST["ip"];
$key='';
$place='';
if($user_ip==null||!filter_var($user_ip, FILTER_VALIDATE_IP)){
    $user_ip = $_SERVER["REMOTE_ADDR"];
}
//echo $user_ip;
$location=json_decode(bilud_json(file_get_contents('https://restapi.amap.com/v5/ip?key='.$key.'&type=4&ip='.$user_ip)))->location;
$adcode=json_decode(bilud_json(file_get_contents('https://restapi.amap.com/v3/geocode/regeo?key='.$key.'&location='.$location)))->regeocode->addressComponent->adcode;
$weather=bilud_json(file_get_contents('https://restapi.amap.com/v3/weather/weatherInfo?key='.$key.'&city='.$adcode.'&extensions=base'));
echo $weather;
?>