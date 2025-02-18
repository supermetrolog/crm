<div class='editBtn edit-open-btn'>
    <i class="fa fa-chevron-right"></i>
</div>
<div class='edit-menu edit-table-list flex-box'>
    <div class="columns_list" >
        <div class='mob_menu_list'>
            <div id="sortable1" class='sortable2 connectedSortable '>
                <?
                $table = new Post(0);
                $table->getTable($_GET['table']);
                foreach($table->getTableColumns() as $column){?>
                    <div class='section timBox'>
                        <div class='block_content timBox'>
                            <?=$column['Field'] ?>(<?=$column['Type']?>)
                        </div>
                        <div class='column_delete' id='<?=$column['Field'] ?>~<?=$_GET['table']?>'><i class="fa fa-times" aria-hidden="true"></i></div>
                    </div>
                <?  }  ?>
            </div>
        </div>
    </div>
    <div class="fields_list" >
        <div class='mob_menu_list'>
            <div id="sortable2" class='sortable2 '>
                <?
                $fields = new Post(0);
                $fields->getTable('core_fields');
                foreach($fields->getAllUnits() as $field){?>
                    <div class='section timBox' id='block_<?=$field['id']?>~<?=$table->setTable()?>'>
                        <div class='block_content timBox'>
                            <?=$field['title'] ?> (<?=$field['type']?>)
                        </div>
                    </div>
                <?  }  ?>
            </div>
        </div>
    </div>
</div>
<div class='fields_overlay'>
</div>
<script type="text/javascript">
    //////////МЕНЮ РЕДАКТИРОВАНИЯ СТРАНИЦЫ///////////////////////////////////////////////////
    var edit = function() { //главная функция

        $('.editBtn').click(function() {

            if($('.edit-menu').css('right') == '-420px'){
                $('.edit-menu').animate({  right: '0px' }, 200);
                $('.edit-open-btn').animate({ right: '420px' }, 200);
                $('.fields_overlay').show(100);

            }else {

                $('.edit-menu').animate({ right: '-420px' }, 200);
                $('.editBtn').animate({  right: '0px' }, 200);
                $('.fields_overlay').hide(100);
            }
        });
    };
    $(document).ready(edit); /* как только страница полностью загрузится, будет
               вызвана функция main, отвечающая за работу меню */
    //////////МЕНЮ РЕДАКТИРОВАНИЯ СТРАНИЦЫ///////////////////////////////////////////////////


    //////////МЕНЮ РЕДАКТИРОВАНИЯ СТРАНИЦЫ///////////////////////////////////////////////////
    $(document).ready(function(){
        $('#sortable2 .section').hover(function() {
            window.new_block = this;
            window.new_block_id = $(this).attr("id");

        });

        $(".sortable1").sortable({
            containment: "parent"
        });

        $(".sortable1, .sortable2").sortable({
            connectWith: ".connectedSortable",
            cursor: "move",
            beforeStop: function() {
                //alert(window.new_block_id);
                if(window.new_block_id != undefined){
                    $.ajax({
                        url: "<?=PROJECT_URL?>/system/controllers/column/add.php",
                        type: "GET",
                        data: {"column_info": window.new_block_id},
                        cache: false,
                        success: function(response){
                            if(response == 0){  // смотрим ответ от сервера и выполняем соответствующее действие
                                alert("не удалось получить ответ от скрипта");
                            }else{
                                alert(response);
                                //$('.order_table').append(response);
                            }
                        }
                    });
                }
                //подгружаем содержимое блока;
                //alert($(this).html());
                //сюда вставлять AJAX подгрузки блока после вытаскивания
            }

        });

        //удаление столбцов
        $('.column_delete').click(function() {
            $(this).closest('.section').hide(300);
            let column_info = $(this).attr("id");
            alert(column_info);
            $.ajax({
                url: "<?=PROJECT_URL?>/system/controllers/column/delete.php",
                type: "GET",
                data: {"column_info": column_info},
                cache: false,
                success: function(response){
                    if(response == 0){  // смотрим ответ от сервера и выполняем соответствующее действие
                        alert("не удалось получить ответ от скрипта");
                    }else{
                        alert(response);
                        //$('.order_table').append(response);
                    }
                }
            });
        });

    });
    //////////МЕНЮ РЕДАКТИРОВАНИЯ СТРАНИЦЫ///////////////////////////////////////////////////
</script>
