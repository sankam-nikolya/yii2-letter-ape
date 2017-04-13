<?php

namespace soovorow\letter_ape\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Migration;
use yii\db\Schema;

/**
 * @author Dmitry Suvorov <soovorow@gmail.com>
 * @property mixed opens
 */
class Message extends ActiveRecord
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
                'email' => Schema::TYPE_STRING,
                'title' => Schema::TYPE_TEXT,
                'body' => Schema::TYPE_TEXT,
                'status' => Schema::TYPE_INTEGER,
                'opens' => Schema::TYPE_INTEGER,
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

    /**
     * Increase opens counter
     * @return bool
     */
    public function trackOpen()
    {
        $this->opens > 0 ? $this->opens++ : $this->opens = 1;
        return $this->save(false);
    }
}
