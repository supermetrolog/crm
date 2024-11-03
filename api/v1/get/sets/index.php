<?php


$sets = [];

$new = [
    'title'=>'Новые',
    'text'=>'объекты на сайте',
    'icon'=>'',
    'cover_photo'=>'https://images.unsplash.com/photo-1587293852726-70cdb56c2866?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=1080&fit=max&ixid=eyJhcHBfaWQiOjEyMDd9',
    'text_sec'=>'',
];

$buy = [
    'title'=>'купить склад',
    'text'=>'Успейте',
    'icon'=>'',
    'cover_photo'=>'https://expanzs.com/assets/Slide1.jpg',
    'text_sec'=>'',
];

$classA= [
    'title'=>'класса А',
    'text'=>'Склады',
    'icon'=>'',
    'cover_photo'=>'https://www.cmorgan.com/blog/wp-content/uploads/2018/05/How-to-Build-a-Strong-Relationship-with-Your-3PL-CMorgan.jpg',
    'text_sec'=>'',
];

$warehouse = [
    'title'=>'под склад',
    'text'=>'Аренда помещений',
    'icon'=>'',
    'cover_photo'=>'https://inventure.com.ua/upload/pic2020-1q/logistic-real-estate-ua.jpg',
    'text_sec'=>'',
];

$classB = [
    'title'=>'класса В',
    'text'=>'Склады',
    'icon'=>'',
    'cover_photo'=>'https://www.wallpaperbetter.com/wallpaper/467/288/833/morgan-warehouse-hd-1080P-wallpaper.jpg',
    'text_sec'=>'',
];

$land = [
    'title'=>'Земельные участки',
    'text'=>'',
    'icon'=>'',
    'cover_photo'=>'',
    'text_sec'=>'',
];

$safe = [
    'title'=>'ответственное хранение',
    'text'=>'Переходи на',
    'icon'=>'',
    'cover_photo'=>'',
    'text_sec'=>'',
];

$build = [
    'title'=>'строительство склада',
    'text'=>'Выгодное',
    'icon'=>'',
    'cover_photo'=>'https://www.10wallpaper.com/wallpaper/1366x768/1403/warehouse_hook_crane-Life_photo_wallpaper_1366x768.jpg',
    'text_sec'=>'по требованию заказчика',
];

$industry = [
    'title'=>'под производство',
    'text'=>'Аренда помещений',
    'icon'=>'',
    'cover_photo'=>'https://images.pexels.com/photos/236698/pexels-photo-236698.jpeg?auto=compress&cs=tinysrgb&dpr=1&w=500',
    'text_sec'=>'',
];

$ramp = [
    'title'=>'с авторампой',
    'text'=>'Склады',
    'icon'=>'',
    'cover_photo'=>'https://c.wallhere.com/photos/5a/73/world_travel_usa_building_vertical_architecture_digital_america-890715.jpg!d',
    'text_sec'=>'',
];

$sets[] = $new ;
$sets[] = $buy ;
$sets[] = $classA;
$sets[] = $warehouse;
$sets[] = $classB;
$sets[] = $land;
$sets[] = $safe;
$sets[] = $build;
$sets[] = $industry;
$sets[] = $ramp;

echo json_encode($sets, JSON_UNESCAPED_UNICODE);