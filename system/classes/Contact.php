<?php

class Contact extends Post
{

    public function setTable()
    {
        return 'c_industry_contacts';
    }

    public function title()
    {
        if ($this->firstName() || $this->lastName() || $this->fatherName()) {
            return $this->fullName();
        } else {
            return $this->getField('title');
        }
    }

    public function phone()
    {
        $phones = $this->getJsonField('phones');
        $str_full = '';

        if (arrayIsNotEmpty($phones) && $phones != null) {
            for ($i = 0; $i < count($phones); $i = $i + 2) {
                $main = $phones[$i];
                $dope = $phones[$i + 1];
                if ($dope) {
                    $str = $main . ' доб. ' . $dope . '<br>';
                } else {
                    $str = $main . '<br>';
                }
                $str_full .= $str;
            }
            return $str_full;
        } else {
            return $this->getField('phone');
        }
    }

    public function email()
    {
        $emails = $this->getJsonField('emails');
        if (arrayIsNotEmpty($emails)) {
            return implode('<br>', $emails);
        } else {
            return $this->getField('email');
        }
    }


    public function firstName()
    {
        return $this->getField('first_name');
    }

    public function lastName()
    {
        return $this->getField('last_name');
    }

    public function fatherName()
    {
        return $this->getField('father_name');
    }

    public function fullName()
    {
        return $this->lastName() . ' ' . $this->firstName() . ' ' . $this->fatherName();
    }


}
