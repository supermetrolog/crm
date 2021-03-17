<div class="contact-unit"  style=" margin-bottom: 10px;">
    <div class="box-small" style="background-color: <?=$task_status->getField('highlight_color')?>;">
        <div class="flex-box flex-vertical-top"  >
            <div>
                Задача от <?=date('d.m.Y',$task_obj->getField('publ_time'))?>  <?//=date('H:i',$task_obj->getField('publ_time'))?>
            </div>
            <div class="isBold box-wide" style="color: <?=$task_status->getField('highlight_color_status')?>;">
                <?//=$task_status->title()?>
            </div>
            <div class="flex-box to-end ">
                <div class="modal-call-btn box-wide pointer" data-modal="edit-all" data-id="<?=$task_obj->postId()?>"  data-table="<?=$task_obj->setTableId()?>" data-modal-size="modal-big"  >
                    <span title="Редактировать"><i class="fas fa-pencil-alt"></i></span>
                </div>
                <div class="modal-call-btn pointer" data-id=""  data-table="" data-modal-size="modal-big" data-names='["post_id_referrer,table_id_referrer"]'  data-values='[<?=$task_obj->getField('id')?>,<?=$task_obj->setTableId()?>]'  >
                    <span title="Создать напоминание"><i class="fas fa-bell"></i></span>
                </div>
            </div>
        </div>
        <!--
        <?if(count($members = $task_obj->getJsonField('members')) > 0){?>
            <div class="ghost underlined">
                Участники:
                <?foreach($members as $member){?>
                    <?=(new Member($member))->titleShort()?>
                <?}?>
            </div>
        <?}?>
        -->
        <div class="isBold">
            <a href="/task/<?=$task_obj->postId()?>">
                <?=$task_obj->title()?>
            </a>
        </div>
    </div>
    <div class="box-small">
        <div class="flex-box flex-vertical-top">
            <div class="ghost">
                <?=date('d.m.Y',$task_obj->getField('publ_time'))?>  <?=date('H:i',$task_obj->getField('publ_time'))?> <?=(new Member($task_obj->getField('author_id')))->titleShort()?>
            </div>
            <div class="box-wide">
                <?=$task_obj->description()?>
            </div>
        </div>
        <?$last_comments = $task_obj->getPostComments()?>
        <?array_splice($last_comments,  5)?>
        <?foreach($last_comments as $comment){?>
            <?$comment_obj = new Comment($comment['id'])?>
            <div class="flex-box flex-vertical-top">
                <div class="ghost">
                    <?=date('d.m.Y',$comment_obj->getField('publ_time'))?>  <?=date('H:i',$comment_obj->getField('publ_time'))?> <?=(new Member($comment_obj->getField('author_id')))->titleShort()?>
                </div>
                <div class="box-wide">
                    <?=$comment_obj->description()?>
                </div>
            </div>
        <?}?>
        <div class="modal-call-btn underlined pointer" style="color: blue;" data-id="<?=$task_obj->postId()?>" data-table="<?=$task_obj->setTableId()?>"  data-modal="post-comments"   data-modal-size="modal-middle">
            <?if(count($task_obj->getPostComments()) > 5){?>
                Добавить/показать комментарии
            <?}else{?>
                Добавить комментарии
            <?}?>
        </div>
    </div>
</div>

<!--
<div >
    <div class="isBold">
        <a href="/task/<?=$task_obj->getField('id')?>">
            <?=($task_obj->getField('mark_as_important')) ? '<i title="Важное" class="attention fas fa-exclamation"></i>' : ''?>
            <?=($task_obj->getField('finished')) ? '<i title="Завершено" class="good fas fa-check"></i>' : ''?>
            <?=$task_obj->getField('title')?>
        </a>
    </div>
    <div>
        Начало :<?=$task_obj->getField('start_time')?>
    </div>
    <div>
        Окончание :<?=$task_obj->getField('end_time')?>
    </div>
    <div>
        Назначена кем :
        <?$author = new Member($task_obj->getField('author_id'))?>
        <?=$author->getField('title')?>
    </div>
    <div class="hidden">
        Назначена кому :
        <?$author = new Member($task_obj->getField('agent_id'))?>
        <?=$author->getField('title')?>
    </div>
</div>
<div class="flex-box ">
    <?if($task_obj->getField('is_read')){?>
        <div class="ghost">
            <i title="Просмотрено" class="fas fa-eye"></i>
        </div>
    <?}?>
    <?if($comments = count($task_obj->getPostComments())){?>
        <div class="ghost box-wide">
            <i title="Комментарии" class="fas fa-comment"></i> <?=$comments?>
        </div>
    <?}?>
</div>
-->