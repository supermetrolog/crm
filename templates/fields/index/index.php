<?php
/**
 * Created by PhpStorm.
 * User: Zhitkov
 * Date: 13.08.2018
 * Time: 18:22
 */


?>

<? if ($table_id == 35  ) {
    if (isset($_POST['offer_id'])) {
        $offer_id = $_POST['offer_id'];
    } else {
        $offer_id = $post->getField('offer_id');
    }
    $offer_of_part = new Offer($offer_id);
    if ($offer_of_part->getField('deal_type') == 3  && $field->getField('id') == 176  )   {
        $is_required_by_fuck = true;
    } else {
        $is_required_by_fuck = false;
    }

} ?>


    <div id="field-<?=$field->getField('id')?>" class="grid-element-unit <?if($field->getField('field_is_disabled')){?> ghost  <?}?> <?= ($field->getField('field_is_hidden')) ? 'hidden' : '';?> <?= ($field->showInline()) ? 'field-display-row' : 'field-display-column';?>" data-element-id="<?=$field->getField('id')?>">
        <div class="grid-element-core">
            <div class="grid-element-content   <?= ($field->showInline()) ? 'flex-stretch' : ''?>">
                <?if(!$field->getField('field_title_none')){?>
                    <div class="flex-box grid-element-title  <?=$field->getField('field_title_highlight') ? 'isBold' : '';?> <?=$field->getField('field_title_underline') ? 'underlined' : '';?> <?= ($field->showInline()) ? 'one_third' : '';?>">
                        <div title="<?=$field->titleToDisplay()?>">
                            <?if(!$field->getField('field_title_hide')){?>
                                <?if($field->showInline()){?>
                                    <?=mb_strimwidth($field->titleToDisplay(),'0','35','..')?>
                                <?}else{?>
                                    <?=$field->titleToDisplay()?>
                                <?}?>
                            <?}else{?>
                                &#160;
                            <?}?>
                        </div>
                        <?if($field->getField('field_required')  || $is_required_by_fuck  ){?>
                            <div title="Обязательное поле" class="to-end box-wide attention">
                                *
                            </div>
                        <?}?>
                    </div>
                <?}?>
                <div class="grid-element-body flex-box full-width text_left">
                    <div class="full-width flex-box">
                        <div class="full-width">
                            <?if($field->getField('is_multifield')){?>
                                <?include ($_SERVER['DOCUMENT_ROOT'].'/templates/fields/templates/multifield/index.php'); ?>
                            <?}else{?>
                                <?if($field->getField('field_template_id')){?>
                                    <?$field_template = new Post($field->getField('field_template_id'))?>
                                    <?$field_template->getTable('core_fields_templates')?>

                                    <?if($field_template->postId()){?>
                                        <?include ($_SERVER['DOCUMENT_ROOT'].'/templates/fields/templates/'.trim($field_template->title()).'/index.php'); ?>
                                    <?}?>
                                <?}?>
                                <?//include ($_SERVER['DOCUMENT_ROOT'].'/templates/fields/templates/'.$field->getField('field_template').'/index.php'); ?>
                            <?}?>
                        </div>
                        <div class="ghost box-wide">
                            <?=$field->getField('dimension')?>
                        </div>
                    </div>
                </div>
                <?$entity = new Post(0)?>
                <?$entity->getTable($table)?>

                <?if($entity->hasField($field->title().'_hide')){?>
                    <div class="flex-box">
                        <div class="toggle-item flex-box flex-vertical-center">
                            <div class="toggle-bg">
                                <input type="radio" name="<?=$field->title()?>_hide" value="0">
                                <input type="radio" name="<?=$field->title()?>_hide" <?=($src[$field->title().'_hide'] == 1 ) ? 'checked' : '';?> value="1">
                                <div class="filler"></div>
                                <div class="switch"></div>
                            </div>
                        </div>
                        <div title="скрыть данные">
                            <i class="fas fa-eye-slash"></i>
                        </div>

                    </div>
                <?}?>
                <?if($field->getTemplateId() != 29){?>
                    <div class="box-wide no-shrink" style="min-width: 110px; box-sizing: border-box;  border-left: 2px solid #e7e5f2; border-bottom: 1px solid #e4eddb; background: #ffffff; ">

                        <?if($field->getField('field_required') || $is_required_by_fuck ){?>
                            <div class="attention">
                                Обязательное
                            </div>
                        <?}?>
                        <?if($weight = $field->getField('field_weight')){?>
                            <div>
                                <?=$weight?>% 
                            </div>
                        <?}?>
                    </div>
                <?}?>
            </div>
        </div>
    </div>

