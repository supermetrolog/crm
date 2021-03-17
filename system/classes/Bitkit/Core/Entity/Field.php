<?php
/**
 * Created by PhpStorm.
 * User: Zhitkov
 * Date: 15.06.2018
 * Time: 14:09
 */
class Field extends Post{

    protected $table;
    protected $id;

    public function setTable()
    {
        return 'fields';
    }



    public function permissions(){
        return json_decode($this->showField('permissions'));
    }

    public function title(){
        return $this->showField('title');
    }

    public function description(){
        return $this->showField('description');
    }

    public function showInline(){
        return $this->showField('field_display_inline');
    }

    public function titleToDisplay(){
        if($this->showField('title_show')){
            return $this->showField('title_show');
        }else{
            return $this->showField('description');
        }
    }

    public function getFieldByName($title){
        $sql = $this->pdo->prepare("SELECT * FROM ".$this->setTable()." WHERE title=:title");
        $sql->bindParam(':title', $title);
        $sql->execute();
        $unit = $sql->fetch(PDO::FETCH_LAZY);
        $this->id = $unit->id;
    }

    public function avaliableForSearch(){
        if($this->showField('search_allow')){
            return true;
        }else{
            return false;
        }
    }

    public function canSee(){
        $user = new Member($_COOKIE['member_id']);
        if(in_array($user->group_id(),$this->permissions())){
            return true;
        }else{
            return false;
        }
    }

    public function variantsTable()
    {
        return $this->showField('linked_table');
    }

    public function getFieldVariants()
    {
        $field_vars = new Post(0);
        $field_vars->getTable($this->variantsTable());
        return $field_vars->getAllUnits();
    }




}