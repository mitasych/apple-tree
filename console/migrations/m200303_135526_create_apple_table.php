<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%apple}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%color}}`
 */
class m200303_135526_create_apple_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%apple}}', [
            'id' => $this->primaryKey(),
            'color_id' => $this->integer()->notNull(),
            'state' => $this->integer()->notNull(),
            'size' => $this->decimal(3, 2)->notNull(),
            'created_at' => $this->integer()->notNull(),
            'fallen_at' => $this->integer(),
            'active' => $this->boolean()->notNull()->defaultValue(true)
        ]);

        // creates index for column `color_id`
        $this->createIndex(
            '{{%idx-apple-color_id}}',
            '{{%apple}}',
            'color_id'
        );

        // add foreign key for table `{{%color}}`
        $this->addForeignKey(
            '{{%fk-apple-color_id}}',
            '{{%apple}}',
            'color_id',
            '{{%apple_color}}',
            'id',
            'RESTRICT',
            'RESTRICT'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%color}}`
        $this->dropForeignKey(
            '{{%fk-apple-color_id}}',
            '{{%apple}}'
        );

        // drops index for column `color_id`
        $this->dropIndex(
            '{{%idx-apple-color_id}}',
            '{{%apple}}'
        );

        $this->dropTable('{{%apple}}');
    }
}
