<?php

use yii\db\cubrid\Schema;
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
            'pin' => $this->primaryKey(),
            'first_name' => $this->string()->notNull()->defaultValue('empty'),
            'middle_name' => $this->string()->notNull()->defaultValue('empty'),
            'last_name' => $this->string()->notNull()->defaultValue('empty'),
            'full_name' => $this->string()->notNull()->defaultValue('empty'),
            'avatar' => $this->string()->defaultValue(null),
            'birth_day' => $this->date()->defaultValue(null),
            'place_birth' => $this->string()->defaultValue(null),
            'education' => $this->string()->defaultValue(null),
            'army' => $this->string()->defaultValue(null),
            'marital_status' => $this->string()->defaultValue(null),
            'phone' => $this->string()->defaultValue(null),
            'place_residence' => $this->string()->defaultValue(null),
            'residential_adress' => $this->string()->defaultValue(null),
            'pasport_number' => $this->string()->defaultValue(null),
            'pasport_issued' => $this->string()->defaultValue(null),
            'pasport_issued_date' => $this->date()->defaultValue(null),
            'salary' => $this->integer()->defaultValue(null),
            'created_at' => $this->datetime()->defaultValue(date('Y-m-d H:i:s')),
            'updated_at' => $this->datetime()->defaultValue(null),
        ]);

        $this->createIndex(
            'idx-personal-pin',
            'personal',
            'pin'
        );

        $this->addForeignKey(
            'fk-personal-pin',
            'personal',
            'pin',
            'user',
            'pin',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%personal}}');
    }
}
