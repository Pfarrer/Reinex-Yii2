<?php
use app\models\TagI18n;
use app\models\TagMeta;
use app\widgets\GoBackButton;
use kartik\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/** @var app\components\View $this */
/** @var TagMeta $meta */
/** @var TagI18n $i18n */
?>

<div class="row">
<div class="col-md-12">

	<h1><?= Yii::t('tag', $meta->isNewRecord ? 'Create a category' : 'Edit category') ?></h1>

	<?php $form = ActiveForm::begin([
		'id' => 'login-form',
		'type' => ActiveForm::TYPE_HORIZONTAL,
	]) ?>

	<?= $form->field($i18n, 'name') ?>
	<?= $form->field($i18n, 'body')->textarea(['rows'=>20]) ?>
	<?= $form->field($i18n, 'shortcut_active') ?>

	<?= GoBackButton::widget() ?>

	<div class="form-group pull-right">
		<?= Html::submitButton(Yii::t('common', 'Save'), ['class' => 'btn btn-primary']) ?>
	</div>

	<?php ActiveForm::end(); ?>

</div>
</div>