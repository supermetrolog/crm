<div id="grid-tasks" class="tabs-block" style="background: #61BD4F;">
    <?if($logedUser->getJsonField('tasks')){?>
        <?$tabs = []?>
        <?$contents = []?>
        <?foreach ($logedUser->getJsonField('tasks') as $key=>$value){?>
            <?$tabs[] = $key?>
            <?$contents[] = $value?>
        <?}?>
        <div class="flex-box">
            <div class="tabs flex-box box-small">
                <?foreach ($tabs as $tab){?>
                    <div class="tab box-wide">
                        <input  type="text" value="<?=$tab?>"/>
                    </div>
                <?}?>
            </div>
            <div class="grid-elements-save"  data-grid-container="grid-tasks" data-grid-type="core_tasks" data-grid-table="core_users" data-grid-id="<?=$logedUser->member_id()?>" data-grid-field="tasks">
                Сохранить
            </div>
            <div class="flex-box" >
                <div class=" box to-end tasks-pool-show">
                    задачи
                </div>
                <div class="tasks-pool">
                    <div class="tasks-pool-container tasksSortable box-small">
                        <?$tasks = new Task(0); ?>
                        <?foreach($tasks->getAllActiveUnits() as $task_unit){?>
                            <?$id=$task_unit['id'] ?>
                            <div class="task-real">
                                <?include ($_SERVER['DOCUMENT_ROOT'].'/templates/tasks/board-task/index.php')?>
                            </div>
                        <?}?>
                    </div>
                </div>
            </div>
        </div>
        <div class="tabs-content">
            <?foreach ($contents as $content){?>
                <div class="tab-content task-board ">
                    <?foreach ($content as $page){?>
                        <div class="grid-page  flex-box flex-vertical-top">
                            <input class="grid-page-name" style="display: none;" value="<?=$page[0]?>" type="text" placeholder="Название страницы" >
                            <div class="grid-columns columnsSortable flex-box flex-vertical-top">
                                <?foreach ($page[1] as $column){?>
                                    <div class="box-small ">
                                        <div class="grid-column task-column" >
                                            <div class="task-column-header box-small">
                                                <div class="flex-box flex-between ">
                                                    <div class="task-column-title">
                                                        <input  class="full-width isBold box-small-wide" value="<?=$column[0]?>" type="text" placeholder="Название колонки" >
                                                    </div>
                                                    <div class="task-column-actions pointer ">
                                                        <div class="ghost">
                                                            <i class="fas fa-ellipsis-h"></i>
                                                        </div>
                                                        <div class="box-small" style="width: 300px; border: 1px dashed grey; position: absolute; background: #ffffff; display: none;">
                                                            <ul>
                                                                <li>Добавить задачву</li>
                                                                <li>Удалить колонку</li>
                                                                <li>Чтонить еще</li>
                                                                <li>Что нить потом</li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="task-column-body box-small-wide tasksSortable ">
                                                <?foreach($column[1] as $task_unit) {?>
                                                    <?if($task_unit){?>
                                                        <?$id = $task_unit?>
                                                        <?include ($_SERVER['DOCUMENT_ROOT'].'/templates/tasks/board-task/index.php')?>
                                                    <?}?>
                                                <?}?>
                                            </div>
                                            <div class="task-add box-small ghost pointer">
                                                Добавить карточку...
                                            </div>
                                        </div>
                                    </div>
                                <?}?>
                            </div>
                            <div class="box-small">
                                <div class="task-column-add">
                                    + Добавить колонку
                                </div>
                            </div>
                        </div>
                    <?}?>
                </div>
            <?}?>

        </div>

    <?}else{?>
        <div class="flex-box">
            <div class="tabs flex-box box-small">
                <div class="tab box-wide">
                    <input type="text" value="" placeholder="Название доски"/>
                </div>
            </div>
            <div class="grid-elements-save"  data-grid-container="grid-tasks" data-grid-type="core_tasks" data-grid-table="core_users" data-grid-id="<?=$logedUser->member_id()?>" data-grid-field="tasks">
                Сохранить
            </div>
            <div class="flex-box" >
                <div class=" box to-end tasks-pool-show">
                    задачи
                </div>
                <div class="tasks-pool">
                    <div class="tasks-pool-container tasksSortable box-small">
                        <?$tasks = new Task(0); ?>
                        <?foreach($tasks->getAllActiveUnits() as $task_unit){?>
                            <?$id = $task_unit['id']?>
                            <div class="task-real">
                                <?include ($_SERVER['DOCUMENT_ROOT'].'/templates/tasks/board-task/index.php')?>
                            </div>
                        <?}?>
                    </div>
                </div>
            </div>
        </div>
        <div class="tabs-content">
                <div class="tab-content task-board ">
                        <div class="grid-page  flex-box flex-vertical-top">
                            <input class="grid-page-name" style="display: none;" value="" type="text" placeholder="Название страницы" >
                            <div class="grid-columns columnsSortable flex-box flex-vertical-top">
                                    <div class="box-small">
                                        <div class="grid-column task-column" >
                                            <div class="task-column-header box-small">
                                                <div class="flex-box flex-between ">
                                                    <div class="task-column-title">
                                                        <input class="full-width isBold box-small-wide" value="" type="text" placeholder="Название колонки" >
                                                    </div>
                                                    <div class="task-column-actions pointer ">
                                                        <div class="ghost">
                                                            <i class="fas fa-ellipsis-h"></i>
                                                        </div>
                                                        <div class="box-small" style="width: 300px; border: 1px dashed grey; position: absolute; background: #ffffff; display: none;">
                                                            <ul>
                                                                <li>Добавить задачву</li>
                                                                <li>Удалить колонку</li>
                                                                <li>Чтонить еще</li>
                                                                <li>Что нить потом</li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="task-column-body box-small-wide tasksSortable ">

                                            </div>
                                            <div class="task-add box-small ghost pointer">
                                                Добавить карточку...
                                            </div>
                                        </div>
                                    </div>
                            </div>
                            <div class="box-small">
                                <div class="task-column-add">
                                    + Добавить колонку
                                </div>
                            </div>
                        </div>
                </div>
        </div>

    <?}?>

</div>
<script>

    let sort = ['.tasksSortable','.columnsSortable'];
    makeThemSortable(sort);



    $('body').on('click','.task-column-actions1',function(){
        $(this).closest('.task-column').find('.task-column-body').prepend(
            '<div class="grid-element-unit task-column-element box-small">'
                +'<div>'
                    +'<textarea class="full-width box-small"></textarea>'
                +'</div>'
            +'</div>'
        );
    });

    //добавляем заготвку задачи
    $('body').on('click','.task-add',function(){
        $(this).closest('.task-column').find('.task-column-body').append(
            `<div class="task-new-container">
                <div class="grid-element-unit task-column-element ">
                    <form onkeydown="if(event.keyCode===13){return false;}" method="POST" action="<?=PROJECT_URL?>/system/controllers/posts/create.php" >
                        <div>
                            <input type="hidden" name="id" value="">
                            <input type="hidden" name="table_id" value="<?=(new Task())->setTableId()?>">
                            <textarea  name="title" class="full-width box-small"></textarea>
                        </div>
                        <div class="flex-box box-small">

                            <div class="btn-ajax-task" style="background: limegreen; padding: 5px 10px; color: #FFFFFF">
                                сохранить
                            </div>
                            <div class="to-end task-delete">
                                х
                            </div>
                        </div>
                    </form>
                </div>
            </div>`
        );
    });


    /*
    //callbacks test
    function some_function2(url, callback) {
        let httpRequest; // создаём наш XMLHttpRequest-объект
        if (window.XMLHttpRequest) {
            httpRequest = new XMLHttpRequest();
        } else if (window.ActiveXObject) {
            // для дурацкого Internet Explorer'а
            httpRequest = new
            ActiveXObject("Microsoft.XMLHTTP");
        }
        httpRequest.open('GET', url, true);
        httpRequest.onreadystatechange = function () {
            // встраиваем функцию проверки статуса нашего запроса
            // это вызывается при каждом изменении статуса
            if (httpRequest.readyState === 4 && httpRequest.status === 200) {
                callback.call(httpRequest.responseText); // вызываем колбек
            }
        };
        httpRequest.send();
    }
    // вызываем функцию
    some_function2("https://pennylane.pro/inter.php", function () {
        console.log(this+'это коллбэк');
    });
    console.log("это выполнится до вышеуказанного колбека");
    */


    async function sendAjaxRequest(type,url,params,async){
        let xhr = new XMLHttpRequest();
        if (window.XMLHttpRequest) {
            xhr = new XMLHttpRequest();
        } else if (window.ActiveXObject) {
            // для дурацкого Internet Explorer'а
            xhr = new
            ActiveXObject("Microsoft.XMLHTTP");
        }
        xhr.open(type, url, async);

        if(type == 'POST'){
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        }

        xhr.onreadystatechange = function() {
            if(xhr.readyState === 4 && xhr.status === 200){
                //alert(xhr.responseText + 'ответ от файла');
                return xhr.responseText;
            }
        };



        if(type == 'POST') {
            xhr.send(params.join('&'));
        }else{
            url += '?' + params.join('&');
            xhr.send(null);
        }


        return xhr.responseText;
        //!!!!!!!!если async TRUE то не возвращает значение (не успевает)

        //return xhr.responseText;


    }


    /*

        //async/await test
    async function f() {
        setTimeout(function () {
            let hui =  $.get("https://pennylane.pro/inter.php");
            //let hui = sendAjaxRequest('GET','https://pennylane.pro/inter.php', ['title=4','pole=7'], true);
            return hui;
        },1000);

    }
    //async await необязательно
    async function test() {
        let x = await f();
        console.log(x);
        console.log('2333')
    }
    test();



    async function doAjax() {
        let result;

        try {
            result = await sendAjaxRequest('GET','https://pennylane.pro/inter.php', ['title=4','pole=7'], true);
            return result;
            //console.log(result);
        } catch (error) {
            console.error(error);
        }
    }

    async function  dildo() {
        const stuff = await doAjax();
        console.log(stuff);
    }






    async function createTask(){
        let response1 =  await sendAjaxRequest('POST',getFormUrl(),getFormElements(), true);
        console.log(response1);
        alert('это ответ от скрипта после отработки функции запроса '+response1);
        //alert('создали задачу');
        let response = JSON.parse(response1);
        let post_id = response['post_id'];
        let table_id = response['table'];
        //Получаем html из шаблона
        let url = '<?=PROJECT_URL?>/templates/tasks/board-task/index.php';
        //место куда вставляем response
        this.closest('.task-new-container').innerHTML = getPostHtml(url, post_id, table_id) ;

        $('#grid-tasks').find('.grid-elements-save').click();
    }

    */


    //Добавление Задачи
    $('body').on('click','.btn-ajax-task',function(){


        //createTask();

        //let response = JSON.parse(sendAjaxRequestPost(getFormUrl(this),getFormElements(this), false));
        let response1 =  sendAjaxRequest('POST',getFormUrl(),getFormElements(), false);
        //alert('это ответ от скрипта после отработки функции запроса '+response1);
        //alert('создали задачу');
        alert(response1);
        let response = JSON.parse(response1);
        let post_id = response['post_id'];
        let table_id = response['table'];

        //Получаем html из шаблона
        let url = '<?=PROJECT_URL?>/templates/tasks/board-task/index.php';
        //место куда вставляем response

        this.closest('.task-new-container').innerHTML = getPostHtml(url, post_id, table_id) ;
        alert(getPostHtml(url, post_id, table_id) );


        $('#grid-tasks').find('.grid-elements-save').click();



    });


    $('body').on('click','.task-column-add',function(){
        //alert('Добавили');
        $(this).closest('.grid-page ').find('.grid-columns').append(
            '<div class="box-small">'
                +'<div class="grid-column task-column " >'
                    +'<div class="task-column-header box-small">'
                        +'<div class="flex-box flex-between ">'
                            +'<div class="task-column-title">'
                                +'<input  class="full-width isBold box-small-wide" value="" type="text" placeholder="Название колонки" >'
                            +'</div>'
                            +'<div class="task-column-actions pointer ">'
                                +'<div class="ghost">'
                                    +'<i class="fas fa-ellipsis-h"></i>'
                                +'</div>'
                                +'<div class="box-small" style="width: 300px; border: 1px dashed grey; position: absolute; background: #ffffff; display: none;">'
                                    +'<ul>'
                                        +'<li>Добавить задачву</li>'
                                        +'<li>Удалить колонку</li>'
                                    +'</ul>'
                                +'</div>'
                            +'</div>'
                        +'</div>'
                    +'</div>'
                    +'<div class="task-column-body box-small-wide tasksSortable ">'

                    +'</div>'
                    +'<div class="task-add box-small ghost pointer">'
                        +'Добавить карточку...'
                    +'</div>'
                +'</div>'
            +'</div>'
        );

        makeThemSortable(['.tasksSortable']);

    });



    $('body').on('keyup','.task-column-element textarea',function(){
        if(this.scrollTop > 0){
            this.style.height = this.scrollHeight + "px";
        }
    });

    $('body').on('click','.tasks-pool-show',function(){
        $('.tasks-pool').css('width','200px');
    });

    $('body').on('click','.tasks-pool-hide',function(){
        $('.tasks-pool').css('width','0px');
    });

    $('body').on('click','.task-delete',function(){
        $(this).closest('.task-column-element').remove();
    });


</script>

