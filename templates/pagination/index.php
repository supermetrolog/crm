<?php
/**
 * Created by PhpStorm.
 * User: Zhitkov
 * Date: 24.07.2018
 * Time: 18:39
 */
?>
<div id="pagination" class="pagination">
    <?php
    $get_package = '?';
    foreach($_GET as $key=>$value)
    {
        $get_package .= "$key=$value&";
    }
    $page_radius = 2;
    ($start_page < 1)? $start_page=1 : '';
    ?>
    <div class="icon-round page-item"  name="page_num" value="1">
        <div name="page_num" value="1"><<</div>
    </div>
    <?if($page_num>1){?>
        <div class="icon-round page-item" name="page_num" value="<?=$i?>" >
            <div name="page_num" value="<?=$page_num-1?>"><</div>
        </div>
    <?}?>
        <?php
        for($i = $page_num - $page_radius; $i < $page_num + $page_radius + 1; $i++){
            if($i > 0 && $i < $pagesAmount+1){
                ($page_num == $i)? $curr='current-page' : $curr='';?>
                <div class="icon-round page-item <?=($i == $page_num) ? 'btn-green' : '' ;?>" name="page_num" value="<?=$i?>" >
                    <div name="page_num" value="<?=$i?>" ><?=$i?></div>
                </div>
            <?}?>
        <?}?>
    <?if($page_num < $pagesAmount){?>
        <div class="icon-round page-item" name="page_num" value="<?=$page_num+1?>" >
            <div name="page_num" value="<?=$page_num+1?>">></div>
        </div>
    <?}?>
    <div class="icon-round page-item"  name="page_num" value="<?=ceil($pagesAmount)?>">
        <div name="page_num" value="<?=ceil($pagesAmount)?>">>></div>
    </div>
</div>
