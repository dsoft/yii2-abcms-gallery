<?php
namespace abcms\gallery\migrations;

use yii\db\Schema;
use yii\db\Migration;

class m151216_114713_create_gallery_image extends Migration
{

    public function up()
    {
        $this->createTable('gallery_image', [
            'id' => $this->primaryKey(),
            'albumId' => $this->integer()->notNull(),
            'image' => $this->string(50)->notNull(),
            'active' => $this->boolean()->defaultValue(1)->notNull(),
            'deleted' => $this->boolean()->defaultValue(0)->notNull(),
            'ordering' => $this->integer()->defaultValue(1)->notNull(),
        ]);
    }

    public function down()
    {
        $this->dropTable('gallery_image');
    }

}
