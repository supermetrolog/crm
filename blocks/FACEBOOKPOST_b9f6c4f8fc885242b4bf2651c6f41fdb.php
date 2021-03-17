<?php

$post_link = 'https://www.facebook.com/161990113848751/posts/1760421910672222/';

$fb_token = '2057519694522565|d3y4UntKpUHJCV-adWVW3I9w8pk';
//$fb_token = '1a2853ff97f56db38c29cc11a3d85d76';
$link = "https://graph.facebook.com/v3.0/161990113848751_1760421910672222?fields=about,fan_count,website&access_token=$fb_token";


$ch = curl_init($link);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$data = curl_exec($ch);

var_dump($data);