<?php
/**
 * Created by PhpStorm.
 * User: Zhitkov
 * Date: 05.06.2018
 * Time: 10:43
 */
?>

    <div class="record-add">
        <div id="record_add" class="record-add-button btn-arrow btn-blue">
            Добавить запись
        </div>
        <script>
            $(document).ready( function() {
                var input_num = 1;

                $("#record_add").click(function(){
                    $(this).hide();
                    $(".record-form").show();
                });

                $('body').on('input', '.file_input:last', function () {
					alert('последний');
                    input_num++;
                    $.ajax({
                        url: "<?=PROJECT_URL?>/pages/file-input.php",
                        type: "GET",
                        data: {"input_num": input_num},
                        cache: false,
                        success: function(response){
                            if(response == 0){  // смотрим ответ от сервера и выполняем соответствующее действие
                                alert("не удалось получить ответ от скрипта");
                            }else{
                                //alert(response);
                                $('.file_lines').append(response);
                            }
                        }
                    });
                });

                $('body').on('click', '.delete_field', function () {

                    $(this).closest('.file_input').find('.record_file').val('');
                    $(this).closest('.file_input').remove();
                });

                $('body').on('click', '.delete_field_first', function () {
                    $(this).closest('.file_input').find('.record_file').val('');
                    $(this).closest('.file_input').find('#file_name_1').val('');
                });


            });

        </script>
        <div class="record-form">
            <p>Запись</p>
            <form enctype="multipart/form-data" action="<?=PROJECT_URL?>/modules/records/create.php" method="POST">
                <div>
                    <textarea name="description" class="box"></textarea>
                </div>
                <div class="flex-box flex-vertical-center">
                    <div>Заголовок</div>
                    <input class="record-field" name="title"  type="text"/>
                </div>
                <div class="flex-box flex-vertical-center">
                    <div>
                        Файл
                    </div>
                    <script>
                        $(document).ready( function() {
                            var file_line_num = 1;
                            $("body").on('change','.record_file',function(){
                                var filename = $(this).val().replace(/.*\\/, "");
                                $(this).closest('.file_input').find('.file_name').val(filename);
                            });
                        });
                    </script>
                    <div class="file_lines full-width right">
                        <div class="file_input flex-box">
                            <input id="record_file_1" class="record_file" type="file" name="files[]"/>
                            <input id="file_name_1" class="file_name" type="text" placeholder="Файл не выбран"  disabled/>
                            <label class="btn-blue record_file_label" for="record_file_1"><span><i class="far fa-save"></i></span></label>
                            <div class="delete_field_first box">
                                <i class="fas fa-times"></i>
                            </div>
                        </div>
                        <br>
                    </div>
                </div>
                <div>
                    <div>Товар / услуга</div>
                    <input class="record-field" list="type" name="item_id"    type="text"/>
                    <datalist id="type">
                        <? $items = new Item(0);
                        foreach($items->getAllUnits() as $item){
                            ?>
                            <option label="<?=$item['title']?>" value="<?=$item['id']?>" />
                        <?}?>
                    </datalist>
                </div>
                <div>
                    <div>
                        Кто видит
                    </div>
                    <select name="record_can_see">
                        <?php
                        $canSeeGroup = new Post(0);
                        $canSeeGroup->getTable('record_visibility');
                        foreach ($canSeeGroup->getAllUnits() as $canSeeGroup){?>
                            <option value="<?=$canSeeGroup['id']?>"><?=$canSeeGroup['title']?></option>
                        <?}?>
                    </select>
                </div>
                <div>
                    <div>
                    </div>
                    <button class="btn-arrow btn-blue">Отправить</button>
                </div>
            </form>
        </div>
    </div>
