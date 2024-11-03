<?php
/**
 * Created by PhpStorm.
 * User: Zhitkov
 * Date: 28.06.2018
 * Time: 14:45
 */
?>

    <div class='profile-header flex-box header-panel background-fix' style='background-image: url("https://www.retail-loyalty.org/upload/medialibrary/5bb/5bbe63e825bd8e3ca15c34cca4840919.jpg");'>
        <div class='calendar_event_time isBold'>

        </div>
        <div class='photo_line flex-box flex-center-center ' >
            <div class='photo-round photo-big'>
                <img src='https://cdn.udc.edu/wp-content/uploads/2016/11/project_request.png'/>
            </div>
            <div class='user_name flex-box flex-center-center'>
                <h2>#<?=$request->postId()?></h2>
            </div>
        </div>
        <div class='profile-panel info_line text_left bitkit_box flex-box ' style='color: white'>
            <div class='info_line_units '>
                <span >Тип запроса:</span><br>
                <?$deal_type = new Post($request->getField('deal_type'))?>
                <?$deal_type->getTable('l_deal_types')?>
                <?=$deal_type->title()?>
            </div>
            <div class='info_line_units '>
                <span >Статус:</span><br>
                <?=$request->getRequestStatus()?>
            </div>
            <div class='info_line_units '>
                <span >Компания:</span><br>
                <?$company = new Company($request->getField('company_id'))?>
                <a style="color: white" href="/company/<?=$company->postId()?>/"><?=$company->title()?></a>
            </div>
            <div class='info_line_units '>
                <span >Основной контакт:</span><br>
                <form action="<?=PROJECT_URL?>/system/controllers/posts/create.php" method="post">
                    <input type="hidden" name="id" value="<?=$company->postId()?>"/>
                    <input type="hidden" name="table" value="c_industry_companies"/>
                    <select oninput="$(this).closest('form').submit()" name="contact_id" style="padding: 5px">
                        <?if($selected_contact = $company->getField('contact_id')){?>
                            <?
                            $curr_contact = new Contact($selected_contact);
                            ?>
                            <option value="<?=$selected_contact?>"><?=$curr_contact->title()?></option>
                        <?}?>
                        <?
                        foreach($company->getCompanyContacts() as $contact){
                            $contact = new Contact($contact['id']);?>

                            <option value="<?=$contact->postId()?>"><?=$contact->title()?></option>
                        <?}?>
                    </select>

                </form>
            </div>
            <div class='info_line_units '>
                <span >Ведет брокер:</span><br>
                <?$agent = new Member($request->getField('agent_id'))?>
                <?=$agent->getField('title')?>
            </div>
            <div class='info_line_units'>
                <span>Создан:</span><br>
                <?= date('Y-m-d',$request->getField('publ_time'))?>
            </div>
            <div class='info_line_units '>
                <span >Последнее обновление:</span><br>
                <?= date('Y-m-d в H:i',$request->getField('last_update'))?>
            </div>
            <div class="icon-round to-end modal-call-btn" data-id="<?=$request->postId()?>" data-table="<?=$request->setTableId()?>" data-form-size="modal-middle"  >
                <span title="Редактировать"><a href="javascript: 0"><i class="fas fa-pencil-alt"></i></a> </span>
            </div>
        </div>
    </div>


