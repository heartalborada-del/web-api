<?php
header('content-type:text/html;charset=utf8');
//header('content-type:application/json;charset=utf8');
header('Access-Control-Allow-Origin:*');
function bilud_json($origin_str){
    $json_obj = json_decode($origin_str);
    $json_str = json_encode($json_obj, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
    return $json_str;
}
$tag=@$_REQUEST["tag"];
$url='https://api.lolicon.app/setu/v2?r18=2&size=small&size=original';
if ($tag) {
    $url=$url.'&tag='.$tag;
}
$url=preg_replace('# #','%20',$url);
$json=bilud_json(file_get_contents($url));
$Djson = json_decode($json);
if (!empty($json->data)){
    header("HTTP/1.1 403 Forbidden");
    header("Status: 403 Forbidden");
    echo 'Tag No Images!';
    exit;
}
$Title=$Djson->data[0]->title;
$Author=$Djson->data[0]->author;
$PID=$Djson->data[0]->pid;
$Image_tags='';
for($i=0;$i<sizeof($Djson->data[0]->tags);$i++){
    if($i!=sizeof($Djson->data[0]->tags)-1){
        $Image_tags=$Image_tags.$Djson->data[0]->tags[$i].',';
    } else {
        $Image_tags=$Image_tags.$Djson->data[0]->tags[$i];
    }
}
$image_urls=array($Djson->data[0]->urls->small,$Djson->data[0]->urls->original);
echo '
    <h4>Title:'.$Title.'</br>Author:'.$Author.'</br>PID:'.$PID.'</br>Tags:'.$Image_tags.'</h4>
    <a href="https://www.pixiv.net/artworks/'.$PID.'" target="_blank">
        <img id="img" src="'.$image_urls[0].'" alt="'.$PID.'.'.$Djson->data[0]->ext.'" style="height:50%" onerror="reloadI()"/></br>
    </a>
    <button name= "reload" onclick="location.reload()" style="margin-top:5px;margin-right:5px">Reload</button>
    <a href="'.$image_urls[1].'" target="_blank">
        <button name= "download" style="margin-top:5px;margin-right:5px">Download</button>
    </a>
    <script type="text/javascript">
        var img=document.getElementById(\'img\');
        function reloadI(){
            img.src="'.$image_urls[0].'?"+Math.random();
        }
    </script>
';
?>