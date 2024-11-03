<?php

class Deal extends Post
{

    public function setTable()
    {
        return 'c_industry_deals';
    }

    public function getDealRequest()
    {
        $requests = new Request(0);
        $sql = $this->pdo->prepare("SELECT * FROM " . $requests->setTable() . " WHERE deal_id='" . $this->postId() . "'");
        $sql->execute();
        $request = $sql->fetch(PDO::FETCH_LAZY);
        return $request->id;
    }
}
