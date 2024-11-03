

<? include_once($_SERVER['DOCUMENT_ROOT'].'/templates/objects/selection/index.php');?>
<div>
    <div class="hidden" id="preloader" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(256,256,256, 0.9); z-index: 9;">
        <img style="width: 100px; margin-top: 100px;" src="https://loading.io/spinners/coolors/lg.palette-rotating-ring-loader.gif"/>
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
            <?=$objectsAmount?> вариантов
        </div>
    </div>
    <div class="main-table-block">
        <?include ($_SERVER['DOCUMENT_ROOT'].'/templates/pagination/index.php') ?>
        <div class="table-results-list">
            <div class="objects-caption object-list-template">
                <div class="for-id obj-col-1">
                    <div class="sortel ">
                        <a href="/industry/asc/id/1/?scroll2list">
                            ID
                            <i class="fas fa-exchange-alt rotate-90"></i>
                        </a>
                    </div>
                </div>
                <div class="obj-col-2">
                    <div class="sortel ">
                        <a href="/industry/asc/yandex_address_str/1/?scroll2list">
                            Адрес, фото ,назанчение
                        </a>
                    </div>
                </div>
                <div class="obj-col-3">
                    <div class="sortel ">
                        <a href="/industry/asc/region/1/?scroll2list">
                            Регион
                            <i class="fas fa-exchange-alt rotate-90"></i>
                        </a>
                    </div>
                </div>
                <div class="obj-col-4">
                    <nobr class="sortel ">
                        <a href="/industry/asc/region/1/?scroll2list">
                            Направление
                            <i class="fas fa-exchange-alt rotate-90"></i>
                        </a>
                    </nobr>
                    <!--
                    <div class="sortel ">
                        <a href="/industry/asc/highway/1/?scroll2list">
                            Шоссе
                        </a>
                    </div>
                    -->
                </div>
                <div class="obj-col-5">
                    <div class="sortel sortel-line2 ">
                        <a href="/industry/asc/otmkad/1/?scroll2list">
                            МКАД
                            <i class="fas fa-exchange-alt rotate-90"></i>
                        </a>
                    </div>
                </div>
                <div class="for-area obj-col-6">
                    <div class="sortt">
                        Площадь
                        <i class="fas fa-exchange-alt rotate-90"></i>
                    </div>
                </div>
                <div class="for-price obj-col-7">
                    <div class="sortt">
                        Цена
                        <i class="fas fa-exchange-alt rotate-90"></i>
                    </div>
                </div>
                <div class="obj-col-8">
                    <div class="for-area ">
                        <div class="sortt">
                            Контакт
                        </div>
                    </div>
                </div>
                <div class="obj-col-9">
                    <div class="sortel ">
                        <a href="/industry/asc/agent/1/?scroll2list">
                            Брокер
                            <i class="fas fa-exchange-alt rotate-90"></i>
                        </a>
                    </div>
                </div>
                <div class="obj-col-10">
                    <div class="sortel ">
                        <a href="/industry/asc/result/1/?scroll2list">
                            Статус
                            <i class="fas fa-exchange-alt rotate-90"></i>
                        </a>
                    </div>
                </div>
                <div class="obj-col-11">
                    <div class="sortt">
                        Обновление
                        <i class="fas fa-long-arrow-alt-down"></i>
                    </div>
                    <!--
                    <nobr class="sortel ">
                        <a href="/industry/asc/rent_price/1/?scroll2list">
                            <span class="b">реклама</span>
                        </a>
                    </nobr>
                    -->
                </div>
            </div>
        </div>
        <div class="">
            <?
            $start = ($page_num - 1)*$pageItems;
            $finish = ($page_num - 1)*$pageItems + $pageItems;
            $points_arr =[]; //для карты
            for($i = $start; $i < $finish; $i++){
                if($unique_objects[(int)$i]) {
                    $object = $factory->createBuilding($unique_objects[(int)$i]);
                    include ($_SERVER['DOCUMENT_ROOT'].'/templates/objects/list/index.php');
                }
            }?>
        </div>
    </div>
</div>
<?include ($_SERVER['DOCUMENT_ROOT'].'/templates/pagination/index.php') ?>