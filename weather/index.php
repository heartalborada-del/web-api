<?php
header('content-type:application/json;charset=utf8');
function bilud_json($origin_str){
    $json_obj = json_decode($origin_str);
    $json_str = json_encode($json_obj, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
    return $json_str;
}
$user_ip=@$_REQUEST["ip"];
$key = '';
if($user_ip==null||!filter_var($user_ip, FILTER_VALIDATE_IP)){
    $user_ip = $_SERVER["REMOTE_ADDR"];
}
//echo $user_ip;
$ip_info=json_decode(bilud_json(file_get_contents('https://restapi.amap.com/v5/ip?key='.$key.'&type=4&ip='.$user_ip)));
if($ip_info->country=='中国'){
    $city_info=json_decode(bilud_json(file_get_contents('https://restapi.amap.com/v3/geocode/regeo?key='.$key.'&location='.$ip_info->location)));
    $weather_info=json_decode(bilud_json(file_get_contents('https://restapi.amap.com/v3/weather/weatherInfo?key='.$key.'&city='.$city_info->regeocode->addressComponent->adcode.'&extensions=base')));
    $ar=array(
        'country'=>$ip_info->country,
        'province'=>$ip_info->province,
        'city'=>$ip_info->city,
        'weather'=>$weather_info->lives[0]->weather,
        'temperature'=>$weather_info->lives[0]->temperature,
        'winddirection'=>$weather_info->lives[0]->winddirection,
        'humidity'=>$weather_info->lives[0]->humidity,
        'reporttime'=>$weather_info->lives[0]->reporttime
    );
} else {
        $ar=array(
        'country'=>$ip_info->country,
        'province'=>$ip_info->province,
        'city'=>$ip_info->city,
        'weather'=>null,
        'temperature'=>null,
        'winddirection'=>null,
        'humidity'=>null,
        'reporttime'=>null
    );
}
echo json_encode($ar, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
?>