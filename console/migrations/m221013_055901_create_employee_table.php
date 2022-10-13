<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%employee}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%company}}`
 * - `{{%user}}`
 * - `{{%user}}`
 */
class m221013_055901_create_employee_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%employee}}', [
            'id' => $this->primaryKey(),
            'first_name' => $this->string(),
            'last_name' => $this->string(),
            'middle_name' => $this->string(),
            'passport_number' => $this->string(),
            'address' => $this->string(),
            'phone' => $this->string(),
            'position' => $this->string(),
            'company_id' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
            'status' => $this->integer(),
        ]);

        // creates index for column `company_id`
        $this->createIndex(
            '{{%idx-employee-company_id}}',
            '{{%employee}}',
            'company_id'
        );

        // add foreign key for table `{{%company}}`
        $this->addForeignKey(
            '{{%fk-employee-company_id}}',
            '{{%employee}}',
            'company_id',
            '{{%company}}',
            'id',
            'CASCADE'
        );

        // creates index for column `created_by`
        $this->createIndex(
            '{{%idx-employee-created_by}}',
            '{{%employee}}',
            'created_by'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-employee-created_by}}',
            '{{%employee}}',
            'created_by',
            '{{%user}}',
            'id',
            'CASCADE'
        );

        // creates index for column `updated_by`
        $this->createIndex(
            '{{%idx-employee-updated_by}}',
            '{{%employee}}',
            'updated_by'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-employee-updated_by}}',
            '{{%employee}}',
            'updated_by',
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
        // drops foreign key for table `{{%company}}`
        $this->dropForeignKey(
            '{{%fk-employee-company_id}}',
            '{{%employee}}'
        );

        // drops index for column `company_id`
        $this->dropIndex(
            '{{%idx-employee-company_id}}',
            '{{%employee}}'
        );

        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-employee-created_by}}',
            '{{%employee}}'
        );

        // drops index for column `created_by`
        $this->dropIndex(
            '{{%idx-employee-created_by}}',
            '{{%employee}}'
        );

        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-employee-updated_by}}',
            '{{%employee}}'
        );

        // drops index for column `updated_by`
        $this->dropIndex(
            '{{%idx-employee-updated_by}}',
            '{{%employee}}'
        );

        $this->dropTable('{{%employee}}');
    }
}
