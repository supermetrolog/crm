<?php

use yii\db\Migration;

/**
 * Class m201204_102235_update_default_value_name_and_created_at_column_in_userInfo_table
 */
class m201204_102235_update_default_value_name_and_created_at_column_in_userInfo_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // $this->dropColumn('userinfo', 'created_at');
        // $this->dropColumn('userinfo', 'updated_at');
        $this->dropColumn('userinfo', 'first_name');
        $this->dropColumn('userinfo', 'middle_name');
        $this->dropColumn('userinfo', 'last_name');

        // $this->addColumn('userinfo', 'first_name', $this->string()->defaultValue(null));
        // $this->addColumn('userinfo', 'middle_name', $this->string()->defaultValue(null));
        // $this->addColumn('userinfo', 'last_name', $this->string()->defaultValue(null));
        // $this->addColumn('userinfo', 'created_at', $this->timestamp()->notNull());
        // $this->addColumn('userinfo', 'updated_at', $this->timestamp()->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('userinfo', 'created_at');
        $this->dropColumn('userinfo', 'updated_at');
        $this->dropColumn('userinfo', 'first_name');
        $this->dropColumn('userinfo', 'middle_name');
        $this->dropColumn('userinfo', 'last_name');
    }

}
