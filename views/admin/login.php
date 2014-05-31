<?php
use yii\helpers\Html;
use kartik\widgets\ActiveForm;;

/**
 * @var yii\web\View $this
 * @var yii\widgets\ActiveForm $form
 * @var \app\models\LoginForm $model
 */

?>

<div class="container">

    <div class="row">
        <div class="col-md-12">
        	<h1>Login</h1>
        
            <?php $form = ActiveForm::begin([
            	'id' => 'login-form',
            	 'type' => ActiveForm::TYPE_INLINE,
            ]); ?>
            
                <?= $form->field($model, 'username') ?>
                <?= $form->field($model, 'password')->passwordInput() ?>

                <div class="form-group">
                    <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                </div>
                
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
