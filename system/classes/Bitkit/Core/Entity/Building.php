<?php
namespace BitKit\Core\Entity;
class Building extends  \BitKit\Core\Entity\Prototype\Unit {

    public function setTable(){
        return 'c_industry';
    }

    public function title(){
        return $this->showField('title');
    }

    public function itemId(){
        return $this->showField('id');
    }

    public function photos(){
        return json_decode($this->showField('photo'));
    }

    public function classType(){
        $object_class = new \BitKit\Core\Entity\Prototype\Post($this->showField('object_class'));
        $object_class->getTable('l_classes');
        return  $object_class->title();
    }

    public function showObjectStat($field, $dimension ,$placeholder ){
        if($this->showField($field)){
            return $this->showField($field).' '.$dimension;
        }else{
            return $placeholder;
        }
    }

    public function region(){
        $region = new \BitKit\Core\Entity\Prototype\Post($this->showField('region'));
        $region->getTable('regions');
        return  $region->title();
    }

    public function lawType(){
        $law_type = new \BitKit\Core\Entity\Prototype\Post($this->showField('law_type'));
        $law_type->getTable('l_law_type');
        return  $law_type->title();
    }

    public function parkingCarType(){
        $parking_type = new \BitKit\Core\Entity\Prototype\Post($this->showField('parking_car_type'));
        $parking_type->getTable('l_parkings_type');
        return  $parking_type->title();
    }


    public function direction(){
        $direction = new \BitKit\Core\Entity\Prototype\Post($this->showField('direction'));
        $direction->getTable('directions');
        return  $direction->title();
    }

    public function metroYandex(){

        $metro = new \BitKit\Core\Entity\Prototype\Post($this->showField('metro'));
        $metro->getTable('metros');
        return  $metro->showField('yandex_id');
    }

    public function metro(){
        $metro = new \BitKit\Core\Entity\Prototype\Post($this->showField('metro'));
        $metro->getTable('metros');
        return  $metro->title();
    }

    public function village(){
        $village = new Post($this->showField('village'));
        $village->getTable('villages');
        return  $village->title();
    }

    public function highway(){
        $highway = new \BitKit\Core\Entity\Prototype\Post($this->showField('highway'));
        $highway->getTable('highways');
        return  $highway->title();
    }

    public function railwayStation(){
        $railwayStation = new \BitKit\Core\Entity\Prototype\Post($this->showField('railway_station'));
        $railwayStation->getTable('c_railway_station');
        return  $railwayStation->title();
    }

    public function fromMkad(){
        if($this->showField('from_mkad')){
            return $this->showField('from_mkad');
        }else{
            return false;
        }

    }

    public function clientId(){
        return  $this->showField('clyent_id');
    }

    public function ownerPerson(){
        $owner = new \BitKit\Core\Entity\Prototype\Post($this->showField('clyent_id'));
        $owner->getTable('c_industry_customers');
        return  $owner->title();
    }

    public function ownerPersonPosition(){
        $owner = new Member($this->showField('clyent_id'));
        return  $owner->group_name();
    }

    public function ownerPhone(){
        $owner = new \BitKit\Core\Entity\Prototype\Post($this->showField('clyent_id'));
        $owner->getTable('c_industry_customers');
        return  $owner->showField('c_phone');
    }

    public function ownerCompany(){
        $owner = new \BitKit\Core\Entity\Prototype\Post($this->showField('clyent_id'));
        $owner->getTable('c_industry_customers');
        return  $owner->showField('c_company');
    }

    public function ventilationType()
    {
        $ventilation = new \BitKit\Core\Entity\Prototype\Post($this->showField('ventilation'));
        $ventilation->getTable('l_ventilations');
        return $ventilation->title();
    }

    public function internetType()
    {
        $internet = new \BitKit\Core\Entity\Prototype\Post($this->showField('internet'));
        $internet->getTable('l_internet');
        return $internet->title();
    }

    public function telType()
    {
        $tel = new \BitKit\Core\Entity\Prototype\Post($this->showField('telephony'));
        $tel->getTable('l_telecommunications_retail');
        return $tel->title();
    }

    public function waterType()
    {
        $water = new \BitKit\Core\Entity\Prototype\Post($this->showField('water'));
        $water->getTable('l_waters');
        return $water->title();
    }

    public function heatType()
    {
        $heating = new \BitKit\Core\Entity\Prototype\Post($this->showField('heating'));
        $heating->getTable('l_heatings');
        return $heating->title();
    }

    public function firefightingType()
    {
        $firefighting = new Post($this->showField('firefighting'));
        $firefighting->getTable('l_firefighting');
        return $firefighting->title();
    }

    public function entranceType()
    {
        $entry = new \BitKit\Core\Entity\Prototype\Post($this->showField('entry_territory'));
        $entry->getTable('l_entry_territory');
        return $entry->title();
    }

    public function facingType()
    {
        $facing = new \BitKit\Core\Entity\Prototype\Post($this->showField('facing_type'));
        $facing->getTable('l_facing_types');
        return $facing->title();
    }

    public function guardType()
    {
        $guard = new \BitKit\Core\Entity\Prototype\Post($this->showField('guard'));
        $guard->getTable('l_guards_industry');
        return $guard->title();
    }

    public function sewageType()
    {
        $sewage = new \BitKit\Core\Entity\Prototype\Post($this->showField('sewage'));
        $sewage->getTable('l_sewages');
        return $sewage->title();
    }

    public function author(){
        return $this->showField('author');
    }



    public function purposes(){
        return  json_decode($this->showField('purposes'));
    }

    public function dealTypes(){
        return  json_decode($this->showField('deal_type'));
    }

    public function status(){
        $status = new \BitKit\Core\Entity\Prototype\Post($this->showField('item_status'));
        $status->getTable('items_status');
        return $status->title();
    }

    public function subItems(){
        $sql = $this->pdo->prepare("SELECT * FROM c_industry_blocks WHERE deleted !='1' AND result='5' AND parent_id=".$this->itemId());
        $sql->execute();
        return $sql->fetchAll();
    }

    public function getObjectOffers(){
        $sql = $this->pdo->prepare("SELECT * FROM c_industry_offers WHERE object_id='".$this->itemId()."' ");
        $sql->execute();
        return $sql->fetchAll();
    }

    public function getObjectMinArea(){
        $min_area = 99999999999999999;
        foreach ($this->subItems() as $subItem) {
            if($min_area > $subItem['area']){
                $min_area = $subItem['area'];
            }
            return $min_area;
        }
    }



    //ТУТ НУЖНО БРАТЬ ПОТОМ НОРМАЛЬНУЮ ЦЕНУ А НЕ ТУ ИЛИ ТУ
    public function getObjectMinPrice(){
        $min_price = 99999999999999999;
        foreach ($this->subItems() as $subItem) {
            if($min_price > $subItem['rent_price']){
                $min_price = $subItem['rent_price'];
            }
            return $min_price;
        }
    }

    public function hasSubItems(){
        if($this->subItems() != NULL){
            return true;
        }else{
            return false;
        }
    }

    public function photo(){
        return $this->photos()[0];
    }

    public function photoCount(){
        return count($this->photos());
    }

    public function thumbs(){
        return json_decode($this->showField('thumbs'));
    }

    public function publTime(){
        return $this->showField('dt_insert');
        //return $this->showField('publ_time');
    }

    public function lastUpdate(){
        //return $this->showField('last_update');
        return $this->showField('dt_update');
    }

    public function timeFormat(int $time){
        return date_format_rus($time);
    }


    public function thumb(){
        //return $this->thumbs()[0];
        return 'http://www.sklad-man.ru/uploads/images/sklad666.jpg';
    }

    public function agentVisit(){
        return $this->showField('agent_visited');
    }

    public function description(){
        return $this->showField('description');
    }

    public function createUpdate(){
        $line1 = '';
        $line2 = '';
        $line_update= '';
        $publ_time = time();
        $activity = 1;
        $uploaddir = DOMAIN . 'uploads/'; //папка для загрузки
        $table_name=$this->table;
        $id_num=$this->id;

        $arr_isset = array();
        $par_arr = $this->getAllFields();
        unset($par_arr[array_search('description', $par_arr)]);


        /* search for values in $_POST array and create array of values */
        foreach($par_arr as $arr_item){
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
        /* get INSERT and UPDATE lines */
        foreach($arr_isset as $key=>$value){
            $line1 = $line1.$key.', ';
            $line2 = $line2."'".addslashes($value)."'".', ';
            $line_update = $line_update." "."$key = '$value',";
        }

        //смотрим информацию о посте, если он есть
        $post_sql=$this->mysqli->prepare("SELECT * FROM $table_name WHERE id=?");
        $post_sql->bind_param('i', $this->id);
        $post_sql->execute();
        $src = $post_sql->get_result()->fetch_assoc();
        echo $src['title'];

//////Загрузка вторичного изображения;
        if($_FILES['file']['name'] == NULL){
            $photo_small = $src['photo_small'];
            if($this->table == 'items' || $this->table == 'database_records'){//для тамбов
                $thumb_small = $src['thumb_small'];
            }
        }else{
            if(file_exists($_SERVER["DOCUMENT_ROOT"]. DOMAIN .$this->photo_small())){
                unlink($_SERVER["DOCUMENT_ROOT"]. DOMAIN .$this->photo_small());
            }
            if(file_exists($_SERVER["DOCUMENT_ROOT"]. DOMAIN .$this->thumb_small())){
                unlink($_SERVER["DOCUMENT_ROOT"]. DOMAIN .$this->thumb_small());
            }
            $time = time();
            if($this->table == 'uploads'){
                $ext = '.'.$_POST['upload_type'];
            }else{
                if(preg_match('/[.](jpg)$/', $_FILES['file']['name'])) {
                    $ext = '.jpg';
                } elseif (preg_match('/[.](gif)$/', $_FILES['file']['name'])) {
                    $ext = '.gif';
                } elseif (preg_match('/[.](png)$/', $_FILES['file']['name'])) {
                    $ext = '.png';
                }
            }
            $file_sec_new_name = md5($_FILES['file']['name'].$time).$ext;
            $uploadfile_sec = $uploaddir.$file_sec_new_name;
            echo $_SERVER['DOCUMENT_ROOT'].$uploadfile_sec;
            if(move_uploaded_file($_FILES['file']['tmp_name'], $_SERVER['DOCUMENT_ROOT'].$uploadfile_sec)){
                $photo_small = '/uploads/'.$file_sec_new_name;
                if($this->table == 'items' || $this->table == 'database_records'){//для тамбов
                    createThumbnail($file_sec_new_name);
                    $thumb_small =  '/uploads/'.'thumb_'.$file_sec_new_name;
                }
                echo "Загрузили";

            }else{
                echo "не Загрузили";
            }
        }
//////Загрузка вторичного изображения;

//////Загрузка основных изображений;
        $photo = array();
        if($_FILES['files']['name'][0] == NULL){
            $photo = $src['photo'];
            if($this->table == 'items' || $this->table == 'database_records'){//для тамбов
                $thumbs = $src['thumbs'];
            }
        }else{
            //удаляем фотки и строку
            $photos_old = unserialize($src['photo']);
            foreach($photos_old as $photo_old){
                if(file_exists($_SERVER["DOCUMENT_ROOT"]. DOMAIN .$photo_old)){
                    unlink($_SERVER["DOCUMENT_ROOT"]. DOMAIN .$photo_old);
                }
            }
            if($this->table == 'items' || $this->table == 'database_records'){//для тамбов
                //удаляем thumbnails
                $thumbs_old = unserialize($src['thumbs']);
                foreach($thumbs_old as $thumb_old){
                    if(file_exists($_SERVER["DOCUMENT_ROOT"]. DOMAIN . $thumb_old)){
                        unlink($_SERVER["DOCUMENT_ROOT"]. DOMAIN . $thumb_old);
                    }
                }
            }
            //загружаем новые и создаем ссылки
            for($i =0; $i < 10;$i++){
                $time = time();
                if(preg_match('/[.](jpg)$/', $_FILES['files']['name'][$i])) {
                    $ext = '.jpg';
                } elseif (preg_match('/[.](gif)$/', $_FILES['files']['name'][$i])) {
                    $ext = '.gif';
                } elseif (preg_match('/[.](png)$/', $_FILES['files']['name'][$i])) {
                    $ext = '.png';
                }
                $file_new_name = md5($_FILES['files']['name'][$i].$time).$ext;
                $uploadfile = $uploaddir.$file_new_name;
                if (move_uploaded_file($_FILES['files']['tmp_name'][$i], $_SERVER['DOCUMENT_ROOT'].$uploadfile)) {
                    //$photo[$i] = $uploadfile;
                    $photo[$i] = '/uploads/'.$file_new_name;
                    if($this->table == 'items' || $this->table == 'database_records'){//для тамбов
                        createThumbnail($file_new_name);
                        $thumb[$i] =  '/uploads/'.'thumb_'.$file_new_name;
                    }
                }else {}
            }
            $photo = serialize($photo);
            if($this->table == 'items' || $this->table == 'database_records'){
                $thumbs = serialize($thumb);
            }
        }


        //если PHP то создаем файл с кодом и записываем его название в title
        if($src['block_name'] || $_POST['category'] == 'php'){
            if($src['block_name']){//если редактируем блок и унего есть имя блока(значит это PHP)
                $file = $src['block_name']; //сохраняем имя файла
                if(file_exists($_SERVER["DOCUMENT_ROOT"].'/blocks/'.$file)){
                    unlink($_SERVER["DOCUMENT_ROOT"].'/blocks/'.$file); //удаляем файл далее создадим новый с тем же именем
                }
            }
            /* else{
              $file = str_replace(" ","_",$_POST['title']).'_'.md5(time().$_POST['title']).'.php'; //генирируем имя файля
            } */
            $file = str_replace(" ","_",$_POST['title']).'_'.md5(time().$_POST['title']).'.php'; //генирируем имя файля
            $blocks_dir = $_SERVER["DOCUMENT_ROOT"].'/blocks/'; //папка в которой будет создаваться блок
            if (!file_exists($file)) {
                $fp = fopen($blocks_dir.$file, "w"); // ("r" - считывать "w" - создавать "a" - добовлять к тексту),мы создаем файл
                fwrite($fp, $_POST['description']);
                fclose($fp);
            }
            $bl_name_field = ', block_name';
            $bl_name_value = ",  '$file'";
            $bl_upd = "block_name = '$file',";

        }

        ($this->table == 'blocks') ? $description = addslashes($_POST['description'])  :  $description = addslashes($_POST['description']);

        //если это тема то создаем файл CSS с кодом и записываем его название в title
        if($this->setTable() == 'themes'){
            echo "Таблицу определтли<br>";
            if($src['css_name']){//если редактируем тему
                $fileCss = $src['css_name']; //сохраняем имя файла
                $theme_content = $_POST['description'];
                echo "Редактируем....берем содержимое текстового поля<br>";
                if(file_exists($_SERVER["DOCUMENT_ROOT"].'/css/'.$fileCss)){
                    unlink($_SERVER["DOCUMENT_ROOT"].'/css/'.$fileCss); //удаляем файл далее создадим новый с тем же именем
                }
            }else{
                $theme_content = file_get_contents($_SERVER["DOCUMENT_ROOT"].'/css/style.css');
            }


            $fileCss = str_replace(" ","_",$_POST['title']).'_'.md5(time().$_POST['title']).'.css'; //генирируем имя файля
            $css_dir = '/css/'; //папка в которой будет создаваться .css файл
            if (!file_exists($fileCss)) {
                $fp = fopen($_SERVER["DOCUMENT_ROOT"].$css_dir.$fileCss, "w");
                echo $_SERVER["DOCUMENT_ROOT"].$css_dir.$fileCss;// ("r" - считывать "w" - создавать "a" - добовлять к тексту),мы создаем файл
                if(fwrite($fp, $theme_content)){
                    fclose($fp);
                    echo "Файл не существует и его создаем<br>";
                }
            }

            $bl_name_field = ', css_name';
            $bl_name_value = ",  '$fileCss'";
            $bl_upd = "css_name = '$fileCss',";
            $description = str_replace("'",'"',$theme_content);
        }
        //Создание хэша страниц
        if($this->table == 'pages'){
            $page_hash_field = ', page_hash';
            $page_hash_val = ", '".md5($_POST['title'].time())."'";
        }
        //Записываем thumbs
        if($this->table == 'items' || $this->table == 'database_records'){
            $thumbs_field = ', thumbs, thumb_small';
            $thumbs_val = ", '$thumbs', '$thumb_small'";
            $thumbs_upd = "thumbs='$thumbs', thumb_small='$thumb_small',";
        }
        //записывае FURL
        if($this->table == 'pages' || $this->table == 'items'  || $this->table == 'database_records'){
            if($_POST['furl'] == NULL || $_POST['furl'] == ' ' || $_POST['furl'] == ''){
                $furl = furl_create($_POST['title']);
            }else{
                $furl = $_POST['furl'];
            }
            $furl_field = ', furl';
            $furl_value = ",  '$furl'";
        }

        $line1 = $line1.'activity, publ_time, photo, photo_small, description'.$thumbs_field.$bl_name_field.$page_hash_field.$furl_field;
        $line2 = $line2."'$activity', "."'$publ_time', "."'$photo', "."'$photo_small' , "."'$description'".$thumbs_val.$bl_name_value.$page_hash_val.$furl_value;
        $line_update = $line_update." photo ='$photo', photo_small ='$photo_small', $bl_upd $thumbs_upd description ='$description'";


        if($this->id > 0){
            /* Запрос обновления */
            $sql = "UPDATE $this->table SET $line_update WHERE id='$id_num'";
        }else{
            /* запрос создания */
            $sql = "INSERT INTO $this->table(".$line1.")"."VALUES(".$line2.")";
        }

        try {
            $post_sql = $this->mysqli->prepare($sql);
            $post_sql->execute();
            //echo "good";
        }catch (Exception $e) {
            echo 'Подключение не удалось: ' . $e->getMessage();
        }

    }

    public function metaTitle(){
        if($this->showField('content_title')){
            return $this->showField('content_title');
        }else{
            return $this->showField('title');
        }
    }

    public function metaKeywords(){
        if($this->showField('content_keywords')){
            return $this->showField('content_keywords');
        }else{
            return $this->showField('title');
        }
    }

    public function metaDescription(){
        if($this->showField('content_description')){
            return $this->showField('content_description');
        }else{
            return $this->showField('title');
        }
    }

    public function metaIcon(){
        return unserialize($this->showField('photo'))[0];
    }



    public function price(){
        return $this->showField('price');
    }

    public function articul(){
        return $this->showField('articul');
    }

    public function pack(){
        return $this->showField('pack');
    }

    public function sale(){
        return $this->showField('sale');
    }

    public function discount(){
        return $this->showField('discount');
    }

    public function size(){
        return $this->showField('size');
    }

    public function color(){
        return $this->showField('color');
    }


}

