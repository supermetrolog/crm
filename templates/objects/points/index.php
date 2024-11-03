<? require($_SERVER['DOCUMENT_ROOT'].'/templates/objects/selection/index.php');?>
<?

$points_arr =[]; //для карты
for($i = 0; $i < $objectsAmount; $i++){
    if($unique_objects[(int)$i]){
        $object = $factory->createBuilding($unique_objects[(int)$i]);
        $point = ['id'=>$object->getField('complex_id'),  
            'latitude'=>$object->getField('latitude'),
            'longitude'=>$object->getField('longitude'),
            'address'=>str_replace('"',"'",$object->getField('address')),
            'thumb'=>$object->getJsonField('photo')[0]
        ];
        $points_arr[] = $point;
    }
}?>
<?=json_encode($points_arr)?>
