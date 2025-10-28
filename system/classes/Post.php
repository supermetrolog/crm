<?

class Post extends Unit
{
    protected $table;
    protected $author;

    //Получаем таблицу поста с которой работать и ее проверяем
    public function getTable($table)
    {
        $tables = new Table(0);
        if (in_array($table, $tables->getAllTables(DB_NAME))) {
            $this->table = $table;
        }
    }

    //выозвращаем имя базы при подключении к БД
    public function setTable()
    {
        return $this->table;
    }


    //Возвращаем ID таблицы поста
    public function setTableId()
    {
        $table = new Table(0);
        $table->getTableByName($this->setTable());
        return $table->tableId();
    }


    public function getPostByTitle($title)
    {
        $sql = $this->pdo->prepare("SELECT * FROM " . $this->setTable() . " WHERE title=:title  LIMIT 1");
        $sql->bindParam(':title', $title);
        $sql->execute();
        $unit = $sql->fetch(PDO::FETCH_LAZY);
        $this->id = $unit->id;
    }

    public function getPostByField($field, $value)
    {
        $sql = $this->pdo->prepare("SELECT * FROM " . $this->setTable() . " WHERE {$field}=:value  LIMIT 1");
        //$sql->bindParam(':field', $field);
        $sql->bindParam(':value', $value);
        $sql->execute();
        $unit = $sql->fetch(PDO::FETCH_LAZY);
        $this->id = $unit->id;
        return $this->id;
    }

    public function currentUser()
    {
        $member = new Member($_COOKIE['member_id']);
        return $member->member_id();
    }


    public function setAuthor()
    {
        if ($this->hasField('author_id')) {
            $this->author = $this->currentUser();
            return true;
        }
        return false;
    }

    public function getPostFormFields(string $form): array
    {
        $table_obj = new Table($this->setTableId());
        $forms = $table_obj->getJsonField('grid_elements_test');
        $form_data = $forms->$form;
        $fields = [];
        foreach ($form_data as $page) {
            foreach ($page[1] as $column) {
                foreach ($column[1] as $field_unit) {
                    $field = new Field($field_unit);


                    if (in_array($field->getTemplateId(), [52, 53])) {
                        $fields[] = $field->title();
                        $fields[] = $field->title() . '_type';
                        $fields[] = $field->title() . '_value';
                    } elseif (in_array($field->getTemplateId(), [51, 49])) {
                        $fields[] = $field->title();
                        $fields[] = $field->title() . '_type';
                    } elseif (in_array($field->getTemplateId(), [50])) {
                        $fields[] = $field->title();
                        $fields[] = $field->title() . '_value';
                    } elseif (in_array($field->getTemplateId(), [18])) {
                        $fields[] = $field->title() . '_min';
                        $fields[] = $field->title() . '_max';
                    } else {
                        $fields[] = $field->title();
                    }

                }
            }
        }

        return $fields;
    }

    public function permissions()
    {
        return $this->getJsonField('permissions');
    }

    public function canSee()
    {
        $user = new Member($_COOKIE['member_id']);
        if (in_array($user->group_id(), $this->permissions())) {
            return true;
        } else {
            return false;
        }
    }

    public function getPostDir()
    {
        $dir = new Table($this->setTableId());
        return $dir->getField('table_directory') . '/' . $this->postId();
    }

    public function getThumbs($field)
    {
        $originals = $this->getJsonField($field);
        $thumbs = [];
        foreach ($originals as $photo) {
            $name = $this->getFilePureName($photo);
            //$ext = $this->getFileExtension($photo);
            $ext = '.jpg';

            $thumb = '/uploads/' . $this->getPostDir() . '/thumbs/' . $name . $ext;
            $thumbs[] = $thumb;
        }
        return $thumbs;
    }

    public function getThumbPreview($field)
    {
        return $this->getThumbs($field)[0];
    }

    public function getImagesMarked($field)
    {
        $originals = $this->getJsonField($field);
        $thumbs = [];
        foreach ($originals as $photo) {
            $name = $this->getFilePureName($photo);
            $ext = $this->getFileExtension($photo);

            $thumb = '/uploads/' . $this->getPostDir() . '/marked/' . $name . $ext;
            $thumbs[] = $thumb;
        }
        return $thumbs;
    }

    public function canCreate()
    {
        $user = new Member($_COOKIE['member_id']);
        if ($user->is_valid()) {
            return true;
        } else {
            return false;
        }
    }

    public function canEdit()
    {
        $user = new Member($_COOKIE['member_id']);
        if ($user->isAdmin() || $user->member_id() == $this->getAuthor()) {
            return true;
        } else {
            return false;
        }
    }


    public function sendNotificationTelegram($topic, $members)
    {
        //сюда вставить код для отправки сообщений  втелегрма юзеру
        $author = new Member($this->getAuthor());
        foreach ($members as $destination_id) {
            $destination_user = new Member($destination_id);
            $telegram = new Bitkit\Social\Telegram('736512998:AAGIlIPVdPdrffvQRmh1Kwoj2_isbvYUKc4');
            $message = "$topic от <b>" . $author->getField('title') . '</b>:';
            $telegram->sendMessage($message, $destination_user->getField('telegram_id'));

            $message = trim('<b>' . $this->title() . '</b>');
            $telegram->sendMessage($message, $destination_user->getField('telegram_id'));
        };
    }


    public function hasDeal()
    {
        if ($this->setTableId() == 11) {
            return (new Subitem($this->id))->hasDeal();
        } elseif ($this->setTableId() == 35) {
            return (new Part($this->id))->hasDeal();
        } else {
            return false;
        }
    }

    public function createUpdate()
    {

        $sendUser = new Member(141);
        $telegram = new Bitkit\Social\Telegram('736512998:AAGIlIPVdPdrffvQRmh1Kwoj2_isbvYUKc4');

        //Если айди есть то обновляем иначе создаем и получаем id
        if ($this->postId()) {
            $id = $this->postId();
        } else {
            $id = $this->createLine([], []);
        }


        //экземпляр класса пост
        $post = new Post($id);
        $post->getTable($this->setTable());

        //время записи
        $publ_time = time();


        //Определяем папку сущности
        $dir = new Table(0);
        $dir->getTableByName($this->setTable());
        $table_dir = UPLOAD_DIR . $dir->getField('table_directory');

        //Создаем папку сущности если она не существует
        if (!file_exists($table_dir) && !is_dir($table_dir)) {
            mkdir(PROJECT_ROOT . $table_dir, 0755);
        }

        //Определяем папку поста
        $item_dir = $table_dir . '/' . $id . '/';

        //создаем папку поста если она не существует
        if (!file_exists($item_dir) && !is_dir($item_dir)) {
            mkdir(PROJECT_ROOT . $item_dir, 0755);
        }

        //echo 'Папка фото поста'.$item_dir; echo '<br>';


        //пустой массив для переданных значений
        $arr_isset = [];


        //Определяем все возможные переданные поля для таблицы
        $par_arr = $this->getTableColumnsNames();


        //удалить
        //if($_COOKIE['member_id'] == 141){
        /*
        if(1 == 2){
            if($_POST['form']){
                //массив всех ПОЛЕЙ(а не значений)   пришедших с формы
                $form_fields = $post->getPostFormFields($_POST['form']);
                $pure_arr = [];
                //если пришедшее с формы поле существует в таблице то его собираем
                foreach ($form_fields as $field){
                    if(in_array($field,$par_arr) && $field !== 'form'){
                        $pure_arr[] = $field;
                    }
                }
                $par_arr = $pure_arr;
            }
        }
        */


        //удаляем описание ибо его надо будет обработаь отдельно
        //unset($par_arr[array_search('description', $par_arr)]);

        /* search for values in $_POST array and create array of values */
        foreach ($par_arr as $arr_item) {

            $cond = isset($_POST[$arr_item]) && !in_array($arr_item, ['id', 'description']);
            //if(isset($_POST[$arr_item]) &&  !in_array($arr_item,['id','form','description'])){
            if ($cond) {

                //проверяем не массив ли это иначе кодируем в json
                if (is_array($_POST[$arr_item])) {

                    //$message = $arr_item;
                    //$telegram->sendMessage($message,$sendUser->getField('telegram_id'));
                    //тут конкретно для ворот
                    if ($arr_item == 'gates') {
                        $arr = $_POST[$arr_item];
                        foreach ($arr as $key => $value) {  //нечетные делаем как строку
                            if ($key % 2 == 0) {
                                $arr[$key] = (string)$value;
                            } else {
                                $arr[$key] = (int)$value;
                            }
                        }
                        $arr_isset[$arr_item] = json_encode($arr, JSON_UNESCAPED_UNICODE);
                    } else {
                        $arr_isset[$arr_item] = json_encode($_POST[$arr_item], JSON_UNESCAPED_UNICODE);
                    }
                } else {
                    //если поле называется password то криптуем
                    if ($arr_item == 'password') {
                        $arr_isset[$arr_item] = crypt($_POST[$arr_item]); //криптуем пароль
                    } elseif ($arr_item == 'available_from') {
                        $arr_isset[$arr_item] = strtotime($_POST[$arr_item]); //делаем время
                    } else {
                        $arr_isset[$arr_item] = trim($_POST[$arr_item]);
                    }
                }
            }


            //если были переданы файлы
            if ($_FILES[$arr_item]) {
                //если есть хоть один файл
                if ($_FILES[$arr_item]['name'][0]) {
                    //тут выод всего инфо по файлам
                    //var_dump($_FILES[$arr_item]['name']);

                    //смотрим свойства поля
                    $field = new Field(0);
                    $field->getFieldByName($arr_item);
                    //определяем директорию для данного поля внутри папки поста
                    $field_dir_value = $field->getField('field_directory');

                    //если у поля прописана папка
                    if ($field_dir_value != null) {
                        //ищем эту папку внутри папки поста
                        $field_dir = $item_dir . $field_dir_value;
                        //если папки нету то создаем
                        if (!file_exists($field_dir) && !is_dir($field_dir)) {
                            mkdir(PROJECT_ROOT . $field_dir, 0755);
                        }
                        $field_dir = $field_dir_value . '/';
                    } else {
                        $field_dir = '';
                    }

                    //если файлов много (тоесть мульти загрузка в поле) если инпутов больше 1
                    if (count($_FILES[$arr_item]['name']) > 1) {
                        //смотрим есть ли уже записанные файлы в базе для этого поля
                        if ($this->getJsonField($arr_item)) {
                            $have_yet = $this->getJsonField($arr_item);
                        } else {
                            $have_yet = [];
                        }

                        //загружаем новые и создаем ссылки
                        $files_amount = count($_FILES[$arr_item]['name']);
                        for ($i = 0; $i < $files_amount; $i++) {
                            //смотрим имя файла
                            $name = str_replace(' ', '', $this->getFileName($_FILES[$arr_item]['name'][$i]));
                            //смотрим расширение файла
                            $ext = $this->getFileExtension($_FILES[$arr_item]['name'][$i]);
                            //добавляем хэш и формируем новое имя файла
                            $file_new_name = $name . '_' . md5($_FILES[$arr_item]['name'][$i] . $publ_time) . $ext;

                            //формируем полный путь загрузки файла
                            $uploadFile = $item_dir . '/' . $field_dir . $file_new_name;
                            //фиксим двойные слэши если вдруг
                            $uploadFile = str_replace('//', '/', $uploadFile);

                            //если файл загружен по новому адресу
                            if (move_uploaded_file($_FILES[$arr_item]['tmp_name'][$i], PROJECT_ROOT . $uploadFile)) {

                                //$files[$i] = $uploadFile;
                                //$have_yet[]=$files[$i];

                                //дописываем адрес новго файла к тем что уже е сть в базе
                                $have_yet[] = $uploadFile;

                                /*

                                //если для этого поля нужно создавать тамбы
                                if($field->getField('create_thumbnails')){
                                    $thumb = new \Bitkit\Core\Files\Thumb(PROJECT_ROOT.$item_dir.'/'.$file_new_name);
                                    $thumb->generateThumb(300,300,PROJECT_ROOT.$item_dir.'/thumbs/');
                                }


                                //если для этого поля нужно создавать ЦВЗ
                                if($field->getField('create_watermarked')){
                                    $watermark = new \Bitkit\Core\Files\Watermark(PROJECT_ROOT.$item_dir.'/'.$file_new_name);
                                    $watermark->generateWatermark(300,300,PROJECT_ROOT.$item_dir.'/marked/');
                                }
                                */
                            }
                        }
                        //сохраняем все адреса файлов
                        $arr_isset[$arr_item] = json_encode($have_yet);


                    } else {
                        //для одинарных файлов

                        //определяем имя файла
                        $name = str_replace(' ', '', $this->getFileName($_FILES[$arr_item]['name']));
                        //определение расширения файла
                        $ext = $this->getFileExtension($_FILES[$arr_item]['name']);
                        //формируем новое имя файла
                        $file_new_name = $name . '_' . md5($_FILES[$arr_item]['name'] . $publ_time) . $ext;

                        //формируем полный путь загрузки файла
                        $uploadFile = $item_dir . '/' . $field_dir . $file_new_name;
                        //фиксим двойные слэши если вдруг
                        $uploadFile = str_replace('//', '/', $uploadFile);

                        //если файл загружен по новому адресу
                        if (move_uploaded_file($_FILES[$arr_item]['tmp_name'],
                            $_SERVER['DOCUMENT_ROOT'] . $uploadFile)) {


                            /*             
                            //если для этого поля нужно создавать тамбы
                            if($field->getField('create_thumbnails')){
                                $thumb = new \Bitkit\Core\Files\Thumb(PROJECT_ROOT.$item_dir.'/'.$file_new_name);
                                $thumb->generateThumb(300,300,PROJECT_ROOT.$item_dir.'/thumbs/');
                            }


                            //если для этого поля нужно создавать ЦВЗ
                            if($field->getField('create_watermarked')){
                                $watermark = new \Bitkit\Core\Files\Watermark(PROJECT_ROOT.$item_dir.'/'.$file_new_name);
                                $watermark->generateWatermark(300,300,PROJECT_ROOT.$item_dir.'/marked/');
                            }*/

                            //сохраняем все адреса файлов
                            $arr_isset[$arr_item] = $uploadFile;

                            //тут возможно надо удалять тамбы и ЦВЗ
                            //


                            //удаляем тот файл что был до этого
                            $this->fileDelete($this->getField($arr_item));
                        } else {
                            //echo 'файл не загружен';
                            //echo "Not uploaded because of error #".$_FILES[$arr_item]["error"];
                        }

                    }
                }
            }
        }


        //пустые массивы для полей и значений
        $fields_array = [];
        $values_array = [];

        /* наполняем эт и массивы переданными данными*/
        foreach ($arr_isset as $key => $value) {
            $fields_array[] = $key;
            $values_array[] = $value;
        }

        //смотрим информацию о посте, если он есть
        $src = $this->getLine();

        //если PHP то создаем файл с кодом и записываем его название в title
        if ($src['block_name'] || $_POST['block_type'] == 'php') {
            $blocks_dir = $_SERVER["DOCUMENT_ROOT"] . '/blocks/'; //папка в которой будет создаваться блок

            if ($src['block_name']) {//если редактируем блок и унего есть имя блока(значит это PHP)
                $file = $src['block_name']; //сохраняем имя файла
            } else {
                $file = str_replace(" ", "_",
                        $_POST['title']) . '_' . md5(time() . $_POST['title']) . '.php'; //генирируем имя файля
            }

            $fp = fopen($blocks_dir . $file,
                "w"); // ("r" - считывать "w" - создавать "a" - добовлять к тексту),мы создаем файл
            fwrite($fp, $_POST['description']);
            fclose($fp);

            $fields_array[] = 'block_name';
            $values_array[] = $file;

        }

        ($this->setTable() == 'blocks') ? $description = addslashes($_POST['description']) : $description = $_POST['description'];

        //если это тема то создаем файл CSS с кодом и записываем его название в title
        if ($this->setTable() == 'themes') {
            if ($src['css_name']) {//если редактируем тему
                $file = $src['css_name']; //сохраняем имя файла
                $theme_content = $_POST['description'];
                /**
                 * Редактируем....берем содержимое текстового поля
                 **/
            } else {
                $theme_content = file_get_contents(PROJECT_ROOT . '/css/style.css');
                $file = str_replace(" ", "_",
                        $_POST['title']) . '_' . md5(time() . $_POST['title']) . '.css'; //генирируем имя файля
            }

            $css_dir = '/css/'; //папка в которой будет создаваться .css файл

            $fp = fopen($_SERVER["DOCUMENT_ROOT"] . $css_dir . $file, "w");
            if (fwrite($fp, $theme_content)) {
                fclose($fp);
            }

            $description = str_replace("'", '"', $theme_content);

            $fields_array[] = 'css_name';
            $values_array[] = $file;
        }
        //Создание хэша страниц
        if ($this->hasField('page_hash')) {
            $fields_array[] = 'page_hash';
            $values_array[] = md5($_POST['title'] . time());
        }

        //Записываем thumbs
        if ($this->setTable() == 'items' || $this->setTable() == 'database_records') {
            //$fields_array[]='thumbs';
            //$values_array[]=$thumbs;
        }

        //проставляем автора поста
        if ($this->hasField('author_id')) {
            $fields_array[] = 'author_id';
            if (!$this->getField('author_id')) {
                $this->setAuthor();
                $values_array[] = $this->author;
            } else {
                $values_array[] = $this->getField('author_id');
            }
        }

        if ($_POST['address'] && $this->hasField('latitude')) {
            $url = 'https://geocode-maps.yandex.ru/1.x/?apikey=7cb3c3f6-2764-4ca3-ba87-121bd8921a4e&format=json&geocode=' . urlencode($_POST['address']);

            if ($curl = curl_init()) {
                curl_setopt($curl, CURLOPT_URL, $url);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                $out = curl_exec($curl);
                //echo $out;
                curl_close($curl);
            }

            $data = json_decode($out);

            $point = explode(' ', $data->response->GeoObjectCollection->featureMember[0]->GeoObject->Point->pos);

            $telegramAddress = new \Bitkit\Social\Telegram('736512998:AAGIlIPVdPdrffvQRmh1Kwoj2_isbvYUKc4');

            $fields_array[] = 'latitude'; 
            $values_array[] = $point[1];

            $fields_array[] = 'longitude';
            $values_array[] = $point[0];

            $telegramAddress->sendMessage( 'fdfdfd',223054377);
            $telegramAddress->sendMessage( $point[1],223054377);
            $telegramAddress->sendMessage( $point[0],223054377);
            $telegramAddress->sendMessage( $_POST['address'],223054377);
        }

        //проставляем время публикации
        if (!$this->getField('publ_time')) {
            $fields_array[] = 'publ_time';
            $values_array[] = time();
        }

        //проставляем время обновления
        if ($this->hasField('last_update')) {
            $fields_array[] = 'last_update';
            $values_array[] = time();
        }


        $fields_array[] = 'description';
        $values_array[] = addslashes($_POST['description']);
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

        if ($post_id = $post->updateLine($fields_array, $values_array)) {
            /*
            if ($this->setTable() == 'core_tasks') {
                $this->sendNotificationTelegram('Задача', $_POST['members']);
            }
            */
            return $post_id;
        }
        return 0;
    }


    public function createPhotos($par_arr)
    {

    }

    //метод для создания тамбнейлов
    public function createThumbnail($filename)
    {


        $final_width_of_image = 300;
        $path_to_image = $this->getPostFilesDir(); //Папка, куда будут загружаться полноразмерные изображения
        //echo "$path_to_image <br>";
        $path_to_thumbs = $path_to_image . 'thumbs/';//Папка, куда будут загружаться миниатюры

        if (!file_exists($path_to_thumbs) && !is_dir($path_to_thumbs)) {
            mkdir($path_to_thumbs, 0755);
        }

        $thumb_name = $this->getFilePureName($filename);
        $file_ext = trim($this->getFileExtension($filename), '.');

        if ($file_ext == 'gif') {
            $im = imagecreatefromgif(PROJECT_ROOT . $filename);
        } elseif ($file_ext == 'png') {
            $im = imagecreatefrompng(PROJECT_ROOT . $filename);
        } else {
            $im = imagecreatefromjpeg(PROJECT_ROOT . $filename);
        }
        //Определяем формат изображения

        //Получаем высоту и ширину исходного изображения
        $ox = imagesx($im);
        $oy = imagesy($im);

        //echo "Ширина: ".$ox;
        //задаем размеры холста
        $nx = $final_width_of_image;
        $ny = floor($oy * ($final_width_of_image / $ox));

        $canvas = imagecreatetruecolor($nx, $ny); //создаем новый холст с заданными параметрами
        $white = imagecolorallocate($canvas, 255, 255, 255);
        imagefill($canvas, 0, 0, $white);
        imagecopyresized($canvas, $im, 0, 0, 0, 0, $nx, $ny, $ox, $oy); //переносим исходник на холст

        imagejpeg($canvas, $path_to_thumbs . $thumb_name . '.' . $file_ext);
        //echo  $path_to_thumbs.$thumb_name.'.'.$file_ext.'<br>';
    }

    //метод для создания фотографий с ЦВЗ
    public function createMarkedImage($filename)
    {

        $path_to_image = $this->getPostFilesDir(); //Папка, куда будут загружаться полноразмерные изображения
        $path_to_marked = $path_to_image . 'marked/';//Папка, куда будут загружаться миниатюры

        if (!file_exists($path_to_marked) && !is_dir($path_to_marked)) {
            mkdir($path_to_marked, 0755);
        }

        $marked_name = $this->getFilePureName($filename);
        $file_ext = trim($this->getFileExtension($filename), '.');

        if ($file_ext == 'gif') {
            $im = imagecreatefromgif(PROJECT_ROOT . $filename);
        } elseif ($file_ext == 'png') {
            $im = imagecreatefrompng(PROJECT_ROOT . $filename);
        } else {
            $im = imagecreatefromjpeg(PROJECT_ROOT . $filename);
        }

        //Ширина оригинального изображения
        $im_width = imagesx($im);
        $im_height = imagesy($im);

        // Наложение ЦВЗ с прозрачным фоном
        imagealphablending($im, true);
        imagesavealpha($im, true);

        // Создаем ресурс изображения для нашего водяного знака
        $watermark_image = imagecreatefrompng($_SERVER['DOCUMENT_ROOT'] . '/img/watermark.png');
        //$watermark_image = imagecreatefrompng('https://cdn.freebiesupply.com/logos/large/2x/penny-lane-realty-logo-png-transparent.png');

        // Получаем значения ширины и высоты
        $watermark_width = imagesx($watermark_image);
        $watermark_height = imagesy($watermark_image);

        // Самая важная функция - функция копирования и наложения нашего водяного знака на исходное изображение
        //imagecopy($im, $watermark_image, $im_width - $watermark_width, $im_height - $watermark_height, 0, 0, $watermark_width, $watermark_height);

        for ($x = 0, $y = 0; $y < $im_height; $x = $x + $watermark_width * 3 / 2) {
            if ($x > $im_width) {
                $x = 0;
                $y = $y + $watermark_width / 2;
            }
            imagecopy($im, $watermark_image, $x, $y, 0, 0, $watermark_width, $watermark_height);
        }

        // Создание и сохранение результирующего изображения с водяным знаком
        imagejpeg($im, $path_to_marked . $marked_name . '.' . $file_ext, 60);
        // Уничтожение всех временных ресурсов
        imagedestroy($im);
        imagedestroy($watermark_image);

    }


    public function postFilesDelete()
    {
        $post_info = $this->getLine();
        $root = PROJECT_ROOT;
        foreach ($post_info as $key => $value) {
            if (is_file($root . $post_info[$key]) && file_exists($root . $post_info[$key])) {
                //delete single file
                $this->fileDelete($post_info[$key]);

                $this->fileDeleteThumb($post_info[$key]);
            }
            if (is_array($this->getJsonField($key))) {
                echo 'нашел кучу файлов';
                //delete multiple files
                foreach ($this->getJsonField($key) as $file) {
                    if (is_file($root . $file) && file_exists($root . $file)) {
                        $this->fileDelete($file);

                        $this->fileDeleteThumb($file);
                    }
                }
            }
            /* ищем есть ли поле с названием block_name у данного поста */
            if ($key == 'block_name') {
                $this->fileDelete($root . '/blocks/' . $value);
            }
            if ($key == 'css_name') {
                $this->fileDelete($root . '/css/' . $value);
            }
        }
        echo 'удалил все файлы)))';

    }


    public function postDelete()
    {
        //if(in_array($this->table, $WHITE_LIST))
        if (1) {
            $arr_out = [
                'c_industry_blocks',
                'c_industry_parts',
                'c_industry_floors',
                'c_industry_offers_mix',

            ];
            if (!in_array($this->table, [$arr_out])) {
                //$this->postFilesDelete();
            }


            if ($post_id = $this->softDelete()) {
                return $post_id;
            }
        }
        return 0;
    }

	public function postRestore() {
		if ($this->setTableId() == 33) {
			$this->softRestore();
		}
	}


    public function filesChange(string $field, string $files)
    {

        if ($_GET['action'] == 'delete') {
            $photo = parse_url($files);
            $photo = $photo['path'];
            $all_photos = $this->photos();
            $all_thumbs = $this->thumbs();
            unset($all_photos[array_search($photo, $all_photos)]);
            sort($all_photos);
            //sort($all_thumbs);
            if (file_exists($_SERVER["DOCUMENT_ROOT"] . $photo)) {
                unlink($_SERVER["DOCUMENT_ROOT"] . $photo);
                echo "Фото удалено / ";
            }

        } else {
            $files = substr($files, 0, -1);//удалям последнюю запятую
            echo $files;
            $all_files = explode(",", $files); //создаем массив фоток ссылок

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
        } catch (Exception $e) {
            echo 'Подключение не удалось: ' . $e->getMessage();
        }
    }

    public function fileDeleteThumb(string $file)
    {
        $name = $this->getFilePureName($file);
        $ext = $this->getFileExtension($file);
        $this->fileDelete('/uploads/' . $this->getPostDir() . '/thumbs/' . $name . '.jpg');
        $this->fileDelete('/uploads/' . $this->getPostDir() . '/marked/' . $name . '.jpg');
    }

    public function fileDeleteFromPost(string $field, string $file)
    {

        $all_files = $this->getJsonField($field);//take all file from the field we choose
        if (is_array($all_files)) {
            unset($all_files[array_search($file, $all_files)]); //delete element from array by value
            sort($all_files); //sort an array in order to escape errors with json encoding
            $files_string = json_encode($all_files); // json encoding
            if ($this->fileDelete($file) && $this->updateField($field, $files_string)) { //delete file
                $this->fileDeleteThumb($file);
                return true;
            }
        } else {
            if ($this->fileDelete($file) && $this->updateField($field, '')) { //delete file
                return true;
            }
        }
        return false;
    }

    public function title()
    {
        return $this->getField('title');
    }

    public function rating()
    {
        return $this->getField('rating');
    }

    public function getPostComments()
    {
        $comments_table = (new Comment(0))->setTable();
        $sql = $this->pdo->prepare("SELECT * FROM $comments_table WHERE post_id_referrer='" . $this->id . "' AND table_id_referrer='" . $this->setTableId() . "' AND deleted!='1' ORDER BY publ_time DESC");
        $sql->execute();
        return $sql->fetchAll();
    }

    public function getPostLastComment()
    {
        $comments_table = (new Comment(0))->setTable();
        $sql = $this->pdo->prepare("SELECT * FROM $comments_table WHERE post_id_referrer='" . $this->id . "' AND table_id_referrer='" . $this->setTableId() . "' ORDER BY publ_time DESC LIMIT 1");
        $sql->execute();
        return $sql->fetch(PDO::FETCH_LAZY);
    }

    public function getPostUnfinishedTasks()
    {
        $tasks_table = (new Task(0))->setTable();
        $sql = $this->pdo->prepare("SELECT * FROM $tasks_table WHERE post_id_referrer='" . $this->id . "' AND table_id_referrer='" . $this->setTableId() . "' AND finished!='1' ORDER BY publ_time DESC");
        $sql->execute();
        return $sql->fetchAll();
    }

    public function getPostTasks()
    {
        $tasks_table = (new Task(0))->setTable();
        $sql = $this->pdo->prepare("SELECT * FROM $tasks_table WHERE post_id_referrer='" . $this->id . "' AND table_id_referrer='" . $this->setTableId() . "' AND deleted!='1' ORDER BY publ_time DESC");
        $sql->execute();
        return $sql->fetchAll();
    }

    public function getPostNewTasks()
    {
        $tasks_table = (new Task(0))->setTable();
        $sql = $this->pdo->prepare("SELECT * FROM $tasks_table WHERE post_id_referrer='" . $this->id . "' AND table_id_referrer='" . $this->setTableId() . "' AND deleted!='1' AND task_status_id='1' ORDER BY publ_time DESC");
        $sql->execute();
        return $sql->fetchAll();
    }

    public function getPostInProgressTasks()
    {
        $tasks_table = (new Task(0))->setTable();
        $sql = $this->pdo->prepare("SELECT * FROM $tasks_table WHERE post_id_referrer='" . $this->id . "' AND table_id_referrer='" . $this->setTableId() . "' AND deleted!='1' AND task_status_id='2' ORDER BY publ_time DESC");
        $sql->execute();
        return $sql->fetchAll();
    }

    public function getPostFinishedTasks()
    {
        $tasks_table = (new Task(0))->setTable();
        $sql = $this->pdo->prepare("SELECT * FROM $tasks_table WHERE post_id_referrer='" . $this->id . "' AND table_id_referrer='" . $this->setTableId() . "' AND deleted!='1' AND task_status_id='3' ORDER BY publ_time DESC");
        $sql->execute();
        return $sql->fetchAll();
    }

    public function getPostChanges()
    {
        $actions_table = (new UserAction(0))->setTable();
        $sql = $this->pdo->prepare("SELECT * FROM $actions_table WHERE post_id='" . $this->id . "' AND action_id='3' ORDER BY publ_time DESC");
        $sql->execute();
        return $sql->fetchAll();
    }

    public function furl()
    {
        return $this->getField('furl');
    }

    public function postId()
    {
        $id = $this->getField('id');
        if ($this->id) {
            $id = $this->id;
        }
        return (int)$id;
    }

    public function author()
    {
        return $this->getField('author_');
    }


    public function getAuthor()
    {
        return $this->getField('author_id');
    }

    public function getAuthorName()
    {
        $author = new Member($this->getAuthor());
        return $author->getField('title');
    }

    public function supervisor()
    {
        return $this->getField('broker');
    }

    public function photos()
    {
        return json_decode($this->getField('photo'));
    }

    public function thumbs()
    {
        return json_decode($this->getField('thumbs'));
    }

    public function thumbSmall()
    {
        return json_decode($this->getField('thumb_small'));
    }

    public function photo()
    {
        return $this->photos()[0];
    }

    public function photoSmall()
    {
        return $this->getField('photo_small');
    }


    public function thumbnail()
    {
        return $this->getField('photo_small');
    }

    public function publTime()
    {
        return date_format_rus($this->getField('publ_time'));
    }

    public function lastUpdate()
    {
        return date_format_rus($this->getField('last_update'));
    }

    public function price()
    {
        return $this->getField('price');
    }

    public function articul()
    {
        return $this->getField('articul');
    }

    public function isActive()
    {
        if ($this->getField('activity') == 1) {
            return true;
        } else {
            return false;
        }
    }

    public function pack()
    {
        return $this->getField('pack');
    }

    public function sale()
    {
        return $this->getField('sale');
    }

    public function discount()
    {
        return $this->getField('discount');
    }

    public function size()
    {
        return $this->getField('size');
    }

    public function color()
    {
        return $this->getField('color');
    }

    public function description()
    {
        return $this->getField('description');
    }

    public function collection()
    {
        return $this->getField('collection');
    }

}


?>
