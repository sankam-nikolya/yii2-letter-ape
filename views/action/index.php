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
        <div class="col-xs-12">
            <?php $campaignsDataProvider = Campaign::getDataProvider() ?>

            <div class="header">
                <h1 class="inline-block">
                    Campaigns: <?= $campaignsDataProvider->getTotalCount() ?>
                </h1>
                <?= Html::a('Create Campaign', Campaign::getCreateLink(), [
                    'class' => 'btn btn-primary pull-right'
                ]) ?>
            </div>

            <?= GridView::widget([
                'dataProvider' => $campaignsDataProvider,
                'columns' => Campaign::getColumns(),
            ]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <?php $memberDataProvider = Member::getDataProvider() ?>

            <div class="header">
                <h1 class="inline-block">
                    Members: <?= $memberDataProvider->getTotalCount() ?>
                </h1>
                <?= Html::a('Add user', Member::getCreateLink(), [
                    'class' => 'btn btn-primary pull-right'
                ]) ?>
            </div>

            <?= GridView::widget([
                'dataProvider' => $memberDataProvider,
                'columns' => Member::getColumns(),
            ]) ?>
        </div>
    </div>

</div>