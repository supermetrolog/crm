<? // include_once($_SERVER['DOCUMENT_ROOT'].'/display_errors.php')
?>
<?
function getCompanyFullnameById($id)
{
    $url = "https://api.pennylane.pro/companies/$id?fields=full_name";
    $company = json_decode(file_get_contents($url));
    if ($company) {
        return $company->full_name;
    }
    return null;
}
function getContactListByCompanyId($id)
{
    $url = "https://api.pennylane.pro/contacts?company_id=$id&fields=id,full_name";
    return json_decode(file_get_contents($url));
}
?>
тестовое
<div class="datalist-company-block">
    <div class="datalist-field" style="position: relative;">
        <? if ($src[$field->title()]) { ?>
            <? $val = new Post($src[$field->title()]) ?>
            <? $val->getTable($field->getField('linked_table')) ?>
            <?
            if ($val->getField('title')) {
                $val_res = $val->getField('title');
            } elseif ($val->getField('title_eng')) {
                $val_res = $val->getField('title');
            } else {
                $val_res = $val->getField('title_old');
            }
            ?>
            <? $val_res = str_replace('"', '', $val_res) ?>
        <? } ?>
        <?
        $val_res = getCompanyFullnameById($src[$field->title()]);
        ?>
        <span></span>
        <input data-table="<?= $field->getField('linked_table') ?>" data-company="1" class="datalist-input-api" data-async="1" type="text" value="<?= $val_res ?>" />
        <input type="hidden" value="<?= $src[$field->title()] ?>" name="<?= $field->title() ?>" />
        <div class="field-list-variants box-small" style="position: absolute; display: none; background: white; z-index: 999; height: 150px; width: 100%;  overflow-y: scroll; border: 1px solid grey">

        </div>
    </div>
    <br>
    <div class="datalist-subfield-contacts">
        <?
        $company_id = $src[$field->title()];
        $name = $field->getField('field_datalist_container');
        $field = new Field();
        $field->getFieldByName($name);
        //$field = new Field(68);
        if ($_POST[$field->title()]) {
            $value_item = $_POST[$field->title()];
        } else {
            $value_item = $src[$field->title()];
        }
        ?>
        <select id="field-<?= $field->title() ?>" class="<?= (trim($value_item)) ? 'field-checked' : '' ?>" <?= ($field->getField('field_required') ? 'required' : '') ?> name='<?= $field->title() ?>' <?= ($field->getField('field_is_disabled')) ? 'disabled' : '' ?>>
            <?

            if (trim($value_item)) {
                $table_post = new Post($value_item);
                $table_post->getTable($field->getField('linked_table'));
                if ($table_post->getField('first_name')) {
                    $title = $table_post->getField('first_name') . ' ' . $table_post->getField('last_name');
                } else {
                    $title = $table_post->title();
                }
                echo "<option value='" . $table_post->postId() . "'>" . $title . "</option>";
            } else {
                echo "<option value=''>Выберите</option>";
            }
            //if(!$field->getField('field_list_empty') && $company_id){
            if ($company_id) {
                //$sql = $pdo->prepare("SELECT * FROM ".$field->getField('linked_table')." WHERE  deleted !=1 ");
                // $sql = $pdo->prepare("SELECT * FROM " . $field->getField('linked_table') . " WHERE company_id=$company_id AND deleted !=1 ");
                // $sql->execute();
                // while ($sql_src = $sql->fetch(PDO::FETCH_LAZY)) {
                //     if ($src[$field->title()] != $sql_src->id && $sql_src->title) {
                //         echo "<option value='" . $sql_src->id . "'>" . $sql_src->title . "</option>";
                //     }
                // }

                $contacts = getContactListByCompanyId((int)$company_id);
                foreach ($contacts as $contact) {
                    if ($contact->full_name === null) {
                        $contact->full_name = "Общий";
                    }
                    $fuck = "";
                    if ($value_item == $contact->id) {
                        $fuck = "selected";
                    }
                    echo "<option " . $fuck . " value='" . $contact->id . "'>" . $contact->full_name . "</option>";
                }
            }

            ?>
        </select>
    </div>

</div>

<style>
    .field-list-variants {}

    .field-list-variants>div:hover {
        background: blue;
        color: white;
    }
</style>