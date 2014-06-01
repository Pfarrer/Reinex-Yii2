<?php
use yii\helpers\Html;
use kartik\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 */

?>

<div class="container">

    <div class="row">
        <div class="col-md-12">
        	<h1><?= \Yii::t('product', $meta->id ? 'Edit product' : 'Create a product') ?></h1>
        
            <?php $form = ActiveForm::begin([
            	'id' => 'login-form',
            	'type' => ActiveForm::TYPE_HORIZONTAL,
            ]) ?>
            
                <?= $form->field($i18n, 'title') ?>
                <?= $form->field($i18n, 'body')->textarea() ?>

				<div class="form-group pull-right">
					<?= Html::submitButton(Yii::t('common', 'Save'), ['class' => 'btn btn-primary']) ?>
                </div>
                
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
