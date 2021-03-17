<? 
$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$furl = parse_url($actual_link);
$object_id = explode('/',$furl['path'])[2];
$object = new Item($object_id);

$table_sql = $pdo->prepare("SELECT * FROM tables_map WHERE title='c_industry' ");
$table_sql->execute();
$table_model = $table_sql->fetch(PDO::FETCH_LAZY);


?>

            <div  style="width: 100%; flex-wrap: wrap; align-items: flex-start"  class="flex-box">
            <?foreach (json_decode($table_model->grid_columns) as $column){?>
                <div class="grid-column" style="width: <?=$column[0]?>">
                    <div class="connectedSortable"  >
                        <?foreach($column[1] as $field_unit) {?>
                            <?$field = new Field($field_unit)?>
                            <?include ($_SERVER['DOCUMENT_ROOT'].'/admin/templates/field/index/index.php')?>
                        <?}?>
                    </div>
                </div>
            <?}?>
        </div>

