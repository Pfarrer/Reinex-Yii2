<?php
use app\widgets\Menu;
use app\widgets\ShortcutsModal;
use kartik\sortable\Sortable;
use kartik\widgets\ActiveForm;
use kartik\widgets\FileInput;
use yii\helpers\Html;

/** @var app\components\View $this */
?>

<?= Menu::widget([
	'items' => Menu::admin()
]) ?>

<div class="container">

	<div class="row">

		<div class="col-md-12">
			<h1>
				<?= \Yii::t('download', $meta->id ? 'Edit Download' : 'Create Download') ?>
			</h1>

			<?php $form = ActiveForm::begin([
				'id' => 'download-form',
				'options' => [
					'enctype' => 'multipart/form-data',
				],
				'type' => ActiveForm::TYPE_HORIZONTAL,
			]) ?>

				<?= $form->field($i18n, 'name') ?>
				<?= $form->field($i18n, 'body')->textarea(['rows'=>20]) ?>

				<?= Html::activeFileInput($meta, 'filename') ?>
				<?= Html::fileInput('file') ?>

				<div class="form-group pull-right">
					<?= Html::submitButton(Yii::t('common', 'Save'), ['class' => 'btn btn-primary']) ?>
				</div>

			<?php ActiveForm::end(); ?>
		</div>

	</div>

</div>
