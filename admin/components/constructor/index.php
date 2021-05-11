<div class='editBtn grid-edit-btn'>
    <i class="fa fa-chevron-right"></i>
</div>
<div class='grid-edit-panel grid-edit-panel-right'>
    <div class="grid-column-add greenBtn box">
        Добавить колонку
    </div>
    <div class="grid-page-add greenBtn box">
        Добавить страницу
    </div>
    <div class="grid-book-add greenBtn box">
        Добавить книгу
    </div>
    <div class='grid-column-sortable-zone grid-elements-list' >
        <?
        $fields = new Post(0);
        $fields->getTable($_GET['table']);
        $table = new Table(0);
        $table->getTableByName($_GET['table']);

        foreach($fields->getTableColumnsNames() as $column){?>
            <?$field = new Field(0)?>
            <?$field->getFieldByName($column)?>
            <?foreach ($field->getFieldsByName($column) as $id){ ?>
                <?$field = new Field($id)?>
                <?if($field->postId()){?>
                    <?//if(!$table->fieldInGrid($field->postId()) && $field->isActive()){?>
                    <?include ($_SERVER['DOCUMENT_ROOT'].'/admin/templates/field/index/index.php')?>
                    <?//}?>
                <?}?>
            <?}?>
        <?}?>
    </div>
    <? $table = new Table(0);?>
    <? $table->getTableByName($_GET['table'])?>
    <div class='grid-elements-save greenBtn editBtn box pointer' data-grid-container="grid-canvas" data-grid-type="core_fields" data-grid-table="core_tables" data-grid-id="<?=$table->tableId()?>" data-grid-field="grid_elements_test"  >Сохранить</div>
</div>

<script type="text/javascript">
    //////////МЕНЮ РЕДАКТИРОВАНИЯ СТРАНИЦЫ///////////////////////////////////////////////////
    $(document).ready(function() { //главная функция

        let menu_flag = 0;
        let sorts = ['.grid-book-sortable-zone','.grid-page-sortable-zone','.grid-column-sortable-zone'];

        $('.editBtn').click(function() {
            if(menu_flag === 0){
                $('.grid-edit-panel').animate({  right: '0px' }, 200);
                $('.grid-edit-btn').animate({ right: '210px' }, 200);

                $('.grid-page,.grid-column,.grid-element-unit').addClass('grid-element-editable');
                //делаем сортбельными
                makeThemSortable(sorts);
                menu_flag = 1;

            }else {
                $('.grid-edit-panel').animate({ right: '-210px' }, 200);
                $('.editBtn').animate({  right: '0px' }, 200);

                $('.grid-page,.grid-column,.grid-element-unit').removeClass('grid-element-editable');
                //делаем НЕ сортбельными
                makeThemNotSortable(sorts);
                menu_flag = 0;
            }
        });
    });

    //////////МЕНЮ РЕДАКТИРОВАНИЯ СТРАНИЦЫ///////////////////////////////////////////////////

    document.querySelector("body").onclick = function() {
        gridElementDelete();

        gridColumnCreate();
        gridPageCreate();
        gridBookCreate();
        gridElementsSave();
    };


</script>
<script src="<?=PROJECT_URL?>/admin/js/constructor.js"></script>
<script src="<?=PROJECT_URL?>/js/script.js"></script>



