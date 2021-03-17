<?php


class Task extends Post
{

    public function setTable()
    {
        return 'core_tasks';
    }

    public function markAsRead()
    {
        $this->updateField('is_read', 1);
    }


    public function createTask()
    {
        $this->updateField('is_read', 1);
    }


}