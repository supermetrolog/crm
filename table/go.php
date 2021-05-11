<?

$PAR_ARR = array(
  '0' => 'articul',
  '1' => 'color',
  '2' => 'title',
  '3' => 'size',
  '4' => 'price',
  '5' => 'pack',
  '6' => 'certificates',
  '7' => 'description',
  '8' => 'collection',
  '9' => 'material_top',
  '10' => 'material_under',
  '11' => 'material_feet',
  '12' => 'material_tyres',
  '13' => 'height_heel',
  '14' => 'height_boot_top', 
  '15' => 'amount',
  '16' => 'discount',
  '17' => 'height_heel_range', 
  '18' => 'material_top_clear', 
  '19' => 'color_real' 
);



 include_once('../global_pass.php');
 
 //echo "..".$_GET['filepath'];
 
 //$sale = $pdo->prepare("TRUNCATE TABLE items");
 //$sale->execute();

     $line1 = '';
     $line2 = '';
	 $publ_time = time();
     $activity = 1;
     $i =0;	 
	 
	 //создаем строку полей
     foreach($PAR_ARR as $arr_isset_item){
       $line1 = $line1.$arr_isset_item.', ';
     }

	 $line1 = $line1."activity, publ_time";
	 

	 
	 //echo $line1;
  ?>
<?
function readExelFile($filepath){
  require_once 'PHPExcel.php'; //подключаем наш фреймворк
  $ar=array(); // инициализируем массив
  $inputFileType = PHPExcel_IOFactory::identify($filepath);  // узнаем тип файла, excel может хранить файлы в разных форматах, xls, xlsx и другие
  $objReader = PHPExcel_IOFactory::createReader($inputFileType); // создаем объект для чтения файла
  $objPHPExcel = $objReader->load($filepath); // загружаем данные файла в объект
  $ar = $objPHPExcel->getActiveSheet()->toArray(); // выгружаем данные из объекта в массив
  return $ar; //возвращаем массив
}

$ar=readExelFile('..'.$_GET['filepath']); 
$str  = 0;

$upd_count = 0;
$count = 0;
$i = 0;

foreach($ar as $ar_row){  
 $line2 = '';
 
   if($i > 0  && $ar_row[0] != NULL ){
   
   
   
     $sale = $pdo->prepare("SELECT * FROM items WHERE articul='".$ar_row[0]."'");
     $sale->execute();
	 
     if($sale->rowCount() > 0){
	   for($field = 1; $field < count($PAR_ARR); $field++){
	      $curr = $PAR_ARR[$field];
	      //$amount_upd_sql= $pdo->prepare("UPDATE items SET amount='".$ar_row[15]."' WHERE articul='".$ar_row[0]."'");
	      $amount_upd_sql= $pdo->prepare("UPDATE items SET ".$PAR_ARR[$field]."='".$ar_row[$field]."' WHERE articul='".$ar_row[0]."'");
          
		  if($amount_upd_sql->execute()){
			 $fld_count++;   
	      }
	   }  
       $upd_count++;	    
	 }else{
	    $j = 0;
	    foreach($ar_row as $ar_col){  
		  if($j < count($PAR_ARR) ){
	       $line2 = $line2."'".addslashes($ar_col)."'".', ';
		  }
		  $j++;
	    }
		$line2 = $line2."$activity, "."$publ_time";
        $insert_sql = "INSERT INTO items(".$line1.")"."VALUES(".$line2.")";
        //echo $insert_sql;
		
        try {
         $sale = $pdo->prepare($insert_sql);
         $sale->execute();
         $count++;	   
        }catch (PDOException $e) {
          echo 'Подключение не удалось: ' . $e->getMessage();
        }
		
	 } 
  }
  $i++;   
}
echo "Выгрузка прошла успешно: Создано  $count строк, Обновлено $upd_count строк($fld_count полей)";




?>