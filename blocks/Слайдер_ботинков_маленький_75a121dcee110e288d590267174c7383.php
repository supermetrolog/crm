																<div class='container_slim'>
 <div class='latest_products' >   
   <div  class="latest_products flexslider">
			<ul class='slides items'>
			 <?php
			    $slides_sql = $pdo->prepare("SELECT * FROM $table_items $active AND photo!='' AND sale!='1'  ORDER BY id DESC LIMIT 24");
				$slides_sql->execute();
				while($slide = $slides_sql->fetch()){
				//$item = new Item($slide['id'] ,$pdo);
				 $photo = unserialize($slide['photo']);
				    $collection_sql = $pdo->prepare("SELECT * FROM collections WHERE title=:collection ");
				    $collection_sql->bindParam(':collection', $slide['collection']);
				    $collection_sql->execute();
					$collection = $collection_sql->fetch();
				    $collection_furl = $collection['furl'];
					
					$category_sql = $pdo->prepare("SELECT * FROM categories WHERE title=:category ");
				    $category_sql->bindParam(':category', $slide['category']);
				    $category_sql->execute();
					$category = $category_sql->fetch();
				    $category_furl = $category['furl'];?> 
				<li class=''>
					<div >
	                  <div class='item_in card_item'>
				         
				         <a href='<?=PROJECT_URL?>//tovar/<?=$collection_furl?>/<?=$category_furl?>/<?=($slide['furl'])? $slide['furl'] : furl_create($slide['title'])?>/<?=$slide['id']?>/' target='_blank'>
				           <div class='photo'>
				                 <img style='width: 100%' src="<?=PROJECT_URL.'/'.$photo[0]?>"/>
				           </div>  
				         </a> 
	                  </div>
	               </div>
				</li>
				<? }?>
			</ul>
		</div>
 </div>
</div>
<script>
$(window).load(function() {
  $('.latest_products.flexslider ').flexslider({
    animation: "slide",
	controlNav: true,
	directionNav: false, 
    itemWidth: 210,
    itemMargin: 20,
    minItems: 1,
    maxItems: 4
  });
});
</script>																