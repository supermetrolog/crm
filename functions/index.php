<?
//Приведение даты к читаемому виду
function date_format_rus($date){
 $month_array = array (
  1 => 'Января',
  2 => 'Февраля',
  3 => 'Марта',
  4 => 'Апреля', 
  5 => 'Мая',
  6 => 'Июня',   
  7 => 'Июля', 
  8 => 'Августа', 
  9 => 'Сентября',
  10 => 'Октября',
  11 => 'Ноября',
  12 => 'Декабря'
 );
  
  $time = time();
  $tm = date('H:i', $date);
  $d = date('d', $date);
  $m = date('m', $date);
  $y = date('Y', $date);

  if($time - $date < 60){
		 $text =  "Только что"; 
  }elseif($time - $date > 60 && $time - $date < 3600 ){
		 $minute = round(($time - $date)/60);
	     if($minute < 55){
	       if($minute % 10 == 1 && $minute != 11 ){
		    $text =  "$minute минуту назад";
	       }elseif($minute % 10 > 1  && $minute% 10 < 5  ){
		    $text =  "$minute минуты назад";
	       }else{
		    $text =  "$minute минут назад"; 
	       }
         } 
  }elseif($time - $date > 3600){
		 $last = round(($time - $date)/3600);
         if( ($last < 13) && ($d.$m.$y == date('dmY',$time))){ 
	      if($last % 10 == 1 && $last != 11 ){
		     $text =  "$last час назад";
	      }elseif($last % 10 > 1  && $last% 10 < 5  ){
		     $text =  "$last часа назад";
	      }else{
		     $text =  "$last часов назад"; 
	      }
         }elseif($d.$m.$y == date('dmY',$time)){
	      $text =  "Сегодня в $tm";
         }elseif($d.$m.$y == date('dmY', strtotime('-1 day'))){
	      $text =  "Вчера в $tm";
         }else{
	       $text =  $d.' '.$month_array[(int)($m)].' '.$y.' в '.$tm;
         }
  }else{
		 $text =  $d.' '.$month_array[(int)($m)].' '.$y.' в '.$tm;
  }

  return $text; 
}

function capitalize_rus($string){
    if($string){
        $char = mb_strtoupper(substr($string,0,2), "utf-8"); // это первый символ
        $string[0] = $char[0];
        $string[1] = $char[1];
        return $string;
    }
    return '';

}

function getFileExtension($file){
    $ext = '.'.array_pop(explode('.',$file));
    return $ext;
}
function getFilePureName($file){
    $without_folder = array_pop(explode('/',$file));
    $name_parts = explode('.',$without_folder);
    array_pop($name_parts);
    $name_with_hash = implode('.',$name_parts);
    $name_parts = explode('_',$name_with_hash);
    array_pop($name_parts);
    return implode('_',$name_parts);
}
function getFileIcon($file){
    $ext = getFileExtension($file);
    if($ext == '.mp3' || $ext == '.ogg'){
        $icon = '<i class="fas fa-file-video"></i>';
    }elseif($ext == '.doc' || $ext == '.docx'){
        $icon = '<i class="far fa-file-word"></i>';
    }elseif($ext == '.xls' || $ext == '.xlsx'){
        $icon = '<i class="far fa-file-excel"></i>';
    }elseif($ext == '.htm' || $ext == '.html' || $ext == '.php' || $ext == '.css' || $ext == '.xml'){
        $icon = '<i class="far fa-file-code"></i>';
    }elseif($ext == '.exe'){
        $icon = '<i class="fas fa-file-code"></i>';
    }elseif($ext =='.mp4' || $ext =='.ogg' || $ext =='.webm'){
        $icon = '<i class="far fa-file-video"></i>';
    }elseif($ext =='.rar' || $ext =='.tar' || $ext =='.zip'){
        $icon = '<i class="far  fa-file-archive"></i>';
    }elseif($ext =='.txt'){
        $icon = '<i class="far fa-file-alt"></i>';
    }elseif($ext =='.ppt' || $ext =='.pptx' || $ext =='.pptm'){
        $icon = '<i class="fas fa-file-powerpoint"></i>';
    }elseif($ext == '.pdf'){
        $icon = '<i class="fas fa-file-pdf"></i>';
    }elseif($ext == '.psd' || $ext == '.jpg' || $ext == '.png' || $ext == '.gif'){
        $icon = '<i class="far fa-file-image"></i>';
    }else{
        $icon = '<i class="far fa-file"></i>';
    }
    return $icon;
}
function getFileNameShort($file){
    return mb_strimwidth(getFilePureName($file), 0, 15, "...");
}

//Пеервод цвета на русский
function color_detect($color){
	  if(substr_count($color, 'зеленый') > 0){
	     $color = 'green';
	  }elseif(strpos($color, 'синий') !== FALSE){
	     $color = 'blue';
	  }elseif(substr_count($color, 'оранжевый') > 0){
	     $color = 'orange';
	  }elseif(substr_count($color, 'серый') > 0){
	     $color = 'grey';
	  }elseif(substr_count($color, 'золотой') > 0){
	     $color = 'gold';
	  }elseif(substr_count($color, 'красный') > 0){
	     $color = 'red';
	  }elseif(substr_count($color, 'коричневый') > 0){
	     $color = 'brown';
	  }elseif(substr_count($color, 'бежевый') > 0){
	     $color = 'tan';
	  }elseif(substr_count($color, 'белый') > 0){
	     $color = 'rgb(240, 240, 240)';
	  }elseif(substr_count($color, 'розовый') > 0){
	     $color = '#f6a59c';
	  }elseif(substr_count($color, 'голубой') > 0){
	     $color = 'lightblue';
	  }elseif(substr_count($color, 'зеленый') > 0){
	     $color = 'green';
	  }elseif(substr_count($color, 'желтый') > 0){
	     $color = 'yellow';
	  }elseif(substr_count($color, 'фиолетовый') > 0){
	     $color = '#8A2BE2';
	  }elseif(substr_count($color, 'серебряный') > 0){
	     $color = 'silver';
	  }elseif(substr_count($color, 'черный') > 0){
	     $color = 'black';
	  }else{
	     $color = 'white';
	  }
	  return $color;
}

function delete_from_array(array $array, $value) {
    if(in_array($value,$array)){
        unset($array[array_search($value, $array)]);
        sort($array);
    }
    return $array;
}

function getPostTitle($id, $table_name) {
    if ((int)$id) {
        $post = new Post($id);
        $post->getTable($table_name);
        return $post->title();
    }
    return '';
}




//Запазной вариант для проверки хэша
if(!function_exists('hash_equals'))
{
    function hash_equals($str1, $str2)
    {
        if(strlen($str1) != strlen($str2))
        {
            return false;
        }
        else
        {
            $res = $str1 ^ $str2;
            $ret = 0;
            for($i = strlen($res) - 1; $i >= 0; $i--)
            {
                $ret |= ord($res[$i]);
            }
            return !$ret;
        }
    }
}

function isJSON($string){
    return is_string($string) && is_array(json_decode($string, true)) && (json_last_error() == JSON_ERROR_NONE) ? true : false;
}

//Транслитерация
function furl_create($string){
      $converter = array(
        'а' => 'a',   'б' => 'b',   'в' => 'v',
        'г' => 'g',   'д' => 'd',   'е' => 'e',
        'ё' => 'e',   'ж' => 'zh',  'з' => 'z',
        'и' => 'i',   'й' => 'y',   'к' => 'k',
        'л' => 'l',   'м' => 'm',   'н' => 'n',
        'о' => 'o',   'п' => 'p',   'р' => 'r',
        'с' => 's',   'т' => 't',   'у' => 'u',
        'ф' => 'f',   'х' => 'h',   'ц' => 'c',
        'ч' => 'ch',  'ш' => 'sh',  'щ' => 'sch',
        'ь' => '\'',  'ы' => 'y',   'ъ' => '\'',
        'э' => 'e',   'ю' => 'yu',  'я' => 'ya',
        
        'А' => 'A',   'Б' => 'B',   'В' => 'V',
        'Г' => 'G',   'Д' => 'D',   'Е' => 'E',
        'Ё' => 'E',   'Ж' => 'Zh',  'З' => 'Z',
        'И' => 'I',   'Й' => 'Y',   'К' => 'K',
        'Л' => 'L',   'М' => 'M',   'Н' => 'N',
        'О' => 'O',   'П' => 'P',   'Р' => 'R',
        'С' => 'S',   'Т' => 'T',   'У' => 'U',
        'Ф' => 'F',   'Х' => 'H',   'Ц' => 'C',
        'Ч' => 'Ch',  'Ш' => 'Sh',  'Щ' => 'Sch',
        'Ь' => '\'',  'Ы' => 'Y',   'Ъ' => '\'',
        'Э' => 'E',   'Ю' => 'Yu',  'Я' => 'Ya',
    );
    $str=strtr($string, $converter);
	
    // в нижний регистр
    $str = strtolower($str);
    // заменям все ненужное нам на "-"
    $str = preg_replace('~[^-a-z0-9_]+~u', '-', $str);
    // удаляем начальные и конечные '-'
    $str = trim($str, "-");
    return $str;
  }

function valuesCompare($first_val, $second_val) {
    if(($first_val  &&  $second_val) && ($first_val  ==  $second_val)){
        return $first_val;
    }
    if(($first_val  &&  $second_val) && ($first_val  !=  $second_val)){
        return $first_val.' - '.$second_val;
    }
    if($first_val  ||  $second_val){
        if($first_val){
            return $first_val;
        }
        if($second_val){
            return $second_val;
        }
    }
    return 0;
}


function arrayIsNotEmpty($array) {
    if(is_array($array)) {
        foreach ($array as $elem) {
            if (trim($elem) != NULL) {
                return true;
                break;
            }
        }
    }
    return false;

}


//четные
function getArrayEven($array){
    $arr_res = [];
    if(is_array($array)){
        foreach ($array as $key=>$value){
            if($key%2 == 0 && $value != null){
                $arr_res[] = $value;
            }
        }
    }else{
        return false;
    }
    return $arr_res;
}


//нечетные
function getArrayOdd($array){
    $arr_res = [];
    if(is_array($array)){
        foreach ($array as $key=>$value ){
            if($key%2 != 0 && $value != null){
                $arr_res[] = $value;
            }
        }
    }else{
        return false;
    }
    return $arr_res;
}




function getArrayUnique($array){
    $arr_res = [];
    if(is_array($array)){
        foreach ($array as $key=>$value){
            if(!in_array($value,$arr_res)){
                $arr_res[] = $value;
            }
        }
    }else{
        return false;
    }
    return $arr_res;
}

function getArrReal($array){
    $arr_res = [];
    if(is_array($array)){
        foreach ($array as $item){
            if($item != null){
                $arr_res[] = $item;
            }
        }
    }else{
        return false;
    }
    return $arr_res;
}

//нечетные
function getArrayMin(array $array){
    $min = max($array);
    foreach ($array as $elem ){
        if($elem > 0 && $elem < $min){
            $min = $elem;
        }
    }
    return $min;
}

function getPostIdByTitle($table, $title){
    $post =  new Post(0);
    $post->getTable($table);
    $post->getPostByTitle($title);
    return $post->id;
}

function getTownIdByTitleAndType($title, $type, $pdo){
    $table = 'l_towns';
    $sql = $pdo->prepare("SELECT * FROM $table WHERE title='".$title."' AND town_type='".$type."'");
    $sql->execute();
    $town =  $sql->fetch(PDO::FETCH_LAZY);
    return $town->id;
}

function capFirst($string){
    $char = mb_strtoupper(substr($string,0,2), "utf-8"); // это первый символ
    $string[0] = $char[0];
    $string[1] = $char[1];
    return $string;
}

function numFormat($value){
    return number_format($value, 0, '', ' ');
}


//вырываем id видео
function getYoutubeId($url){
    if(stristr($url,'v=') !== false){
        $params_str = parse_url($url)['query'];
        $parts = explode('&',$params_str);
        $par_arr=[];
        foreach($parts as $param){
            $param_part = explode('=',$param);
            $par_arr[$param_part[0]] = $param_part[1];
        }
        $res = $par_arr['v'];
    }else{
        $parts = explode('/',$url);
        $res = array_pop($parts);
    }

    return $res;
}


function getApiCompanies($ids) : array
{
    $idsLine = implode(',',$ids);
    $baseUrl = 'https://api.pennylane.pro';
    $xml = file_get_contents($baseUrl . '/companies?expand=requests,contacts.emails,contacts.phones,contacts.contactComments,broker,companyGroup,consultant,consultant.userProfile,productRanges,categories,files&id=' . $idsLine);
    $companies = json_decode($xml,true);

    $companiesAssoc = [];
    foreach ($companies as $company) {
        $companiesAssoc[$company['id']] = $company;
    }
    return $companiesAssoc;
}


