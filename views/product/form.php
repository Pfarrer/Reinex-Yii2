<?php
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use app\widgets\Menu;
use kartik\widgets\FileInput;

/**
 * @var yii\web\View $this
 */

?>

<?= Menu::widget([
	'items' => Menu::admin()
]) ?>

<div class="container">

    <div class="row">

        <div class="col-md-12">
        	<h1><?= \Yii::t('product', $meta->id ? 'Edit product' : 'Create a product') ?></h1>
        
            <?php $form = ActiveForm::begin([
            	'id' => 'login-form',
            	'options' => [
            		'enctype' => 'multipart/form-data',
            	],
            	'type' => ActiveForm::TYPE_HORIZONTAL,
            ]) ?>
            
                <?= $form->field($i18n, 'title') ?>
                <?= $form->field($i18n, 'body')->textarea() ?>

				<div class="form-group">
					<label class="col-md-2 control-label" for="metaproduct-images">Bilder hinzufügen</label>
		            <div class="col-md-10">
						<?= FileInput::widget([
							'name' => 'images[]',
							'options' => [
								'id' => 'metaproduct-images',
								'accept' => 'image/*',
								'multiple' => true,
							],
							'pluginOptions' => [
								'browseLabel' => 'Durchsuchen',
								'showUpload' => false,
								'showRemove' => false,
							]
						]) ?>
					</div>
				</div>
				
				<div class="form-group pull-right">
					<?= Html::submitButton(Yii::t('common', 'Save'), ['class' => 'btn btn-primary']) ?>
                </div>
                
            <?php ActiveForm::end(); ?>
        </div>

    </div>
</div>
