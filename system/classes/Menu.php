<?php

/**
 * Created by PhpStorm.
 * User: Zhitkov
 * Date: 26.06.2018
 * Time: 12:32
 */
class Menu extends Post
{
    public function setTable()
    {
        return 'core_menus';
    }

    public function menuActivePages()
    {
        $sql = $this->pdo->prepare("SELECT * FROM core_pages  WHERE deleted!='1' AND activity='1' AND menu_id=:id ORDER BY order_row DESC");
        $sql->bindParam(':id', $this->postId());
        $sql->execute();
        return $sql->fetchAll();
    }
}