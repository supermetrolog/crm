<div>
    <div>
        <?$field = new Field(369)?>
        <?$field_template = new Post($field->getField('field_template_id'))?>
        <?$field_template->getTable('core_fields_templates')?>
        <?include ($_SERVER['DOCUMENT_ROOT'].'/templates/fields/templates/'.trim($field_template->title()).'/index.php'); ?>
    </div>
    <div>
        <div>
            <?$field = new Field(370)?>
            <?$field_template = new Post($field->getField('field_template_id'))?>
            <?$field_template->getTable('core_fields_templates')?>
            <?include ($_SERVER['DOCUMENT_ROOT'].'/templates/fields/templates/'.trim($field_template->title()).'/index.php'); ?>
        </div>
        <div>
            <?$field = new Field(371)?>
            <?$field_template = new Post($field->getField('field_template_id'))?>
            <?$field_template->getTable('core_fields_templates')?>
            <?include ($_SERVER['DOCUMENT_ROOT'].'/templates/fields/templates/'.trim($field_template->title()).'/index.php'); ?>
        </div>

    </div>
</div>