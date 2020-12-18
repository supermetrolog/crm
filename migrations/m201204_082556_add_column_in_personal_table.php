<?php

use yii\db\Migration;

/**
 * Class m201204_082556_add_column_in_personal_table
 */
class m201204_082556_add_column_in_personal_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('personal', 'department', $this->integer()->notNull()->defaultValue(-1));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('personal', 'department');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201204_082556_add_column_in_personal_table cannot be reverted.\n";

        return false;
    }
    */
}
