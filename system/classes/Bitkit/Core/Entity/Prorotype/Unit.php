<?php
namespace Bitkit\Core\Entity\Prototype;
abstract class Unit implements \BitKit\Core\Interfaces\UnitActions
{
	protected $mysqli; // Идентификатор соединения
	protected $pdo; // Идентификатор соединения
    protected $sortField = 'id';
    protected $sortDirection = 'ASC';

	/*конструктор, подключающийся к базе данных, устанавливающий локаль и кодировку соединения */
	public function __construct(int $id) {
		$this->id = $id;
		$this->mysqli = new \mysqli('localhost', 'timon', '20091993dec', 'pennylane');
		$this->mysqli->query("SET lc_time_names = 'ru_RU'");
		$this->mysqli->query("SET NAMES 'utf8'");
        $this->pdo = \BitKit\Core\Database\Connect::getInstance()->pdo;
	}

    abstract public function setTable();

    public function show()
    {
        $sql = $this->pdo->prepare("SELECT * FROM ".$this->setTable()." WHERE id=:id");
        $sql->bindParam(':id', $this->id);
        $sql->execute();
        $unit = $sql->fetch(\PDO::FETCH_LAZY);
        return $unit;
    }

	public function showField($field)
	{
		return $this->getLine()->$field;
	}

    public function showJsonField($field)
    {
        return json_decode($this->showField($field));
    }

    public function setJsonField($field, $string, $delimiter)
    {
        $value_str = trim($string,$delimiter);
        $value_arr = explode($delimiter,$value_str);
        $value_json = json_encode($value_arr);
        if($this->updateField($field, $value_json)){
            return true;
        }
        return false;
    }


    public function updateField($field, $param){
        $sql = $this->pdo->prepare("UPDATE ".$this->setTable()." SET $field=:param WHERE id=:id");
        $sql->bindParam(':param', $param);
        $sql->bindParam(':id', $this->id);
        if(in_array($field,$this->getTableColumnsNames())) {
            if($sql->execute()){
                return true;
            }
        }
        return false;
    }


    public function setLimit(int $from, int $amount)
    {
        $this->sortLimit = $amount;
    }

    public function setSortDirection($direction)
    {
        if($direction == 'desc'){
            $this->sortDirection = 'DESC';
        }else{
            $this->sortDirection = 'ASC';
        }
    }

    public function setSortField($field)
    {
        if($field){
            $this->sortField = $field;
        }else{
            $this->sortDirection = 'ASC';
        }
    }

    public function getLine()
    {
        $sql = $this->pdo->prepare("SELECT * FROM ".$this->setTable()." WHERE id=:id");
        $sql->bindParam(':id', $this->id);
        $sql->execute();
        $unit = $sql->fetch(\PDO::FETCH_LAZY);
        return $unit;
    }

    public function createLine($fields_array, $values_array){

        $fields_str = implode(',',$fields_array);
        $placeholders_str = '';
        foreach ($fields_array as $key=>$value) {
            $placeholders_str .= ":$value,";
        }
        $sql = $this->pdo->prepare("INSERT INTO ".$this->setTable()."($fields_str)VALUES(".trim($placeholders_str,',').") ");
        foreach($fields_array as $key=>$value){
            $sql->bindParam(":$fields_array[$key]", $values_array[$key]);
        }
        try {
            $sql->execute();
            $this->id = $this->pdo->lastInsertId();
            return $this->id;
        }catch (\PDOException $e) {
            echo 'Подключение не удалось: ' . $e->getMessage();
        }
        return 0;
    }

    public function updateLine($fields_array, $values_array){
        $update_str = '';
        foreach($fields_array as $key=>$value){
            $update_str .= "$value=:$value,";
        }
        $sql = $this->pdo->prepare("UPDATE ".$this->setTable()." SET ".trim($update_str,',')."  WHERE id='".$this->id."'");
        foreach($fields_array as $key=>$value){
            $sql->bindParam(":$value", $values_array[$key]);
        }
        try {
            $sql->execute();
        }catch (\PDOException $e) {
            echo 'Подключение не удалось: ' . $e->getMessage();
        }
    }

    public function deleteLine(){
        $sql = $this->pdo->prepare("DELETE FROM ".$this->setTable()." WHERE id=:id");
        $sql->bindParam(':id', $this->id);
        try {
            $sql->execute();
        }catch (\PDOException $e) {
            echo 'Подключение не удалось: ' . $e->getMessage();
        }
    }

    public function softDelete(){
        $this->updateField('deleted', 1);
    }

    public function activate(){
        $this->updateField('activity', 1);
    }

    public function deactivate(){
        $this->updateField('activity', 0);
    }
	


    public function countAllActive(){
        $sql= $this->pdo->prepare("SELECT COUNT(*) FROM ".$this->setTable());
        $sql->execute();
        $all = $sql->fetch();
        return  $all[0];
    }

    public function getTableColumns(){
        $par_arr = array();
        $columns_sql= $this->pdo->prepare("SHOW COLUMNS FROM ".$this->setTable()."");
        $columns_sql->execute();
        return $columns_sql->fetchAll();
    }

	public function getTableColumnsNames(){
        $par_arr = array();
        //$columns_sql= $this->pdo->prepare("SHOW COLUMNS FROM ".$this->setTable()." ");
        //$columns_sql->execute();
        foreach ($this->getTableColumns() as $column){
            $par_arr[$column['Field']] = $column['Field'];
        }
        return $par_arr;
    }

    public function getAllUnits(){
        $sql = $this->pdo->prepare("SELECT * FROM ".$this->setTable()." ORDER BY ".$this->sortField." ".$this->sortDirection."");
        $sql->execute();
        $units = $sql->fetchAll();
        return $units;
    }

    public function getAllActiveUnits(){
        $sql = $this->pdo->prepare("SELECT * FROM ".$this->setTable()." WHERE activity='1'");
        $sql->execute();
        $units = $sql->fetchAll();
        return $units;
    }

    public function getAllUnitsReverse(){
        $sql = $this->pdo->prepare("SELECT * FROM ".$this->setTable()." ORDER BY publ_time DESC");
        $sql->execute();
        $units = $sql->fetchAll();
        return $units;
    }

    public function hasField($field_name){
        if(in_array($field_name,$this->getTableColumnsNames())){
            return true;
        }
        return false;
    }

    public function getMaxId(){
        $sql = $this->pdo->prepare("SELECT MAX(id) FROM ".$this->setTable()." ");
        $sql->execute();
        $id_info = $sql->fetch(\PDO::FETCH_LAZY);
        return $id_info['MAX(id)'];
    }
}


