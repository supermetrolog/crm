<div class="tabs-block">
    <div class="tabs flex-box">
        <div class="tab">
            Ручное описание
        </div>
        <div class="tab">
            Системное описание
        </div>
    </div>
    <div class="tabs-content">
        <div class="tab-content">
            <?
            $field = new Field(14);
            $field_template = new Post($field->getField('field_template_id'));
            $field_template->getTable('core_fields_templates');
            include($_SERVER['DOCUMENT_ROOT'].'/templates/fields/templates/'.$field_template->title().'/index.php');
            ?>
        </div>
        <div class="tab-content">
            <?
            $field = new Field(185);
            $field_template = new Post($field->getField('field_template_id'));
            $field_template->getTable('core_fields_templates');
            include($_SERVER['DOCUMENT_ROOT'].'/templates/fields/templates/'.$field_template->title().'/index.php');
            ?>
        </div>
    </div>
    <div class="box-small-vertical flex-box">
        <?
        $field = new Field(408);
        $field_template = new Post($field->getField('field_template_id'));
        $field_template->getTable('core_fields_templates');
        ?>
        <div>
            <?include($_SERVER['DOCUMENT_ROOT'].'/templates/fields/templates/'.$field_template->title().'/index.php');?>
        </div>
        <div class="box-wide">
            <?=$field->description()?>
        </div>
    </div>
</div>