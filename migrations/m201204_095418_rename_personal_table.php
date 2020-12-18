<?php

use yii\db\Migration;

/**
 * Class m201204_095418_rename_personal_table
 */
class m201204_095418_rename_personal_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->renameTable('personal', 'userInfo');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m201204_095418_rename_personal_table cannot be reverted.\n";

        return false;
    }

}
