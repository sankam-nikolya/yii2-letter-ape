<?php

namespace soovorow\letter_ape\controllers;

use soovorow\letter_ape\models\Click;
use soovorow\letter_ape\models\Message;
use Yii;
use yii\filters\AccessControl;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\Response;
use yii\web\ServerErrorHttpException;

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
     * @return \yii\console\Response|Response
     * @throws ServerErrorHttpException
     */
    public function actionTrackOpen($key)
    {
        $message_id = explode('.', $key)[0];

        if ($m = Message::findOne($message_id)) {
            $m->trackOpen();
        }

        $response = Yii::$app->response;
        $response->headers->add('content-type','image/png');
        $response->format = Response::FORMAT_RAW;
        $response->stream = @fopen(dirname(__DIR__).'/image.jpg', 'r');
        return $response;
    }

    /**
     * Track message opens
     * @param $message_id
     * @param string $url
     * @return Response
     * @throws BadRequestHttpException
     */
    public function actionTrackClick($message_id, $url)
    {
        if (!$m = Message::findOne($message_id)) {
            throw new BadRequestHttpException();
        }

        $clickParams = ['message_id' => $message_id, 'url' => $url];

        if (!$c = Click::findOne($clickParams)) {
            $c = new Click($clickParams);
        }

        $c->trackClick();

        return $this->redirect($url);
    }

}











