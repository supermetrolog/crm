<li style="<?=($comment_obj->getField('is_important')) ? 'border: 3px solid red;' : ''?>">
    <div class="flex-box box-vertical">
        <?$author = new Member($comment_obj->getAuthor())?>
        <div class="photo-round photo-icon">
            <a href="<?=PROJECT_URL?>/user/<?=$author->member_id()?>/">
                <img style='width: 100px;' src='<?=$author->avatar()?>'/>
            </a>
        </div>
        <div class="flex-box flex-vertical-top full-width">
            <div class="box-wide">
                <div class="isBold">
                    <?=$author->title()?>
                </div>
                <div class="ghost">
                    <?=$comment_obj->publTime()?>
                </div>
            </div>
            <div class="edit-panel ghost to-end hidden">
                <div class="modal-call-btn  pointer" data-id="<?=$comment_obj->postId()?>"  data-table="<?=$comment_obj->setTableId()?>" data-modal="edit-all" data-modal-size="modal-middle"  >
                    <span title="Редактировать"><i class="fas fa-pencil-alt"></i></span>
                </div>
            </div>
        </div>
    </div>
    <div>
        <?=$comment_obj->description()?>
    </div>
</li>
