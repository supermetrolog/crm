
<?
$filters_arr = json_decode($_GET['request']);
$filter_send = json_encode($filters_arr);
//var_dump($filters_arr);
//var_dump($filter_send);
?>

<? include_once($_SERVER['DOCUMENT_ROOT'].'/global_pass.php');?>
<?if($filters_arr->region){?>
    <div class="box-small" >
        <div class="box-small">
            <?if(in_array($filters_arr->region ,[6,100,200])){?>
                <?$filter = new Filter(2)?>
                <? include($_SERVER["DOCUMENT_ROOT"] . '/templates/filters/templates/'.$filter->filterGroupTemplate().'/index.php') ?>
            <?}?>
        </div>
        <div class="box-small">
            <?if(in_array($filters_arr->region ,[1,100,300,400])){?>
                <?$filter = new Filter(5)?>
                <? include($_SERVER["DOCUMENT_ROOT"] . '/templates/filters/templates/'.$filter->filterGroupTemplate().'/index.php') ?>
            <?}?>
        </div>

        <div class="modal-filter-row flex-box flex-center">
            <div class="box flex-box flex-around half ">
                <div class=" pointer modal-call-btn" data-modal-size="modal-big" data-names='["region"]' data-values='["<?=$filters_arr->region?>"]' data-modal="filters-modal"  style="border-bottom: 1px dotted #8a8c8f;"  >
                    <i class="fas fa-globe ghost-double"></i>
                    Область на карте
                </div>
                <?if(in_array($filters_arr->region ,[1,100,300,400])  ){?>
                    <div class="pointer modal-call-btn" data-modal-size="modal-big" data-names='["region"]' data-values='["<?=$filters_arr->region?>"]'  data-modal="filters-modal"  style="border-bottom: 1px dotted #8a8c8f" >
                        <i class="fas fa-star ghost-double"></i>
                        Населенный пункт
                    </div>
                    <div class="pointer modal-call-btn" data-modal-size="modal-big" data-names='["region"]' data-values='["<?=$filters_arr->region?>"]'  data-modal="filters-modal"  style="border-bottom: 1px dotted #8a8c8f" >
                        <i class="far fa-dot-circle ghost-double"></i>
                        Район
                    </div>
                    <div class="pointer modal-call-btn" data-modal-size="modal-big" data-names='["region"]' data-values='["<?=$filters_arr->region?>"]'  data-modal="filters-modal"  style="border-bottom: 1px dotted #8a8c8f" >
                        <i class="fas fa-road ghost-double"></i>
                        Шоссе
                    </div>
                <?}?>
                <?if(in_array($filters_arr->region ,[6,100,200])){?>
                    <div class="pointer modal-call-btn" data-modal-size="modal-big" data-names='["region"]' data-values='["<?=$filters_arr->region?>"]'  data-modal="filters-modal"  style="border-bottom: 1px dotted #8a8c8f" >
                        <i class="fas fa-road ghost-double"></i>
                        Шоссе Москвы
                    </div>
                    <div class="pointer modal-call-btn" data-modal-size="modal-big" data-names='["region"]' data-values='["<?=$filters_arr->region?>"]'  data-modal="filters-modal"  style="border-bottom: 1px dotted #8a8c8f" >
                        <i class="fab fa-monero ghost-double"></i>
                        Метро
                    </div>
                <?}?>
            </div>
        </div>

        <? include_once($_SERVER['DOCUMENT_ROOT'] . '/templates/modals/filters-modal/index.php') ?>

    </div>
<?}?>

