<?php
$page_template = $router->getPageName();
$page_item = $router->getPageItemId();
if($page_template == 'user'){
    if($page_item == $logedUser->member_id()){
        $pageUser = new Member($user_id = $logedUser->member_id());
    }else{
        $pageUser = new Member($page_item);
        if($logedUser->member_id() > 0){
            $pageUser->setNewVisitor($logedUser->member_id());
        }
    }
}else{
    $pageUser = new Member($logedUser->member_id());
}

?>

 <div class='profile-card personal-page-grid'>
  <? include($_SERVER["DOCUMENT_ROOT"].'/templates/users/header/index.php');?>
  <div class='user-menu '>
     <div class='widget'>
        <div class='widget-title'>
	        Меню пользователя
        </div>
        <div class="widget-body">
            <ul>
                <?
                $sql = $pdo->prepare("SELECT * FROM core_user_areas ORDER BY order_row DESC");
                $sql->execute();
                while($menu_item = $sql->fetch()){?>
                    <li class="<?=(trim($menu_item['link'], '/') == (trim($page_template, '/'))  ) ? 'btn-highlight' : ''; ?> ">
                        <div>
                            <a href="<?=PROJECT_URL?>/<?=$menu_item['link']?><?=(trim($menu_item['link'], '/') == 'user')? $logedUser->member_id(): '';?>" ><?=$menu_item['title']?></a>
                        </div>
                    </li>
                <?}?>
            </ul>
        </div>
     </div>




   </div>
   <div class='work-area box-left-top'>
       <? include($_SERVER["DOCUMENT_ROOT"].'/user/'.$page_template.'/index.php');?>
   </div>
 </div>

 <?// include_once($_SERVER["DOCUMENT_ROOT"].'/system/templates/modals/member-edit/index.php')?>

