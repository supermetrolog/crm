<?php
/**
 * Created by PhpStorm.
 * User: Zhitkov
 * Date: 30.06.2018
 * Time: 17:38
 */
?>
<? $edit_post_id = $pageUser->member_id()?>
<? $edit_post_table = $pageUser->setTable()?>
<form action="<?=PROJECT_URL?>/system/modules/posts/create.php" method="post">
    <div class="flex-box form-header box ghost">
        <div>
            Редактировать профиль
        </div>
        <div class="to-end pointer" id="modal_close">
            <span>&#215;</span> <!-- Кнoпкa зaкрыть -->
        </div>
        <input type="hidden" name="id" value="<?=$edit_post_id?>"/>
        <input type="hidden" name="table" value="users"/>
    </div>
    <div class="form-body box">
        <? include_once ($_SERVER['DOCUMENT_ROOT'].'/system/templates/forms/all-edit/index.php')?>
    </div>
    <div class="form-footer flex-box box">
        <button class="button btn-brown to-end">Сохранить</button>
    </div>
</form>
