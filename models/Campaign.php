<?php

namespace soovorow\letter_ape\models;

use Yii;
use yii\db\Migration;
use yii\db\Schema;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @author Dmitry Suvorov <soovorow@gmail.com>
 *
 * @property integer status
 * @property mixed body
 * @property mixed id
 * @property mixed title
 */
class Campaign extends AbstractModel
{
    const STATUS_PREPARED = 0;

    const STATUS_SENT = 1;

    public $from = '';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        $table_name = 'letter_ape_campaign';

        if (Yii::$app->db->schema->getTableSchema($table_name) === null) {
            $migration = new Migration();
            $migration->createTable($table_name, [
                'id' => Schema::TYPE_PK,
                'title' => Schema::TYPE_TEXT,
                'description' => Schema::TYPE_TEXT,
                'body' => Schema::TYPE_TEXT,
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
            [['title'], 'required'],
            [['description', 'body'], 'default']
        ];
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if ($this->isNewRecord) {
            $this->status = self::STATUS_PREPARED;
        }
        return parent::beforeSave($insert);
    }

    /**
     * @inheritdoc
     */
    static function getColumns()
    {
        return [
            'title',
            'description',
            [
                'attribute' => 'status',
                'value' => function ($model) {
                    /** @var $model Campaign */
                    return $model->getStatus();
                }
            ],
            'created_at:datetime',
            [
                'format' => 'raw',
                'value' => function ($model) {
                    /** @var $model Campaign */
                    $response = null;
                    if ($model->status == $model::STATUS_PREPARED) {
                        $response = Html::a( 'SEND',
                            Url::to(['/letter_ape/action/send-campaign','id' => $model->id]),
                            [
                                'class' => 'btn btn-default w100',
                                'data-confirm' => 'Are you sure?'
                            ]);
                    } else {
                        $response .= $model->getSentMessagesCount().' sent ';
                        $response .= $model->getSentMessagesOpens().' opens ';
                        $response .= $model->getSentMessagesClicks().' clicks';
                    }
                    return $response;
                }
            ]
        ];
    }

    public static function statuses()
    {
        return [
            self::STATUS_PREPARED => 'Prepared',
            self::STATUS_SENT => 'Sent',
        ];
    }

    public function getStatus()
    {
        return self::statuses()[$this->status];
    }

    public function send()
    {
        if ($members = Member::find()->all()) {

            $this->status = self::STATUS_SENT;
            $this->save(false);

            foreach ($members as $u)
            {
                $m = new Message();
                $m->from = $this->from;
                $m->title = $this->title;
                $m->body = $this->body;
                $m->campaign_id = $this->id;

                /** @var $u Member */
                $m->email = $u->email;

                if ($m->save(false)) {
                    if ($m->send()) {
                        $m->status = $m::STATUS_SENT;
                    } else {
                        $m->status = $m::STATUS_ERROR;
                    }
                    $m->save(false);
                };
            }
        };
    }

    public function getSentMessagesCount()
    {
        return Message::find()
            ->where(['campaign_id' => $this->id])
            ->groupBy('email')
            ->count();
    }

    public function getSentMessagesOpens()
    {
        return Message::find()
            ->where(['campaign_id' => $this->id])
            ->andWhere(['>', 'opens', '0'])
            ->count();
    }

    public function getSentMessagesClicks()
    {
        $clicks =  Message::find()
            ->where(['campaign_id' => $this->id])
            ->leftJoin(Click::tableName().' c', 'c.message_id = '.Message::tableName().'.id')
            ->andWhere(['>', 'clicks', 0])
            ->count();
        return $clicks > 0 ? $clicks : 0;
    }
}
