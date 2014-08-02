<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

use kartik\widgets\ActiveForm;
use kartik\widgets\FileInput;
use kartik\widgets\InputWidget;
use kartik\sortable\Sortable;

use app\widgets\Menu;
use app\models\MetaTag;
use app\widgets\ShortcutsModal;

/**
 * @var app\components\View $this
 */

$tags = MetaTag::find()
	->asArray()
	->joinWith('i18n')
	->all();
$tags = ArrayHelper::map($tags, 'id', 'i18n.name');

$sortableImageItems = array_map(function ($img) {
	return [
		'content' => '<img src="'.app\widgets\ImageWidget::thumbnail($img).'" />'
				.'<input type="hidden" name="image_sort[]" value="'.$img->id.'" />',
	];
}, $meta->images);

$sortableMediaItems = array_map(function ($media) {
	return [
		'content' => $media->name.' (<a href="'.$media->url.'" target="_blank">'.$media->url.'</a>)'
			.'<input type="hidden" name="medias_sort[]" value="'.$media->id.'" />',
	];
}, $meta->medias);
?>

<?= Menu::widget([
	'items' => Menu::admin()
]) ?>

<div id="product-form" class="container">

	<div class="row">

		<div class="col-md-12">
			<h1>
				<?= \Yii::t('product', $meta->id ? 'Edit product' : 'Create a product') ?>
			</h1>

			<?php $form = ActiveForm::begin([
				'id' => 'login-form',
				'options' => [
					'enctype' => 'multipart/form-data',
				],
				'type' => ActiveForm::TYPE_HORIZONTAL,
			]) ?>

				<?= $form->field($i18n, 'name', $meta->parent ? ['addon' => ['prepend' => ['content'=>($meta->parent->i18n ? $meta->parent->i18n->name : Yii::t('common', 'Translation missing!'))]]] : []) ?>
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
