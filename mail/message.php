<?php

use yii\helpers\Html;
use yii\helpers\Url;

/** @var $message \soovorow\letter_ape\models\Message */

echo Html::img(Url::to(['action/track-open', 'key' => $message->id.'.jpg'], true));

echo preg_replace(
    '/<a(.*)href="([^"]*)"(.*)>/',
    '<a$1href="'.(Url::to(['action/track-click','message_id' => $message->id], true)).'&url=$2"$3>',
    $message->body
);