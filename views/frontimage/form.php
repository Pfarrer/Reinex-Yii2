<?php
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\widgets\FileInput;
use app\widgets\Menu;

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
        	<h1><?= \Yii::t('tag', $meta->id ? 'Edit Frontimage' : 'Create a Frontimage') ?></h1>
        
            <?php $form = ActiveForm::begin([
            	'type' => ActiveForm::TYPE_HORIZONTAL,
            ]) ?>
            
                <?= $form->field($i18n, 'name') ?>
        		<?= $form->field($i18n, 'body')->textarea(['rows'=>10]) ?>
        		
        		<div class="form-group field-images">
					<label class="col-md-2 control-label" for="images">Bild</label>
					<div class="col-md-10">
						<?= FileInput::widget([
							'name' => 'image',
							'options' => [
								'accept' => 'image/*',
								'multiple' => false,
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
