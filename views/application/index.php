<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Список заявок';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="application-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            
            'id',
            'subject',
            'message:ntext',
            [
                'attribute'=>'user_id',
                'label'=>'Пользователь',
                'content'=>function($data){
                    return $data->user->username;
                }
            ],            
            [
                'attribute'=>'file',
                'label'=>'Ссылка на файл',
                'content'=>function($data){
                    return !empty($data->file) ? "<a target='target'  href='$data->file'>Просмотреть файл</a>" : ' - ';
                }
            ],
            [
                'attribute'=>'status',
                'label'=>'Статус',
                'content'=>function($data){
                    return $data->statusText;
                }
            ],
            
            [
                'attribute'=>'created_at',
                'label'=>'Дата создания заявки',
                'content'=>function($data){
                    return date("d.m.Y (H:i:s)", $data->created_at);
                }
            ],

            ['class' => 'yii\grid\ActionColumn',
                'template' => '{view}',
            ],
        ],
    ]); ?>


</div>
