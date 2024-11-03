<?php
if(!$_COOKIE['member_id']){
    $_COOKIE['member_id'] =0;
}
$admin = new Member($_COOKIE['member_id']);
$admin->is_valid(); //делаем проверку на взлом куки
if(!$admin->isAdmin()){header("Location: ".PROJECT_URL.'/'.'auth/');}
?>


<!DOCTYPE html>
<head>
    <?php
    $media = $pdo->prepare("SELECT * FROM global_media LIMIT 1");
    $media->execute();
    $media_src = $media->fetch();?>
    <?$theme = new Theme($media_src['theme']);?>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1, maximum-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name='description' content=''>
    <meta name='author' content=''>
    <link rel='icon' href='<?=PROJECT_URL?>/<?=$theme->metaIcon()?>'>
    <link rel="stylesheet" type="text/css" href="<?=PROJECT_URL?>/admin/css/style.css?time=<?=time()?>">
    <link rel="stylesheet" type="text/css" href="<?=PROJECT_URL?>/admin/css/system.css?time=<?=time()?>">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.10/css/all.css" integrity="sha384-+d0P83n9kaQMCwj8F4RJB66tzIwOKmrdb46+porD/OvrJ+37WqIM7UoBtwHO6Nlg" crossorigin="anonymous">



    <link rel='icon' href='<?=PROJECT_URL?>/<?=$theme->metaIcon()?>'>
    <meta property='og:image' content='<?=PROJECT_URL?>/<?=$theme->metaIcon()?>'>
    <meta property='og:title' content='<?=$theme->metaTitle()?>'>
    <meta property='og:site_name' content='<?=$theme->metaTitle()?>'>
    <meta property='og:type' content='website'>
    <meta property='og:url' content='<?=PROJECT_URL?>/'>
    <link rel="canonical" href="<?=PROJECT_URL?>/">




    <title><?=$media_src['site_name']?> - Панель администратора</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>


    <script type="text/javascript">
        $(document).ready(function(){
            /////////////меню


            let menu_height = $('.admin_container').css("height");
            $('.admin_main_menu').css("height",menu_height);

            $('a').click(function() {
                $('.loading_layout').show(1);
            });

            $('.change_media img').click(function() {
                $(this).closest('form').find('input').attr("disabled",false);
                $(this).closest('form').find('select').attr("disabled",false);
                $(this).closest('form').find('button').css("display","inline-block");
                $(this).closest('.desktop_form_unit').find('.del_form').find('button').css("display","inline-block");
            });

            $('.change_media select').click(function() {
                $(this).closest('form').find('button').css("display","inline-block");
            });

        });
        //поиск по артикулу
        function art_search(value) {
            //alert(value);
            let url = "<?=PROJECT_URL?>/admin/templates/page/index/index.php";
            let table = '<?=$_GET['table']?>';
            let view = '<?=$_GET['view']?>';
            //alert(table);
            $.ajax({
                url: url,
                type: "GET",
                data: {"search": value, "table": table, "view": view},
                cache: false,
                success: function(response){
                    if(response == 0){  // смотрим ответ от сервера и выполняем соответствующее действие
                        alert("не удалось получить ответ от скрипта");
                    }else{
                        //alert(response);
                        $('.admin-worksheet').html(response);
                    }
                }
            });
        }
    </script>
</head>
<body>
