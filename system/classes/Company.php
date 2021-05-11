<?php

/**
 * Created by PhpStorm.
 * User: Zhitkov
 * Date: 31.05.2018
 * Time: 15:19
 */
class Company extends Post
{
    public function setTable()
    {
        return 'c_industry_companies';
    }

    public function title()
    {
        if ($this->getField('title')) {
            return $this->getField('title');
        }
        return $this->getField('title_old');
    }


    public function getCompanyAreaUnits($area)
    {
        $table = new $area(0);
        $sql = $this->pdo->prepare("SELECT * FROM " . $table->setTable() . " WHERE company_id=" . $this->id . " AND deleted !='1'  ");
        $sql->execute();
        return $sql->fetchAll();
    }

    public function countCompanyAreaUnits($area)
    {
        $table = new $area(0);
        $sql = $this->pdo->prepare("SELECT COUNT(id) as u FROM " . $table->setTable() . " WHERE company_id=" . $this->id . " AND deleted !='1'  ");
        $sql->execute();
        $count = $sql->fetch();
        return $count['u'];
    }

    public function hasContact(): bool
    {
        if ($this->getField('contact_id')) {
            return true;
        }
        return false;
    }

    public function setContact(int $contact_id)
    {
        if ($this->updateField('contact_id', $contact_id)) {
            return true;
        }
        return false;
    }

    public function getCompanyContacts()
    {
        $contacts = new Contact(0);
        $sql = $this->pdo->prepare("SELECT * FROM " . $contacts->setTable() . " WHERE company_id=" . $this->id . " AND deleted !='1' ");
        $sql->execute();
        return $sql->fetchAll();
    }


    public function getCompanyRequests()
    {
        $requests = new Request(0);
        $sql = $this->pdo->prepare("SELECT * FROM " . $requests->setTable() . " WHERE company_id=" . $this->id . " AND DELETED !='1'  ORDER BY publ_time DESC");
        $sql->execute();
        return $sql->fetchAll();
    }

    public function getCompanyObjects()
    {
        $object = new Building(0);
        $sql = $this->pdo->prepare("SELECT * FROM " . $object->setTable() . " WHERE company_id=" . $this->id . " AND deleted!='1' ");
        $sql->execute();
        return $sql->fetchAll();
    }

    public function getCompanyOffers()
    {
        $offers = new Offer(0);
        $sql = $this->pdo->prepare("SELECT * FROM " . $offers->setTable() . " WHERE company_id=" . $this->id . " AND deleted !='1'  ");
        $sql->execute();
        return $sql->fetchAll();
    }

    public function getCompanyDeals()
    {
        $deals = new Deal(0);
        $sql = $this->pdo->prepare("SELECT * FROM " . $deals->setTable() . " WHERE company_id=" . $this->id . " AND deleted !='1'  ");
        $sql->execute();
        return $sql->fetchAll();
    }

    public function getCompanyAreaTasks($area)
    {
        $company_units = $this->getCompanyAreaUnits($area);
        $units_id = [];
        foreach ($company_units as $unit) {
            $units_id[] = $unit['id'];
        }
        $units_id_line = implode(',', $units_id);
        $sql = $this->pdo->prepare("SELECT * FROM " . (new Task(0))->setTable() . " WHERE table_id_referrer='" . (new $area(0))->setTableId() . "' AND post_id_referrer IN($units_id_line) ");
        $sql->execute();
        return $sql->fetchAll();
    }

    public function getCompanyAreaCompletedTasks($area)
    {
        if ($company_units = $this->getCompanyAreaUnits($area)) {
            $units_id = [];
            foreach ($company_units as $unit) {
                $units_id[] = $unit['id'];
            }
            $units_id_line = implode(',', $units_id);
            $sql = $this->pdo->prepare("SELECT * FROM " . (new Task(0))->setTable() . " WHERE table_id_referrer='" . (new $area(0))->setTableId() . "' AND post_id_referrer IN($units_id_line) AND task_status_id='3'");
            $sql->execute();
            return $sql->fetchAll();
        }
        return [];

    }

    public function getCompanyAreaNewTasks($area)
    {
        if ($company_units = $this->getCompanyAreaUnits($area)) {
            $units_id = [];
            foreach ($company_units as $unit) {
                $units_id[] = $unit['id'];
            }
            $units_id_line = implode(',', $units_id);
            $sql = $this->pdo->prepare("SELECT * FROM " . (new Task(0))->setTable() . " WHERE table_id_referrer='" . (new $area(0))->setTableId() . "' AND post_id_referrer IN($units_id_line) AND task_status_id='1'");
            $sql->execute();
            return $sql->fetchAll();
        }
        return [];

    }

    public function getCompanyAreaInprogressTasks($area)
    {
        if ($company_units = $this->getCompanyAreaUnits($area)) {
            $units_id = [];
            foreach ($company_units as $unit) {
                $units_id[] = $unit['id'];
            }
            $units_id_line = implode(',', $units_id);
            $sql = $this->pdo->prepare("SELECT * FROM " . (new Task(0))->setTable() . " WHERE table_id_referrer='" . (new $area(0))->setTableId() . "' AND post_id_referrer IN($units_id_line) AND task_status_id='2'");
            $sql->execute();
            return $sql->fetchAll();
        }
        return [];
    }

    public function getCompanyNewTasks()
    {
        return count($this->getCompanyAreaNewTasks('Contact')) + count($this->getCompanyAreaNewTasks('Building')) + count($this->getCompanyAreaNewTasks('Request'));
    }

    public function getCompanyInprogressTasks()
    {
        return count($this->getCompanyAreaInprogressTasks('Contact')) + count($this->getCompanyAreaInprogressTasks('Building')) + count($this->getCompanyAreaInprogressTasks('Request'));
    }

    public function getCompanyCompletedTasks()
    {
        return count($this->getCompanyAreaCompletedTasks('Contact')) + count($this->getCompanyAreaCompletedTasks('Building')) + count($this->getCompanyAreaCompletedTasks('Request'));
    }


    public function getCompanyAllFinishedTasks()
    {

    }


    public function getCompanyMainContact()
    {
        return $this->showField('contact_id');
    }

}