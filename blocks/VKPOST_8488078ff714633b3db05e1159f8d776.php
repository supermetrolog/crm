<?php

$link1 = 'https://vk.com/id139119163';
//$link1 = 'https://vk.com/id139119163?w=wall139119163_1377%2Fall';
//$link2 = 'https://vk.com/wall139119163_1377';

$token = 'bbc5736cbbc5736cbbc5736c98bba036d5bbbc5bbc5736ce08affe4142a0987f01b2931';
$version = 5.63;

$vk_post = new Vkontakte($token, $version, $link1);

var_dump($vk_post->getProfile());

var_dump(file_get_contents('https://api.twitter.com/1.1/lists/show.json?slug=team&owner_screen_name=twitter/4609902334-7wk2UvYdt2fFBE9jMB7IgbPfgLXnDxYDfZT0G16'));

