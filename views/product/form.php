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
            	'type' => ActiveForm::TYPE_HORIZONTAL,
            ]) ?>
            
                <?= $form->field($i18n, 'title') ?>
                <?= $form->field($i18n, 'body')->textarea() ?>

				<div class="form-group pull-right">
					<?= Html::submitButton(Yii::t('common', 'Save'), ['class' => 'btn btn-primary']) ?>
                </div>

				<?= $form->field($meta, 'images')->widget(FileInput::classname(), [
					'options' => [
						'accept' => 'image/*',
						'multiple' => true,
					],
				]) ?>
                
            <?php ActiveForm::end(); ?>
        </div>

		<div class="col-md-8">

			<div class="well well-small">
				<?= FileInput::widget([
					'name' => 'attachments',
					'options' => ['multiple' => true],
				]) ?>
			</div>

		</div>

    </div>
</div>
