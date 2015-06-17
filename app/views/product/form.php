<?php
use app\models\ProductI18n;
use app\models\ProductMeta;
use app\models\TagMeta;
use app\widgets\GoBackButton;
use kartik\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/** @var app\components\View $this */
/** @var ProductMeta $meta */
/** @var ProductI18n $i18n */

$tags = TagMeta::find()->asArray()->joinWith('i18n')->all();
$tags = ArrayHelper::map($tags, 'id', 'i18n.name');
?>

<div class="row">
<div class="col-md-12">

	<h1><?= Yii::t('product', $meta->isNewRecord ? 'Create a product' : 'Edit product') ?></h1>

	<?php $form = ActiveForm::begin([
		'id' => 'login-form',
		'type' => ActiveForm::TYPE_HORIZONTAL,
	]) ?>

	<?= $form->field($i18n, 'name',
		$meta->parent ? ['addon' => ['prepend' => [
			'content'=> ($meta->parent->i18n ? $meta->parent->i18n->name : Yii::t('common', 'Translation missing!'))
		]]] : []
	) ?>
	
	<?php if (!$meta->parent): // Unterprodukte können keinen Shortcut haben, da sie auch keine eigene Seite haben ?>
		<?= $form->field($i18n, 'shortcut_active') ?>
	<?php endif; ?>

	<?= $form->field($i18n, 'body')->textarea(['rows'=>20]) ?>

	<?php if (!$meta->parent): // Unterprodukte haben keine Tags ?>
		<?= $form->field($meta, 'tags')->checkboxList($tags) ?>
	<?php endif; ?>

	<?php if ($meta->parent): ?>
		<input type="hidden" name="parent_id" value="<?= $meta->parent_id ?>" />
	<?php endif; ?>

	<?= GoBackButton::widget() ?>

	<div class="form-group pull-right">
		<?= Html::submitButton(Yii::t('common', 'Save'), ['class' => 'btn btn-primary']) ?>
	</div>

	<?php ActiveForm::end(); ?>

</div>
</div>