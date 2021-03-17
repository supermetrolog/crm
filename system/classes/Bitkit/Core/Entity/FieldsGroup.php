<?php
/**
 * Created by PhpStorm.
 * User: Zhitkov
 * Date: 15.06.2018
 * Time: 13:51
 */
class FieldsGroup extends Post{
    public function setTable()
    {
        return 'fields_groups';
    }

    public function getGroupFields()
    {
        $sql= $this->pdo->prepare("SELECT * FROM fields WHERE field_group=:group");
        $sql->bindParam(':group', $this->id);
        $sql->execute();
        return $sql->fetchAll();
    }

    public function getGroupActiveFields()
    {
        $sql= $this->pdo->prepare("SELECT * FROM fields WHERE field_group=:group AND activity='1'");
        $sql->bindParam(':group', $this->id);
        $sql->execute();
        return $sql->fetchAll();
    }

    public function getGroupPublicFields()
    {
        $sql= $this->pdo->prepare("SELECT * FROM fields WHERE field_group=:group  AND activity='1' AND is_public_field='1'");
        $sql->bindParam(':group', $this->id);
        $sql->execute();
        return $sql->fetchAll();
    }

    public function groupHasFields()
    {
        $sql= $this->pdo->prepare("SELECT * FROM fields WHERE field_group=:group ");
        $sql->bindParam(':group', $this->id);
        $sql->execute();
        if($sql->rowCount() > 0){
            return true;
        }else{
            return false;
        }
    }

    public function groupHasPublicFields()
    {
        $sql= $this->pdo->prepare("SELECT * FROM fields WHERE field_group=:group AND activity='1' AND is_public_field='1' ");
        $sql->bindParam(':group', $this->id);
        $sql->execute();
        if($sql->rowCount() > 0){
            return true;
        }else{
            return false;
        }
    }
}