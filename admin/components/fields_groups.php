<div class='editBtn grid-edit-btn'>
    <i class="fa fa-chevron-right"></i>
</div>
<div class='grid-edit-panel grid-edit-panel-right'>
        <div class="grid-column-add greenBtn box">
            Добавить
        </div>
        <div class='connectedSortable grid-elements-list' >
            <?
            $fields = new Post(0);
            $fields->getTable($_GET['table']);
            $table = new Table(0);
            $table->getTableByName($_GET['table']);

            foreach($fields->getTableColumnsNames() as $column){?>
                <?$field = new Field(0)?>
                <?$field->getFieldByName($column)?>
                <?if(!$table->fieldInGrid($field->postId()) && $field->isActive()){?>
                    <?include ($_SERVER['DOCUMENT_ROOT'].'/admin/templates/field/index/index.php')?>
                <?}?>
            <?}?>
        </div>
        <div id="grid-columns-save" class='greenBtn editBtn box pointer'  >Сохранить</div>
</div>
<script type="text/javascript">
    //////////МЕНЮ РЕДАКТИРОВАНИЯ СТРАНИЦЫ///////////////////////////////////////////////////
    let edit = function() { //главная функция

        let menu_flag = 0
        $('.editBtn').click(function() {

            if(menu_flag === 0){
                $('.grid-edit-panel').animate({  right: '0px' }, 200);
                $('.grid-edit-btn').animate({ right: '210px' }, 200);


                $('.grid-element-unit').addClass('grid-element-editable');
                $('.grid-column').addClass('grid-column-editable');

                $('.sortable, .connectedSortable').sortable('enable');

                $(".sortable, .connectedSortable").sortable({
                    connectWith: ".connectedSortable",
                    cursor: "move",
                    beforeStop: function() {

                    }
                });


                //делаем сортабельными
                $('#grid-canvas').sortable('enable');           //делаем сортабельными

                $("#grid-canvas ").sortable({
                    connectWith: ".canvasSortable",
                    cursor: "move",
                    beforeStop: function() {

                    }
                });
                menu_flag = 1;

            }else {
                $('.grid-edit-panel').animate({ right: '-210px' }, 200);
                $('.editBtn').animate({  right: '0px' }, 200);

                $('.grid-column').removeClass('grid-column-editable');

                $('.sortable, .connectedSortable').sortable('disable');
                $('#grid-canvas').sortable('disable'); //делаем несортабельными

                $('.grid-element-unit').removeClass('grid-element-editable');

                menu_flag = 0;
            }
        });
    };
    $(document).ready(edit); /* как только страница полностью загрузится, будет
               вызвана функция main, отвечающая за работу меню */
    //////////МЕНЮ РЕДАКТИРОВАНИЯ СТРАНИЦЫ///////////////////////////////////////////////////



    document.getElementById('grid-columns-save').addEventListener("click", gridColumnsSave.bind(null, 'tables_map','<?=$table->tableId()?>','grid_columns', 'fields'));

    /**
     * СОХРАНЕНИЕ КОЛОНОК И ПОЛЕЙ
     */
    function gridColumnsSave(table, post_id, field, elements_type, event){

        let col_str = '';
        let cols_arr_full = [];                                     //массив колонок
        let cols = document.getElementsByClassName("grid-column");
        for (let i = 0; i < cols.length; i++) {
            //если колонка не удалена с экрана
            if(cols[i].style.display !== 'none') {
                //получаем ширину колонки
                let column_width = cols[i].style.width;
                if(!column_width){column_width = '100%';}

                //пустой массив элементов
                let els_arr = [];
                // коллекция элементов  внутри колонки
                let elements = cols[i].getElementsByClassName("grid-element-unit");
                //добавляем id элемента в массив в цикле
                for (let j = 0; j < elements.length; j++) {
                    if(elements[j].style.display !== 'none'){
                        els_arr.push(elements[j].getAttribute('data-element-id'));
                    }
                }
                let col_arr = [ column_width , els_arr] ;
                cols_arr_full.push(col_arr);
            }
        }
        col_str = JSON.stringify(cols_arr_full);
        //сохраняем значение для таблицы
        let xhttp = new XMLHttpRequest();
        xhttp.open('GET',"<?=PROJECT_URL?>/admin/components/grid_resort.php?post_id="+post_id+"&table="+table+"&field="+field+"&elements_type="+elements_type+"&elements="+col_str,false);
        xhttp.send();
        if (xhttp.readyState === 4 && xhttp.status === 200){
            alert(xhttp.responseText);
        }
    }



</script>
