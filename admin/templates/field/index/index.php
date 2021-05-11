<div class="grid-element-unit box-small" data-element-id="<?=$field->showField('id')?>">
    <div class="grid-element-core">
        <div class="grid-element-content flex-box">
            <div  style="width: 300px; text-align: left">
                <?=$field->description()?>
            </div>
            <div>
                <?if($field->getField('field_template_id')){?>
                    <?$field_template = new FieldTemplate($field->getField('field_template_id'))?>
                    <?if($field_template->postId()){?>
                        <?include ($_SERVER['DOCUMENT_ROOT'].'/admin/templates/field/templates/'.trim($field_template->title()).'/index.php'); ?>
                    <?}?>
                <?}?>
            </div>
        </div>
        <div class="grid-element-name" >
            <b><?=$field->description()?></b>
        </div>
        <div class="grid-element-delete" data-element-delete-id="<?=$field->showField('id')?>">
            <i class="fa fa-times" aria-hidden="true"></i>
        </div>
        <div class="grid-element-overlay" >

        </div>
    </div>
</div>
