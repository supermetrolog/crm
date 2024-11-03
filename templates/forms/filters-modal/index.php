

            <?$region = (int)$_POST['region']?>
            <?// var_dump($region)?>
            <? require_once($_SERVER['DOCUMENT_ROOT'] . '/global_pass.php');?>

            <div class="tabs-block filters-step-2  box" id="filters-modal">
                <div class="tabs flex-box">
                    <div class="tab">
                        Область на карте
                    </div>
                    <?if(in_array($region,[1,100,300,400])){?>
                        <div class="tab">
                            Населенный пункт
                        </div>
                        <div class="tab">
                            Район
                        </div>
                        <div class="tab">
                            Шоссе
                        </div>
                    <?}?>
                    <?if(in_array($region,[6,100,200])){?>
                        <div class="tab">
                            Шоссе Москвы
                        </div>
                        <div class="tab">
                            Метро
                        </div>
                    <?}?>
                </div>
                <div class="tabs-content">
                    <div class="tab-content">
                        <div class="box">

                        </div>
                        тут карта
                    </div>
                    <?if(in_array($region,[1,100,300,400])){?>
                        <div class="tab-content">
                            <? $filter = new Filter(53);?>
                            <? include($_SERVER["DOCUMENT_ROOT"] . '/templates/filters/templates/'.$filter->filterGroupTemplate().'/index.php') ?>
                        </div>
                        <div class="tab-content">
                            <? $filter = new Filter(52);?>
                            <? include($_SERVER["DOCUMENT_ROOT"] . '/templates/filters/templates/'.$filter->filterGroupTemplate().'/index.php') ?>
                        </div>
                        <div class="tab-content">
                            <? $filter = new Filter(51);?>
                            <? include($_SERVER["DOCUMENT_ROOT"] . '/templates/filters/templates/'.$filter->filterGroupTemplate().'/index.php') ?>
                        </div>
                    <?}?>
                    <?if(in_array($region,[6,100,200])){?>
                        <div class="tab-content">
                            <? $filter = new Filter(50);?>
                            <? include($_SERVER["DOCUMENT_ROOT"] . '/templates/filters/templates/'.$filter->filterGroupTemplate().'/index.php') ?>
                        </div>
                        <div class="tab-content">
                            <? $filter = new Filter(49);?>
                            <? include($_SERVER["DOCUMENT_ROOT"] . '/templates/filters/templates/'.$filter->filterGroupTemplate().'/index.php') ?>
                        </div>
                    <?}?>

                </div>
            </div>
