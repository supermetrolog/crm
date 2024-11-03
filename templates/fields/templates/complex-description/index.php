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

            include($_SERVER['DOCUMENT_ROOT'] . '/templates/fields/templates/' . $field_template->title() . '/index.php');
            ?>
        </div>
        <div class="tab-content">
            <?
            $field = new Field(185);
            $field_template = new Post($field->getField('field_template_id'));
            $field_template->getTable('core_fields_templates');
            $buffer = $src;
            if (strpos($buffer->queryString, 'c_industry_blocks') && $buffer->deal_type) {
                $original_id = $buffer->id;
                $original_type = 1;

                //получить результат файла в переменную
                ob_start();
                include($_SERVER['DOCUMENT_ROOT'] . "/autodesc.php");
                $desc = ob_get_clean();
                $src = [
                    'description_auto' => $desc
                ];
            }
            include($_SERVER['DOCUMENT_ROOT'] . '/templates/fields/templates/' . $field_template->title() . '/index.php');
            $src = $buffer;
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
            <? include($_SERVER['DOCUMENT_ROOT'] . '/templates/fields/templates/' . $field_template->title() . '/index.php'); ?>
        </div>
        <div class="box-wide">
            <?= $field->description() ?>
        </div>
    </div>
</div>