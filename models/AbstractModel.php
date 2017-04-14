<?php

namespace soovorow\letter_ape\models;

use yii\behaviors\TimestampBehavior;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;
use yii\helpers\Url;

/**
 * @author Dmitry Suvorov <soovorow@gmail.com>
 */
abstract class AbstractModel extends ActiveRecord
{

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
     * Get data provider
     * @return ActiveDataProvider
     */
    public static function getDataProvider()
    {
        return new ActiveDataProvider([
            'query' => self::find(),
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ],
            ]
        ]);
    }

    abstract static function getColumns();

    public static function getCreateLink()
    {
        return Url::to(['/letter_ape/action/create', 'model_name' => self::className()]);
    }
}
