<div class="flex-box">
    <div class="multifield-container">
        <?if(trim($placeholder = $field->getField('field_placeholder'))){?>
            <?$placeholder = 'title="'.$placeholder.'"';?>
        <?}else{?>
            <?$placeholder ='';?>
        <?}?>

        <?if(trim($pattern = $field->getField('field_pattern'))){?>
            <?$pattern = 'pattern="'.$placeholder.'"';?>
        <?}else{?>
            <?$pattern ='';?>
        <?}?>



        <?$field_template = new Post($field->getField('field_template_id'))?>
        <?$field_template->getTable('core_fields_templates')?>


        <?//если это каталог например краны лифты подъемнки?>
        <?if((in_array($field_template->title(),['catalog','catalog-select','phone'])) && arrayIsNotEmpty(json_decode($src[$field->title()]))){?>
            <?$arr_value =[]?>

            <?for($i = 0; $i < count(json_decode($src[$field->title()])); $i = $i+2){?>
                <?if(1){?>
                    <?$arr_value[] = json_decode($src[$field->title()])[$i]?>
                    <?$arr_value[] = json_decode($src[$field->title()])[$i+1]?>
                    <div class="multifield flex-box">
                        <?  include ($_SERVER['DOCUMENT_ROOT'].'/templates/fields/templates/'.$field_template->title().'/index.php'); ?>
                        <div class="field-delete box-wide"><i class="far fa-times"></i></div>
                    </div>
                <?}?>
                <?$arr_value =[]?>
            <?}?>
            <?//если это ?>
        <?}elseif((in_array($field_template->title(),['catalog-select-range'])) && arrayIsNotEmpty(json_decode($src[$field->title()]))){?>
            <?$arr_value =[]?>

            <?for($i = 0; $i < count(json_decode($src[$field->title()])); $i = $i+3){?>
                <?if(1){?>
                    <?$arr_value[] = json_decode($src[$field->title()])[$i]?>
                    <?$arr_value[] = json_decode($src[$field->title()])[$i+1]?>
                    <?$arr_value[] = json_decode($src[$field->title()])[$i+2]?>
                    <div class="multifield flex-box">
                        <?  include ($_SERVER['DOCUMENT_ROOT'].'/templates/fields/templates/'.$field_template->title().'/index.php'); ?>
                        <div class="field-delete box-wide"><i class="far fa-times"></i></div>
                    </div>
                <?}?>
                <?$arr_value =[]?>
            <?}?>





        <?//если это все остальное заполненное?>
        <?}elseif( ($fields = json_decode($src[$field->title()]))[0] != null){?>
            <?foreach ($fields as $value_item){?>
                <?if($value_item != null){?>
                    <div class="multifield flex-box">
                        <?  include ($_SERVER['DOCUMENT_ROOT'].'/templates/fields/templates/'.$field_template->title().'/index.php'); ?>
                        <div class="field-delete box-wide"><i class="far fa-times"></i></div>
                    </div>
                <?}?>
            <?}?>
        <?}else{?>
            <div class="multifield flex-box">
                <?  include ($_SERVER['DOCUMENT_ROOT'].'/templates/fields/templates/'.$field_template->title().'/index.php'); ?>
                <div class="field-delete box-wide"><i class="far fa-times"></i></div>
            </div>
        <?}?>
    </div>
    <?if(!$field->getField('field_is_disabled')){?>
        <div title="Добавить поле" class="icon-round to-end more-fields pointer">+</div>
    <?}?>

</div>