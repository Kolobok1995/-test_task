<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Contact';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-contact">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (Yii::$app->session->hasFlash('contactFormSubmitted')): ?>

        <div class="alert alert-success">
            Заявка оправлена! 
        </div>

    <?php elseif(Yii::$app->session->hasFlash('contactFormErrorTime')): ?>
   		  <div class="alert alert-danger">
          К сожалению отправить заявку можно раз в сутки.
          <br>
          Подождите еще <?php echo Yii::$app->session->getFlash('contactFormErrorTime'); ?> 
      	  </div>
    <?php else: ?>

        <p>
            If you have business inquiries or other questions, please fill out the following form to contact us.
            Thank you.
        </p>

        <div class="row">
            <div class="col-lg-5">

                <?php $form = ActiveForm::begin(['id' => 'contact-form', 'options' => ['enctype' => 'multipart/form-data']]); ?>
                    <?= $form->field($model, 'subject') ?>

                    <?= $form->field($model, 'body')->textarea(['rows' => 6]) ?>
                    
                    <?= $form->field($model, 'imageFile')->fileInput() ?>
                    
                    <div class="form-group">
                        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
                    </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>

    <?php endif; ?>
</div>
