<?php

use soovorow\letter_ape\models\Campaign;
use soovorow\letter_ape\models\Member;
use yii\grid\GridView;
use yii\helpers\Html;

?>

<style>
    .inline-block {
        display: inline-block;
    }
    h1.inline-block,
    .h1.inline-block {
        margin: 0;
    }
    .header {
        padding: 60px 0 ;
    }
</style>

<div class="container">

    <div class="row">
        <div class="header">
            <h1 class="inline-block">
                New <?= $model::className() ?>
            </h1>
            <?= Html::a('Go back', ['index'], [
                'class' => 'btn btn-default pull-right'
            ]) ?>
        </div>

        <?php
        $form = \yii\widgets\ActiveForm::begin();
        $except = [
            'created_at',
            'updated_at',
            'status',
            'id',
        ];
        foreach ($model->attributes() as $attribute) {
            if (!in_array($attribute, $except)) {
                if ($attribute == 'body') {
                    echo $form->field($model, $attribute)->textarea();
                } else {
                    echo $form->field($model, $attribute);
                }
            }
        }
        echo Html::submitButton('Create', ['class' => 'btn btn-primary pull-right']);
        $form::end();
        ?>
    </div>

</div>