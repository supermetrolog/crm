<?php

class UserAction extends Unit
{
    public function setTable()
    {
        return 'core_users_actions';
    }

    public function logAction(
        int $action_id,
        $table_name,
        int $post_id,
        int $table_name_referrer,
        int $post_id_referrer,
        $before,
        $after
    ) {
        $table = new Table(0);
        $table->getTableByName($table_name);
        if ($table->getField('log_changes') && $action_id == 3) {
            $log_before = json_encode($before);
            $log_after = json_encode($after);
        } else {
            $log_before = '';
            $log_after = '';
        }

        $table_referrer = new Table(0);
        $table_referrer->getTableByName($table_name_referrer);

        if ($table_id_referrer = $table_referrer->tableId()) {

        } else {
            $table_id_referrer = 0;
        }
        if ($table_id = $table->tableId()) {
            $this->createLine([
                'author_id',
                'action_id',
                'table_id',
                'post_id',
                'table_id_referrer',
                'post_id_referrer',
                'post_before',
                'post_after',
                'publ_time'
            ], [
                (new Member($_COOKIE['member_id']))->member_id(),
                $action_id,
                $table_id,
                $post_id,
                $table_id_referrer,
                $post_id_referrer,
                $log_before,
                $log_after,
                time()
            ]);
        }
    }

}