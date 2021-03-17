
    <script src='/libs/front/tinymce/tinymce.min.js'></script>

    <script type="text/javascript">
        $(document).ready(function(){
            //включение скрипта текстового редактора на текст
            $('#text_switch').click(function() {
                $('#mytextarea').addClass('mytextarea');
                tinymce.init({
                    selector: '.mytextarea',
                    theme: 'modern',
                    plugins: [
                        'advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker',
                        'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking',
                        'save table contextmenu directionality emoticons template paste textcolor'
                    ],
                    content_css: 'css/content.css',
                    document_base_url : '../index.php',
                    convert_urls : false,
                    toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons'
                });
            });





////////////////сохраняем порядок фото
            $('.photo_resort').click(function() {
                let files = '';
                let id = "<?=$_GET['id']?>";
                let table = "<?=$_GET['table']?>";
                let field = $(this).attr('data-field');
                $(this).closest('.form-files').find(".form-file img").each(function(indx, element){
                    //скрытые фотки не учитываем
                    if($(element).css("display") === 'inline'){
                        files = files+$(element).attr("src")+",";
                        //если собираемся и тамбы делать files = files+$(element).attr("src").replace('/uploads/', "")+",";
                    }
                });
                //alert(id);
                //alert(table);
                //alert(field);
                //alert(files);
                $.ajax({
                    url: "<?=PROJECT_URL?>/system/controllers/files/resort.php",
                    type: "GET",
                    data: {"table": table, "id": id, "field": field, "files": files },
                    cache: false,
                    success: function(response){
                        if(response == 0){  // смотрим ответ от сервера и выполняем соответствующее действие
                            alert("не удалось получить ответ от скрипта");
                        }else{
                            //alert(response);
                            alert('Сохранено');
                        }
                    }
                });
            });

///////показываем крестик и делаем сортируемыми
            $(".form-file").dblclick(function(){
                $(this).find('.file-delete').css('display','flex');
                //////делаем фотки сортируемыми
                $(".draggable").sortable().disableSelection();
            });

///////удаляем фотку
            $(".form-file div").click(function(){
                let file = $(this).closest('.form-file').find('img').attr("src");
                let id="<?=$_GET['id']?>";
                let table="<?=$_GET['table']?>";
                let field = $(this).attr('data-field');
                //alert(id);
                //alert(table);
                //alert(field);
                //alert(file);
                $(this).closest('.form-file').hide(); //скрываем  весь блок
                $(this).closest('.form-file').find('img').hide(); //скрываем фотку для счета
                $.ajax({
                    url: "<?=PROJECT_URL?>/system/controllers/files/delete.php",
                    type: "GET",
                    data: {"table": table, "id": id, "field": field, "file": file },
                    cache: false,
                    success: function(response){
                        if(response == 0){  // смотрим ответ от сервера и выполняем соответствующее действие
                            alert("не удалось получить ответ от скрипта");
                        }else{
                            alert(response);
                        }
                    }
                });
            });

        });
    </script>

    <div class="anketa">
        <form enctype="multipart/form-data" method="POST" action='<?=PROJECT_URL?>/system/controllers/posts/create.php?num=<?=$_GET['num']?>'>
            <?
            $table = $_GET['table'];
            $post_id = (int)$_GET['id'];       

            $table_obj = new Table(0);
            $table_obj->getTableByName($table);
            $table = $table_obj->tableName();

            $table_id = $table_obj->getField('id');

            ?>
            <input type="hidden" name="id" value="<?=$post_id?>">
            <input type="hidden" name="table_id" value="<?=$table_id?>">
            <?

            ($post_id) ? $action_call = 'Изменить' : $action_call = 'Создать';

            if($post_id){
                $post = new Post($post_id);
                $post->getTable($table);

                $src = $post->show();
                $photo = $post->photos();
            }

            $table_obj = new Table(0);
            $table_obj->getTableByName($table);

            ?>


            <div id="grid-canvas"   class="tabs-block">
                <?$tabs = []?>
                <?$contents = []?>
                <?foreach ($table_obj->getJsonField('grid_elements_test') as $key=>$value){?>
                    <?$tabs[] = $key?>
                    <?$contents[] = $value?>
                <?}?>
                <div class="tabs flex-box">
                    <?foreach ($tabs as $tab){?>
                        <div class="tab box-wide">
                            <input title="" type="text" value="<?=$tab?>">
                        </div>
                    <?}?>
                </div>
                <div class="tabs-content">
                    <?foreach ($contents as $content){?>
                        <div class="tab-content <?=(!$first) ? 'tab-content-active' : ''?> <?$first = 1?> grid-book ">
                            <div class="grid-book-sortable-zone">
                                <?foreach ($content as $page){?>
                                    <div class="grid-page">
                                        <input class="grid-page-name" value="<?=$page[0]?>" type="text" placeholder="Название страницы" >
                                        <div class="grid-element-delete">
                                            <i class="fa fa-times" aria-hidden="true"></i>
                                        </div>
                                        <div class="grid-page-sortable-zone">
                                            <?foreach ($page[1] as $column){?>
                                                <div class="grid-column box-small " style="width: <?=$column[0]?>">
                                                    <input class="grid-column-change" value="<?=(int)$column[0]?>" type="number" placeholder="Ширина блока" >
                                                    <div class="grid-element-delete">
                                                        <i class="fa fa-times" aria-hidden="true"></i>
                                                    </div>
                                                    <div class="grid-column-sortable-zone">
                                                        <?foreach($column[1] as $field_unit) {?>
                                                            <?$field = new Field($field_unit)?>
                                                            <?include ($_SERVER['DOCUMENT_ROOT'].'/admin/templates/field/index/index.php')?>
                                                        <?}?>
                                                    </div>
                                                </div>
                                            <?}?>
                                        </div>
                                    </div>
                                <?}?>
                            </div>
                        </div>
                    <?}?>
                </div>
            </div>



            <div class='anketa_stats'>


                <? if($table == 'filters'){?>
                    <div class="field-unit box">
                        <div>
                            Поле сортировки
                        </div>
                        <div>
                            <select name='parametr'>
                                <?if($src['parametr']){
                                    echo "<option value='".$src['parametr']."'>".$src['parametr']."</option>";
                                }
                                $columns_sql = $pdo->prepare("SHOW COLUMNS FROM items");
                                $columns_sql->execute();
                                while($column = $columns_sql->fetch()){
                                    $name_sql = $pdo->prepare("SELECT * FROM core_fields WHERE title='".$column['Field']."' ");
                                    $name_sql->execute();
                                    $field_name = $name_sql->fetch()?>
                                    <option value='<?=$column['Field']?>'><?=$field_name['description']?></option>
                                <?}?>
                            </select>
                        </div>
                    </div>
                <?}?>



                <? if($table == 'uploads'){?>
                    <div>
                        Тип данных
                    </div>
                    <select required  name='upload_type'>
                        <option value='<?=$src['upload_type']?>'><?=$src['upload_type']?></option>
                        <option value='xml'>xml</option>
                        <option value='excel'>excel</option>
                    </select><br>
                <? } ?>


                <? if($table_id == 6){ ?>
                    <div class="field-unit box">
                        <div>
                            Тип поля
                        </div>
                        <div>
                            <select name='field_type' required>
                                <option value='<?=$src['field_type']?>'><?=$src['field_type']?> (Выбрано)</option>
                                <option value='int(11)'>Числовое</option>
                                <option value='tinyint(1)'>Маленькое числовое</option>
                                <option value='text'>Текстовое</option>
                                <option value='bool'>Да/Нет</option>
                                <option value='timestamp'>Временная метка</option>
                            </select>
                        </div>
                    </div>

                    <!--
                    <div class="field-unit box">
                        <div>
                            Шаблон поля
                        </div>
                        <div>
                            <select name='field_template'>
                                <option value='<?=$src['field_template']?>'><?=$src['field_template']?> (Выбрано)</option>
                                <option value='manual'>manual</option>
                                <option value='textarea'>textarea</option>
                                <option value='hidden'>hidden</option>
                                <option value='select'>select</option>
                                <option value='table-select'>table-select</option>
                                <option value='multiselect'>multiselect</option>
                                <option value='datalist'>datalist</option>
                                <option value='radio'>radio</option>
                                <option value='range'>range</option>
                                <option value='size-2d'>size-2d</option>
                                <option value='catalog'>catalog</option>
                                <option value='catalog-select'>catalog-select</option>
                                <option value='tumbler'>tumbler</option>
                                <option value='tumbler-checkbox'>tumbler-checkbox</option>
                                <option value='tumbler-radio'>tumbler-radio</option>
                                <option value='tumbler-value'>tumbler-value</option>
                                <option value='tumbler-select'>tumbler-select</option>
                                <option value='tiles-checkbox'>tiles-checkbox</option>
                                <option value='tiles-radio'>tiles-radio</option>
                                <option value='select-radio'>select-radio</option>
                                <option value='select-checkbox'>select-checkbox</option>
                                <option value='rating'>rating</option>
                                <option value='multifield'>multifield</option>
                                <option value='photos'>photos</option>
                                <option value='documents-select'>documents-select</option>
                                <option value='photo'>photo</option>
                                <option value='files'>files</option>
                                <option value='file'>file</option>
                            </select>
                        </div>
                    </div>
                    -->
                    <div class="field-unit box">
                        <div>
                            Тип поля
                        </div>
                        <div>
                            <select name='field_input_type'>
                                <option value='<?=$src['input_type']?>'><?=$src['field_input_type']?> (Выбрано)</option>
                                <option value='text'>text</option>
                                <option value='address'>address</option>
                                <option value='number'>number</option>
                                <option value='email'>email</option>
                                <option value='url'>url</option>
                                <option value='datetime-local'>datetime-local</option>
                                <option value='date'>date</option>
                                <option value='tel'>tel</option>
                                <option value='color'>color</option>
                                <option value='file'>file</option>
                            </select>
                        </div>
                    </div>

                    <!--
                    <div class="field-unit box">
                        <div>
                            Имя таблицы
                        </div>
                        <div>
                            <select name='linked_table'>
                                <?$db = DB_NAME ?>
                                <option value='<?=$src['linked_table']?>'><?=$src['linked_table']?> (Выбрано)</option>
                                <?php
                                $WHITE_LIST = array();
                                $tables_sql= $pdo->prepare("SHOW TABLES FROM $db");
                                $tables_sql->execute();
                                $i = 0;
                                while($table = $tables_sql->fetch()){?>
                                    <option value='<?=$table["Tables_in_$db"]?>'><?=$table["Tables_in_$db"]?></option>
                                    <?   $i++;
                                } ?>
                            </select>
                        </div>
                    </div>
                    -->
                <? } ?>
            </div><br>


            <input type="submit" id="go" class="" name="submit" value='<? echo $action_call ?>'>
        </form>




    </div>
    <script type="text/javascript">
        function handleFileSelectMultiple() {

            let obj = event.target;

            let files = obj.files; // FileList object

            // Loop through the FileList and render image files as thumbnails.
            for (let i = 0, f; f = files[i]; i++) {

                // Only process image files.
                if (!f.type.match('image.*')) {
                    continue;
                }

                let reader = new FileReader();

                // Closure to capture the file information.
                reader.onload = (function(theFile) {
                    return function(e) {
                        // Render thumbnail.
                        window.span = '<div class="form-file"><img  src="'+e.target.result+'" title="'+theFile.name+'"/></div>';
                        //alert(span);


                        $(obj).closest('.files-list').append(span);
                        $(obj).closest('.files-list').append('<input type="file" class="file-input-multiple"  name="'+obj.name+'" value=""  accept="image/*,image/jpeg">');

                    };
                })(f);

                // Read in the image file as a data URL.
                reader.readAsDataURL(f);
            }
            obj.style.display = 'none';
        }
        //$('.files-list').on('change','.file-input',handleFileSelect );
        document.oninput = function() {
            if (event.target.className === 'file-input-multiple') {
                handleFileSelectMultiple();
            }
        };
        //document.querySelector('.file-input').addEventListener('change', handleFileSelect, false);
    </script>

    <script type="text/javascript">
        function handleFileSelect() {

            let obj = event.target;

            let files = obj.files; // FileList object

            // Loop through the FileList and render image files as thumbnails.
            for (let i = 0, f; f = files[i]; i++) {


                // Only process image files.
                if (!f.type.match('image.*')) {
                    continue;
                }

                let reader = new FileReader();

                // Closure to capture the file information.
                reader.onload = (function(theFile) {
                    return function(e) {
                        // Render thumbnail.
                        window.span = '<div class="form-file"><img  src="'+e.target.result+'" title="'+theFile.name+'"/></div>';
                        //alert(span);

                        $(obj).closest('.files-single').find('.form-file').hide();
                        $(obj).closest('.files-single').prepend(span);

                    };
                })(f);

                // Read in the image file as a data URL.
                reader.readAsDataURL(f);
            }
        }
        $('.files-single').on('change','.file-input',handleFileSelect );

        //document.querySelector('.file-input').addEventListener('change', handleFileSelect, false);
    </script>


<?php require_once(PROJECT_ROOT.'/admin/components/constructor/index.php');?>
