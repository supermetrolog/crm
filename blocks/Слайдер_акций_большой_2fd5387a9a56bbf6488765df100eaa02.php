		    		    		    		    		    		    		    		    		    				  <div  class="big_items big_boot_slider flexslider">
			<ul class="slides">
			 <?php
 
			    $slides_sql = $pdo->prepare("SELECT * FROM $table_sales $active  ORDER BY order_row DESC LIMIT 10");
				$slides_sql->execute();
				while($slide = $slides_sql->fetch()){
				 $photo = unserialize($slide["photo"]);?> 
				<li>
					
                                          <div  class="small_slide" style='background: url(<?=PROJECT_URL.'/'.$photo[0]?>)' >
                                           <div class='container_slim'>                                     <div>
					    <p style="font-family: 'Sans';"><?=$slide["description"]?></p><br>
						<a class='button_active_trans' href='<?=PROJECT_URL.'/'.$slide["link"]?>'>Подробнее</a>
</div>                    
                                          </div>
					</div>
				</li>
				<? }?>
			</ul>
		</div>
<script type="text/javascript" src="<?=PROJECT_URL?>//js/jquery.flexslider.js"></script>
<script>
// Can also be used with $(document).ready()
$(window).load(function() {
  $('.banners').flexslider({
    animation: "slide",
	controlNav: false,
  });
  
  $('.big_boot_slider').flexslider({
    animation: "slide",
  });
});



</script>																				