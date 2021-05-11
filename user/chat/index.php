<?php
/**
 * Created by PhpStorm.
 * User: Home
 * Date: 01.05.2018
 * Time: 11:17
 */
?>
<?
$partner = new Member($_GET['room_id']);?>
<div class="message-room">
    <div class="room-header box flex-box flex-between flex-vertical-center">
        <div class="">
            <a href="/inbox/">
                <i class="fas fa-angle-left"></i> Назад
            </a>
        </div>
        <div class="message-partner-info">
            <div class="room-partner-name flex-box flex-around">
                <?=$partner->title()?>
            </div>
            <div class="message-partner-status flex-box flex-around">
                <?=$partner->last_was()?>
            </div>
        </div>
        <div class="message-partner-actions flex-box ">
            <div class="box-wide">
                <i class="fas fa-ellipsis-h "></i>
            </div>
            <div class="photo-round photo-small">
                <a href="<?=PROJECT_URL?>/user/<?=$partner->member_id()?>/">
                    <img  src='<?=$partner->avatar()?>'/>
                </a>
            </div>
        </div>
    </div>
    <script>
        function loadAllMessages() {
            $.ajax({
                url: "<?=PROJECT_URL?>/user/chat-wall.php",
                type: "GET",
                data: {"room_id": <?=$_GET['room_id']?>, "user_id": <?=$logedUser->member_id()?>},
                cache: false,
                success: function(response){
                    if(response === 0){  // смотрим ответ от сервера и выполняем соответствующее действие
                        alert("не удалось получить ответ от скрипта");
                    }else{
                        //alert(response);
                        $('.message-room-list').html(response);
                    }
                }
            });
        }
        //setInterval(loadAllMessages, 1000);

        function addNewMessage() {
            let xhttp=new XMLHttpRequest();
            xhttp.open('GET',"<?=PROJECT_URL?>/user/chat-wall.php?room_id=<?=$_GET['room_id']?>&user_id=<?=$logedUser->member_id()?>",false);
            xhttp.send();
            if (xhttp.readyState===4 && xhttp.status===200){
                document.getElementById("messages-list").innerHTML += xhttp.responseText;
                document.getElementById("messages-list").scrollTop = document.getElementById("messages-list").scrollHeight;
            }
        }

        function addMessage() {
            //alert('sdfsd');
            let new_msg = $('#text-box').val();
            if(new_msg !== '' && new_msg !==' ' ){
                $('#text-box').val('')
                $.ajax({
                    url: "<?=PROJECT_URL?>/system/controllers/messages/create.php",
                    type: "GET",
                    data: {"room_id": <?=$_GET['room_id']?>, "description": new_msg},
                    cache: false,
                    success: function(response){
                        if(response === 0){  // смотрим ответ от сервера и выполняем соответствующее действие
                            //alert("не удалось получить ответ от скрипта");
                        }else{
                            //alert(response);
                            //$('.message-room-list').html(response);
                        }
                    }
                });
                $.ajax({
                    url: "<?=PROJECT_URL?>/user/chat-wall.php",
                    type: "GET",
                    data: {"room_id": <?=$_GET['room_id']?>, "user_id": <?=$logedUser->member_id()?>},
                    cache: false,
                    success: function(response){
                        if(response === 0){  // смотрим ответ от сервера и выполняем соответствующее действие
                            alert("не удалось получить ответ от скрипта");
                        }else{
                            //alert(response);
                            $('.message-room-list').html(response);
                            document.getElementById("messages-list").scrollTop = document.getElementById("messages-list").scrollHeight;
                        }
                    }
                });
            }
        }

        $(document).ready(function(){




            $.ajax({
                url: "<?=PROJECT_URL?>/user/chat-wall.php",
                type: "GET",
                data: {"room_id": <?=$_GET['room_id']?>, "user_id": <?=$logedUser->member_id()?>},
                cache: false,
                success: function(response){
                    if(response === 0){  // смотрим ответ от сервера и выполняем соответствующее действие
                        alert("не удалось получить ответ от скрипта");
                    }else{
                        //alert(response);
                        $('.message-room-list').html(response);
                        document.getElementById("messages-list").scrollTop = document.getElementById("messages-list").scrollHeight;
                    }
                }
            });

            //Клик по отправить
            $(".btn-send").click(function(){
                //addMessage();
                let response = JSON.parse(sendAjaxRequestPost(getFormUrl(this),getFormElements(this), false));

                let post_id = response['post_id'];
                let table_id = response['table'];
                let url = '<?=PROJECT_URL?>/templates/messages/index/index.php';
                //место куда вставляем response
                //alert(getPostHtml(url, post_id, table_id));
                $('#messages-list').append(getPostHtml(url, post_id, table_id));
                document.getElementById("messages-list").scrollTop = document.getElementById("messages-list").scrollHeight;

            });
            //Клик по ENTER
            $('#text-box').on('keydown', function( e ) {
                if( e.keyCode === 13 ) {
                    //addMessage();
                    let response = JSON.parse(sendAjaxRequestPost(getFormUrl(e),getFormElements(e), false));

                    let post_id = response['post_id'];
                    let table_id = response['table'];
                    let url = '<?=PROJECT_URL?>/templates/messages/index/index.php';
                    //место куда вставляем response
                    alert(getPostHtml(url, post_id, table_id));
                    $('#messages-list').append(getPostHtml(url, post_id, table_id));
                }
            });


        });


        setWebsocketConnection();

        function setWebsocketConnection(){


            let url = "wss://pennylane.pro:2346";
            //с этим пашет норм
            //let url = "wss://echo.websocket.org";
            //alert(url);
            let socket = new WebSocket(url);
            //let socket = new WebSocket('wss://echo.websocket.org');

            socket.onopen = function() {
                alert("Соединение установлено.");
            };

            socket.onclose = function(event) {
                if (event.wasClean) {
                    alert('Соединение закрыто чисто');
                } else {
                    alert('Обрыв соединения'); // например, "убит" процесс сервера
                }
                alert('Код: ' + event.code + ' причина: ' + event.reason);
            };

            $('body').on('click','.btn-send',function(){
                socket.send('test');
            });

            socket.onmessage = function(event) {
                alert("Получены данные " + event.data);
            };

            socket.onerror = function(error) {
                alert("Ошибка " + error.message);
            };
        }




    </script>
    <div id="messages-list" class="message-room-list box">
        <div class="flex-box flex-around">
            <div>
                <img style="width: 200px" src="https://s.yimg.com/ny/api/res/1.2/81EFT_aygExFdnRjnpnC.A--/YXBwaWQ9aGlnaGxhbmRlcjtzbT0xO3c9ODAw/http://media.zenfs.com/en-US/homerun/the_zoe_report_fashion_166/00f649c6b13a6a1bb6ad971428d79d0a" />
            </div>
        </div>
    </div>
    <div class="room-form box">
        <form class="flex-box" action="<?=PROJECT_URL?>/system/controllers/posts/create.php" method="GET">
            <input type="hidden" name="table" value="<?=(new Message(0))->setTable()?>"/>
            <input type='hidden' name='destination_id' value='<?=$partner->member_id()?>'/>
            <textarea class="box" id="text-box" placeholder="Напишите сообщение..." name="description"></textarea>
            <div title="Отправить" class="flex-box flex-vertical-center right ">
                <div class="right" >
                    <div class="btn-send box " ><i class="fas fa-paper-plane fa-2x"></i></div>
                </div>
            </div>
        </form>
    </div>
</div>
