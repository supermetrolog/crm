<?php

/**
 * Created by PhpStorm.
 * User: Zhitkov
 * Date: 26.06.2018
 * Time: 17:44
 */
class EmbeddedCode extends Post
{

    public function setTable()
    {
        return 'embedded_code';
    }

    public function getTopBlocks()
    {
        $sql = $this->pdo->prepare("SELECT * FROM " . $this->setTable() . " WHERE activity='1' AND in_header='1' ORDER BY order_row DESC");
        $sql->execute();
        $units = $sql->fetchAll();
        return $units;
    }

    public function getBottomBlocks()
    {
        $sql = $this->pdo->prepare("SELECT * FROM " . $this->setTable() . " WHERE activity='1' AND  in_header!='1' ORDER BY order_row DESC");
        $sql->execute();
        $units = $sql->fetchAll();
        return $units;
    }
}