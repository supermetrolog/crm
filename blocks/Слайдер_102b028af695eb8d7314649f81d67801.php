				<div class="header" >
         <a href="<?=PROJECT_URL?>/"><img class='logo_mobile' src='<?=PROJECT_URL.'/'.$logo?>'/><span></span></a>
		 <div class="menu_start_top">
		  <ul> 
		   <li class="logo_sign black"><a href="<?=PROJECT_URL?>/"><img src='<?=PROJECT_URL.'/'.$logo?>'/><span></span></a></li>
		   <?
	    $menu_sql = $pdo->prepare("SELECT * FROM pages $active ORDER BY order_row DESC");
        $menu_sql->execute();    
		while($menu_item = $menu_sql->fetch()){
          $permissions_arr = unserialize($menu_item['permissions']);
          if($logedUser->can_see($permissions_arr) ) {		  
		   ($menu_item['link'] != ' ') ? $page_link = $menu_item['link'] : $page_link = '?page='.$menu_item['id'] ;?>
		   <li class='menu_items' ><a href="<?=PROJECT_URL.'/'.$page_link?>"><?=$menu_item['title']?></a></li>
		<?}
		}?>
                  <li class='a_bit_wide' title='Поиск'><button class='liblenn_button' id='search_open'><i class="fa fa-search" aria-hidden="true"></i></button>
                    <div class='search_absolute'>  
                      <form action="<?=PROJECT_URL?>/"  method="GET">
                       <input type='text' name='articul' list='search' value='<?=$_GET['articul']?>' placeholder='Поиск по артикулу'></input>
                        <datalist id="search">
						 <?
						  $search_sql = $pdo->prepare("SELECT * FROM items $active ORDER BY order_row DESC");
			              $search_sql->execute();
			              while($search = $search_sql->fetch()){?>
						    <option label="<?=$search['title']?>" value="<?=$search['articul']?>" />
				          <?}?>
                        </datalist>
					   <input type='hidden' name='page' value='18'></input>
                       <button><i class="fa fa-search" aria-hidden="true"></i></button>
                     </form>
                    </div>	
                  </li>
                  <li class='a_bit_wide' title='Войти/Выйти' id='<?=($logedUser->member_id() > 0)? 'logOut' : 'logIn' ?>'>
				    <button class='liblenn_button'><i class="fa fa-lock" aria-hidden="true"></i></button>
					<div class='logout'><a href='<?=PROJECT_URL?>//registration/login.php'>Выйти</a></div>
				  </li>
                  <li class='a_bit_wide' title='Корзина'><button class='liblenn_button'><a href='<?=PROJECT_URL?>//?page=20'><i class="fa fa-shopping-bag" aria-hidden="true"></i><div class='basket_items'></div> </a></button></li>
		  </ul>
		 </div>
		</div>
		<div  class="flexslider banners" >
			<ul class="slides">
			 <?php
			    $banner_sql = $pdo->prepare("SELECT * FROM $table_ban $active"); 
		        $banner_sql->execute();
				while($banner = $banner_sql->fetch()){
				 $photo = unserialize($banner["photo"]);?> 
				<li >
                                 <div class='desktop_banners' style='background: url(<?=PROJECT_URL.'/'.$photo[0]?>);'>
				  
                                 <div class='container_slim' style='position: relative; ' >
                                   <div class='main_video' style='margin-top: 300px;'>
                                    <h1 style='color: white;'><?=$banner['title']?></h1>
                                    <p style='color: white;'><?=$banner['description']?></p>
									<iframe width="400px" height="200px" src="<?=$banner['link']?>" frameborder="0" gesture="media" allow="encrypted-media" allowfullscreen></iframe>
								  </div>

                                 </div>
                                 </div>
                                 <div class='mobile_banners'>
				  <a href="<?=$banner["link"]?>">
				   <img src="<?=PROJECT_URL.'/'.$banner['photo_small']?>"/>
				  </a> 
                                 </div>
				</li>
                                
				<? }?>
			</ul>
		</div>
<script type="text/javascript" src="./js/jquery.flexslider.js"></script>
<script>
// Can also be used with $(document).ready()
$(window).load(function() {
  $('.banners').flexslider({
    animation: "slide",
	controlNav: false,
  });
  
});



</script>
<script type="text/javascript"> 

$(document).ready(function() {
    $('#search_open').click(function() {
       $('.search_absolute').slideToggle(300);
    }); 			   
 }); 
</script> 			
<script type="text/javascript"> 
//Подгрузка колва товара в корзине
$(document).ready(function() {
                 $.ajax({
                  url: "<?=PROJECT_URL?>//basket/basketWidget.php",
                  cache: false,
                  success: function(response){
                    if(response == 0){  // смотрим ответ от сервера и выполняем соответствующее действие
                      //alert("не удалось"); 
                    }else{
                      //alert("удалось");	
                      $(".basket_items, .basket_items_mob").html(response);					
                    }
                  }
                 });					     	
 }); 
</script> 																			