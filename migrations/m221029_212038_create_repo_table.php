<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%repo}}`.
 */
class m221029_212038_create_repo_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%repo}}', [
            'id' => $this->primaryKey()->unsigned(),
            'user_id' => $this->integer()->unsigned()->notNull(),
            'name' => $this->string()->notNull(),
            'updated_at' => $this->dateTime()->notNull(),
        ]);

        $this->createIndex(
            '{{%idx-repo-user_id}}',
            '{{%repo}}',
            'user_id'
        );

        $this->addForeignKey(
            '{{%fk-repo-user_id}}',
            '{{%repo}}',
            'user_id',
            '{{%user}}',
            'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('{{%fk-repo-user_id}}', '{{%repo}}');
        $this->dropIndex('{{%idx-repo-user_id}}', '{{%repo}}');

        $this->dropTable('{{%repo}}');
    }
}
