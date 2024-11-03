<div class='container_slim text_center'>
					<div class='search'  <?=(isset($_GET['articul']) && $_GET['articul']!='') ? "style='display: block;'" : '' ?>>
                      <form action="<?=PROJECT_URL?>/"  method="GET">
                       <input type='text' name='articul' list='search' value='<?=$_GET['articul']?>' placeholder='Поиск по артикулу'></input>
                        <datalist id="search">
						 <?
						  $search_sql = $pdo->prepare("SELECT * FROM items $active ORDER BY order_row DESC");
			              $search_sql->execute();
			              while($search = $search_sql->fetch()){?>
						    <option label="<?=$search['title']?>" value="<?=$search['articul']?>" ></option>
				          <?}?>
                        </datalist>
						

					   <input type='hidden' name='page' value='<?=$_GET['page']?>'></input>
                       <button><i class="fa fa-search" aria-hidden="true"></i></button>
                     </form>
                    </div><br><br>	  
</div>													