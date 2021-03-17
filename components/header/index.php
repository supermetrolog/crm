<!DOCTYPE html>
<head>
    <?

    $media = $pdo->prepare("SELECT * FROM global_media LIMIT 1");
    $media->execute();
    $media_src = $media->fetch();



    $theme = new Theme($media_src['theme']);
    $meta_title = $theme->metaTitle();
    $meta_description = $theme->metaDescription();
    $meta_keywords = $theme->metaKeywords();
    $meta_icon = $theme->metaIcon();

    if($page_id){
        $page = new Page($page_id); //пердаю странице 3 параметра а надо бы сделать 1
        $meta_title = $meta_title.'. '.$page->metaTitle().' '.$collection.' '.$category;
        $meta_description = $meta_description.'. '.$page->metaDescription().' '.$collection.' '.$category;
        $meta_keywords = $meta_keywords.'. '.$page->metaKeywords().' '.$collection.' '.$category;
        ($page->metaIcon()) ? $meta_icon = $page->metaIcon() : '';
    }
    if($post_id){
        $item = new Item($post_id);
        $meta_title = $meta_title.'. '.$item->metaTitle() ;
        $meta_description = $meta_description.'. '.$item->metaDescription();
        $meta_keywords = $meta_keywords.'. '.$item->metaKeywords();
        ($item->metaIcon()) ? $meta_icon = $item->metaIcon() : '';
    }

    $page_template = $router->getPageName();

    $page_name_rus = $router->getPage()->title();

    if($page_template == 'object'){
        $page_item = '  ЛОТ '.$router->getPageItemId();
    }


    ?>
    <title><?=$meta_title.' '.$page_name_rus.$page_item?></title>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1, maximum-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <meta name='description' content='<?=$meta_description?>'>
    <meta name='keywords' content='<?=$meta_keywords?>'>

    <link rel='icon' href='<?=PROJECT_URL?><?=$theme->metaIcon()?>'>
    <meta property='og:image' content='<?=PROJECT_URL?>/<?=$meta_icon?>'>
    <meta property='og:title' content='<?=$meta_title?>'>
    <meta property='og:site_name' content='<?=$meta_title?>'>
    <meta property='og:type' content='website'>
    <meta property='og:url' content='<?=PROJECT_URL?>/'>
    <link rel="canonical" href="<?=PROJECT_URL?>/">


    <link rel="stylesheet" href="<?=PROJECT_URL?>/css/slider.css">


    <script src='<?=PROJECT_URL?>/libs/front/tinymce/tinymce.min.js'></script>
    <script src="<?=PROJECT_URL?>/admin/js/constructor.js"></script>




    <link rel="stylesheet" type="text/css" href="<?=PROJECT_URL?>/css/fontawesome/css/all.css">
    <link rel="stylesheet" type="text/css" href="<?=PROJECT_URL?>/css/<?=$theme->css()?>?time=<?=time()?>">
    <link rel="stylesheet" type="text/css" href="<?=PROJECT_URL?>/admin/css/system.css?time=<?=time()?>">


    <link href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>

    <script src="<?=PROJECT_URL?>/js/fields.js"></script>





    <!--Place for header embedded_code-->
    <?$top_embedded_code = new EmbeddedCode(0);
    foreach($top_embedded_code->getTopBlocks() as $top_code_block){
        $top_code_block = new EmbeddedCode($top_code_block['id']);
        echo $top_code_block->description();
    } ?>
    <!--Place for header embedded_code-->
</head>
<?if($media_src['full_page_on'] == 1 ){?>
    <script src="<?=PROJECT_URL?>/js/jquery.fullPage.js"></script>
    <link href="<?=PROJECT_URL?>/css/fullpage/jquery.fullPage.css" rel="stylesheet">
    <script>
        //////////СКРОЛЛИНГ СТРАНИЦ///////////////////////////////////////////////////
        $(document).ready(function() {

            if($(window).width() > 480){
                $('.grid_column_center').fullpage({
                    sectionsColor: ['#ffff', '#ffff', '#ffff','#ffff','#ffff'],
                    css3: true,
                    navigation: true,
                    slidesNavigation: true,
                    slideSelector: '.horizontal-scrolling',
                    anchors: ['1', '2'],
                    normalScrollElements: '.normal_scroll',
                    afterRender: function () {
                        setInterval(function () {
                            $.fn.fullpage.moveSlideRight();
                        }, 5000);
                    }

                });
            }
        });
        //////////СКРОЛЛИНГ СТРАНИЦ///////////////////////////////////////////////////
    </script>
<?}?>

<body id="body">

<?php

//создаем юзера
$logedUser = new Member($_COOKIE['member_id']);
if(!$logedUser->is_valid() ){ //делаем проверку на взлом куки
    $logedUser = new Member($_COOKIE['member_id']);
}

if($logedUser->member_id()){
    if(trim($_SERVER['REQUEST_URI'], "/") != NULL){

    }else{
        //header("Location: ".PROJECT_URL.'/'.'objects/');
    }

}elseif(trim($_SERVER['REQUEST_URI'], "/") != NULL){
    //header("Location: ".PROJECT_URL.'/');
}else{

}



?>

<?if($page->hasMenu()){?>
    <? require_once(PROJECT_ROOT.'/components/menu/index.php');?>
<?}?>



