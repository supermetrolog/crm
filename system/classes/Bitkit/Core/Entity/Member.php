<?php
class Member extends Unit{

  public $login;
  public $password;
  public $result;
  
  
	public function setTable(){ 
	  return 'users';
	}
	
	public function member_id(){
		if($this->showField('id')){
			return $this->showField('id');
		}
		return 0;
	}
	
	public function name(){
			return $this->showField('title');
	}
	
	public function surName(){
			return $this->showField('surname');
	}

    public function fatherName(){
            return $this->showField('fathername');
    }

    public function fullName(){
            return $this->name().' '.$this->surName().' '.$this->fatherName();
    }
	
	public function status(){
		return $this->showField('status');
	}
  
	public function reputation_points(){
		return $this->showField('reputation_points');
	}
    
	public function photo(){
		if(unserialize($this->showField('photo'))[0] != ''){
			return unserialize($this->showField('photo'))[0];
		}else{
			return 'https://openclipart.org/image/2400px/svg_to_png/247319/abstract-user-flat-3.png';	
		}
	}
  
	public function photos(){
		if(unserialize($this->showField('photo')) != ''){
			return unserialize($this->showField('photo'));
		}
		return false;
	}
  
	public function cover_photo(){
			return $this->showField('photo_small');
	}
  
	public function respect_points(){
	  return $this->showField('respect_points');
	}

    public function canCreateRecord(){
        $group = new Group($this->group_id());
        $start_time = time() - 30*24*3600;
        $sql = $this->pdo->prepare("SELECT COUNT(*) FROM database_records WHERE author='".$this->member_id()."' AND publ_time>'$start_time'");
        $sql->execute();
        $res = $sql->fetch();
        if($group->showField('month_record_limit') > $res[0]){
            return true;
        }else{
            return false;
        }
    }

  
	public function isActive(){
		if($this->showField('activity') == 1){
			return true;
		}
		return false;
	}
  
	public function is_online(){
		if(time() - $this->showField('last_visit') < 60){
			return true;
		}
        return false;
	}
  
	public function joined(){
			return date_format_rus($this->showField('publ_time'));
	}
  
	public function last_was(){

			return date_format_rus($this->showField('last_visit'));
	}
  
	public function instagram(){
			return $this->showField('instagram');
	}

    public function avatar()
    {
        if($this->showField('photo')){
            return $this->showJsonField('photo')[0];
        }else{
            return 'http://pennylane.linkholder.ru/uploads/544627a25062b757ba01b675fffa271d.png';
        }

    }

    public function changeAvatar($photo)
    {

        if(file_exists($_SERVER["DOCUMENT_ROOT"]. DOMAIN .$this->avatar())){
            unlink($_SERVER["DOCUMENT_ROOT"]. DOMAIN .$this->avatar());
        }
        $file_sec_new_name = md5($_FILES['file']['name'].time()).'.jpg';
        $uploadfile_sec = '/uploads/'.$file_sec_new_name;
        echo $uploadfile_sec;
        echo $_SERVER['DOCUMENT_ROOT'].$uploadfile_sec;
        if(move_uploaded_file($_FILES['file']['tmp_name'], $_SERVER['DOCUMENT_ROOT'].$uploadfile_sec)){
            $photo = '/uploads/'.$file_sec_new_name;
            $this->updateField('photo',json_encode($photo));
            echo "Загрузили";
        }else{
            echo "не Загрузили";
        }
    }

    public function getAllNewMessages(){
        $sql = $this->pdo->prepare("SELECT * FROM messages WHERE to_id=:to_id  AND activity='1' AND was_read='0' ");
        $sql->bindParam(':to_id', $this->member_id());
        $sql->execute();
        $units = $sql->fetchAll();
        return $units;
    }

    public function canWriteFeedback(int $item_id){
        $sys = new System(0);
        $good_comment_cooldown_days = $sys->showField('good_comment_cooldown');
        $lim_time = time() - $good_comment_cooldown_days*24*3600;
        $sql = $this->pdo->prepare("SELECT COUNT(*) FROM comments WHERE author=:member_id AND record_id=:item_id AND comment_group='2' AND publ_time>'$lim_time' ");
        $sql->bindParam(':member_id', $this->member_id());
        $sql->bindParam(':item_id', $item_id);
        $sql->execute();
        $res = $sql->fetch();
        if($res[0] == 0  || $this->isAdmin() ) {
            return true;
        }else{
            return false;
        }
    }
  
	/* check login and pass  */
	public function loginCheck($login, $password){
		$member_sql = $this->pdo->prepare("SELECT * FROM ".$this->setTable()." WHERE title=:title OR email=:email ");
        $member_sql->bindParam(':title',$login);
        $member_sql->bindParam(':email',$login);
		$member_sql->execute();
		$members = $member_sql->fetchAll();
		if($member_sql->rowCount()){
		    $flag = 0;
            foreach($members as $member){
                if( hash_equals($member['password'], crypt($password, $member['password']))){
                    $id = $member['id'];
                    $member_password_hash = $member['password'];
                    setcookie ("member_id", "$id",time()+3600,"/");
                    $user_hash = md5($_SERVER ['HTTP_USER_AGENT'].'%'.$member_password_hash); //создаем хэш для защиты куки
                    $sql = $this->pdo->prepare("UPDATE ".$this->setTable()." SET ip_address=:ip_address , user_hash=:user_hash  WHERE id=:id");
                    $sql->bindParam(":ip_address", $_SERVER['REMOTE_ADDR']);
                    $sql->bindParam(":user_hash", $user_hash);
                    $sql->bindParam(":id", $id);
                    $sql->execute();
                    $flag =1;
                    break;
                }else{
                    setcookie ("member_id","0",time()-3600,"/");
                    //echo 'пароль неверный';
                }
            }
            if($flag == 1){
                return true;
            }else{
                return false;
            }
        }else{
            setcookie ("member_id","0",time()-3600,"/");
            return false;
            //echo 'такого юзера нету';
        }
		
	}
	
	/* validate the users id*/
	public function is_valid(){
		$sql = $this->mysqli->prepare("SELECT * FROM ".$this->setTable()." WHERE id=?");
		$sql->bind_param("i", $this->id);
		$sql->execute();
		$member =  $sql->get_result()->fetch_assoc();
		$user_hash = md5($_SERVER ['HTTP_USER_AGENT'].'%'.$member['password']); //создаем хэш для проверки
		if(!hash_equals ( $member['user_hash'] , $user_hash )){  
			setcookie ("member_id","0",time()-3600,"/");
			return false;	  
		}else{
			return true;
		}
	}
  
	/* check if the user is admin  */
	public function isAdmin(){
		if($this->showField('member_group_id') == 4){
			return true;
		}else{
			return false;
		}
	}
	
	
	
	/* total users amount count */
	public function users_count(){
		$sql = $this->mysqli->prepare("SELECT * FROM ".$this->setTable()." ");
		$sql->execute();
		return $sql->get_result()->num_rows;
	}

	/* online users amount count */
	public function online_users_count(){
		$sql = $this->mysqli->prepare("SELECT * FROM visitors WHERE activity='1' ");
		$sql->execute();
		return $sql->get_result()->num_rows;
	}

	/* today visitors count */
	public function today_visits_count(){
	$now = time();
	$today_start = strtotime(date("d-m-Y", time()));
    $sql = $this->mysqli->prepare("SELECT * FROM visitors WHERE publ_time >'$today_start' AND publ_time <'$now' ");
    $sql->execute();
	return $sql->get_result()->num_rows;
	}

	/* month visitors count */
	public function month_visits_count(){
		$now = time();
		$month_start = strtotime(date("m-Y", time()));
		$sql = $this->mysqli->prepare("SELECT * FROM visitors WHERE publ_time >'$month_start' AND publ_time <'$now' ");
		$sql->execute();
		return $sql->get_result()->num_rows;
	}

	/* get the last visit time of a user */
	public function get_last_visit(){
		$sql = $this->mysqli->prepare("UPDATE ".$this->setTable()." SET last_visit=? WHERE id=?");
		$sql->bind_param('ii', time(), $this->id );
		try{
			$sql->execute();	
		}catch (PDOException $e) {
			echo 'Подключение не удалось: ' . $e->getMessage();
		}
	}
 
	/*
	public function visit_find(){
		$time = time() - 60;
		$sql = $this->mysqli->prepare("UPDATE visitors SET activity='0' WHERE publ_time< ?");   
		$sql->bindParam("i", $time);
		$sql->execute();
    
		if($_SESSION['page_hash']){
			$page_hash = $_SESSION['page_hash'];	
		}else{
			$page_hash = 0;	
		}  	  
		$sql = $this->mysqli->prepare("SELECT * FROM users WHERE ip_address=?");   
		$sql->bindParam("s", $_SERVER['REMOTE_ADDR']);
		$sql->execute();
		if($sql->get_results->num_rows > 0){
			$member =  $sql->get_results->fetch_assoc();
			$name = $member['title'];
			$user_id = $member['id'];		
		}else{
			$name = 'Гость'; 
			$user_id = 0;	
		}
		try{  
			$sql = $this->mysqli->prepare("SELECT * FROM visitors WHERE activity='1' AND ip_address=?");   
			$sql->bindParam("s", $_SERVER['REMOTE_ADDR']);
			$sql->execute();  
			if($sql->get_results->num_rows > 0){  
				
			}else{
				if( $curl = curl_init() ) {
				curl_setopt($curl, CURLOPT_URL, 'ru.sxgeo.city/xml/'.$_SERVER['REMOTE_ADDR']);
				curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
				$out = curl_exec($curl);
				$items = new SimpleXMLElement($out);// перезаписываем items для каждой конкретной машины
				$item = $items->ip;
				$country = $item->country;
				$country = $country->name_en;
				$city = $item->city;
				$city = $city->name_en;
				if($country == ''){
				   $country = 'Australia'; 
				}
               curl_close($curl);
			}
			$sql = $this->mysqli->prepare("INSERT INTO visitors(title, ip_address, country, city, publ_time, user_id, page_hash, activity)"."VALUES(:title, :ip_address, :country, :city, :publ_time, :user_id, :page_hash, '1')");  
			$sql->bindParam("s", $name);  
			//$sql->bindParam(":title", $name);  
			//$sql->bindParam(":publ_time", time());  
			//$sql->bindParam(":user_id", $user_id);  
			//$sql->bindParam(":page_hash", $page_hash);  
			//$sql->bindParam(":ip_address", $_SERVER['REMOTE_ADDR']);
			//$sql->bindParam(":country", $country);
			//$sql->bindParam(":city", $city);
			$sql->execute(); 
		}	
      
		}catch (PDOException $e) {
			echo 'Подключение не удалось: ' . $e->getMessage();
		}
	}
		*/
  
	public function check_email($email){
		$sql = $this->mysqli->prepare("SELECT * FROM ".$this->setTable()." WHERE email=?");
		$sql->bind_param("s", $email);
		$sql->execute();
		if($sql->get_result()->num_rows > 0){
			return true;
		}else{
			return false;
		}
	}
  
	public function check_name($name){
		$sql = $this->mysqli->prepare("SELECT * FROM ".$this->setTable()." WHERE title=?");
		$sql->bind_param("s", $name);
		$sql->execute();
		if($sql->get_result()->num_rows > 0){
			return true;
		}else{
			return false;
		}
	}
  
	public function check_password($password, $confirm){
		if($password === $confirm && $password !='' && $password !=' '){
			return true;
		}else{
			return false;
		}
	}
  
	public function change_pass($new_pass){
		$sql = $this->mysqli->prepare("UPDATE ".$this->setTable()." SET password=?	WHERE restore_hash=?");
		$sql->bind_param("s", crypt($new_pass));
		$sql->bind_param("s", $_COOKIE['restore_hash']);
		try{
			$sql->execute();  
			$sql = $this->pdo->prepare("SELECT * FROM ".$this->setTable()." WHERE restore_hash=?");
			$sql->bindParam("s", $_COOKIE['restore_hash']);
			$sql->execute();
			$member = $sql->fetch();
			setcookie ("pass_restored", "1",time()+3600,"/");
			setcookie ("restore_hash","0",time()-3600,"/"); 	 
			setcookie ("member_id", $member['id'],time()+3600,"/");
			return true; 	 
		}catch(PDOException $e){
			echo 'Подключение не удалось: ' . $e->getMessage();
		}
	}
  
  
	public function hasMarker(){
		if($this->marker()->id != NULL){
		    return true;
        }else{
		    return false;
        }
	}

    public function marker(){
	    $marker = new Marker(0);
        $sql = $this->pdo->prepare("SELECT * FROM markers_groups WHERE table_name='".$this->setTable()."'");
        $sql->execute();
        $markerGroup = $sql->fetch(PDO::FETCH_LAZY);

        $sql = $this->pdo->prepare("SELECT * FROM markers WHERE element_id='".$this->member_id()."' AND marker_group='".$markerGroup->id."'");
        $sql->execute();
        $marker_line = $sql->fetch(PDO::FETCH_LAZY);

        $marker = new Marker($marker_line->id);
        return $marker;
    }
  
	public function email(){
			return $this->showField('email');
	}
  
	public function phone(){
			return $this->showField('phone');
	}
  
	public function find_by_param($param_name, $param_val){
		$sql = $this->mysqli->prepare("SELECT * FROM ".$this->setTable()." WHERE ?=?");
		$sql->bind_param("ss", $param_name, $param_val);
		if($sql->execute()){
			$member = $sql->get_result()->fetch_asscoc();
			return $member['id'];
		}
	}
  
  /*
  public function create($PAR_ARR, $global_pars, PROJECT_URL.'/'){
     $line1 = '';
     $line2 = '';
	 $publ_time = time();
     $i =0;
	 ($global_pars['email_verification'] == 1) ? $activity = 1 : $activity = 0;
     $member_group_id = 2;	 
     $reg_hash = md5(time().md5(time()));	 
	 $arr_isset = array();
     //смотрим какие поля были получены
     foreach($PAR_ARR as $arr_item){
      if($_POST[$arr_item] != NULL){
	   if(is_array($_POST[$arr_item])){ //проверяем не массив ли это
	     $arr_isset[$arr_item] = serialize($_POST[$arr_item]);
	   }else{
         if($arr_item == 'password'){	    
          $arr_isset[$arr_item] = crypt($_POST[$arr_item]); //криптуем пароль 
	     }else{
          $arr_isset[$arr_item] = $_POST[$arr_item];
         }		 
	   }
      }
     }
	 //создаем строку полей
     foreach($arr_isset as $arr_isset_item =>$key){
       $line1 = $line1.$arr_isset_item.', ';
     }
	 //создаем строку знаений
     foreach($arr_isset as $arr_isset_item){
      $line2 = $line2."'".addslashes ($arr_isset_item)."'".', ';
      $arr_isset_values[$i] = $arr_isset_item; 
      $i++;  
     }
	
	$line1 = $line1.'activity, publ_time, reg_hash, member_group_id'; 
    $line2 = $line2."'$activity', "."'$publ_time', "."'$reg_hash', "."'$member_group_id'";
	
    try {
     $user = $this->pdo->prepare("INSERT INTO users(".$line1.")"."VALUES(".$line2.")");
     $user->execute(); 
	 
	 //смотрим пользователя
	 $sql = $this->pdo->prepare("SELECT * FROM users WHERE email= :email");
     $sql->bindParam(":email", $_POST['email']);
     $sql->execute();
	 $new_user = $sql->fetch();
	 
	 if($global_pars['email_verification'] == 1 && $new_user['id'] ){
	   $ver_link = PROJECT_URL.'/'."/controllers/verification/?code=".$reg_hash;
	   $msg = $new_user['title'].", благодарим Вас за регистрацию на сайте ".$global_pars['site_name'].".<br></br>  Для активации Вашего аккаунта пройдите по ссылке $ver_link";
	   setcookie ("member_id", "-1",time()+3600,"/"); 
	   mail($new_user['email'], $global_pars['site_name'].". Подтверждение E-mail адреса",$msg); 
     }else{
       setcookie ("member_id", $new_user['id'],time()+3600,"/");     
     }	
     
     //Отправляем или не отправляе подтверждение на почту 
	 		 
    }catch (PDOException $e) {
     echo 'Подключение не удалось: ' . $e->getMessage();
    }
  }
	
	public function verify($code){
		$sql = $this->pdo->prepare("SELECT * FROM users WHERE reg_hash= :hash");
		$sql->bindParam(":hash", $code);
		$sql->execute();
		if($sql->rowCount() > 0 ){
			try{
				$member = $sql->fetch();
				$ver_sql = $this->pdo->prepare("UPDATE users SET activity='1', reg_hash=''  WHERE id= :member_id");
				$ver_sql->bindParam(":member_id", $member['id']);
				$ver_sql->execute();
				$member_id = $member['id'];
				setcookie ("member_id", "$member_id",time()+3600,"/");
				return true;		 
			}
			catch (PDOException $e){
				echo 'Подключение не удалось: ' . $e->getMessage();
				return false;
			}		
		}
	}
	*/
  
	
  
	public function group_id(){
	    if($this->showField('member_group_id')){
            return $this->showField('member_group_id');
        }else{
	        return 1;
        }
	}
  
	public function group_name(){
	    $group = new Group($this->group_id());
        return $group->title();
	}                          
  
	public function can_see($permissions_arr){
		if(is_array($permissions_arr)){
			if($this->id == NULL){ //если нету куки тоесть гость то считаем его группу равной 1
			    $member_group = 1;
			}else{
				$member_group = $this->group_id();
			}
			if(in_array($member_group, $permissions_arr)){
				return true;
			}else{
				return false;
			}
		}
	}

    public function inFavourites(int $item_id){
        $favs_arr =  $this->showJsonField('favourites');
        if(in_array($item_id, $favs_arr)){
            return true;
        }else{
            return false;
        }
    }

    public function getFavourites(){
        return $this->showJsonField('favourites');
    }

	public function setFavourites(int $object_id){

            $favsArray =  $this->getFavourites();
            if($favsArray == NULL){
                $favsArray =  array();
            }
            if(in_array($object_id, $favsArray)){
                unset($favsArray[array_search($object_id, $favsArray)]);
                sort($favsArray); //иначе при перегоне из json в массив будет косяк
            }else{
                array_push($favsArray,$object_id);
            }
            $favs_json = json_encode($favsArray);
            $sql = $this->pdo->prepare("UPDATE ".$this->setTable()." SET favourites='$favs_json' WHERE id='".$this->id."'");
            if($sql->execute()){
               return true;
            }else{
                return false;
            }

    }


    /* FRIENDS METHODS */
    public function addUserToSocialList($list_field_name, int $target_user){
        //$member = new Member($member_id);
        $list =  $this->showJsonField($list_field_name);
        if($list == NULL){
            $list =  array();
        }
        if(!in_array($target_user,$list)){
            array_push($list,$target_user);
            $listJson = json_encode($list);
            $sql = $this->pdo->prepare("UPDATE ".$this->setTable()." SET $list_field_name='$listJson'  WHERE id='".$this->member_id()."'");
            $sql->execute();
        }
    }

    public function deleteUserFromSocialList($list_field_name, int $target_user){
        //$member = new Member($member_id);
        $list =  $this->showJsonField($list_field_name);
        if($list == NULL){
            $list =  array();
        }
        if(in_array($target_user,$list)){
            unset($list[array_search($target_user, $list)]);
            sort($list); //иначе при перегоне из json в массив будет косяк
            $listJson = json_encode($list);
            $sql = $this->pdo->prepare("UPDATE ".$this->setTable()." SET $list_field_name='$listJson'  WHERE id='".$this->member_id()."'");
            $sql->execute();
        }
    }



    public function subscribe(int $user_id)
    {

    }

    public function unSubscribe(int $user_id)
    {

    }

    public function subscriberAdd(int $user_id)
    {
        $this->addUserToSocialList('subscribers', $user_id);
    }

    public function subscriberDelete(int $user_id)
    {
        $this->deleteUserFromSocialList('subscribers', $user_id);
    }

    public function subscriptionAdd(int $user_id)
    {
        $this->addUserToSocialList('subscriptions', $user_id);
    }

    public function subscriptionDelete(int $user_id)
    {
        $this->deleteUserFromSocialList('subscriptions', $user_id);
    }

    public function friendAdd(int $user_id)
    {
        $this->addUserToSocialList('friends', $user_id);
    }

    public function friendDelete(int $user_id)
    {
        $this->deleteUserFromSocialList('friends', $user_id);
    }


    public function getFriends1()
    {
        return array_intersect($this->getSubscribers(), $this->getSubscriptions());
    }

    public function getFriends()
    {
        return $this->showJsonField('friends');
    }

    public function getSubscribers()
    {
        return $this->showJsonField('subscribers');
    }

    public function getSubscriptions()
    {
        return $this->showJsonField('subscriptions');
    }

    public function isSubscribedTo(int $user_id)
    {
        if(in_array($user_id,$this->getSubscriptions())){
            return true;
        }else{
            return false;
        }
    }


    public function isFriend(int $user_id)
    {
        $subscription_user = new Member($user_id);
        if($this->isSubscribedTo($subscription_user->member_id()) && $subscription_user->isSubscribedTo($this->member_id())){
            return true;
        }else{
            return false;
        }
    }


    public function friendsCount()
    {
        return count($this->getFriends());
    }

    public function subscribersCount()
    {
        return count($this->getSubscribers());
    }

    public function subscriptionsCount()
    {
        return count($this->getSubscriptions());
    }

    public function memberInfoField($field)
    {
        $sql = $this->pdo->prepare("SELECT * FROM ".$this->setTable()." WHERE id=:id");
        $sql->bindParam(':id', $this->id);
        $sql->execute();
        $unit = $sql->fetch();
        if($unit[$field]){
            $field = json_decode($unit[$field]);
            $fieldValue = $field->value;
            $fieldPermission = $field->permission;
            return $unit[$field];
        }
    }



    public function isFriendOfFriend($id)
    {
        $sql = $this->mysqli->prepare("SELECT * FROM " . $this->setTable() . " WHERE id=?");
        $sql->bind_param("i", $this->id);
        $sql->execute();
        $unit = $sql->get_result()->fetch_assoc();
        $friendsArray = json_decode($unit['friends']);
        if(in_array($id, $friendsArray)){
            return true;
        }else{
            foreach ($friendsArray as $friendId) {
                $sql = $this->mysqli->prepare("SELECT * FROM " . $this->setTable() . " WHERE id=?");
                $sql->bind_param("i", $friendId);
                $sql->execute();
                $f = $sql->get_result()->fetch_assoc();
                $friendsOfFriendArray = json_decode($unit['friends']);
                if (in_array($id, $friendsOfFriendArray)) {
                    return true;
                    break;
                } else {
                    return false;
                }
            }
        }
    }

    public function getALLVisitors()
    {
        return array_reverse($this->showJsonField('visitors'));
    }

    public function getLastVisitors()
    {


    }


    public function setNewVisitor(int $user_id)
    {
        $visitorsList = $this->getALLVisitors();
        if($visitorsList == NULL){
            $visitorsList =  array();
            $new_visitor_data = array('time' => time(), 'id' => $user_id );
            array_push( $visitorsList, $new_visitor_data);
            $visitorsList = json_encode($visitorsList);
            $sql = $this->pdo->prepare("UPDATE ".$this->setTable()." SET visitors=' $visitorsList' WHERE id='".$this->member_id()."' ");
            $sql->execute();
        }else{
            foreach ($visitorsList as $visitor_list_item) {
                if($visitor_list_item->id == $user_id){
                    //echo $visitor_list_item->id;
                    if(time() > $visitor_list_item->time + 3600*24 ){
                        $new_visitor_data = array('time' => time(), 'id' => $user_id );
                        array_push( $visitorsList, $new_visitor_data);
                        $visitorsList = json_encode($visitorsList);
                        $sql = $this->pdo->prepare("UPDATE ".$this->setTable()." SET visitors=' $visitorsList' WHERE id='".$this->member_id()."' ");
                        $sql->execute();
                    }
                    break;
                }

            }
        }
    }
	
  
}



?>