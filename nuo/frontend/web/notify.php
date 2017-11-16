<?php


$url = "http://127.0.0.1/nuo/frontend/web/index.php?r=site/notify";


$ch = curl_init();
curl_setopt($ch,CURLOPT_URL,$url);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
curl_setopt($ch,CURLOPT_POST,1);
curl_setopt($ch,CURLOPT_POSTFIELDS,$postData);

$content = curl_exec($ch);
//echo $content;

curl_close($ch);
