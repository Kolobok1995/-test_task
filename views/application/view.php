<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Application */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Список заявок', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="application-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
    <?php if($model->status !== \app\models\Application::STATUS_VIEWED): ?>
        <?= Html::a('На эту заявку я ответил', ['setstatus', 'id' => $model->id], [
            'class' => 'btn btn-info',
            'data' => [
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <?php endif; ?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [               
                'label'=>'Пользователь',
                'value'=>function($data){
                    return $data->user->username;
                }
            ],    
            [
                'label'=>'Почта клиента',
                'value'=>function($data){
                    return $data->user->email;
                }
            ], 
            [
                'label'=>'Файл',
                'format' => 'raw',
                'value'=>function($data){
                    return !empty($data->file) ?  "<a target='target'  href='$data->file'>Просмотреть файл</a>" : ' - ';
                }               
            ], 
            'subject',
            'message:ntext',           
            [
              'label'=>'Статус',
               'value'=>function($data){
                   return $data->statusText;
               }
            ],
            [
                'label'=>'Дата создания заявки',
                'value'=>function($data){
                    return date("d.m.Y", $data->created_at);
                }    
            ],
            [
                'label'=>'Время создания заявки',
                'value'=>function($data){
                    return date("H:i:s", $data->created_at);
                }    
            ],
        ],
    ]) ?>

</div>
