<? include_once($_SERVER['DOCUMENT_ROOT'].'/global_pass.php');?>
<?php


$logedUser = new Member($_COOKIE['member_id']);

$favourites = $logedUser->getJsonField('favourites');
?>

<? include_once($_SERVER['DOCUMENT_ROOT'].'/templates/offers/selection/index.php');?>

<div>
    <div class="hidden" id="preloader" style=" position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(256,256,256, 0.9); z-index: 9;">
        <img style="width: 100px; margin-top: 100px;   margin-left: 47%" src="<?=PROJECT_URL?>/img/loading.gif"/>
    </div>
    <div class="map-block" style="height: 100px; overflow: hidden !important;">
        <div id="map-catalog" style="height: 700px; width: 100%; margin-bottom: -600px; position: relative; border-bottom: 1px solid #d0d0d0; ">

        </div>
    </div>
    <div class="flex-box flex-center">
        <div class="isBold box-small pointer map-more" style=" width: 180px;  border-top: 1px solid #FFFFFF; border-left: 1px solid #d0d0d0; border-right: 1px solid #d0d0d0; border-bottom: 1px solid #d0d0d0;">
            Показать на карте <span><i class="fas fa-caret-down"></i></span>
        </div>
    </div>
    <div class="flex-box flex-center">
        <div>
             предложений <?=$offersAmount?> ( объектов <?=$objectsAmount?>)
        </div>
    </div>
    <div class="icon-round modal-call-btn" data-modal="edit-all" data-id="" data-table="<?=(new Complex())->setTableId()?>"  data-names='' data-values='' data-modal-size="modal-very-big"  >
        <div title="Создать комплекс"><i class="fas fa-warehouse"></i></div>
    </div>

    <div class="box-wide pointer modal-call-btn" data-form="" data-id="" data-table="<?=(new Location())->setTableId()?>" data-names='' data-values="" data-modal="edit-all" data-modal-size="modal-very-big"   >
        <span title="Создать локацию"><i class="fas fa-plus-circle"></i></span>
    </div>

    <div class="main-table-block">
        <?include ($_SERVER['DOCUMENT_ROOT'].'/templates/pagination/index.php') ?>
        <div id="catalog-header" class="table-results-list">
            <div class="objects-caption object-list-template">
                <?
                $header = [
                        ['ID','id',1],
                        ['Адрес, фото ,назанчение','',0],
                        ['Регион, Направление, шоссе','region',1],

                        ['МКАД','mkad',1],
                        ['Площадь','area',1],
                        ['Цена','price',1],
                        ['Контакт','',0],
                        ['Брокер','user',1],
                        ['Обновление','update',1],
                ];
                ?>

                <?foreach ($header as $column=>$elem){?>
                    <div class="for-id obj-col-<?=$column+1?> flex-box">
                        <div>
                            <?=$elem[0]?>
                        </div>
                        <?if(1){?>
                            <? $name = $elem[1]?>
                            <div class="flex-box box-wide">
                                <div class="sort-label">
                                    <input id="sort-<?=$name?>-1" class="filter-sort hidden" type="radio" name="sort" <?=($filters_arr->sort == $name.'-1') ? 'checked' : ''?>  value="<?=$name?>-1" />
                                    <label class="pointer" for="sort-<?=$name?>-1">
                                        <i class="fas fa-long-arrow-alt-up filter-sort" ></i>
                                    </label>
                                </div>
                                <div class="sort-label">
                                    <input id="sort-<?=$name?>-2" class="filter-sort hidden" type="radio" name="sort" <?=($filters_arr->sort == $name.'-2') ? 'checked' : ''?>  value="<?=$name?>-2" />
                                    <label class="pointer" for="sort-<?=$name?>-2">
                                        <i class="fas fa-long-arrow-alt-up rotate-180 filter-sort" ></i>
                                    </label>
                                </div>
                            </div>
                        <?}?>

                    </div>
                <?}?>

            </div>
        </div>
        <?//=var_dump($unique_offers)?>

        <a name="catalogtop"></a>
        <div class="">
            <?
            $start = microtime(true);

            foreach($unique_offers as $unique_offer){
                if($unique_offer) {  
                    $offer = $factory::createOffer($unique_offer);
                    //include ($_SERVER['DOCUMENT_ROOT'].'/templates/offers/list/index.php');
                    require ($_SERVER['DOCUMENT_ROOT'].'/templates/offers/list/index.php');
                    //require ($_SERVER['DOCUMENT_ROOT'].'/templates/offers/list/index.php');
                }
            }
            $end = microtime(true);
            //echo 'Время загрузки страницы: '.($end - $start).' сек';
            ?>
        </div>
    </div>
</div>
<?include ($_SERVER['DOCUMENT_ROOT'].'/templates/pagination/index.php') ?>