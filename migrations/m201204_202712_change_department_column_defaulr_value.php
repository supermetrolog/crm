<?php

use app\models\UserInfo;
use yii\db\Migration;

/**
 * Class m201204_202712_change_department_column_defaulr_value
 */
class m201204_202712_change_department_column_defaulr_value extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('userinfo', 'department');
        $this->addColumn('userinfo', 'department', $this->integer()->notNull()->defaultValue(UserInfo::DEFAULT_OPTION));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m201204_202712_change_department_column_defaulr_value cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201204_202712_change_department_column_defaulr_value cannot be reverted.\n";

        return false;
    }
    */
}
