<?php

use yii\db\Migration;

/**
 * Class m201204_104032_add_created_at_and_updated_at_column_in_userinfo_table
 */
class m201204_104032_add_created_at_and_updated_at_column_in_userinfo_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('userinfo', 'created_at', $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'));
        $this->addColumn('userinfo', 'updated_at', $this->timestamp()->defaultValue(null));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('userinfo', 'created_at');
        $this->dropColumn('userinfo', 'updated_at');
    }

}
