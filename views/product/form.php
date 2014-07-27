<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

use kartik\widgets\ActiveForm;
use kartik\widgets\FileInput;
use kartik\sortable\Sortable;

use app\widgets\Menu;
use app\models\MetaTag;
use app\widgets\ShortcutsModal;

/**
 * @var app\components\View $this
 */

//app\assets\SortableAsset::register($this);

$tags = MetaTag::find()
	->asArray()
	->with('i18n')
	->all();
$tags = ArrayHelper::map($tags, 'id', 'i18n.name');

$sortableImageItems = array_map(function ($img) {
	return [
		'content' => '<img src="'.app\widgets\ImageWidget::thumbnail($img).'" />'
				.'<input type="hidden" name="image_sort[]" value="'.$img->id.'" />',
	];
}, $meta->images);
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

				<?= $form->field($i18n, 'name', $meta->parent ? ['addon' => ['prepend' => ['content'=>$meta->parent->i18n->name]]] : []) ?>
				<?php if (!$meta->parent): // Unterprodukte können keinen Shortcut haben, da sie auch keine eigene Seite haben ?>
				<?= $form->field($i18n, 'shortcut_active') ?>
				<?php endif; ?>
				<?= $form->field($i18n, 'body')->textarea(['rows'=>20]) ?>

				<?= $form->field($meta, 'tags')->checkboxList($tags) ?>

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

				<div class="form-group pull-right">
					<?= Html::submitButton(Yii::t('common', 'Save'), ['class' => 'btn btn-primary']) ?>
				</div>

			<?php ActiveForm::end(); ?>
		</div>

	</div>

</div>
