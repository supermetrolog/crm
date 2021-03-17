<? require_once($_SERVER['DOCUMENT_ROOT'].'/global_pass.php');?>
<?

$member = new Member(0);
$member->loginCheck($_POST['login'], $_POST['pass']);



if($member->loginCheck($_POST['login'], $_POST['pass'])){
    if($_POST['admin']){
        header("Location: ".PROJECT_URL."/admin/");
    }else{
        header("Location: ".PROJECT_URL);
    }
}else{
    header('Location: /auth/');
}



