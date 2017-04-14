<?php

namespace soovorow\letter_ape\models;

use Yii;
use yii\db\Migration;
use yii\db\Schema;

/**
 * @property mixed email
 *
 * @author Dmitry Suvorov <soovorow@gmail.com>
 */
class Member extends AbstractModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        $table_name = 'letter_ape_member';

        if (Yii::$app->db->schema->getTableSchema($table_name) === null) {
            $migration = new Migration();
            $migration->createTable($table_name, [
                'id' => Schema::TYPE_PK,
                'email' => Schema::TYPE_STRING,
                'first_name' => Schema::TYPE_STRING,
                'last_name' => Schema::TYPE_STRING,
                'description' => Schema::TYPE_TEXT,
                'status' => Schema::TYPE_INTEGER,
                'created_at' => Schema::TYPE_INTEGER,
                'updated_at' => Schema::TYPE_INTEGER,
            ]);
        }

        return $table_name;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email'], 'email'],
            [['email'], 'required'],
            [['first_name','last_name','description','status'], 'default']
        ];
    }

    /**
     * @inheritdoc
     */
    static function getColumns()
    {
        return [
            'email',
            'first_name',
            'last_name',
            'description',
            'status',
            'created_at:datetime',
            'updated_at:datetime',
        ];
    }
}
