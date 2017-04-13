<?php

namespace soovorow\letter_ape\controllers;

use soovorow\letter_ape\models\Message;
use yii\filters\AccessControl;
use yii\web\Controller;

/**
 * @author Dmitry Suvorov <soovorow@gmail.com>
 */
class ActionController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['error', 'track-open', 'track-click'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Track message opens
     * @param $key
     * @return string
     */
    public function actionTrackOpen($key)
    {
        $message_id = explode('.', $key)[0];

        if ($m = Message::findOne($message_id)) {
            $m->opens > 0 ? $m->opens++ : $m->opens = 1;
            $m->save(false);
        }

        return $this->renderFile(dirname(__DIR__).'/image.jpg');
    }

    /**
     * Track message opens
     * @param $message_id
     * @param null|string $url
     */
    public function actionTrackClick($message_id, $url = null)
    {

    }

}