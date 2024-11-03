		    		    		    		    		    		    		    		    		    		    		 <div class='login_container'>
   <div class='login_form'>
    <form action='<?=PROJECT_URL?>/auth/login/index.php' method='POST'>
      <div style='width: 100%; text-align: center;'>	
	  <div class="flex-box-inline">
                    <div>
                        <img src="http://commerce.gorki.ru/images/industry/logo-short.png" >
                    </div>
                    <div>
                        ИНДУСТРИАЛЬНАЯ<br>НЕДВИЖИМОСТЬ
                    </div>
            </div>
	  </div>
	  <span>Логин</span>
	  <input name='login' type='text' placeholder=''></input><br>
	  <span>Пароль</span>
	  <input name='pass' type='password' placeholder=''></input><br>
	  <? if(isset($_GET['wrong'])){ echo "<div class='login_error'>Неверный логин или пароль</div>";} ?>
	  <input type='submit' value='Войти'></input>
	</form>
   </div>
 </div>		            								    																				