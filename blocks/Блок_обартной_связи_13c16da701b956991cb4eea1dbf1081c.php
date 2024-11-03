		<div class='feedback_block'>
 <div class='container_slim'>
  <div class='line'>Контакты</div>
  <p>Отдел продаж LIBELLEN: <?=$media_src['phone']?>. e-mail: <?=$media_src['email']?>.<br>
  Если Вы имеете возможность посетить наш шоу-рум в Москве(<?=$media_src['working_time']?>), свяжитесь с нами, чтобы согласовать время визита. <br><br>
  Вы можете оставить свой телефон, и наши менеджеры свяжутся с Вами в удобное для Вас время  
  </p>
  <p>Адрес: <?=$media_src['address']?></p>
  
  <form action='admin/send_msg.php' method='POST'>
   <div>
    <input type='hidden' name='topic' value='Обратная связь на сайте'></input>  
    <input type='text' name='name'  placeholder='Ваше имя'></input><br>
    <input type='tel' name='phone'  placeholder='Ваш телефон'></input><br>
    <input type='text' name='city'  class='city_select' placeholder='Ваш город'></input>
    <select name='time' class='time_select'>
     <option value='0'>Удобное время для звонка</option>
     <option value='10-12'>10-12</option>
     <option value='12-14'>12-14</option>
     <option value='14-16'>14-16</option>
     <option value='16-18'>16-18</option>
    </select>
   </div>
  
   <div>
     <textarea name='text' placeholder='Ваше сообщение (по желанию)' ></textarea>
     <button class='liblenn_button'>ok</button>
   </div>
  </form>
 </div>
</div>