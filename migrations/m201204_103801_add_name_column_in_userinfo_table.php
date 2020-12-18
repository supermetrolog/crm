<?php

use yii\db\Migration;

/**
 * Class m201204_103801_add_name_column_in_userinfo_table
 */
class m201204_103801_add_name_column_in_userinfo_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('userinfo', 'first_name', $this->string()->defaultValue(null));
        $this->addColumn('userinfo', 'middle_name', $this->string()->defaultValue(null));
        $this->addColumn('userinfo', 'last_name', $this->string()->defaultValue(null));
        $this->addColumn('userinfo', 'full_name', $this->string()->defaultValue(null));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('userinfo', 'first_name');
        $this->dropColumn('userinfo', 'middle_name');
        $this->dropColumn('userinfo', 'last_name');
        $this->dropColumn('userinfo', 'full_name');
    }

}
