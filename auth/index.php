<? include_once($_SERVER['DOCUMENT_ROOT'].'/global_pass.php');?>
<?php
($router = Bitkit\Core\Routing\Router::getInstance())->setURL();
$router->getWay();
$theme = new Theme(47);
?>

<!DOCTYPE html>
<html>
    <head>
        <title><?=$theme->siteTitle()?>.Вход</title>
        <meta charset='utf-8'>
        <meta http-equiv='X-UA-Compatible' content='IE=edge'>
        <meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1, maximum-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->



        <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">

        <link rel="stylesheet" href="<?=PROJECT_URL?>/admin/css/system.css">
        <link rel="stylesheet" href="<?=PROJECT_URL?>/css/<?=$theme->css()?>">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.10/css/all.css" integrity="sha384-+d0P83n9kaQMCwj8F4RJB66tzIwOKmrdb46+porD/OvrJ+37WqIM7UoBtwHO6Nlg" crossorigin="anonymous">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
    </head>
    <body>
        <div class='login-form'>
            <div >
                <form class="box-small" action='/system/controllers/login/index.php' method='POST'>
                    <div class="box-small" style='width: 100%; text-align: center;'>
                        <div class="flex-box-inline">
                            <div>
                                <img src="<?=PROJECT_URL?>/img/g.png" >
                            </div>
                            <div class="ghost" style="line-height: 15px; padding: 0 5px;">
                                ИНДУСТРИАЛЬНАЯ<br>НЕДВИЖИМОСТЬ
                            </div>
                        </div>
                    </div>
                    <span>Логин</span>
                    <input name='login' type='text' placeholder=''></input><br>
                    <span>Пароль</span>
                    <input name='pass' type='password' placeholder=''></input><br>
                    <? if(isset($_GET['wrong'])){ echo "<div class='login_error'>Неверный логин или пароль</div>";} ?>
                    <div class="text_center box-small">
                            <button class="button full-width btn-brown box-small">Войти</button>
                    </div>

                </form>
            </div>
        </div>
    </body>
</html>
