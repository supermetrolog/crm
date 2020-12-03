<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%personal}}`.
 */
class m201203_114705_create_personal_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%personal}}', [
            'id' => $this->primaryKey(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%personal}}');
    }
}
