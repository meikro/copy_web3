<?php
$url="http://inews.gtimg.com/newsapp_match/0/6470254058/0";
    $dir = pathinfo($url);
    $host = $dir['dirname'];
    $refer = $host.'/';
    $ch = curl_init($url);
    curl_setopt ($ch, CURLOPT_REFERER, $refer);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
    $data = curl_exec($ch);
    curl_close($ch);
    header("Content-type: image/jpeg");
    print( $data );
    exit(); 
?>