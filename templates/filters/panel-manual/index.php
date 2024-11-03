<?
//include_once($_SERVER['DOCUMENT_ROOT'].'/display_errors.php');
$filters_arr = json_decode($_GET['request']);
?>

<? include_once($_SERVER['DOCUMENT_ROOT'].'/global_pass.php');?>
<?//var_dump($filters_arr->purposes)?>
<br>
<?//var_dump($filters_arr->deal_type)?>
<?//if($filters_arr->deal_type  && ($filters_arr->object_type ||  $filters_arr->safe_type)){?>
<?if($filters_arr->deal_type == 3   || ($filters_arr->object_type &&  $filters_arr->deal_type)){?>
    <div class="box-small" >
        <div class="box-small filters-step-4" >
            <div class=" box-small" style=" border: 1px solid #d0d0d0">
                <div class="filters-panel flex-box flex-wrap text_left flex-vertical-bottom flex-around" >
                    <?
                    $sql_filters = $pdo->prepare("SELECT * FROM core_filters WHERE activity='1'  ORDER BY order_row DESC");
                    $sql_filters->execute();
                    while($filter_item = $sql_filters->fetch(PDO::FETCH_LAZY)){?>
                        <?//if((in_array($filters_arr->object_type,json_decode($filter_item->filter_object_type)) != NULL || $filters_arr->safe_type) && in_array($filters_arr->deal_type,json_decode($filter_item->filter_deal_type)) != NULL ){?>
                        <?if(((in_array($filters_arr->object_type,json_decode($filter_item->filter_object_type)) != NULL || $filters_arr->safe_type) && in_array($filters_arr->deal_type,json_decode($filter_item->filter_deal_type) ) != NULL )   ){?>
                        <?//if(1){?>
                            <div class="filter-unit box">
                                <? $filter = new Filter($filter_item->id);?>
                                <? include($_SERVER["DOCUMENT_ROOT"] . '/templates/filters/templates/'.$filter->filterGroupTemplate().'/index.php') ?>
                            </div>
                        <?}?>
                    <?}?>
                </div>
            </div>
            <div class="flex-box flex-center filters-more">
                <div class="isBold box-small pointer" style=" width: 180px; margin-top: -1px; border-top: 1px solid #FFFFFF; border-left: 1px solid #d0d0d0; border-right: 1px solid #d0d0d0; border-bottom: 1px solid #d0d0d0;" data-more="1">
                    Больше фильтров <span><i class="fas fa-caret-down"></i></span>
                </div>
            </div>
        </div>
    </div>
<?}?>

