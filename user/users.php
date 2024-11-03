<?php
/**
 * Created by PhpStorm.
 * User: Zhitkov
 * Date: 27.04.2018
 * Time: 13:01
 */
?>
<div class="box">
    <div class="search-line-block">
        <form action="" method="POST">
            <div class="search-line flex-box">
                <input type="text" name="search" placeholder="ID, адрес, собственник, телефон, фио, брокер, название" />
                <button><i class="fas fa-search"></i></button>
            </div>
        </form>
    </div>
</div>

<div class='friends-list'>
    <?
    /*
    $search = $_GET['search_line'];
    $sql = $pdo->prepare("SELECT *FROM users  WHERE title LIKE '%$search%' OR surname LIKE '%$search%' OR fathername LIKE '%$search%' ");
    $sql->execute();
    $members = $sql->fetchALL();
    */
    $members = new Member(NULL);
    foreach($members->getAllActiveUnits() as $member){
        $listMember = new Member($member['id']); ?>
        <? include($_SERVER["DOCUMENT_ROOT"].'/system/templates/users/list/index.php');?>
    <?}?>
    <?if($_GET['search_line'] != NULL){?>
        <div class="flex-box flex-around ghost box">
            Результаты глобального поиска:
        </div>
        <?
        /*
        foreach($members as $member){
            $listMember = new Member($member['id']);
            if(!$x){?>
                <? include($_SERVER["DOCUMENT_ROOT"].'/system/templates/users/list/index.php');?>
            <?}?>
        <?}*/?>
    <?}?>
</div>
