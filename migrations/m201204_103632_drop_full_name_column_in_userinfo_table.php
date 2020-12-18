<?php

use yii\db\Migration;

/**
 * Handles the dropping of table `{{%full_name_column_in_userinfo}}`.
 */
class m201204_103632_drop_full_name_column_in_userinfo_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('userinfo', 'full_name');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        return false;
    }
}
