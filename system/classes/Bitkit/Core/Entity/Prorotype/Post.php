<?
namespace BitKit\Core\Entity\Prototype;
class Post extends Unit
{
    protected $table;
    protected $author;

    public function getTable($table){
        $tables = new \Table(0);
        if(in_array($table,$tables->getAllTables('pennylane'))){
            $this->table = $table;
        }
    }

    public function setTable(){
        return $this->table;
    }

    public function currentUser(){
        $member = new \Member($_COOKIE['member_id']);
        return $member->member_id();
    }

    public function hasField($field_name){
        if(in_array($field_name,$this->getTableColumnsNames())){
            return true;
        }else{
            return false;
        }
    }

    public function setAuthor(){
        $this->author =  $this->currentUser();
    }

    public function permissions(){
        return json_decode($this->showField('permissions'));
    }

    public function canSee(){
        $user = new \Member($_COOKIE['member_id']);
        if(in_array($user->group_id(),$this->permissions())){
            return true;
        }else{
            return false;
        }
    }


    public function createUpdate(){
        $fields_array = array();
        $values_array = array();
        $publ_time = time();
        $uploaddir = '/uploads/'; //папка для загрузки

        //Создаем папку катеогии если она не существует
        $dir = new \Table(0);
        $dir->getTableByName($this->setTable());
        $new_dir = $uploaddir.$dir->showField('table_directory');
        if (!file_exists($new_dir) && !is_dir($new_dir)) {
            mkdir($new_dir);
        }

        //Создаем папку поста если она не существует
        if($this->postId()){
            $id = $this->postId();
        }else{
            $id = $this->getMaxId()+1;
        }
        $new_dir_item = $new_dir.'/'.$id;
        if (!file_exists($new_dir_item) && !is_dir($new_dir_item)) {
            mkdir($new_dir_item);
        }

        $arr_isset = array();

        $par_arr = $this->getTableColumnsNames();
        unset($par_arr[array_search('description', $par_arr)]);

        /* search for values in $_POST array and create array of values */
        foreach($par_arr as $arr_item){
            if($_POST[$arr_item] != NULL){
                if(is_array($_POST[$arr_item])){ //проверяем не массив ли это
                    $arr_isset[$arr_item] = json_encode($_POST[$arr_item], JSON_UNESCAPED_UNICODE);
                }else{
                    if($arr_item == 'password'){
                        $arr_isset[$arr_item] = crypt($_POST[$arr_item]); //криптуем пароль
                    }else{
                        $arr_isset[$arr_item] = $_POST[$arr_item];
                    }
                }
            }

            if($_FILES[$arr_item]){
                if($_FILES[$arr_item]['name'][0]){
                    if($this->showJsonField($arr_item)){
                        $have_yet = $this->showJsonField($arr_item);
                    }else{
                        $have_yet = array();
                    }

                    /*
                    foreach($this->showField($arr_item) as $file_old){
                        if(file_exists($_SERVER["DOCUMENT_ROOT"].$file_old)){
                            unlink($_SERVER["DOCUMENT_ROOT"].$file_old);
                        }
                    }
                    */
                    //загружаем новые и создаем ссылки
                    for($i = 0; $i < count($_FILES[$arr_item]['name']);$i++){
                        $file_new_name = md5($_FILES[$arr_item]['name'][$i].$publ_time).$this->findExtention($_FILES[$arr_item]['name'][$i]);
                        $uploadfile = $new_dir_item.'/'.$file_new_name;
                        echo $uploadfile.'<br>';
                        if (move_uploaded_file($_FILES[$arr_item]['tmp_name'][$i], $_SERVER['DOCUMENT_ROOT'].$uploadfile)) {
                            $files[$i] = $new_dir_item.'/'.$file_new_name;
                            echo 'файл загружен';
                            array_push($have_yet,$files[$i]);
                        }
                    }
                    $arr_isset[$arr_item] = json_encode($have_yet);
                }
            }
        }


        /* get INSERT and UPDATE lines */
        foreach($arr_isset as $key=>$value){
            array_push($fields_array,$key);
            array_push($values_array,$value);
        }


        //смотрим информацию о посте, если он есть
        $src = $this->show();

        //если PHP то создаем файл с кодом и записываем его название в title
        if($src['block_name'] || $_POST['block_type'] == 'php'){
            $blocks_dir = $_SERVER["DOCUMENT_ROOT"].'/blocks/'; //папка в которой будет создаваться блок

            if($src['block_name']){//если редактируем блок и унего есть имя блока(значит это PHP)
                $file = $src['block_name']; //сохраняем имя файла
            }else{
                $file = str_replace(" ","_",$_POST['title']).'_'.md5(time().$_POST['title']).'.php'; //генирируем имя файля
            }

            $fp = fopen($blocks_dir.$file, "w"); // ("r" - считывать "w" - создавать "a" - добовлять к тексту),мы создаем файл
            fwrite($fp, $_POST['description']);
            fclose($fp);

            array_push($fields_array,'block_name');
            array_push($values_array,$file);

        }

        ($this->setTable() == 'blocks') ? $description = addslashes($_POST['description'])  :  $description = addslashes($_POST['description']);

        //если это тема то создаем файл CSS с кодом и записываем его название в title
        if($this->setTable() == 'themes'){
            if($src['css_name']){//если редактируем тему
                $file = $src['css_name']; //сохраняем имя файла
                $theme_content = $_POST['description'];
                /**
                 * Редактируем....берем содержимое текстового поля
                 **/
            }else{
                $theme_content = file_get_contents($_SERVER["DOCUMENT_ROOT"].'/css/style.css');
                $file = str_replace(" ","_",$_POST['title']).'_'.md5(time().$_POST['title']).'.css'; //генирируем имя файля
            }

            $css_dir = '/css/'; //папка в которой будет создаваться .css файл

            $fp = fopen($_SERVER["DOCUMENT_ROOT"].$css_dir. $file, "w");
            if(fwrite($fp, $theme_content)){
                fclose($fp);
            }

            $description = str_replace("'",'"',$theme_content);

            array_push($fields_array,'css_name');
            array_push($values_array,$file);
        }
        //Создание хэша страниц
        if($this->hasField('page_hash')){
            array_push($fields_array,'page_hash');
            array_push($values_array,md5($_POST['title'].time()));
        }

        //Записываем thumbs
        if($this->setTable() == 'items' || $this->setTable() == 'database_records'){
            //array_push($fields_array,'thumbs');
            //array_push($values_array,$thumbs);
        }

        if($this->author){
            array_push($fields_array,'author');
            array_push($values_array,$this->author);
        }

        array_push($fields_array,'description');
        array_push($values_array,addslashes($_POST['description']));
        /*
        //записывае FURL
        if($this->hasField('furl')){
            if($_POST['furl'] == NULL || $_POST['furl'] == ' ' || $_POST['furl'] == ''){
                $furl = furl_create($_POST['title']);
            }else{
                $furl = $_POST['furl'];
            }
            $furl_field = ', furl';
            $furl_value = ",  '$furl'";
        }
        */

        if($this->postId() > 0){
            /* Запрос обновления */
            $this->updateLine($fields_array, $values_array);
        }else{
            /* запрос создания */
            $this->createLine($fields_array, $values_array);
        }
    }

    public function createThumbnail($filename) {

        $final_width_of_image = 700;
        $path_to_image_directory = $_SERVER["DOCUMENT_ROOT"].'/'.PHOTO_FOLDER.'/'; //Папка, куда будут загружаться полноразмерные изображения
        $path_to_thumbs_directory = $_SERVER["DOCUMENT_ROOT"].'/'.PHOTO_FOLDER.'/';//Папка, куда будут загружаться миниатюры

        if(preg_match('/[.](jpg)$/', $filename)) {
            $im = imagecreatefromjpeg($path_to_image_directory . $filename);
        } else if (preg_match('/[.](gif)$/', $filename)) {
            $im = imagecreatefromgif($path_to_image_directory . $filename);
        } else if (preg_match('/[.](png)$/', $filename)) {
            $im = imagecreatefrompng($path_to_image_directory . $filename);
        }
        //Определяем формат изображения

        //Получаем высоту и ширину исходного изображения
        $ox = imagesx($im);
        $oy = imagesy($im);
        echo "Ширина: ".$ox;
        //задаем размеры холста
        $nx = $final_width_of_image;
        $ny = floor($oy * ($final_width_of_image / $ox));

        $nm = imagecreatetruecolor($nx, $ny); //создаем новый холст с заданными параметрами
        imagecopyresized($nm, $im, 0,0,0,0,$nx,$ny,$ox,$oy); //переносим исходник на холст
        imagejpeg($nm, $path_to_thumbs_directory .'thumb_'.$filename);
    }



    public function delete()
    {
        //if(in_array($this->table, $WHITE_LIST))
        if(1)
        {
            $post_info = $this->show();

            foreach($post_info as $colVal){
                if(file_exists($_SERVER["DOCUMENT_ROOT"].$colVal) && $colVal !='')
                {
                    unlink($_SERVER["DOCUMENT_ROOT"].$colVal);
                }
                if(is_array(json_decode($colVal)))
                {
                    $photos = json_decode($colVal);
                    foreach($photos as $photo){
                        unlink($_SERVER["DOCUMENT_ROOT"].$photo);
                    }
                }
                /* ищем есть ли поле с названием block_name у данного поста */
                if(array_search($colVal, $post_info) == 'block_name')
                {
                    unlink($_SERVER["DOCUMENT_ROOT"].'/blocks/'.$colVal);
                }
                if(array_search($colVal, $post_info) == 'css_name')
                {
                    unlink($_SERVER["DOCUMENT_ROOT"].'/css/'.$colVal);
                }
            }

            $this->deleteLine();
        }
    }


    public function filesChange(string $field, string $files ){

        if($_GET['action'] == 'delete'){
            $photo = parse_url($files);
            $photo = $photo['path'];
            $all_photos = $this->photos();
            $all_thumbs = $this->thumbs();
            unset($all_photos[array_search($photo, $all_photos)]);
            //unset($all_thumbs[array_search('thumb_'.explode('/',$photo)[2], $all_thumbs)]);
            sort($all_photos);
            //sort($all_thumbs);
            if(file_exists($_SERVER["DOCUMENT_ROOT"].$photo)){
                unlink($_SERVER["DOCUMENT_ROOT"].$photo);
                echo "Фото удалено / ";
            }
            /*
            if(file_exists($_SERVER["DOCUMENT_ROOT"].'/uploads/thumb_'.explode('/',$photo)[2])){
                unlink($_SERVER["DOCUMENT_ROOT"].'/uploads/thumb_'.explode('/',$photo)[2]);
                echo "Thumbnail удалено / ";
            }
            */
        }else{
            $files = substr($files,0,-1);//удалям последнюю запятую
            echo $files;
            $all_files = explode(",",$files); //создаем массив фоток ссылок
            /*
            foreach($all_files as $key=>$value){
                $all_files[$key] = parse_url($value)['path'];
                //$all_files[$key] = parse_url($value)['path'];
                //$all_thumbs[$key] = '/uploads/thumb_'.explode('/',$all_photos[$key])[2];
            }
            */

        }
        var_dump($all_files);
        $files_string = json_encode($all_files); // сериализуем
        //$thumb_string = json_encode($all_thumbs); // сериализуем
        $files_update_sql = "UPDATE $this->table SET $field='$files_string' WHERE id=:id";
        //$thumb_update_sql = "UPDATE $this->table SET thumbs='$thumb_string ' WHERE id=?";

        try {
            $update = $this->pdo->prepare($files_update_sql);
            $update->bindParam(":id", $this->id);
            $update->execute();
            echo "Порядок фото обновлен";
        }catch (\Exception $e) {
            echo 'Подключение не удалось: ' . $e->getMessage();
        }
        /*
        try {
            $update = $this->mysqli->prepare($thumb_update_sql);
            $update->bind_param("i", $this->id);
            $update->execute();
            echo "Порядок фото обновлен";
        }catch (Exception $e) {
            echo 'Подключение не удалось: ' . $e->getMessage();
        }
        */
    }

    public function fileDelete(string $field, string $file ){

        $all_files = $this->showJsonField($field); //take all file from the field we choose
        unset($all_files[array_search($file, $all_files)]); //delete element from array by value
        sort($all_files); //sort an array in order to escape errors with json encoding
        if(file_exists($_SERVER["DOCUMENT_ROOT"].$file)){ //delete file
            unlink($_SERVER["DOCUMENT_ROOT"].$file);
            echo "Файл удален / ";
        }

        $files_string = json_encode($all_files); // json encoding
        $files_update_sql = "UPDATE $this->table SET $field='$files_string' WHERE id=:id";

        try {
            $update = $this->pdo->prepare($files_update_sql);
            $update->bindParam(":id", $this->id);
            $update->execute();
            echo "Порядок файлов обновлен";
        }catch (\Exception $e) {
            echo 'Подключение не удалось: ' . $e->getMessage();
        }
    }

    /*
    public function photoChange(string $photo){

        if($_GET['action'] == 'delete'){
            $photo = parse_url($photo);
            $photo = $photo['path'];
            $all_photos = $this->photos();
            $all_thumbs = $this->thumbs();
            unset($all_photos[array_search($photo, $all_photos)]);
            unset($all_thumbs[array_search('thumb_'.explode('/',$photo)[2], $all_thumbs)]);
            sort($all_photos);
            sort($all_thumbs);
            if(file_exists($_SERVER["DOCUMENT_ROOT"].$photo)){
                unlink($_SERVER["DOCUMENT_ROOT"].$photo);
                echo "Фото удалено / ";
            }
            if(file_exists($_SERVER["DOCUMENT_ROOT"].'/uploads/thumb_'.explode('/',$photo)[2])){
                unlink($_SERVER["DOCUMENT_ROOT"].'/uploads/thumb_'.explode('/',$photo)[2]);
                echo "Thumbnail удалено / ";
            }
        }else{
            $photo = substr($photo,0,-1);//удалям последнюю запятую
            $all_photos = explode(",",$photo); //создаем массив фоток ссылок
            foreach($all_photos as $key=>$value){
                $all_photos[$key] = parse_url($value)['path'];
                $all_thumbs[$key] = '/uploads/thumb_'.explode('/',$all_photos[$key])[2];
            }

        }
        $photo_string = json_encode($all_photos); // сериализуем
        $thumb_string = json_encode($all_thumbs); // сериализуем
        $photo_update_sql = "UPDATE $this->table SET photo='$photo_string ' WHERE id=?";
        $thumb_update_sql = "UPDATE $this->table SET thumbs='$thumb_string ' WHERE id=?";

        try {
            $update = $this->mysqli->prepare($photo_update_sql);
            $update->bind_param("i", $this->id);
            $update->execute();
            echo "Порядок фото обновлен";
        }catch (Exception $e) {
            echo 'Подключение не удалось: ' . $e->getMessage();
        }

        try {
            $update = $this->mysqli->prepare($thumb_update_sql);
            $update->bind_param("i", $this->id);
            $update->execute();
            echo "Порядок фото обновлен";
        }catch (Exception $e) {
            echo 'Подключение не удалось: ' . $e->getMessage();
        }
    }*/

    public function findExtention($file){
        if(preg_match('/[.](jpg)$/', $file)) {
            $ext = '.jpg';
        } elseif (preg_match('/[.](gif)$/', $file)) {
            $ext = '.gif';
        } elseif (preg_match('/[.](png)$/', $file)) {
            $ext = '.png';
        }else{
            $ext = '.jpg';
        }
        return $ext;
    }

    public function title(){
        return $this->showField('title');
    }

    public function rating(){
        return $this->showField('rating');
    }

    public function furl(){
        return $this->showField('furl');
    }

    public function postId(){
        return (int)$this->showField('id');
    }

    public function author(){
        return $this->showField('author');
    }

    public function supervisor(){
        return $this->showField('broker');
    }

    public function photos(){
        return json_decode($this->showField('photo'));
    }

    public function thumbs(){
        return json_decode($this->showField('thumbs'));
    }

    public function thumbSmall(){
        return json_decode($this->showField('thumb_small'));
    }

    public function photo(){
        return $this->photos()[0];
    }

    public function photoSmall(){
        return $this->showField('photo_small');
    }


    public function thumbnail(){
        return $this->showField('photo_small');
    }

    public function publTime(){
        return date_format_rus($this->showField('publ_time'));
    }

    public function lastUpdate(){
        return date_format_rus($this->showField('update_time'));
    }

    public function price(){
        return $this->showField('price');
    }

    public function articul(){
        return $this->showField('articul');
    }

    public function isActive(){
        if($this->showField('activity') == 1){
            return true;
        }else{
            return false;
        }
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

    public function description(){
        return $this->showField('description');
    }

    public function collection(){
        return $this->showField('collection');
    }
    
}

