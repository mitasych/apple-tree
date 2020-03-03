<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%apple_color}}`.
 */
class m200303_124103_create_apple_color_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%apple_color}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'slug' => $this->string()->notNull(),
            'color' => $this->string()->notNull(),
        ]);

        $this->batchInsert('{{%apple_color}}', [
            'name', 'slug', 'color'
        ], [
            ['зелёное', 'green', '#21a600'],
            ['жёлтое', 'yellow', '#fbff00'],
            ['красное', 'red', '#ff0000']
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%apple_color}}');
    }
}
