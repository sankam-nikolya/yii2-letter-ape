<?php

namespace soovorow\letter_ape\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Migration;
use yii\db\Schema;

/**
 * @author Dmitry Suvorov <soovorow@gmail.com>
 */
class Click extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        $table_name = 'letter_ape_messages';

        if (Yii::$app->db->schema->getTableSchema($table_name) === null) {
            $migration = new Migration();
            $migration->createTable($table_name, [
                'id' => Schema::TYPE_PK,
                'message_id' => Schema::TYPE_INTEGER,
                'url' => Schema::TYPE_TEXT,
                'clicks' => Schema::TYPE_INTEGER,
                'created_at' => Schema::TYPE_INTEGER,
                'updated_at' => Schema::TYPE_INTEGER,
            ]);
        }

        return $table_name;
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className()
        ];
    }

}
