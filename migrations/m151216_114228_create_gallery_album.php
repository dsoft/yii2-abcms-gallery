<?php
namespace abcms\gallery\migrations;

use yii\db\Schema;
use yii\db\Migration;

/**
 *  ./yii migrate --migrationPath=@vendor/abcms/yii2-gallery/migrations
 */
class m151216_114228_create_gallery_album extends Migration
{

    public function up()
    {
        $this->createTable('gallery_album', [
            'id' => $this->primaryKey(),
            'title' => $this->string(100)->notNull(),
            'categoryId' => $this->integer()->notNull(),
            'active' => $this->boolean()->defaultValue(1)->notNull(),
            'deleted' => $this->boolean()->defaultValue(0)->notNull(),
            'ordering' => $this->integer()->defaultValue(1)->notNull(),
        ]);
    }

    public function down()
    {
        $this->dropTable('gallery_album');
    }

}
