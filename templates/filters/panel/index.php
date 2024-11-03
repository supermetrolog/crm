
<?
/*
$filters_arr = json_decode($_GET['request']);
?>


<? include_once($_SERVER['DOCUMENT_ROOT'].'/global_pass.php');?>
    <div class="box-small" >
        <div class="box-small">
            <?if(in_array(1,$filters_arr->region)){?>
                <?$filter = new Filter(2)?>
                <? include($_SERVER["DOCUMENT_ROOT"] . '/templates/filters/'.$filter->filterGroupTemplate().'/index.php') ?>
            <?}?>
        </div>
        <div class="box-small">
            <?$filter = new Filter(5)?>
            <? include($_SERVER["DOCUMENT_ROOT"] . '/templates/filters/'.$filter->filterGroupTemplate().'/index.php') ?>
        </div>
        <div class="modal-filter-row flex-box flex-center">
            <div class="box flex-box flex-around half ">
                <div class="modal-call-btn pointer"  data-modal-size="modal-very-big" data-names="[]" data-values="[]"  style="border-bottom: 1px dotted #8a8c8f;" data-modal="filters-modal" data-filter-select="tab-1">
                    <i class="fas fa-globe ghost-double"></i>
                    Область на карте
                </div>
                <div class="modal-call-btn pointer " style="border-bottom: 1px dotted #8a8c8f" data-modal="filter" data-filter-select="tab-2">
                    <i class="fas fa-star ghost-double"></i>
                    Населенный пункт
                </div>
                <div class="modal-call-btn pointer " style="border-bottom: 1px dotted #8a8c8f" data-modal="filter" data-filter-select="tab-3">
                    <i class="far fa-dot-circle ghost-double"></i>
                    Район
                </div>
                <div class="modal-call-btn pointer " style="border-bottom: 1px dotted #8a8c8f" data-modal="filter" data-filter-select="tab-4">
                    <i class="fas fa-road ghost-double"></i>
                    Шоссе
                </div>
                <div class="modal-call-btn pointer modal-filter-call" style="border-bottom: 1px dotted #8a8c8f" data-modal="filter" data-filter-select="tab-5">
                    <i class="fab fa-monero ghost-double"></i>
                    Метро
                </div>
            </div>
        </div>

        <script>

            let filters_modal_btns = document.getElementsByClassName('modal-filter-call');
            for(let i = 0; i < filters_modal_btns.length; i++){
                filters_modal_btns[i].addEventListener("click", function () {
                    //alert(filters_modal_btns[i].getAttribute('data-filter-select'));
                    document.getElementById(filters_modal_btns[i].getAttribute('data-filter-select')).setAttribute('checked','checked');
                });
            }

        </script>
        <div class="icon-round  modal-call-btn" data-modal="edit-all" data-id="" data-form="building" data-table="5" data-modal-size="modal-very-big" data-names="[&quot;is_land&quot;,&quot;company_id&quot;]" data-values="[1,199]">
            <div title="Создать обьект"><i class="fas fa-warehouse"></i></div>
        </div>
        <? include_once($_SERVER['DOCUMENT_ROOT'] . '/templates/modals/filter-modal/index.php') ?>
    </div>

    <div class="box-small filters-step-4" >
        <div class=" box-small" style=" border: 1px solid #d0d0d0">
            <div class="filters-panel flex-box flex-wrap text_left flex-vertical-bottom flex-around" >
                <?
                $sql_filters = $pdo->prepare("SELECT * FROM core_filters WHERE activity='1'  ORDER BY order_row DESC");
                $sql_filters->execute();
                while($filter_item = $sql_filters->fetch(PDO::FETCH_LAZY)){?>
                    <div class="filter-unit box">
                        <? $filter = new Filter($filter_item->id);?>
                        <? include($_SERVER["DOCUMENT_ROOT"] . '/templates/filters/'.$filter->filterGroupTemplate().'/index.php') ?>
                    </div>
                <?}?>
            </div>
        </div>
        <div class="flex-box flex-center filters-more">
            <div class="isBold box-small pointer" style=" width: 180px; margin-top: -1px; border-top: 1px solid #FFFFFF; border-left: 1px solid #d0d0d0; border-right: 1px solid #d0d0d0; border-bottom: 1px solid #d0d0d0;" data-more="1">
                Больше фильтров <span><i class="fas fa-caret-down"></i></span>
            </div>
        </div>
    </div>

