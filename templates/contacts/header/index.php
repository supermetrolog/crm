<div class='profile-header flex-box header-panel' style='background-image: url(<?= 11;?>);'>
    <div class='calendar_event_time isBold'>

    </div>
    <div class='photo_line flex-box flex-center-center ' >
        <div class='photo-round photo-big'>
            <img src='<?=PROJECT_URL?>/img/avatar_contact.png'/>
        </div>
        <div class='user_name flex-box flex-center-center'>
            <h2><?=$contact->title()?></h2>
            <?$contact_group = new Post($contact->getField('contact_group'));
            $contact_group->getTable('c_industry_contact_groups');
            ?>
            <h4><?=$contact_group->title()?></h4>
        </div>
    </div>
    <div class='profile-panel info_line text_left bitkit_box flex-box ' style='color: white'>
        <div class='info_line_units'>
            <span>Создана:</span><br>
            <?= date('Y-m-d',$contact->getField('publ_time'))?>
        </div>
        <div class='info_line_units '>
            <span >Последнее обновление:</span><br>
            <?= date('Y-m-d в H:i',$contact->getField('last_update'))?>
        </div>
        <div class='info_line_units '>
            <span >Компания:</span><br>
            <?$company = new Company($contact->getField('company_id'))?>
            <a href="/company/<?=$company->postId()?>" style="color: white">
                <?=$company->getField('title')?>
            </a>
        </div>
        <div class='info_line_units '>
            <span >Ведет брокер:</span><br>
            <?$agent = new Member($contact->getField('agent_id'))?>
            <?=$agent->getField('title')?>
        </div>
        <div class="icon-round to-end modal-call-btn" data-id="<?=$contact->postId()?>" data-table="<?=$contact->setTableId()?>" data-modal="edit-all" data-modal-size="modal-middle"  >
            <span title="Редактировать"><a href="javascript: 0"><i class="fas fa-pencil-alt"></i></a> </span>
        </div>
    </div>
</div>