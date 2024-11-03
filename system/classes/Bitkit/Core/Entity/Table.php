<?php
/**
 * Created by PhpStorm.
 * User: Zhitkov
 * Date: 15.05.2018
 * Time: 12:06
 */
class Table extends Unit{

    protected $table;
    protected $id;


    /*
    public function getTable(string $table){
        $this->table =  $table;
    }


    public function setTable(){
        return $this->table;
    }
    */

    public function tableId(){
        return $this->id;
    }

    public function setTable(){
        return 'tables_map';
    }

    public function addColumn($name , $type){
        $add_sql = $this->pdo->prepare("ALTER TABLE ".$this->setTable()." ADD $name $type");
        $add_sql->execute();
    }

    public function getTableByName($title){
        $sql = $this->pdo->prepare("SELECT * FROM ".$this->setTable()." WHERE title=:title");
        $sql->bindParam(':title', $title);
        $sql->execute();
        $unit = $sql->fetch(PDO::FETCH_LAZY);
        $this->id = $unit->id;
    }

    public function getAllTables($dataBase){
        $sql= $this->pdo->prepare("SHOW TABLES FROM $dataBase");
        $sql->execute();
        $tables_list = array();
        $i = 0;
        while($table = $sql->fetch()){
            $tables_list[$i] = $table["Tables_in_$dataBase"];
            $i++;
        }
        return $tables_list;
    }

    public function fieldInGrid(int $field_id){
        $flag = 0;
        foreach($this->showJsonField('grid_columns') as $grid_column){
            if(in_array($field_id, $grid_column[1])){
                $flag = 1;
                break;
            }
        }
        if($flag == 1){
            return true;
        }else{
            return false;
        }

    }

}