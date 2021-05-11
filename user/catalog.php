<?php
/**
 * Created by PhpStorm.
 * User: Home
 * Date: 27.05.2018
 * Time: 13:35
 */
$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$furl = parse_url($actual_link);
$category = explode('/',$furl['path'])[2];
$cat_sql = $pdo->prepare("SELECT * FROM categories WHERE furl='$category'");
$cat_sql->execute();
$cat_info = $cat_sql->fetch(PDO::FETCH_LAZY);
$cat = $cat_info->id;
?>
<!--САМИ ТОВАРНЫЕ ПОЗИЦИИ-->
		     <div class='catalog'>
                 <?php
                 if(!$category){
                 ?>
                 <div class="container">
                     <?
                     $collection_sql = $pdo->prepare("SELECT * FROM categories $active ORDER BY order_row DESC");
                     $collection_sql->execute();
                     while($collection = $collection_sql->fetch()){
                         $photo = json_decode($collection["photo"]);
                         ?>
                         <div class="collection_sec" style="background: url(<?=PROJECT_URL.'/'.$photo[0]?>); ">
                             <div class="title">
                                 <a  href="<?=PROJECT_URL?>/catalog/<?=$collection["furl"]?>/"><?=$collection["title"]?></a>
                             </div>
                         </div>
                     <?}?>
                 </div>
                 <?}else{?>
                    <?$item_page = ($page_num - 1);
			        if($item_page < 0){
                    $from_num = $page_num*12;
                    }else{
                    $from_num = ($page_num - 1)*12;
                    }


			        $items_sql = $pdo->prepare("SELECT * FROM $table_items WHERE category='$cat'   ORDER BY order_row DESC LIMIT $from_num, 12");
				    $items_sql->execute();
				    if($items_sql->rowCount() > 0){
                    while($item = $items_sql->fetch(PDO::FETCH_LAZY)){
                        $good = new Item($item->id);

                        ?>
                        <div class='one_third'>
                            <div class='item'>
                                <div class='item_img'>
                                    <a href='<?=PROJECT_URL?>/good/<?=($item['furl'])? $item['furl'] : furl_create($item['title'])?>/<?=$item['id']?>/' target='_blank'>
                                        <img style='width: 100%' src='<?=PROJECT_URL.'/'.$good->thumb()?>'/>
                                    </a>
                                </div>
                                <div class='item_stat'>
                                    <div>
                                        <a href='<?=PROJECT_URL?>/good/<?=($item['furl'])? $item['furl'] : furl_create($item['title'])?>/<?=$item['id']?>/'><?=$item['title']?></a><br>
                                    </div>
                                    <?if($item['sale'] == 1) { ?>
                                        <p class='sale_amount'>SALE: <?=$item['discount']?></p>
                                    <?} ?>
                                </div>
                            </div>
                        </div>
                    <?}
                }else{?>
                    <p>Моделей по заданным праметрам не найдено</p>
                <?}?>
                 <?}?>
</div>
<!--САМИ ТОВАРНЫЕ ПОЗИЦИИ-->