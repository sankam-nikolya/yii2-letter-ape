<?php

namespace soovorow\letter_ape\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Migration;
use yii\db\Schema;
use yii\helpers\Url;

/**
 * @author Dmitry Suvorov <soovorow@gmail.com>
 * @property mixed clicks
 * @property mixed message_id
 */
class Click extends AbstractModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        $table_name = 'letter_ape_click';

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
     * Create tracking url
     * @param $to
     * @return string|Url
     */
    public static function createUrl($to)
    {
        return Url::to(['/letter-ape/track-click', 'url' => $to], true);
    }

    /**
     * Increase click counter
     * @return bool
     */
    public function trackClick()
    {
        $this->clicks > 0 ? $this->clicks++ : $this->clicks = 1;

        if ($m = Message::findOne($this->message_id)) {
            if (!$m->opens > 0) {
                $m->opens = 1;
                $m->save(false);
            }
        }

        return $this->save(false);
    }

    static function getColumns()
    {
        // TODO: Implement getColumns() method.
    }
}
