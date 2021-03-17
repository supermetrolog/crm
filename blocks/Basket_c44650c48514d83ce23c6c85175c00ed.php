<div class='container_slim'>  
 <div class='basket_container'>

		  <div class='basket_units two_third vertical_top'>
   <?

    session_start();
	 $final_sum = 0;
	 $final_num =0;
    if(is_array($_SESSION['tovar']))foreach($_SESSION['tovar'] as $num => $goods){

     $id = $goods['id'];
     $discount = $logedUser->discount();
     //$size = $goods['size']; 
     $q = $pdo->prepare("SELECT * FROM items WHERE id='$id'");
   
     if($q->execute()){
      $tovar = $q->fetch();
      $photo = unserialize($tovar['photo']);
      $good_sum = $goods['amount']*$tovar['price']*$tovar['pack'];
      $final_sum = $final_sum+$good_sum;
	  $final_num = $final_num+$goods['amount'];
	  ?>
		  
		   <div class='basket_unit'>
		    <div class='tovar_img vertical_top one_fourth'>
		       <a href='<?=PROJECT_URL?>//?page=19&id=<?=$tovar['id']?>&title=<?=$tovar['title']?>'><img src='<?=PROJECT_URL.'/'.$photo[0]?>'/></a>
		    </div>  
            <div class='mob_stats vertical_top two_fourth'>
			 <div class='stat_unit_mob'>
			   <div class='basket_unit_name'>
		         <a href='<?=PROJECT_URL?>//?page=19&id=<?=$tovar['id']?>&title=<?=$tovar['title']?>'><span><?=$tovar['title']?></span></a>
		       </div>
		     </div>
			 <div class='stat_unit_mob'>
		       <div class='stat_name'>Артикул</div>
			   <div class='stat_val'><?=$tovar['articul']?></div>
		     </div>
			 <div class='stat_unit_mob'>
		       <div class='stat_name'>Цвет</div>
			   <div class='stat_val'><?=$tovar['color']?></div>
		     </div>
			 <div class='stat_unit_mob'>
		       <div class='stat_name'>Размерный ряд</div>
			   <div class='stat_val'><?=$tovar['size']?></div>
		     </div>
			 <div class='stat_unit_mob'>
		       <div class='stat_name'>Цена за пару</div>
			   <div class='stat_val'><?=$tovar['price']?> руб</div>
		     </div>
             <?if($tovar['sale'] == 1) {?>			 
			 <div class='stat_unit_mob'>
		       <div class='stat_name'>Цена cо скидкой</div>
			   <div class='stat_val'><?=$tovar['price']?> руб <span class='sale_amount'>(Скидка: <?=$tovar['discount']?> )</span></div>
		     </div>
	         <? }?>			 
			 <div class='stat_unit_mob'>    
		       <div class='stat_name'>Стоимость</div>  
			   <div class='stat_val fin_unit_price'><span class='how_much'><?=$good_sum?></span> руб (<span class='for'><?=$goods['amount']*$tovar['pack']?></span>шт.)</div>
		     </div>
            </div>
            <div class='tovar_img vertical_top one_fourth'>
		       <div class='stat_unit_mob'>
			    <div class='stat_val num'>
		         <div class='signs one_third vertical_middle'>-</div>
				 <input disabled value='<?=$goods['amount']?>' type='text' id='<?=$tovar['id']?>' class='amount one_third vertical_middle'></input>
				 <div class='signs one_third vertical_middle'>+</div>
				 <p>(кол-во коробов)</p>
		        </div>
		     </div>
		    </div> 			
		  </div>
		  
 <? }
  }
?>  
		  
            </div>
           		
		 
		  <div class='basket_fin_stats one_third vertical_top'>
		   <div class='fin_stats_cont'>
            <div class='od_big'>     
		       <div class='basket_header fin_name'  >
		        Общая стоимость заказа:
		       </div>
			</div>		   
		    <div class='unit'>
		       <div class='fin_name half'>
		        Всего товаров:
		       </div>
			   <div class='fin_val half'>
		        <span id='overall_num'><?=$final_num?></span>
		       </div>
			</div>
			<div class='unit'>
		       <div class='fin_name half' >
		        Сумма заказа:
		       </div>
			   <div class='fin_val half'>
		         <span id='overall_sum'><?=$final_sum?></span> руб.
		       </div>
			</div>
			<div class='unit'>
		       <div class='fin_name half' >
		        Клиентская скидка:
		       </div>
			   <div class='fin_val half'><?=$discount?> %</div>
			</div>
			<div class='fin_price_go fin_name'  >
		        Итого стоимость заказа:
		    </div>
			<div class='fin_val super_final_price '  >
		        <span><?=round($final_sum, 2);?></span> руб.
		    </div>
		   </div>
		   <button class='button_active_trans'>оформить заказ  &#160; &#10004;</a></button>
		   <? if($_SESSION['tovar']){ ?>
             <form action='<?=PROJECT_URL?>//basket/post.php' class='basket_result_in' method='POST'>
	          <div class='customers_data'>
			   <? if($logedUser->member_id() == 0){ ?> 
	            <input type='tel' required  class='tel_num' name='phone' placeholder='Телефон'></input>
	            <input type='email' required  class='tel_num' name='email' placeholder='E-mail'></input>
	            <input type='text' required class='' name='name' placeholder='Имя'></input><br><br>
			   <?}?>
				<div style='margin-left :20px; text-align: left'>
				<p>Способы доставки</p>
				<?$delivery_sql = $pdo->prepare("SELECT * FROM delivery $active");
                  $delivery_sql->execute();
                  while($delivery_info = $delivery_sql->fetch()){ ?>
				    <input type='radio' required  name='delivery_id' value='<?=$delivery_info['id']?>' ></input><?=$delivery_info['title']?><br><br>
			  
				<?}?>
				
				</div>
	            <button class='button_active'>Подтвердить</button>
	          </div>
            </form>  
            <?}  ?>
           <div class='or_go_on'>
		     или  &#160;<a href='<?=PROJECT_URL?>//?page=18'>продолжить покупки</a>
           </div>
          </div>
          		  
	</div>
</div>
 <script>
  $('body').on('click', '.button_active_trans', function(){
        $('.customers_data').slideToggle(300);
 });
 </script>	
 <script>
  $('body').on('input', '.amount', function(){
        var id = $(this).attr('id');
        //var size = $(this).closest(".basket_unit").find(".size").find("p").find("span").html();
        var amount = $(this).val();
        //alert(id);
        //alert(size);
        //alert(amount);
        $.ajax({
          url: "<?=PROJECT_URL?>//basket/change_basket_amount.php",
          type: "GET",
          data: {"id": id, "amount": amount},
          cache: false,
          success: function(response){
              if(response == 0){  // смотрим ответ от сервера и выполняем соответствующее действие
                 //alert("не удалось"); 
              }else{
                 //alert(" удалось");	
                //$(".basket_goods").html(response);
                $.ajax({
                  url: "<?=PROJECT_URL?>//basket/basketWidget.php",
                  cache: false,
                  success: function(response){
                    if(response == 0){  // смотрим ответ от сервера и выполняем соответствующее действие
                      //alert("не удалось"); 
                    }else{
                      //alert(" удалось");	
                      $(".basket_items").html(response);					
                    }
                  }
                });
	            $.ajax({
                  url: "<?=PROJECT_URL?>//basket/basket_sum_count.php",
                  cache: false,
                  success: function(response){
                    if(response == 0){  // смотрим ответ от сервера и выполняем соответствующее действие
                      //alert("не удалось"); 
                    }else{
                      //alert(response);	
                      $().(".super_final_price span").html(response);					
                    }
                  }
                });			
              }
           }
        }); 

 });
 </script>
 <script>
 
  $('body').on('click', '.signs', function(){
        var obj = this;
        var id = $(this).closest(".num").find(".amount").attr('id');
        //var size = $(this).closest(".basket_unit").find(".size").find("p").find("span").html();
        var amount = $(this).closest(".num").find(".amount").val();
		if($(this).html() == '+'){
		  amount = Number(amount)+1;
		}else if($(this).html() == '-'){
		  amount = Number(amount)-1;
		  if(amount < 1){
            $.ajax({
                  url: "<?=PROJECT_URL?>//basket/clear_basket_unit.php",
				  type: "GET",
                  data: {"id": id},
                  cache: false,
                  success: function(response){
                    if(response == 0){  // смотрим ответ от сервера и выполняем соответствующее действие
                      //alert("не удалось"); 
                    }else{
                      //alert(" удалось");	
                      window.location.href = window.location.href;				
                    }
                  }
                });  
		  }
		}else{
		
		}
		$(this).closest(".num").find(".amount").val(amount);
        //alert(amount);
        //alert(size);   
        //alert(amount);
        $.ajax({
          url: "<?=PROJECT_URL?>//basket/change_basket_amount.php",
          type: "GET",
          data: {"id": id, "amount": amount},
          cache: false,
          success: function(response){
              if(response == 0){  // смотрим ответ от сервера и выполняем соответствующее действие
                 //alert("не удалось"); 
              }else{
                 //alert(" удалось");	
                //$(".basket_goods").html(response);
                $.ajax({
                  url: "<?=PROJECT_URL?>//basket/basketWidget.php",
                  cache: false,
                  success: function(response){
                    if(response == 0){  // смотрим ответ от сервера и выполняем соответствующее действие
                      //alert("не удалось"); 
                    }else{
                      //alert(" удалось");	
                      $(".basket_items").html(response);					
                      $("#overall_num").html(response);					
                    }
                  }
                });
				$.ajax({
                  url: "<?=PROJECT_URL?>//basket/unit_sum_count.php",
				  type: "GET",
                  data: {"id": id},
                  cache: false,
                  success: function(response){
                    if(response == 0){  // смотрим ответ от сервера и выполняем соответствующее действие
                      //alert("не удалось"); 
                    }else{
                      //alert(response);
                      $res = response.split(',');					  
                      $(obj).closest('.basket_unit').find('.mob_stats').find(".fin_unit_price .how_much").html( $res[0]);					
                      $(obj).closest('.basket_unit').find('.mob_stats').find(".fin_unit_price .for").html( $res[1]);					  
                    }
                  }
                });
	            $.ajax({
                  url: "<?=PROJECT_URL?>//basket/basket_sum_count.php",
                  cache: false,
                  success: function(response){
                    if(response == 0){  // смотрим ответ от сервера и выполняем соответствующее действие
                      //alert("не удалось"); 
                    }else{
                      //alert(response);
                      $("#overall_sum").html(response);
					  var fin_sum = <?=1 - $logedUser->discount()/100?>*response;				  
                      $(".super_final_price span").html(fin_sum);					
                    }
                  }
                });			
              }
           }
        }); 

 }); 
 </script>	 