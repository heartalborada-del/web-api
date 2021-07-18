<?php
header('Content-type:image/png');//设置mime type
function bilud_json($origin_str){
    $json_obj = json_decode($origin_str);
    $json_str = json_encode($json_obj, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
    return $json_str;
}
$api_url="";
$user_ip = $_SERVER["REMOTE_ADDR"];
$font="Genshin.ttf";
$height=120;
$info=json_decode(bilud_json(file_get_contents($api_url.'/?ip='.$user_ip)));
$img=imagecreatefrompng('asstes/bg.png');
imagesavealpha($img, true);
$color=ImageColorAllocate($img, 52, 152, 219);
$Deep_color=imagecolorallocate($img,41,128,185);
$water_alpha_color=imagecolorallocatealpha($img,116,185,255,90);
$info_alpha_color=imagecolorallocatealpha($img,116,185,255,64);
//$blue=ImageColorAllocate($img, 33, 150, 243);
$place=$info->country;
if($info->province!=''){
    $place=$place.'-'.$info->province;
}
if($info->city!=''){
    $place=$place.'-'.$info->city;
}
$size = getimagesize('asstes/bg.jpg');
imagettftext($img, 60, 0, 50, $height, $Deep_color, "asstes/".$font , "欢迎来自 ".$place." 的访客");
imagettftext($img, 10, 0, $size[0]-150, $size[1]-20, $info_alpha_color, "asstes/".$font , date("Y-m-d H:i:s"));
imagettftext($img, 10, 0, $size[0]-140, $size[1]-5, $info_alpha_color, "asstes/".$font , 'By heartalborada');
$text_info=imagettfbbox(10,0,"asstes/".$font,"Heartalborada's Genshin Impact UID: 104080565");
imagettftext($img, 10, 0, ($size[0]-$text_info[4])/2, 15, $water_alpha_color, "asstes/".$font, "Heartalborada's Genshin Impact UID: 104080565");
if(!($info->weather==null||$info->temperature==null||$info->winddirection==null||$info->humidity==null||$info->reporttime==null)){
    imagettftext($img, 40, 0, 50, $height+70, $color, "asstes/".$font , '当前天气 '.$info->weather.' '.$info->temperature.'℃ 风向 '.$info->winddirection.' 空气湿度 '.$info->humidity.'%');
    imagettftext($img, 30, 0, 50, $height+120, $color, "asstes/".$font , '更新于 '.$info->reporttime);
    imagettftext($img, 30, 0, 50, $height+165, $color, "asstes/".$font , '您的IP '.$user_ip);
} else {
    imagettftext($img, 30, 0, 50, $height+215, $color, "asstes/".$font , '您的IP '.$user_ip);
}
imagepng($img);
imagedestroy($img);
?>