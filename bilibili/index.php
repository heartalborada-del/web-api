<?php
header('content-type:text/html;charset=utf8');
//header('content-type:application/json;charset=utf8');
header('Access-Control-Allow-Origin:*');
function bilud_json($origin_str){
    $json_obj = json_decode($origin_str);
    $json_str = json_encode($json_obj, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
    return $json_str;
}
function Psex($sex){
    $Csex='gender-male-female';
    if($sex=="保密"){
        $Csex='gender-male-female';
    } else if ($sex=="男"){
        $Csex='gender-male';
    } else {
        $Csex='gender-female';
    }
    return $Csex;
}
$UID=@$_REQUEST["UID"];
if ($UID) {
    $url='https://api.bilibili.com/x/space/acc/info?mid='.$UID.'&jsonp=jsonp';
} else {
    header("HTTP/1.1 403 Forbidden");
    header("Status: 403 Forbidden");
    echo 'No UID!';
    exit;
}
$json=bilud_json(file_get_contents($url));
//echo $json;
$Djson = json_decode($json);
$Dimg='';
$Dfans='';
$Svip='';
$CSSbig='';
if (!preg_match("/^[1-9][0-9]*$/",$UID)||$Djson->code!=0){
    header('HTTP/1.1 403 Forbidden');
    header('Status: 403 Forbidden');
    echo 'Is not a valid UID';
    exit;
}
if ($Djson->data->vip->status!='0'){
    $Dimg='<img src="'.$Djson->data->vip->avatar_subscript_url.'" title="'.$Djson->data->vip->label->text.'" class="avatar-icon">';
    $Svip='';
} else {
    $CSSbig=";padding:0 0!important";
}
if($Djson->data->fans_badge){
    $Dfans='<span class="fans-text">粉</span>';
}
echo '
    <meta name="referrer" content="no-referrer" />
    <link rel="stylesheet" href="dist.css" type="text/css" />
    <div>
        <div>
            <div class="avatar">
                <img src="'.str_replace('http:\/\/','https:\/\/',$Djson->data->face).'" id="avatar">
                '.$Dimg.'
            </div>
            <span id="name" class="line">'.$Djson->data->name.'</span>
            <img src="icon/'.Psex($Djson->data->sex).'.png" style="weight:16px;height:16px;display:inline-block;vertical-align:middle;" id="img" onerror="reloadI()"></img>
            <img style="height: 16px;display:inline-block;vertical-align:middle;" src="LV/lv'.$Djson->data->level.'.png"></img>
            <pre class="vipType" style="background-color:'.$Djson->data->vip->label->bg_color.';'.$Svip.$CSSbig.'">'.$Djson->data->vip->label->text.'</pre>
            <div class="fans-icon">
                '.$Dfans.'
            </div></br>
        </div>
        <span class="line sign">'.$Djson->data->sign.'</span>
    </div>
    <script type="text/javascript">
        var img=document.getElementById(\'img\');
        function reloadI(){
            img.src="'.$url[0].'?"+Math.random();
        }
    </script>
';
?>