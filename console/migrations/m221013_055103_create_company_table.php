<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%company}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%user}}`
 * - `{{%user}}`
 * - `{{%user}}`
 */
class m221013_055103_create_company_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%company}}', [
            'id' => $this->primaryKey(),
            'company_name' => $this->string(),
            'boss_full_name' => $this->string(),
            'address' => $this->string(),
            'email' => $this->string(50),
            'website' => $this->string(50),
            'phone' => $this->string(20),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
            'user_id' => $this->integer(),
            'status' => $this->integer(),
        ]);

        // creates index for column `created_by`
        $this->createIndex(
            '{{%idx-company-created_by}}',
            '{{%company}}',
            'created_by'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-company-created_by}}',
            '{{%company}}',
            'created_by',
            '{{%user}}',
            'id',
            'CASCADE'
        );

        // creates index for column `updated_by`
        $this->createIndex(
            '{{%idx-company-updated_by}}',
            '{{%company}}',
            'updated_by'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-company-updated_by}}',
            '{{%company}}',
            'updated_by',
            '{{%user}}',
            'id',
            'CASCADE'
        );

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-company-user_id}}',
            '{{%company}}',
            'user_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-company-user_id}}',
            '{{%company}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-company-created_by}}',
            '{{%company}}'
        );

        // drops index for column `created_by`
        $this->dropIndex(
            '{{%idx-company-created_by}}',
            '{{%company}}'
        );

        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-company-updated_by}}',
            '{{%company}}'
        );

        // drops index for column `updated_by`
        $this->dropIndex(
            '{{%idx-company-updated_by}}',
            '{{%company}}'
        );

        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-company-user_id}}',
            '{{%company}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-company-user_id}}',
            '{{%company}}'
        );

        $this->dropTable('{{%company}}');
    }
}
