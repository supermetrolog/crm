<?php

class Part extends Post
{

    public function setTable()
    {
        return 'c_industry_parts';
    }


    public function isActivePart()
    {
        $like = '%"' . $this->postId() . '"%';
        $sql = $this->pdo->prepare("SELECT MAX(deal_id) as deal FROM c_industry_blocks WHERE parts LIKE '$like' AND deleted!=1");
        $sql->execute();
        $res = $sql->fetch(PDO::FETCH_LAZY);
        //var_dump($res);
        if ($res['deal'] > 0) {
            return false;
        }
        return true;

        //return 'c_industry_parts';
    }

    public function isActivePart22()
    {
        $like = '%"' . $this->postId() . '"%';
        $sql = $this->pdo->prepare("SELECT COUNT(id) as deal_num FROM c_industry_deals WHERE block_id IN(SELECT id FROM c_industry_blocks WHERE parts LIKE '$like' ) ");
        $sql->execute();
        $res = $sql->fetch(PDO::FETCH_LAZY);
        //var_dump($res);
        if ($res['deal_num'] > 0) {
            //return false;
            $deals = 1;
        }


        $sql = $this->pdo->prepare("SELECT COUNT(id) as deal_num FROM  c_industry_blocks WHERE status=2 AND parts LIKE '$like'  ");
        $sql->execute();
        $res = $sql->fetch(PDO::FETCH_LAZY);
        //var_dump($res);
        if ($res['deal_num'] > 0) {
            $passive = 1;
        }
        if ($deals || $passive) {
            return false;
        } else {
            return true;
        }
    }

    public function isOnMarket()
    {
        $like = '%"' . $this->postId() . '"%';
        $sql = $this->pdo->prepare("SELECT COUNT(id) as block_offer FROM c_industry_blocks WHERE parts LIKE '$like' ");
        $sql->execute();
        $res = $sql->fetch(PDO::FETCH_LAZY);
        //var_dump($res);
        if ($res['block_offer'] > 0) {
            return true;
        }
        return false;
    }

    public function getFloorNumId()
    {
        $sql = $this->pdo->prepare("SELECT floor_num_id  FROM c_industry_floors WHERE id=" . $this->getField('floor_id'));
        $sql->execute();
        $res = $sql->fetch(PDO::FETCH_LAZY);
        return $res->floor_num_id;
    }

    public function getFloorName()
    {
        $name = new Post($this->getFloorNumId());
        $name->getTable('l_floor_nums');
        return $name->title();
    }

    public function getFloorColor()
    {
        $name = new Post($this->getFloorNumId());
        $name->getTable('l_floor_nums');
        return $name->getField('color');
    }

    public function hasDeal()
    {
        return !$this->isActivePart();
    }

    public function columnGrid()
    {
        $col = new Post($this->showField('column_grid'));
        $col->getTable('l_pillars_grid');
        return $col->title();
    }

    public function floorType()
    {
        if ($this->getFloorNumId() == 16) {
            $floor = new Post($this->showField('floor_type_land'));
            $floor->getTable('l_floor_types_land');
        } else {
            $floor = new Post($this->showField('floor_type'));
            $floor->getTable('l_floor_types');
        }
        return $floor->title();

    }

    public function landscapeType()
    {
        $landscape = new Post($this->showField('landscape_type'));
        $landscape->getTable('l_landscape');
        return $landscape->title();

    }


    //return 'c_industry_parts';

}