<div class=''>
<?

    $source = $pdo->prepare("SELECT * FROM users WHERE id!='".$logedUser->member_id()."' ");
	$source->execute();
	while($src = $source->fetch()){
		$listMember = new Member($src['id']);
	   ?>
      <div style='display: flex;  align-items: center;'>
	    <div>
			<?=$listMember->name()?>
		</div>
		<div>
			<img style='width: 100px;' src='<?=$listMember->photo()?>'/>
		</div>
		<div>
			<a href='<?=$listMember->member_id()?>'>Перейти на страницу</a>
		</div>
		<div>
			<form action='<?=PROJECT_URL?>/admin/friend_actions.php' method='GET'>
				<input type='hidden' name='friend_id' value='<?=$listMember->member_id()?>'/>
				<button><?=($logedUser->isFriend($listMember->member_id())) ? 'Удалить из друзей' : 'Добавить друзья' ; ?></button>
			</form>
		</div>
	  
	  </div>
   <?}?>
</div>   