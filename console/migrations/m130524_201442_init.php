<?php

use yii\db\Migration;

class m130524_201442_init extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'phone' => $this->string()->notNull(),
            'email' => $this->string()->notNull(),
            'token' => $this->string(255),
            'role' => $this->integer(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'deleted_at' => $this->integer(),
            'status' => $this->smallInteger()->notNull()->defaultValue(\common\models\User::STATUS_INACTIVE),
        ], $tableOptions);

        $this->createIndex(
            '{{%idx-user-email}}',
            '{{%user}}',
            'email'
        );


        $this->insert('{{%user}}', [
            'phone' => '+998110000000',
            'email' => 'test@gmail.com',
            'token' => Yii::$app->security->generateRandomString(64),
            'role' => \common\models\User::ROLE_ADMIN,
            'auth_key' => Yii::$app->security->generateRandomString(),
            'password_hash' => Yii::$app->security->generatePasswordHash('test123'),
            'created_at' => date('U'),
            'updated_at' => date('U'),
            'status' => \common\models\User::STATUS_ACTIVE
        ]);
    }

    public function safeDown()
    {
        $this->dropIndex(
            '{{%idx-user-email}}',
            '{{%user}}',
        );

        $this->dropTable('{{%user}}');
    }
}
