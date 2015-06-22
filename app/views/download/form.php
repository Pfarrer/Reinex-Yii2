<?php
use app\models\DownloadI18n;
use app\models\DownloadMeta;
use app\widgets\GoBackButton;
use kartik\widgets\ActiveForm;
use yii\helpers\Html;

/** @var app\components\View $this */
/** @var DownloadMeta $meta */
/** @var DownloadI18n $i18n */
?>

<div class="row">
<div class="col-md-12">

	<h1>
		<?= Yii::t('download', $meta->isNewRecord ? 'Create a download' : 'Edit download') ?>
	</h1>

	<?php $form = ActiveForm::begin([
		'id' => 'download-form',
		'options' => [
			'enctype' => 'multipart/form-data',
		],
		'type' => ActiveForm::TYPE_HORIZONTAL,
	]) ?>

	<?= $form->field($i18n, 'name') ?>
	<?= $form->field($i18n, 'shortcut_active') ?>
	<?= $form->field($i18n, 'body')->textarea(['rows'=>20]) ?>

	<?php if ($meta->isNewRecord): ?>
		<div class="form-group">
			<label class="control-label col-md-2">File</label>
			<div class="col-md-10">
				<?= Html::fileInput('file', null, ['class' => 'form-control']) ?>
			</div>
		</div>
	<?php endif; ?>

	<?= GoBackButton::widget() ?>

	<div class="form-group pull-right">
		<?= Html::submitButton(Yii::t('common', 'Save'), ['class' => 'btn btn-primary']) ?>
	</div>

	<?php ActiveForm::end(); ?>

</div>
</div>