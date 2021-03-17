<?php
$company = new Company($router->getPath()[1]);
if($_COOKIE['member_id'] == 141){
    //require_once ($_SERVER['DOCUMENT_ROOT'].'/errors.php');
}
?>
<div class="profile-card">
    <? require_once ($_SERVER['DOCUMENT_ROOT'].'/templates/companies/header/index.php');?>
    <div class='flex-box flex-vertical-top flex-wrap'>
        <?if(count($contacts = $company->getCompanyContacts()) > 0){?>
            <?if($logedUser->isAdmin()){?>
                <?//var_dump($contacts)?>
            <?}?>

            <div class='widget half-flex box-small'>
                <div class='widget-title flex-box'>
                    <div>
                        Контакты  (<?=count($contacts)?>)
                    </div>
                    <div class="to-end">
                        <input class="hide_tasks" name="hide_tasks" type="checkbox"/>скрыть задачи
                    </div>
                    <script>
                        $('body').on('change','.hide_tasks',function(){
                            $(this).closest('.widget').find('.tabs-block ').slideToggle();
                        });
                    </script>
                </div>
                <div  class="widget-body  ">
                        <?$k=0?>
                    <?$cont_count = $company->countCompanyAreaUnits('Contact');
                    /*echo $cont_count;
                    ($cont_count > 1) ? $col_num = 2 :  $col_num = 1;
                    $per_column = $cont_count/$col_num ;
                    //echo $per_column;
                    $curr_num = 0;
                        for($i = 0; $i < $col_num; $i++){*/?>
                            <div class="flex-box flex-vertical-top flex-wrap">
                               <?//for($j = $curr_num; $j < $per_column*($i+1); $j++){?>
                               <?for($j = 0; $j < $cont_count; $j++){?>
                                   <?$contact = new Contact($contacts[$j]['id']);?>
                                   <?($contact->postId() == $company->getCompanyMainContact()) ? $isMain = 'contact-main' : $isMain=''?>

                                   <div class="box-small half" >
                                       <div class="contact-unit  box-small <?=$isMain?> <?=($contact->getField('status') == 2) ? 'ghost' : ''?>">
                                           <div class="flex-box">
                                               <div>
                                                   <div class="icon-square pointer icon-border-strong  " <?=($isMain)? 'style="background: green; color: white;"' : ''?>>
                                                       <div class="isBold">
                                                           <form action="<?=PROJECT_URL?>/system/controllers/posts/create.php" method="post">
                                                               <input type="hidden" name="id" value="<?=$company->postId()?>">
                                                               <input type="hidden" name="table_id" value="<?=$company->setTableId()?>">
                                                               <input type="hidden" name="contact_id" value="<?=$contact->postId()?>">
                                                               <button <?=($isMain)? 'style="color: white;"' : ''?> class="btn-free <?=($isMain)? 'isBold' : ''?>"><?=++$k?></button>
                                                           </form>
                                                       </div>
                                                   </div>
                                               </div>
                                               <div>
                                                   <?if($contact->getField('good_relationship')){?>
                                                       <div class="icon-square good pointer" title="Хорошие взаимоотношения">
                                                           <i class="fas fa-people-carry"></i>
                                                       </div>
                                                   <?}?>
                                               </div>
                                               <div>
                                                   <?if($contact->getField('contact_warning')){?>
                                                       <div class="icon-orthogonal attention pointer" title="<?=$contact->getField('contact_warning_description')?>">
                                                           <i class="fas fa-exclamation-triangle"></i><span class="box-wide">ВНИМАНИЕ!</span>
                                                       </div>
                                                   <?}?>
                                               </div>
                                               <?if($logedUser->isAdmin()){?>
                                               <div class="flex-box to-end">
                                                   <div class="modal-call-btn icon-round  pointer" data-id="<?=$contact->postId()?>"  data-table="<?=$contact->setTableId()?>" data-modal="edit-all" data-modal-size="modal-middle"  >
                                                       <span title="Редактировать"><i class="fas fa-pencil-alt"></i></span>
                                                   </div>
                                                   <div class="modal-call-btn icon-round pointer" data-id="" data-table="<?=(new Task(0))->setTableId()?>" data-modal="edit-all" data-names='["post_id_referrer","table_id_referrer"]'  data-values='[<?=$contact->getField('id')?>,<?=$contact->setTableId()?>]' data-modal-size="modal-middle"  >
                                                       <span title="Создать задачу"><i class="fas fa-thumbtack"></i></span>
                                                   </div>
                                               </div>
                                               <?}?>
                                           </div>
                                           <div class="box-small">
                                               <div class="flex-box" >
                                                   <div>
                                                       <a href="/contact/<?=$contact->postId()?>">
                                                           <b>
                                                               <?=$contact->title()?>
                                                           </b>
                                                       </a>
                                                   </div>
                                               </div>
                                               <div class="ghost">
                                                   <?$contact_group = new Post($contact->getField('contact_group'));
                                                   $contact_group->getTable('c_industry_contact_groups');
                                                   ?>
                                                   <?=$contact_group->title()?>
                                               </div>
                                               <?/*if($contact->getField('phones_hide')){?>
                                                   <?if($contact->author() == $logedUser->member_id() || $logedUser->isAdmin()){?>
                                                       <div>
                                                           <?=$contact->phone()?>
                                                       </div>
                                                   <?}?>
                                               <?}else{*/?>
                                                   <div>
                                                       <?=$contact->phone()?>
                                                   </div>
                                               <?//}?>
                                               <?if($contact->getField('emails_hide')){?>
                                                   <?if($contact->author() == $logedUser->member_id() || $logedUser->isAdmin()){?>
                                                       <div>
                                                           <?=$contact->email()?>
                                                       </div>
                                                   <?}?>
                                               <?}else{?>
                                                   <div>
                                                       <?=$contact->email()?>
                                                   </div>
                                               <?}?>
                                               <?if($contact->getField('agent_id')){?>
                                                   <div class="ghost">
                                                       Ведёт <?=(new Member($contact->getField('agent_id')))->getField('title');?>
                                                   </div>
                                               <?}?>
                                           </div>
                                           <div class="box-vertical">

                                           </div>
                                           <?if($contact->getPostLastComment()){?>
                                               <div >
                                                   <?$comment_obj = new Comment($contact->getPostLastComment()->id)?>
                                                   <div class="flex-wrap box-small">
                                                       <div class="flex-box ghost">
                                                           <div>
                                                               <?=date('d.m.Y',$comment_obj->getField('publ_time'))?>
                                                           </div>
                                                           <div class="box-wide">
                                                               <?=(new Member($comment_obj->getField('author_id')))->titleShort()?>
                                                           </div>
                                                       </div>
                                                       <div>
                                                           <?=$comment_obj->description()?>
                                                       </div>
                                                   </div>
                                               </div>
                                           <?}?>
                                           <div class="modal-call-btn underlined pointer  box-small-wide" style="color: blue;" data-id="<?=$contact->postId()?>" data-table="<?=$contact->setTableId()?>"  data-modal="post-comments"   data-modal-size="modal-middle">
                                               Показать/добавить комментарии
                                           </div>
                                           <?$item = $contact?>
                                           <?include($_SERVER['DOCUMENT_ROOT'].'/templates/tasks/wall/index.php')?>
                                       </div>
                                   </div>
                               <?} ?>
                            </div>
                            <?//$curr_num = (1+$i)*$per_column;?>
                        <?/*}*/?>
                </div>
            </div>
        <?}?>
        <?if($objects = $company->getCompanyObjects()){?>
            <?$offers = $company->getCompanyOffers();?>
            <div class='widget half-flex box-small'>
                <div class='widget-title flex-box'>
                    <div>
                        Объекты (<?=count($objects)?>)
                    </div>
                    <div>
                        , Предложения (<?=count($offers)?>)
                    </div>
                    <div class="to-end">
                        <input class="hide_tasks" name="hide_tasks" type="checkbox"/>скрыть задачи
                    </div>
                </div>
                <div class="widget-body">
                        <?
                        $k =0;
                        foreach($objects as $object){?>

                            <?$building = new Building($object['id'])?>
                            <?$offer_first = $building->getObjectOffers()[0]?>
                            <?$offer = new Offer($offer_first['id'])?>
                            <div class="box-vertical <?=($building->getField('status') == 2) ? 'ghost' : ''?>">
                                <div class="contact-unit box-small" >
                                    <div class="flex-box  text_left ">
                                        <div class="one-third-flex background-fix" style="height: 230px; position: relative; background-image: url('<?=$building->getObjectPreview()?>');">
                                            <a class="full-height display-block" href="<?=PROJECT_URL?>/complex/<?=$building->getField('complex_id')?>" target="_blank" >

                                            </a>
                                            <div class="flex-box" style="position: absolute; top: 10px; left: 5px; width: 95%;">
                                                <div>
                                                    <div class="icon-square pointer icon-border-strong ">
                                                        <div class="isBold">
                                                            <?=++$k?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="icon-orthogonal" style=" color: white; background: #6f6a66">
                                                    ID <?=$building->postId()?>
                                                </div>
                                                <?if($logedUser->isAdmin()){?>
                                                <div class="flex-box to-end" >
                                                    <div class="modal-call-btn icon-round" data-modal="edit-all"  data-form="<?=($building->getField('is_land')) ? 'land' : 'building'?>" data-id="<?=$building->postId()?>"  data-table="<?=$building->setTableId()?>" data-modal-size="modal-big"  >
                                                        <span title="Редактировать"><i class="fas fa-pencil-alt"></i></span>
                                                    </div>
                                                    <div class="modal-call-btn icon-round" data-modal="edit-all" data-id="" data-table="<?=(new Task(0))->setTableId()?>" data-names='["post_id_referrer","table_id_referrer"]'  data-values='[<?=$building->getField('id')?>,<?=$building->setTableId()?>]' data-modal-size="modal-middle"  >
                                                        <span title="Создать задачу"><i class="fas fa-thumbtack"></i></span>
                                                    </div>
                                                </div>
                                                <?}?>
                                            </div>
                                        </div>
                                        <div class="one-third-flex box-small" style="height: 230px;">
                                            <div class="half-vertical">
                                                <div class="isBold">
                                                    <a href="<?=PROJECT_URL?>/complex/<?=$building->getField('complex_id')?>" target="_blank">
                                                        <?if($building->title()){?>
                                                            <?=$building->title()?>
                                                        <?}else{?>
                                                            ID-<?=$building->postId()?>
                                                        <?}?>
                                                    </a>
                                                </div>
                                                <? $building_company = new Company($building->getField('company_id'))?>
                                                <?if($building_company->getField('company_group_id')){?>
                                                    <div class="ghost">
                                                        <?=(new CompanyGroup($company->getField('company_group_id')))->title()?>
                                                    </div>
                                                <?}?>
                                                <?if($building->getField('area_building')){?>
                                                    <div class="isBold">
                                                        <?=$building->getField('area_building')?> м<sup>2</sup>
                                                    </div>
                                                <?}?>
                                                <div class="ghost">
                                                    <?=$building->getFieldPreview('address', 105)?>
                                                </div>
                                            </div>
                                            <div class="flex-box flex-between flex-wrap ghost box-vertical half-vertical" >
                                                <div class="isBold half-flex ">
                                                    <i class="fas fa-signal"></i>
                                                    <?if($building->getField('floors')){?>
                                                        <?=$building->getField('floors')?> этаж(а)
                                                    <?}else{?>
                                                        не заполнено
                                                    <?}?>

                                                </div>
                                                <?if($offer_first['id']){?>
                                                <div class="isBold half-flex ">
                                                    <i class="fas fa-arrow-to-bottom"></i>
                                                    <?$floor_types = $building->getObjectBlocksValuesUnique('floor_type');?>

                                                    <?if(count($floor_types) > 1) {?>
                                                        разные
                                                    <?}elseif(count($floor_types) == 1){?>
                                                        <?$gate_obj = new Post($floor_types[0])?>
                                                        <?$gate_obj->getTable('l_gates_types')?>
                                                        <?=$gate_obj->title()?>
                                                    <?}else{?>
                                                        не заполнено
                                                    <?}?>
                                                </div>
                                                <div class="isBold half-flex">
                                                    <i class="fas fa-arrows-alt-v"></i> <?= valuesCompare($building->getObjectBlocksMinValue('ceiling_height_min'),$building->getObjectBlocksMaxValue('ceiling_height_max')) ?> метров
                                                </div>
                                                <div class="isBold half-flex ">
                                                    <i class="fas fa-door-open"></i>
                                                    <?
                                                    $gates = $building->getObjectBlocksValues('gates');
                                                    $gate_types = [];
                                                    $gate_amount = [];
                                                    foreach($gates as $gate){
                                                        $block_gates = json_decode($gate);
                                                        for($i = 0; $i < count($block_gates); $i = $i+2) {
                                                            if (!in_array($block_gates[$i], $gate_types) && $block_gates[$i]!=0) {
                                                                array_push($gate_types, $block_gates[$i]);
                                                            }
                                                            array_push($gate_amount, $block_gates[$i+1]);
                                                        }
                                                    }
                                                    ?>
                                                    <?if(count($gate_types) > 1) {?>
                                                        разные
                                                    <?}elseif(count($gate_types) == 1){?>
                                                        <?$gate_obj = new Post($gate_types[0])?>
                                                        <?$gate_obj->getTable('l_gates_types')?>
                                                        <?=$gate_obj->title()?>
                                                    <?}else{?>
                                                        не заполнено
                                                    <?}?>
                                                </div>
                                                <div class="isBold half-flex ">
                                                    <i class="fas fa-bolt"></i>
                                                    <?= ($building->getField('power')) ? $building->getField('power').'кВт' : 'не заполнено'?>
                                                </div>
                                                <div class="isBold half-flex ">
                                                    <i class="fas fa-truck-loading"></i>
                                                    <?
                                                    $elevators = $building->getObjectBlocksValues('cranes_cathead');
                                                    $elevators_types = [];
                                                    $elevators_amount = [];
                                                    foreach($elevators as $elevator){
                                                        $block_elevators = json_decode($elevator);
                                                        for($i = 0; $i < count($block_elevators); $i = $i+2) {
                                                            if (!in_array($block_elevators[$i+1], $elevators_types) && $block_elevators[$i+1]!=0) {
                                                                array_push($elevators_types, $block_elevators[$i+1]);
                                                            }
                                                        }
                                                    }
                                                    ?>
                                                    <?
                                                    $elevators = $building->getObjectBlocksValues('cranes_overhead');
                                                    foreach($elevators as $elevator){
                                                        $block_elevators = json_decode($elevator);
                                                        for($i = 0; $i < count($block_elevators); $i = $i+2) {
                                                            if (!in_array($block_elevators[$i+1], $elevators_types) && $block_elevators[$i+1]!=0) {
                                                                array_push($elevators_types, $block_elevators[$i+1]);
                                                            }

                                                        }
                                                    }
                                                    ?>
                                                    <?
                                                    $elevators = $building->getObjectBlocksValues('telphers');
                                                    foreach($elevators as $elevator){
                                                        $block_elevators = json_decode($elevator);
                                                        for($i = 0; $i < count($block_elevators); $i = $i+2) {
                                                            if (!in_array($block_elevators[$i+1], $elevators_types) && $block_elevators[$i+1]!=0) {
                                                                array_push($elevators_types, $block_elevators[$i+1]);
                                                            }
                                                        }
                                                    }
                                                    ?>
                                                    <?if(min($elevators_types) || max($elevators_types)){?>
                                                        <?=min($elevators_types)?> - <?=max($elevators_types)?> т
                                                    <?}else{?>
                                                        не заполнено    
                                                    <?}?>
                                                </div>
                                                <?}?>
                                            </div>
                                        </div>
                                        <div class="one-third-flex flex-box flex-vertical-top flex-between flex-wrap  " style="height: 230px; background-color: #f3f3f3; overflow-y: scroll">
                                            <?foreach($building->getObjectOffers() as $offer_item){?>
                                                <?$offer = new Offer($offer_item['id'])?>
                                                <div class="half-flex shadow-block box-small half-vertical " >
                                                    <?$deal_type = new Post($offer->getField('deal_type'))?>
                                                    <?$deal_type->getTable('l_deal_types')?>
                                                    <div class="isBold">
                                                        <a href="<?=PROJECT_URL?>/complex/<?=$building->getField('complex_id')?>?offer_id=[<?=$offer->postId()?>]#offers" target="_blank">
                                                            <?=$deal_type->title()?>
                                                        </a>
                                                    </div>
                                                    <?
                                                    $status = new Post($offer->getOfferStatus());
                                                    $status->getTable('l_statuses_all');
                                                    ?>
                                                    <?if($status->getField('id') == 1){?>
                                                        <?if($deal_type->postId() == 2){?>
                                                            <div >
                                                                <?= valuesCompare($offer->getOfferSumAreaMin(), $offer->getOfferSumAreaMax())?> м<sup>2</sup>
                                                            </div>
                                                            <div>
                                                                <?= $offer->showOfferCalcStat(valuesCompare($offer->getOfferBlocksMinValue('price_sale_min'), $offer->getOfferBlocksMaxValue('price_sale_max')), '<i class="fas fa-ruble-sign"></i>', '-')?> м<sup>2</sup>/год
                                                            </div>
                                                        <?}elseif($deal_type->postId() == 3){?>
                                                            <div>
                                                                <?= valuesCompare($offer->getOfferSumAreaMin(), $offer->getOfferSumAreaMax())?> м<sup>2</sup>
                                                            </div>
                                                            <div>
                                                                <?= $offer->showOfferCalcStat(valuesCompare($offer->getOfferBlocksMinValue('price_safe_pallet_eu_min'), $offer->getOfferBlocksMaxValue('price_safe_pallet_eu_max')), '<i class="fas fa-ruble-sign"></i>', '-')?> п.м./сут
                                                            </div>
                                                        <?}else{?>
                                                            <div>
                                                                <?= valuesCompare($offer->getOfferSumAreaMin(), $offer->getOfferSumAreaMax())?> м<sup>2</sup>
                                                            </div>
                                                            <div>
                                                                <?= $offer->showOfferCalcStat(valuesCompare($offer->getOfferBlocksMinValue('price_floor_min'), $offer->getOfferBlocksMaxValue('price_floor_max')), '<i class="fas fa-ruble-sign"></i>', '-')?> м<sup>2</sup>/год
                                                            </div>
                                                        <?}?>
                                                    <?}?>

                                                    <div><?=$status->title()?></div>
                                                </div>
                                            <?}?>
                                        </div>
                                    </div>
                                    <?$item = $building?>
                                    <?include($_SERVER['DOCUMENT_ROOT'].'/templates/tasks/wall/index.php')?>
                                </div>
                            </div>
                        <?}?>
                    <?
                    $k =0;
                    foreach($offers as $offer){?>
                        <?$building = new Building($offer['object_id'])?>
                        <?if($building->getField('company_id') != $company->postId()){?>
                            <div class="box-vertical">
                                <div class="contact-unit box-small" >
                                    <div class="flex-box  text_left ">
                                        <div class="one-third-flex background-fix" style="height: 230px; position: relative; background-image: url('<?=PROJECT_URL.'/system/controllers/photos/thumb.php/300/'.$building->postId().'/'.array_pop(explode('/',$building->getJsonField('photo')[0]))?>');">
                                            <a class="full-height display-block" href="/object/<?=$building->postId()?>" target="_blank" >
                                            </a>
                                            <div class="flex-box" style="position: absolute; top: 10px; left: 5px; width: 95%;">
                                                <div>
                                                    <div class="icon-square pointer icon-border-strong ">
                                                        <div class="isBold">
                                                            <?=++$k?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="icon-square" style=" color: white; background: #6f6a66">
                                                    ID <?=$building->postId()?>
                                                </div>
                                                <?if($logedUser->isAdmin()){?>
                                                <div class="flex-box to-end" >
                                                    <div class="modal-call-btn icon-round" data-modal="edit-all" data-id="<?=$building->postId()?>"  data-table="<?=$building->setTableId()?>" data-modal-size="modal-big"  >
                                                        <span title="Редактировать"><i class="fas fa-pencil-alt"></i></span>
                                                    </div>
                                                    <div class="modal-call-btn icon-round" data-modal="edit-all" data-id="" data-table="<?=(new Task(0))->setTableId()?>" data-names='["post_id_referrer","table_id_referrer"]'  data-values='[<?=$building->getField('id')?>,<?=$building->setTableId()?>]' data-modal-size="modal-middle"  >
                                                        <span title="Создать задачу"><i class="fas fa-thumbtack"></i></span>
                                                    </div>
                                                </div>
                                                <?}?>
                                            </div>
                                        </div>
                                        <div class="one-third-flex box-small" style="height: 230px;">
                                            <div class="half-vertical">
                                                <div class="isBold">
                                                    <a href="/object/<?=$building->postId()?>">
                                                        <?if($building->title()){?>
                                                            <?=$building->title()?>
                                                        <?}else{?>
                                                            ID-<?=$building->postId()?>
                                                        <?}?>
                                                    </a>
                                                </div>
                                                <?if($company->getField('company_group_id')){?>
                                                    <div>
                                                        PNK group
                                                    </div>
                                                <?}?>
                                                <?if($building->getField('area_building')){?>
                                                    <div class="isBold">
                                                        <?=$building->getField('area_building')?> м<sup>2</sup>
                                                    </div>
                                                <?}?>
                                                <div class="ghost">
                                                    <?=$building->getFieldPreview('address', 105)?>
                                                </div>
                                            </div>
                                            <div class="flex-box flex-between flex-wrap ghost box-vertical half-vertical" >
                                                <div class="isBold half-flex ">
                                                    <i class="fas fa-signal"></i>
                                                    <?if($building->getField('floors')){?>
                                                        <?=$building->getField('floors')?> этаж(а)
                                                    <?}else{?>
                                                        не заполнено
                                                    <?}?>

                                                </div>
                                                <div class="isBold half-flex ">
                                                    <i class="rotate-45 fas fa-arrows-alt"></i>
                                                    <?$floor_types = $building->getObjectBlocksValuesUnique('floor_type');?>

                                                    <?if(count($floor_types) > 1) {?>
                                                        разные
                                                    <?}elseif(count($floor_types) == 1){?>
                                                        <?$gate_obj = new Post($floor_types[0])?>
                                                        <?$gate_obj->getTable('l_gates_types')?>
                                                        <?=$gate_obj->title()?>
                                                    <?}else{?>
                                                        не заполнено
                                                    <?}?>

                                                </div>
                                                <div class="isBold half-flex">
                                                    <i class="fas fa-arrows-alt-v"></i> <?= valuesCompare($building->getObjectBlocksMinValue('ceiling_height_min'),$building->getObjectBlocksMaxValue('ceiling_height_max')) ?> метров
                                                </div>
                                                <div class="isBold half-flex ">
                                                    <i class="fas fa-sign-in-alt"></i>
                                                    <?
                                                    $gates = $building->getObjectBlocksValues('gates');
                                                    $gate_types = [];
                                                    $gate_amount = [];
                                                    foreach($gates as $gate){
                                                        $block_gates = json_decode($gate);
                                                        for($i = 0; $i < count($block_gates); $i = $i+2) {
                                                            if (!in_array($block_gates[$i], $gate_types) && $block_gates[$i]!=0) {
                                                                array_push($gate_types, $block_gates[$i]);
                                                            }
                                                            array_push($gate_amount, $block_gates[$i+1]);
                                                        }
                                                    }
                                                    ?>
                                                    <?if(count($gate_types) > 1) {?>
                                                        разные
                                                    <?}elseif(count($gate_types) == 1){?>
                                                        <?$gate_obj = new Post($gate_types[0])?>
                                                        <?$gate_obj->getTable('l_gates_types')?>
                                                        <?=$gate_obj->title()?>
                                                    <?}else{?>
                                                        не заполнено
                                                    <?}?>
                                                </div>
                                                <div class="isBold half-flex ">
                                                    <i class="fas fa-bolt"></i>
                                                    <?= ($building->getField('power')) ? $building->getField('power').'кВт' : 'не заполнено'?>
                                                </div>
                                                <div class="isBold half-flex ">
                                                    <i class="fas fa-truck-loading"></i>
                                                    <?
                                                    $elevators = $building->getObjectBlocksValues('cranes_cathead');
                                                    $elevators_types = [];
                                                    $elevators_amount = [];
                                                    foreach($elevators as $elevator){
                                                        $block_elevators = json_decode($elevator);
                                                        for($i = 0; $i < count($block_elevators); $i = $i+2) {
                                                            if (!in_array($block_elevators[$i+1], $elevators_types) && $block_elevators[$i+1]!=0) {
                                                                array_push($elevators_types, $block_elevators[$i+1]);
                                                            }
                                                        }
                                                    }
                                                    ?>
                                                    <?
                                                    $elevators = $building->getObjectBlocksValues('cranes_overhead');
                                                    foreach($elevators as $elevator){
                                                        $block_elevators = json_decode($elevator);
                                                        for($i = 0; $i < count($block_elevators); $i = $i+2) {
                                                            if (!in_array($block_elevators[$i+1], $elevators_types) && $block_elevators[$i+1]!=0) {
                                                                array_push($elevators_types, $block_elevators[$i+1]);
                                                            }

                                                        }
                                                    }
                                                    ?>
                                                    <?
                                                    $elevators = $building->getObjectBlocksValues('telphers');
                                                    foreach($elevators as $elevator){
                                                        $block_elevators = json_decode($elevator);
                                                        for($i = 0; $i < count($block_elevators); $i = $i+2) {
                                                            if (!in_array($block_elevators[$i+1], $elevators_types) && $block_elevators[$i+1]!=0) {
                                                                array_push($elevators_types, $block_elevators[$i+1]);
                                                            }
                                                        }
                                                    }
                                                    ?>
                                                    <?if(min($elevators_types) || max($elevators_types)){?>
                                                        <?=min($elevators_types)?> - <?=max($elevators_types)?> т
                                                    <?}else{?>
                                                        не заполнено
                                                    <?}?>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="one-third-flex flex-box flex-vertical-top flex-between flex-wrap  " style="height: 230px; background-color: #f3f3f3">
                                            <?foreach($building->getObjectOffers() as $offer_item){?>
                                                <?$offer = new Offer($offer_item['id'])?>
                                                <div class="half-flex shadow-block box-small half-vertical " >
                                                    <?$deal_type = new Post($offer->getField('deal_type'))?>
                                                    <?$deal_type->getTable('l_deal_types')?>
                                                    <div class="isBold"><?=$deal_type->title()?></div>
                                                    <div><?= valuesCompare($offer->getOfferBlocksMinValue('area_min'), $offer->getOfferBlocksMaxSumValue('area_max'))?> м<sup>2</sup></div>
                                                    <div><?= $offer->showOfferCalcStat(valuesCompare($offer->getOfferBlocksMinValue('price'), $offer->getOfferBlocksMaxValue('price')), '<i class="fas fa-ruble-sign"></i>', '-')?> м<sup>2</sup>/год</div>
                                                    <?
                                                    $status = new Post($offer->getOfferStatus());
                                                    $status->getTable('l_statuses_all');
                                                    ?>
                                                    <div><?=$status->title()?></div>
                                                </div>
                                            <?}?>
                                        </div>
                                    </div>
                                    <div class="box-small">

                                    </div>
                                    <?$item = $building?>
                                    <?include($_SERVER['DOCUMENT_ROOT'].'/templates/tasks/wall/index.php')?>
                                </div>
                            </div>
                        <?}?>
                    <?}?>
                </div>
            </div>
        <?}?>
        <?if($deals = $company->getCompanyDeals()){?>
            <?$requests = $company->getCompanyRequests()?>
            <div class='widget half-flex box-small'>
                <div class='widget-title flex-box'>
                    <div>
                        Запросы (<?=count($requests)?>) ,Сделки (<?=count($deals)?>)
                    </div>
                    <div class="to-end">
                        <input class="hide_tasks" name="hide_tasks" type="checkbox"/>скрыть задачи
                    </div>
                </div>
                <div class="widget-body">
                    <?
                    $k=0;
                    $i = 0;
                    foreach($deals as $deal_item){?>
                        <?$deal = new Deal($deal_item['id'])?>
                        <div class="box-vertical">
                            <div class="contact-unit box-small" >
                                <div class="flex-box box-small-vertical" >
                                    <div >
                                        <div class="icon-square pointer icon-border-strong ">
                                            <div class="isBold">
                                                <?=++$k?>
                                            </div>
                                        </div>
                                    </div>
                                    <?if($deal->getDealRequest()){?>
                                        <?$request = new Request($deal->getDealRequest())?>
                                        <?if($request->getField('is_immediate')){?>
                                            <div class="icon-orthogonal pointer icon-border-strong isBold  " style="background: #ff755b; color: white;">
                                                Срочный запрос
                                            </div>
                                        <?}?>
                                    <?}?>
                                    <div class="flex-box to-end" >
                                        <div class="modal-call-btn pointer icon-round"  data-id="" data-table="<?=(new Task(0))->setTableId()?>" data-modal="edit-all" data-names='["post_id_referrer","table_id_referrer"]'  data-values='[<?=$deal->getField('id')?>,<?=$deal->setTableId()?>]' data-modal-size="modal-middle"  >
                                            <span title="Создать задачу"><i class="fas fa-thumbtack"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex-box flex-vertical-top flex-between text_left " style="background-color: #f3f3f3;">
                                    <div class="half-flex box-small">
                                        <?if($deal->getDealRequest()){?>
                                            <?$request = new Request($deal->getDealRequest())?>
                                            <!--
                                            <div>
                                                Запрос #<?=$request->postId()?>
                                            </div>
                                            -->
                                            <div class="flex-box flex-vertical-bottom">
                                                <div class="isBold attention">
                                                    <?
                                                    $deal_type = new Post($request->getField('deal_type'));
                                                    $deal_type->getTable('l_deal_types')
                                                    ?>
                                                    <?=$deal_type->title()?>
                                                </div>
                                                <div class="isBold attention box-wide">
                                                     <?=$request->getField('area_floor_min')?> - <?=$request->getField('area_floor_max')?> м<sup>2</sup>
                                                </div>
                                                <div class="isBold attention ">
                                                    <?
                                                    $status = new Post($request->getField('status'));
                                                    $status->getTable('l_statuses_all');
                                                    echo $status->title();
                                                    ?>
                                                </div>
                                                <?if($logedUser->isAdmin()){?>
                                                <div class="to-end flex-box">
                                                    <div class="modal-call-btn icon-round" data-id="<?=$request->postId()?>"  data-table="<?=$request->setTableId()?>" data-modal="edit-all" data-modal-size="modal-middle"  >
                                                        <span title="Редактировать"><i class="fas fa-pencil-alt"></i></span>
                                                    </div>
                                                </div>
                                                <?}?>
                                            </div>
                                            <?if(in_array('6',$request->getJsonField('regions'))){?>
                                                <div class="flex-box flex-vertical-top">
                                                    <div>
                                                        <?$reg = new Post(6)?>
                                                        <?$reg->getTable('l_regions')?>
                                                        <b><?=$reg->title()?>:&#160;</b>
                                                    </div>
                                                    <div class="flex-box flex-wrap">
                                                        <?if(($districts = $request->getJsonField('districts_moscow'))[0] > 0){?>
                                                            <?foreach ($districts as $district){
                                                                $district_obj = new Post($district);
                                                                $district_obj->getTable('l_districts_moscow');?>
                                                                <div><?=$district_obj->title()?>,&#160;</div>
                                                            <?}?>
                                                        <?}?>
                                                    </div>
                                                </div>
                                            <?}?>
                                            <?if(in_array('1',$request->getJsonField('regions'))){?>
                                                <div class="flex-box flex-vertical-top">
                                                    <div>
                                                        <?$reg = new Post(1)?>
                                                        <?$reg->getTable('l_regions')?>
                                                        <b><?=$reg->title()?>:&#160;</b>
                                                    </div>
                                                    <div class="flex-box flex-wrap flex-vertical-top">
                                                        <?if(($directions = $request->getJsonField('directions'))[0] > 0){?>
                                                            <?foreach ($directions as $direction){
                                                                $direction_obj = new Post($direction);
                                                                $direction_obj->getTable('l_directions');?>
                                                                <div><?=$direction_obj->title()?>,&#160;</div>
                                                            <?}?>
                                                        <?}?>
                                                    </div>
                                                    <?if($request->getField('from_mkad')){?>
                                                        до <?=$request->getField('from_mkad')?> км.
                                                    <?}?>
                                                </div>
                                            <?}?>
                                            <?if(1){?>
                                                <div class="flex-box flex-vertical-top">
                                                    <b>Регионы:&#160;</b>
                                                    <?$regions = $request->getJsonField('regions')?>
                                                    <?if($regions[0] > 0){?>
                                                        <div class="flex-box flex-wrap">
                                                            <?foreach ($regions as $region){?>
                                                                <?if($region['id'] !='1' && $region['id']!='6'){
                                                                    $region_obj = new Post($region['id']);
                                                                    $region_obj->getTable('l_regions');?>
                                                                    <div><?=$region_obj->title()?>,&#160;</div>
                                                                <?}?>
                                                            <?}?>
                                                        </div>
                                                    <?}?>
                                                </div>
                                            <?}?>
                                            <?if($request->getField('price') > 1 ){?>
                                                <div>
                                                    Цена: до <b><?=$request->getField('price')?>  руб  м<sup>2</sup>/год</b>
                                                </div>
                                            <?}?>
                                            <div class="flex-box flex-vertical-top">
                                                <div>
                                                    ТУ:&#160;
                                                </div>
                                                <div class="flex-box flex-wrap">
                                                    <?if($request->getField('ceiling_height_min') || $request->getField('ceiling_height_max')){?>
                                                        <div>
                                                            <?=$request->getField('ceiling_height_min')?> - <?=$request->getField('ceiling_height_max')?> м,&#160;
                                                        </div>
                                                    <?}?>
                                                    <?if($request->getField('first_floor_only')){?>
                                                        <div>
                                                            1 этаж,&#160;
                                                        </div>
                                                    <?}?>
                                                    <?if($request->getField('heated')){?>
                                                        <div>
                                                            отапливаемый,&#160;
                                                        </div>
                                                    <?}?>
                                                    <?if($request->getField('selfleveling_floor_only')){?>
                                                        <div>
                                                            антипыль,&#160;
                                                        </div>
                                                    <?}?>
                                                    <?/*if($request->getField('gate_type')){?>
                                                        <div>
                                                            <?
                                                            $gate_type = new Post($request->getField('gate_type'));
                                                            $gate_type->getTable('l_gates_types');
                                                            ?>
                                                            <?=$gate_type->title()?>,&#160;
                                                        </div>
                                                    <?}*/?>
                                                    <?if($request->getField('railway')){?>
                                                        <div>
                                                            Ж/Д ветка,&#160;
                                                        </div>
                                                    <?}?>
                                                    <?if($request->getField('has_cranes')){?>
                                                        <div>
                                                            краны,&#160;
                                                        </div>
                                                    <?}?>
                                                    <?if($request->getField('power')){?>
                                                        <div>
                                                            <?=$request->getField('power')?> кВт
                                                        </div>
                                                    <?}?>
                                                </div>
                                            </div>
                                            <div class="ghost">
                                                <?if($request->getField('agent_id')){?>
                                                    Консультатант: <?= (new Member($request->getField('agent_id')))->getField('title')?>
                                                <?}?>
                                            </div>
                                            <div class="ghost">
                                                <?if($request->getField('publ_time')){?>
                                                    Дата поступления: <?=date('d.m.Y',$request->getField('publ_time'))?>
                                                <?}?>
                                            </div>
                                            <?if($request->getPostLastComment()){?>
                                                <div>
                                                    <div class="ghost">
                                                        Комментарии:
                                                    </div>
                                                    <?$comment_obj = new Comment($request->getPostLastComment()->id)?>
                                                    <div class="flex-wrap">
                                                        <div class="flex-box ghost">
                                                            <div>
                                                                <?=date('d.m.Y',$comment_obj->getField('publ_time'))?>
                                                            </div>
                                                            <div class="box-wide">
                                                                <?=(new Member($comment_obj->getField('author_id')))->getField('title')?>
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <?=$comment_obj->description()?>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?}?>
                                        <?}?>
                                    </div>
                                    <div class="half-flex box-small" style="border: 1px solid black;">
                                        <div class="flex-box flex-vertical-bottom" >
                                            <div>
                                                Сделка #<?=$deal->postId()?>
                                            </div>
                                            <div class="isBold box-wide">
                                                <?
                                                $deal_type = new Post($deal->getField('deal_type'));
                                                $deal_type->getTable('l_deal_types')
                                                ?>
                                                <?=$deal_type->title()?>
                                            </div>
                                            <?if($logedUser->isAdmin()){?>
                                            <div class="to-end flex-box ">
                                                <div class="modal-call-btn pointer icon-round " data-id="<?=$deal->postId()?>"  data-table="<?=$deal->setTableId()?>" data-modal="edit-all" data-modal-size="modal-middle"  >
                                                    <span title="Редактировать"><i class="fas fa-pencil-alt"></i></span>
                                                </div>
                                            </div>
                                            <?}?>
                                        </div>
                                        <div class="isBold">
                                            <!--Кем закрыта: Penny Lane-->
                                        </div>
                                        <?if($deal->getField('agent_id')){?>
                                            <div class="isBold">
                                                Консультант:
                                                <?=(new Member($deal->getField('agent_id')))->title()?>
                                            </div>
                                        <?}?>
                                        <div>
                                            ID выбранного объекта:
                                            <?if($deal->getField('object_id')){?>
                                                <?=$deal->getField('object_id')?>
                                                <? include_once ($_SERVER['DOCUMENT_ROOT'].'/errors.php');?>
                                            <?}else{?>
                                                <? $object = new Building(0);
                                                    $object->findBuildingByAddress($deal->getField('address'));
                                                ?>
                                                <?if($object->itemId()){?>
                                                     <a href="/object/<?=$object->itemId()?>" class="underlined"><?=$object->itemId()?></a>
                                                <?}?>
                                            <?}?>


                                        </div>
                                        <?if($deal->getField('area_deal')){?>
                                            <div>
                                                Занимаемая площадь:
                                                <span class="isBold">
                                                    <?=$deal->getField('area_deal')?> м<sup>2</sup>
                                                </span>
                                            </div>
                                        <?}?>
                                        <?if($deal->getField('price')){?>
                                            <div>
                                                Цена по итогу сделки:
                                                <span class="isBold">
                                                    <?=$deal->getField('price')?> руб/м<sup>2</sup>/год
                                                </span>
                                            </div>
                                        <?}?>
                                        <?if($deal->getPostLastComment()){?>
                                            <div>
                                                <div class="ghost">
                                                    Комментарии:
                                                </div>
                                                <?$comment_obj = new Comment($deal->getPostLastComment()->id)?>
                                                <div class="flex-wrap">
                                                    <div class="flex-box ghost">
                                                        <div>
                                                            <?=date('d.m.Y',$comment_obj->getField('publ_time'))?>
                                                        </div>
                                                        <div class="box-wide">
                                                            <?=(new Member($comment_obj->getField('author_id')))->getField('title')?>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <?=$comment_obj->description()?>
                                                    </div>
                                                </div>
                                            </div>
                                        <?}?>
                                        <?if($deal->getField('end_time')){?>
                                            <div class="ghost">
                                                Дата завершения <?=date('d.m.Y',$deal->getField('end_time'))?>
                                            </div>
                                        <?}?>
                                    </div>
                                </div>
                                <div class="box-small">

                                </div>
                                <div class="tabs-block">
                                    <div class="tabs flex-box">
                                        <div class="tab">
                                            Задачи
                                        </div>
                                        <div class="tab box-wide">
                                            Объекты
                                        </div>
                                    </div>
                                    <div class="tabs-content box-vertical">
                                        <div class="tab-content">
                                            <?$item = $deal?>
                                            <?include($_SERVER['DOCUMENT_ROOT'].'/templates/tasks/wall/index.php')?>
                                        </div>
                                        <div class="tab-content">
                                            <div class="box">
                                                <div class="flex-box box-small-vertical isBold">
                                                    <div style="width: 100px;">
                                                        #ID
                                                    </div>
                                                    <div style="width: 200px;">
                                                        Площадь
                                                    </div>
                                                    <div style="width: 200px;">
                                                        Компания
                                                    </div>
                                                    <div style="width: 200px;">
                                                        Консультант
                                                    </div>
                                                    <div style="width: 200px;">
                                                        Дата обновления
                                                    </div>
                                                </div>

                                                <? if($request->getField('area_floor_min')) { ?>
                                                    <?

                                                    $requestsSql = $pdo->prepare("SELECT * FROM c_industry_offers_mix WHERE type_id IN(1,2) AND  deal_type=" . $request->getField('deal_type') . " AND area_min<". $request->getField('area_floor_min') ." AND area_max>" . $request->getField('area_floor_max') . " AND  deleted!=1 ORDER BY last_update DESC LIMIT 20 ");
                                                    $requestsSql->execute();
                                                    while ($offerMix = $requestsSql->fetch(PDO::FETCH_LAZY)) { ?>
                                                        <div class="flex-box box-small-vertical">
                                                            <div style="width: 100px;">
                                                                <?= $offerMix->id ?>
                                                            </div>
                                                            <div style="width: 200px;" class="isBold">
                                                                <?= valuesCompare($offerMix->area_min,$offerMix->area_max)?>
                                                            </div>
                                                            <div style="width: 200px; " class="isBold underlined">
                                                                <? $comp = new Company($offerMix->company_id)?>
                                                                <a href="/company/<?=$comp->postId()?>/"  target="_blank">
                                                                    <?= $comp->title()?>
                                                                </a>
                                                            </div>
                                                            <div style="width: 200px;">
                                                                <?= (new Member($offerMix->agent_id))->getField('title')?>
                                                            </div>
                                                            <div style="width: 200px;">
                                                                <?= date('d-m-Y',$offerMix->last_update)?>
                                                            </div>
                                                        </div>
                                                    <?}?>
                                                <? } ?>


                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    <?}?>
                </div>
            </div>
        <?}?>
        <?/*if($requests = $company->getCompanyRequests()){?>
            <div class='widget half-flex box-small'>
                <div class='widget-title'>
                    Запросы (<?=count($requests)?>)
                </div>
                <div class="widget-body">
                        <?
                        $i = 0;
                        foreach($requests as $request){?>
                            <?$request_obj= new Request($request['id'])?>
                            <div class="box-vertical">
                                <div class="contact-unit box-small" >
                                    <div class="flex-box flex-vertical-top flex-between text_left " style="background-color: #f3f3f3;">
                                        <div class="half-flex box-small">
                                            <div class="flex-box flex-vertical-bottom">
                                                <div>
                                                    Запрос #<?=$request_obj->postId()?>
                                                </div>
                                                <div class="isBold box-wide">
                                                    <a href="/request/<?=$request_obj->postId()?>">
                                                         <?=$request_obj->getRequestDealTypeName()?>  <?=$request_obj->getField('area_min')?> - <?=$request_obj->getField('area_max')?> м <sup>2</sup>
                                                    </a>
                                                </div>
                                                <div class="to-end flex-box">
                                                    <div class="modal-call-btn " data-modal="edit-all" data-id="<?=$request_obj->postId()?>"  data-table="<?=$request_obj->setTableId()?>" data-modal-size="modal-middle"  >
                                                        <span title="Редактировать"><a href="javascript: 0"><i class="fas fa-pencil-alt"></i></a> </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <?if(in_array('1',$request_obj->getJsonField('regions'))){?>
                                                <div class="flex-box flex-vertical-top">
                                                    <div>
                                                        <?$reg = new Post(1)?>
                                                        <?$reg->getTable('l_regions')?>
                                                        <?=$reg->title()?>:&#160;
                                                    </div>
                                                    <div class="flex-box">
                                                        <?if(($districts = $request_obj->getJsonField('districts'))[0] > 0){?>
                                                            <?foreach ($districts as $district){
                                                                $district_obj = new Post($district['id']);
                                                                $district_obj->getTable('districts_moscow');?>
                                                                <div><?=$district_obj->title()?>,&#160;</div>
                                                            <?}?>
                                                        <?}?>
                                                    </div>
                                                </div>
                                            <?}?>
                                            <?if(in_array('1',$request_obj->getJsonField('regions'))){?>
                                                <div class="flex-box flex-vertical-top">
                                                    <div>
                                                        <?$reg = new Post(2)?>
                                                        <?$reg->getTable('l_regions')?>
                                                        <?=$reg->title()?>:&#160;
                                                    </div>
                                                    <div class="flex-box">
                                                        <?if(($directions = $request_obj->getJsonField('directions'))[0] > 0){?>
                                                            <?foreach ($directions as $direction){
                                                                $direction_obj = new Post($direction['id']);
                                                                $direction_obj->getTable('directions');?>
                                                                <div><?=$direction_obj->title()?>,&#160;</div>
                                                            <?}?>
                                                        <?}?>
                                                    </div>
                                                    <?if($request_obj->getField('from_mkad')){?>
                                                        до <?=$request_obj->getField('from_mkad')?> км.
                                                    <?}?>
                                                </div>
                                            <?}?>
                                            <div class="flex-box flex-vertical-top">
                                                Регионы:&#160;
                                                <?$regions = $request_obj->getJsonField('regions')?>
                                                <?if($regions[0] > 0){?>
                                                    <div class="flex-box flex-wrap">
                                                        <?foreach ($regions as $region){?>
                                                            <?if($region['id'] !='1' && $region['id']!='2'){
                                                                $region_obj = new Post($region['id']);
                                                                $region_obj->getTable('l_regions');?>
                                                                <div><?=$region_obj->title()?>,&#160;</div>
                                                            <?}?>
                                                        <?}?>
                                                    </div>
                                                <?}?>
                                            </div>
                                            <div>
                                                Цена: до <b><?=$request_obj->getField('price')?> руб/м<sup>2</sup>/год</b>
                                            </div>
                                            <div class="flex-box flex-vertical-top">
                                                <div>
                                                    ТУ:&#160;
                                                </div>
                                                <div class="flex-box flex-wrap">
                                                    <?if($request_obj->getField('first_floor_only')){?>
                                                        <div>
                                                            1 этаж,&#160;
                                                        </div>
                                                    <?}?>
                                                    <?if($request_obj->getField('heated')){?>
                                                        <div>
                                                            отапливаемый,&#160;
                                                        </div>
                                                    <?}?>
                                                    <?if($request_obj->getField('selfleveling_floor_only')){?>
                                                        <div>
                                                            антипыль,&#160;
                                                        </div>
                                                    <?}?>
                                                    <?if($request_obj->getField('railway')){?>
                                                        <div>
                                                            Ж/Д ветка,&#160;
                                                        </div>
                                                    <?}?>
                                                    <?if($request_obj->getField('power')){?>
                                                        <div>
                                                            <?=$request_obj->getField('power')?> кВт
                                                        </div>
                                                    <?}?>
                                                </div>
                                            </div>
                                            <div class="ghost">
                                                <?if($request_obj->getField('agent_id')){?>
                                                    Консультатант: <?= (new Member($request_obj->getField('agent_id')))->getField('title')?>
                                                <?}?>
                                            </div>
                                        </div>
                                        <div class="half-flex to-end box-small" style="border: 1px solid red;">
                                            <div class="flex-box">
                                                <div>
                                                    Сделка #1111 - 1, Завершена
                                                </div>
                                                <div class="to-end flex-box">
                                                    <div class="modal-call-btn " data-id="<?=$request_obj->postId()?>"  data-table="<?=$request_obj->setTableId()?>" data-modal="edit-all" data-modal-size="modal-middle"  >
                                                        <span title="Редактировать"><a href="javascript: 0"><i class="fas fa-pencil-alt"></i></a> </span>
                                                    </div>
                                                    <div class="modal-call-btn box-wide"  data-id="" data-table="<?=(new Task(0))->setTableId()?>" data-modal="edit-all" data-hidden-name="post_id_referrer,table_id_referrer"  data-hidden-value="<?=$request_obj->getField('id')?>,<?=$request_obj->setTableId()?>" data-modal-size="modal-middle"  >
                                                        <span title="Создать задачу"><a href="javascript: 0"><i class="fas fa-thumbtack"></i></a> </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="isBold">
                                                Кем: Penny Lane
                                            </div>
                                            <div class="isBold">
                                                Консультант: <?// =sdsdsdsd?>
                                            </div>
                                            <div>
                                                ID выбранного момента: 1111
                                            </div>
                                            <div>
                                                Площадь: 1111
                                            </div>
                                            <div>
                                                Цена по итогу сделки: 1111
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-box flex-between">
                                        <div class="underlined">
                                            Назначение:
                                        </div>
                                        <div class="isBold">
                                            <?if(($purposes = $request_obj->getRequestPurposes())[0] != NULL){?>
                                                <?foreach ($purposes as $purpose){
                                                    $purpose_obj = new Post($purpose['id']);
                                                    $purpose_obj->getTable('item_purposes');?>
                                                    <div><?=$purpose_obj->title()?></div>
                                                <?}?>
                                            <?}?>
                                        </div>
                                    </div>
                                </div>
                                <?if(count($tasks = $request_obj->getPostTasks()) > 0){?>
                                    <div style="border-top: 1px solid #eeeeee;" >
                                        <?foreach ($tasks as $task){?>
                                            <?$task_obj = new Task($task['id']);?>
                                            <? $task_status = new  Post($task_obj->getField('task_status_id'))?>
                                            <? $task_status->getTable('core_tasks_statuses')?>
                                            <div class="box-small text_left" style="background-color: <?=$task_status->getField('highlight_color')?>; margin-bottom: 10px;">
                                                <div class="flex-box" >
                                                    <div class="ghost">
                                                        Задача от <?=date('d.m.Y',$task_obj->getField('publ_time'))?>
                                                    </div>
                                                    <div class="isBold box-wide" style="color: <?=$task_status->getField('highlight_color_status')?>;">
                                                        <?=$task_status->title()?>
                                                    </div>
                                                    <div class="flex-box to-end box-small">
                                                        <div class="modal-call-btn box-wide" data-id="<?=$task_obj->postId()?>"  data-table="<?=$task_obj->setTableId()?>" data-modal-size="modal-small"  >
                                                            <span title="Редактировать"><a href="javascript: 0"><i class="fas fa-pencil-alt"></i></a> </span>
                                                        </div>
                                                        <div>
                                                            <?=($task_obj->getField('mark_as_important')) ? '<i title="Важное" class="fas fa-bell"></i>' : ''?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="isBold">
                                                    <a href="/task/<?=$task_obj->postId()?>">
                                                        <?=$task_obj->title()?>
                                                    </a>
                                                </div>
                                                <div>
                                                    <div class="flex-box flex-vertical-top">
                                                        <div>
                                                            <?=date('d.m.Y',$task_obj->getField('publ_time'))?>
                                                        </div>
                                                        <div class="box-wide">
                                                            <?=$task_obj->description()?>
                                                        </div>
                                                    </div>
                                                    <?foreach($task_obj->getPostComments() as $comment){?>
                                                        <?$comment_obj = new Comment($comment['id'])?>
                                                        <div class="flex-box flex-vertical-top">
                                                            <div>
                                                                <?=date('d.m.Y',$comment_obj->getField('publ_time'))?>
                                                            </div>
                                                            <div class="box-wide">
                                                                <?=$comment_obj->description()?>
                                                            </div>
                                                        </div>
                                                    <?}?>
                                                </div>
                                            </div>
                                        <?}?>
                                    </div>
                                <?}?>
                            </div>
                        <?}?>
                </div>
            </div>
        <?}*/?>
        <?/*if($offers = $company->getCompanyOffers()){?>
        <div class=' one-fourth-flex box-small'>
            <div class='widget-title'>
                Предложения (<?=count($offers)?>)
            </div>
            <div class="widget-body">
                <ul>
                    <?
                    foreach($offers as $offer){?>
                        <?$offer_obj = new Offer($offer['id']);?>
                        <?$building_obj = new Building($offer['object_id']);?>
                        <li>
                            <div>
                                <div class="flex-box">
                                    <div class="isBold">
                                        <a href="/object/<?=$offer['object_id']?>">
                                            <?=$offer_obj->getOfferDealType()?> <?=$building_obj->getField('id')?>-<?=preg_split('//u',$offer_obj->getOfferDealType(),-1,PREG_SPLIT_NO_EMPTY)[0]?>
                                            (<?=$offer_obj->getOfferStatus()?>)
                                        </a>
                                    </div>
                                    <div class="flex-box to-end">
                                        <div class="icon-round modal-call-btn" data-id="<?=$offer_obj->postId()?>"  data-table="<?=$offer_obj->setTableId()?>" data-modal-size="modal-middle"  >
                                            <span title="Редактировать"><a href="javascript: 0"><i class="fas fa-pencil-alt"></i></a> </span>
                                        </div>
                                        <div class="icon-round  modal-call-btn" data-id="" data-table="<?=(new Task(0))->setTableId()?>" data-hidden-name="post_id_referrer,table_id_referrer"  data-hidden-value="<?=$offer_obj->getField('id')?>,<?=$offer_obj->setTableId()?>" data-modal-size="modal-middle"  >
                                            <span title="Создать задачу"><a href="javascript: 0"><i class="fas fa-thumbtack"></i></a> </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="isBold">
                                    <?=$building_obj->getObjectType()?>
                                </div>
                                <div>
                                    <?=$building_obj->getField('address')?>
                                </div>
                                <?if(count($offer_obj->subItems())){?>
                                    <div class="isBold">
                                        <?= valuesCompare($offer_obj->getOfferBlocksMaxValue('area_min') , $offer_obj->getOfferBlocksMaxSumValue('area_max'))?> м<sup>2</sup>
                                    </div>
                                    <div>
                                        <?= valuesCompare($offer_obj->getOfferBlocksMaxValue('price') , $offer_obj->getOfferBlocksMaxSumValue('price'))?> руб. за м<sup>2</sup>
                                    </div>
                                <?}else{?>
                                    <div class="isBold attention">В предложении нет блоков</div>
                                <?}?>
                            </div>
                        </li>
                    <?}?>
                </ul>
            </div>
        </div>
        <?}*/?>
    </div>
    <div class='work-area box-left-top'>
        <? //include($_SERVER["DOCUMENT_ROOT"].'/system/user/'.$page_template.'.php');?>
    </div>
</div>


<? include_once($_SERVER["DOCUMENT_ROOT"].'/templates/modals/edit-all/index.php')?>