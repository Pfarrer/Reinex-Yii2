<?php
use app\forms\ProductForm;
use app\models\Image;
use app\models\ProductMedia;
use app\models\TagMeta;
use kartik\sortable\Sortable;
use kartik\widgets\ActiveForm;
use kartik\widgets\FileInput;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/** @var app\components\View $this */
/** @var ProductForm $model */

$tags = TagMeta::find()->asArray()->joinWith('i18n')->all();
$tags = ArrayHelper::map($tags, 'id', 'i18n.name');

$sortableImageItems = array_map(function (Image $img) {
	return [
		'content' => '<img src="'.app\widgets\ImageWidget::thumbnail($img).'" />'
				.'<input type="hidden" name="image_sort[]" value="'.$img->id.'" />',
	];
}, $model->images);

$sortableMediaItems = array_map(function (ProductMedia $media) {
	return [
		'content' => $media->name.' (<a href="'.$media->url.'" target="_blank">'.$media->url.'</a>)'
			.'<input type="hidden" name="medias_sort[]" value="'.$media->id.'" />',
	];
}, $model->medias);
?>

<div class="row">
<div class="col-md-12">

	<h1><?= Yii::t('product', $model->meta->isNewRecord ? 'Edit product' : 'Create a product') ?></h1>

	<?php $form = ActiveForm::begin([
		'id' => 'login-form',
		'options' => [
			'enctype' => 'multipart/form-data',
		],
		'type' => ActiveForm::TYPE_HORIZONTAL,
	]) ?>

	<?= $form->field($model->i18n, 'name', $model->meta->parent
		? ['addon' => ['prepend' => [
			'content'=> ($model->meta->parent->i18n ? $model->meta->parent->i18n->name : Yii::t('common', 'Translation missing!'))
		]]]
		: []
	) ?>

	<?php if (!$model->meta->parent): // Unterprodukte können keinen Shortcut haben, da sie auch keine eigene Seite haben ?>
		<?= $form->field($model->i18n, 'shortcut_active') ?>
	<?php endif; ?>

	<?= $form->field($model->i18n, 'body')->textarea(['rows'=>20]) ?>

	<?php if (!$model->meta->parent): // Unterprodukte haben keine Tags ?>
		<?= $form->field($model->meta, 'tags')->checkboxList($tags) ?>
	<?php endif; ?>

	<?php if ($model->meta->parent): ?>
		<input type="hidden" name="parent_id" value="<?= $model->meta->parent_id ?>" />
	<?php endif; ?>

			<div class="form-group field-images">
				<label class="col-md-2 control-label" for="images">Bilder</label>
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

					<?= Sortable::widget([
						'type' => Sortable::TYPE_GRID,
						'items' => $sortableImageItems,
					]) ?>

				</div>
			</div>

			<div class="form-group field-medias">
				<label class="col-md-2 control-label" for="medias">Media</label>
				<div class="col-md-10">
					<?= Sortable::widget([
						//'type' => Sortable::TYPE_GRID,
						'items' => $sortableMediaItems,
					]) ?>
					<input type="text" class="form-control" name="media_url" />
				</div>
			</div>

			<div class="form-group pull-right">
				<?= Html::submitButton(Yii::t('common', 'Save'), ['class' => 'btn btn-primary']) ?>
			</div>

		<?php ActiveForm::end(); ?>
	</div>

</div>
</div>