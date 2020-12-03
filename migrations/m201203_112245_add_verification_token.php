<?php

use yii\db\Migration;

/**
 * Class m201203_112245_add_verification_token
 */
class m201203_112245_add_verification_token extends Migration
{
    public function up()
    {
        $this->addColumn('{{%user}}', 'verification_token', $this->string()->defaultValue(null));
    }

    public function down()
    {
        $this->dropColumn('{{%user}}', 'verification_token');
    }
}
