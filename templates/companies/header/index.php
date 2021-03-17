<?php
/**
 * Created by PhpStorm.
 * User: Zhitkov
 * Date: 28.06.2018
 * Time: 14:45
 */
?>
<?
if($_COOKIE['member_id'] == 141){
    //include_once ($_SERVER['DOCUMENT_ROOT'].'/errors.php');
}
?>
<div class="card-title-area box">
    <div class="flex-box box-vertical">
        <div>
            <b>ID компании - <?=$company->postId()?></b> ,
        </div>
        <div class="flex-box ghost">
            <div>
                <?$agent = new Member($company->getField('agent_id'))?>,
                внёс <?=$agent->title()?>
            </div>
            <div  class="box-wide">
                поступление <?=date('Y-m-d',$company->getField('publ_time'))?>,
            </div>
            <div>
                обновление <?=date('Y-m-d H:i',$company->getField('last_update'))?>
            </div>
        </div>
        <?if($logedUser->isAdmin()){?>
        <div class="icon-round to-end modal-call-btn" data-id="<?=$company->postId()?>" data-table="<?=$company->setTableId()?>" data-names='["redirect"]' data-values="[1]" data-modal="edit-all" data-modal-size="modal-big"  >
            <span title="Редактировать"><i class="fas fa-pencil-alt"></i></span>
        </div>
        <?}?>

    </div>
    <div>
        <h1>
            <?if($company->getField('company_law_type')){?>
                <?$law = new Post($company->getField('company_law_type'))?>
                <?$law->getTable('l_company_law_types')?>
                <?=$law->title()?>
            <?}?>
            <?if($company->title()){?>
                <?if($company->postId() == $company->title()){?>
                    <span class="attention ">NONAME <?=$company->postId()?></span>
                <?}else{?>
                    <?=$company->title()?>
                <?}?>
            <?}else{?>
                <?='Название компании'?>
            <?}?>
            <?if($company->getField('title_eng')){?>
                - <?=$company->getField('title_eng')?>
            <?}?>
            <?if($company->getField('deleted')){?>
                <?='(УДАЛЕН)'?>
            <?}?>
            <?if($company->getField('company_group_id')){?>
                <span class="ghost">
                    <?
                    $company_group = new CompanyGroup($company->getField('company_group_id'))

                    ?>
                    (
                    <?if($company_group->getField('company_group_law_type')){?>
                        <span>
                            <?
                            $law_type = new Post($company_group->getField('company_group_law_type'));
                            $law_type->getTable('l_company_group_law_types');
                            ?>
                            <?=$law_type->title()?>
                        </span>
                    <?}?>
                    <?=$company_group->title()?>

                    )
                </span>

            <?}?>
            <?if($company->getField('status') ==2 ){?>
                <span style="color: red;">
                    <?php
                    $status = new Post($company->getField('status'));
                    $status->getTable('l_statuses_all');
                    ?>
                    <?=$status->title();?>
                </span>
            <?}?>
        </h1>
    </div>
    <div class="card-top-pictograms ghost box-vertical">
        <ul>
            <?foreach($company->getJsonField('company_group') as $group){?>
                <?$gr = new Post($group)?>
                <?$gr->getTable('c_industry_company_groups')?>
                <li class="icon-orthogonal "><a href="#" title=""><?=$gr->title()?></a></li>
            <?}?>
        </ul>
    </div>
</div>
<div class="card-search-area box">
    <div class="card-search-line">
        <div>
            <input disabled  type="text" name="" value="<?=$company->getField('address')?>" placeholder="" />
            <div id="open-object-map"><i class="fas fa-map-marker-alt"></i></div>
        </div>
    </div>


    <script src="https://api-maps.yandex.ru/2.1/?apikey=2b6763cf-cc99-48c7-81f1-f4ceb162502a&lang=ru_RU" type="text/javascript">

    </script>
    <script async defer type="text/javascript">
        ymaps.ready(init);
        function init(){
            let coords = [<?=$company->getField("latitude")?>,<?=$company->getField("longitude")?>]

            let myMap = new ymaps.Map("map", {
                center: coords,
                controls: ['zoomControl'],
                zoom: 10
            });


            let myPlacemark = new ymaps.Placemark(coords, {

                balloonContentHeader: "<?=$company->title()?>",
                balloonContentBody: "<?=$company->getField('address')?>",
                balloonContentFooter: "",
                hintContent: ""
            });

            myMap.geoObjects.add(myPlacemark);
        }



        $('body').on('click','#open-object-map',function () {
            $('#map').slideToggle(100);
        });
    </script>

    <div id="map"  style=" height: 400px; display: none;">


    </div>


    <div class="flex-box card-search-tags">
        <div>
            <ul>
                <?if(($obj_amount = count($company->getCompanyAreaUnits('Contact'))) > 0){?>
                    <li>Контакты: <?=$obj_amount?></li>
                <?}?>
                <?if(($obj_amount = count($company->getCompanyAreaUnits('Building'))) > 0){?>
                    <li>Объекты: <?=$obj_amount?></li>
                <?}?>
                <?if(($obj_amount = count($company->getCompanyAreaUnits('Offer'))) > 0){?>
                    <li>Предложения: <?=$obj_amount?></li>
                <?}?>
                <?if(($obj_amount = count($company->getCompanyAreaUnits('Request'))) > 0){?>
                    <li>Запросы: <?=$obj_amount?></li>
                <?}?>
                <?if(($obj_amount = count($company->getCompanyAreaUnits('Deal'))) > 0){?>
                    <li>Сделки: <?=$obj_amount?></li>
                <?}?>
            </ul>
        </div>
        <?if($logedUser->isAdmin()){?>
        <div class="flex-box to-end">
            <div class="icon-round modal-call-btn" data-modal="edit-all" data-id="" data-table="<?=(new Contact())->setTableId()?>"  data-names='["company_id"]' data-values='[<?=$company->getField('id')?>]' data-modal-size="modal-middle"  >
                <div title="Создать контакт"><i class="fas fa-user-plus"></i></div>
            </div>
            <!--
            <div class="icon-round  modal-call-btn" data-modal="edit-all" data-id="" data-form="building" data-table="<?=(new Building())->setTableId()?>"    data-modal-size="modal-very-big" data-names='["is_land","company_id"]' data-values='[0,<?=$company->getField('id')?>]' >
                <div title="Создать обьект"><i class="fas fa-warehouse"></i></div>
            </div>
            <div class="icon-round  modal-call-btn" data-modal="edit-all" data-id="" data-form="land" data-table="<?=(new Building())->setTableId()?>"  data-modal-size="modal-very-big" data-names='["is_land","company_id","form_title"]' data-values='[1,<?=$company->getField('id')?>,"Участок"]'  >
                <div title="Создать участок"><i class="fas fa-tree"></i></div>
            </div>
            -->
            <div class="icon-round  modal-call-btn" data-modal="edit-all" data-id="" data-table="<?=(new Request())->setTableId()?>"  data-names='["company_id"]' data-values='[<?=$company->getField('id')?>]' data-modal-size="modal-middle"  >
                <div title="Создать запрос"><i class="fas fa-list-ol"></i></div>
            </div>
            <div class="icon-round  modal-call-btn" data-modal="edit-all" data-id="" data-table="<?=(new Deal())->setTableId()?>"  data-names='["company_id"]' data-values='[<?=$company->getField('id')?>]'  data-show-name="object_id"   data-modal-size="modal-middle"  >
                <div title="Создать сделку"><i class="far fa-handshake"></i></div>
            </div>
        </div>
        <?}?>
    </div>

</div>

<div class="tabs-block box">
    <div class="tabs flex-box">
        <div class="tab">
            Основное
        </div>
        <div class="tab box-wide">
            Деятельность
        </div>
        <div class="tab">
            Реквизиты
        </div>
        <div class="tab box-wide">
            Документы
        </div>
    </div>
    <div class="tabs-content box-vertical">
        <div class="tab-content">
            <div class="object-about-section object-params-list col-1 one-fourth-flex box-small">
                <div class="isBold box-vertical">Данные новой базы</div>
                <ul>
                    <?
                    $arr = [208,200];
                    //$arr = [208,199,200];
                    ?>
                    <?foreach($arr as $item){?>
                        <?$field = new Field($item)?>
                        <?if($company->getJsonField($field->title())){?>
                            <?foreach($company->getJsonField($field->title()) as $value){?>
                                <li>
                                    <div style="width: 150px">
                                        <?=$field->titleToDisplay()?>
                                    </div>
                                    <div class="box-wide">
                                        <div>
                                            <?=$value?>
                                        </div>
                                    </div>
                                </li>
                            <?}?>
                        <?}?>
                    <?}?>
                    <?

                    $arr = [199];
                    ?>
                    <?foreach($arr as $item){?>
                        <?$field = new Field($item)?>
                        <?$all = $company->getJsonField($field->title())?>
                        <?if(($tel_amount = count($all)) > 0){?>
                            <?for($i =0; $i < $tel_amount; $i = $i+2){?>
                                <li>
                                    <div style="width: 150px">
                                        <?=$field->titleToDisplay()?>
                                    </div>
                                    <div class="box-wide">
                                        <div>
                                            <?=$all[$i]?>
                                            <?if($all[$i+1]){?>
                                                доб. <?=$all[$i+1]?>
                                            <?}?>
                                        </div>
                                    </div>
                                </li>
                            <?}?>
                        <?}?>
                    <?}?>
                </ul>
            </div>
            <?if(1){?>
                <div class="object-about-section object-params-list col-1 one-fourth-flex box-small">
                    <div class="isBold box-vertical">Данные старой базы</div>
                    <ul>
                        <?
                        $arr = [183,166,44,88];
                        ?>
                        <?foreach($arr as $item){?>
                            <?$field = new Field($item)?>
                            <?if($company->getField($field->title())){?>
                                <li>
                                    <div style="width: 150px">
                                        <?=$field->titleToDisplay()?>
                                    </div>
                                    <div class="box-wide">
                                        <div>
                                            <?= $company->getField($field->title())?>
                                        </div>
                                    </div>
                                </li>
                            <?}?>
                        <?}?>
                    </ul>
                </div>
            <?}?>
        </div>
        <div class="tab-content">
            <div class="object-about-section object-params-list col-1 one-fourth-flex box-small">
                <div class="isBold box-vertical">Данные новой базы</div>
                <ul>
                    <?
                    $arr = [184,438,439,14];
                    //$arr = [];
                    ?>
                    <?foreach($arr as $item){?>
                        <?$field = new Field($item)?>
                        <?if($company->getField($field->title())){?>
                            <li>
                                <div style="width: 150px">
                                    <?=$field->titleToDisplay()?>
                                </div>
                                <div class="box-wide">
                                    <?if(is_array($many = $company->getJsonField($field->title()))){?>
                                        <?foreach($many as $item){?>
                                            <div>
                                                <?if($field->getField('linked_table')){?>
                                                    <?$data = new Post($item)?>
                                                    <?$data->getTable($field->getField('linked_table'))?>
                                                    <?=$data->title()?>
                                                <?}else{?>
                                                    <?= $company->getField($field->title())?>
                                                <?}?>
                                            </div>
                                        <?}?>
                                    <?}else{?>
                                        <div>
                                            <?if($field->getField('linked_table')){?>
                                                <?$data = new Post($company->getField($field->title()))?>
                                                <?$data->getTable($field->getField('linked_table'))?>
                                                <?=$data->title()?>
                                            <?}else{?>
                                                <?//вот тут надо расскоментить?>
                                                <?//= $company->getField($field->title())?>
                                            <?}?>
                                        </div>
                                    <?}?>

                                </div>
                            </li>
                        <?}?>
                    <?}?>
                </ul>
            </div>
            <div class="object-about-section object-params-list box-small three-fourth-flex">
                <div class="isBold box-vertical">Данные старой базы</div>
                <div style="    background: #f4f4f4; min-height: 80px; padding: 5px">
                    <?= strip_tags($company->getField('company_service_name'))?>
                </div>
            </div>
        </div>
        <div class="tab-content" >
            <div class="object-about-section object-params-list col-1 one-fourth-flex box-small">
                <ul>
                    <?
                    $arr = [440,441,442,443,444,445,446];
                    ?>
                    <?foreach($arr as $item){?>
                        <?$field = new Field($item)?>
                        <?if($company->getField($field->title())){?>
                            <li>
                                <div style="width: 150px">
                                    <?=$field->titleToDisplay()?>
                                </div>
                                <div class="box-wide" title="<?=$company->getField($field->title())?>" >
                                    <?=$company->getField($field->title())?>
                                </div>
                            </li>
                        <?}?>
                    <?}?>
                </ul>
            </div>
            <div class="object-about-section object-params-list col-1 one-fourth-flex box-small">
                <ul>
                    <?
                    $arr = [447,448,449,450,451,452,453,454];
                    ?>
                    <?foreach($arr as $item){?>
                        <?$field = new Field($item)?>
                        <?if($company->getField($field->title())){?>
                            <li>
                                <div style="width: 150px">
                                    <?=$field->titleToDisplay()?>
                                </div>
                                <div class="box-wide" title="<?=$company->getField($field->title())?>">
                                    <?=$company->getField($field->title())?>
                                </div>
                            </li>
                        <?}?>
                    <?}?>
                </ul>
            </div>
        </div>
        <div class="tab-content">
            <div class="files-grid flex-box full-width">
                <?if($company->postId()){?>
                    <? if($company->getJsonField('documents') != NULL){?>
                        <?foreach($company->showJsonField('documents') as $file_unit){?>
                            <div class='files-grid-unit' data-src="<?=$file_unit?>" >
                                <?$ext = getFileExtension($file_unit)?>
                                <div class="text_center full-height flex-box flex-box-vertical grey-border">
                                    <div class="box">

                                    </div>
                                    <div style="font-size: 60px;" title="<?=getFilePureName($file_unit)?> <?=$ext?>">
                                        <?=getFileIcon($file_unit)?>
                                    </div>
                                    <div title="<?=getFilePureName($file_unit)?>" class="box-small text_center full-width to-end-vertical grey-background" >
                                        <a href="<?=$file_unit?>" target="_blank" class="text_center">
                                            <div class="flex-box flex-center">
                                                <div class="box-wide" style="font-size: 20px;">
                                                    <?=getFileIcon($file_unit)?>
                                                </div>
                                                <div>
                                                    <?=getFileNameShort($file_unit)?> <?=$ext?>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                <div class="file-delete icon-round"  >
                                    <i class='fa fa-times' aria-hidden='true'></i>
                                </div>
                            </div>
                        <?}?>
                    <?}?>
                <?}?>
            </div>

            <?

            $id = $company->postId();
            $table_name = 'companies';

            $files = array_diff( scandir(PROJECT_ROOT."/uploads/files_old/$table_name/$id/"), ['..', '.']); //иначе scandir() дает точки
            $files_list = [];

            //echo 'лот номер'. "<b>$id</b>";
            //echo 'его фотки далее<br>';
            foreach ($files as $file) {
                $files_list[] = PROJECT_ROOT."/uploads/files_old/$table_name/$id/".$file;
            }

            //var_dump($files_list);
            ?>

            <?if(count($files_list) > 0){?>
                <div class="form-files  files-list   " style="min-width :300px;">
                    Документы старой базы
                    <div class=" flex-box flex-wrap files-grid" >
                        <?if($company->postId()){?>
                            <? if($files != NULL){?>
                                <?foreach($files_list as $file_unit){?>
                                    <div class='files-grid-unit' data-src="<?=$file_unit?>" >
                                        <?$ext = getFileExtension($file_unit)?>
                                        <div class="text_center full-height flex-box flex-box-vertical grey-border">
                                            <div class="box">

                                            </div>
                                            <div style="font-size: 60px;" title="<?=getFilePureName($file_unit)?> <?=$ext?>">
                                                <?=getFileIcon($file_unit)?>
                                            </div>
                                            <div title="<?=getFilePureName($file_unit)?>" class="box-small text_center full-width to-end-vertical grey-background" >
                                                <a href="<?=$file_unit?>" target="_blank" class="text_center">
                                                    <div class="flex-box flex-center">
                                                        <div class="box-wide" style="font-size: 20px;">
                                                            <?=getFileIcon($file_unit)?>
                                                        </div>
                                                        <div>
                                                            <a href="<?= "/uploads/files_old/$table_name/$id/".array_pop(explode('/',$file_unit))?>" target="_blank">
                                                                <?=array_pop(explode('/',$file_unit))?> <?//=$ext?>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                <?}?>
                            <?}?>
                        <?}?>
                    </div>
                </div>
            <?}?>
        </div>
    </div>
</div>



