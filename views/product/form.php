<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

use kartik\widgets\ActiveForm;
use kartik\widgets\FileInput;

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
?>

<?= Menu::widget([
	'items' => Menu::admin()
]) ?>

<div id="product-form" class="container">

	<div class="row">

		<div class="col-md-12">

			<div class="clearfix">
				<div class="pull-left">
					<h1>
						<?= \Yii::t('product', $meta->id ? 'Edit product' : 'Create a product') ?>
					</h1>
				</div>
				<div class="pull-right">
					<?= ShortcutsModal::widget(['target'=>$meta]) ?>
				</div>
			</div>

			<?php $form = ActiveForm::begin([
				'id' => 'login-form',
				'options' => [
					'enctype' => 'multipart/form-data',
				],
				'type' => ActiveForm::TYPE_HORIZONTAL,
			]) ?>

				<?= $form->field($i18n, 'name') ?>
				<?= $form->field($i18n, 'body')->textarea(['rows'=>20]) ?>

				<?= $form->field($meta, 'tags')->checkboxList($tags) ?>

				<?php if ($meta->parent): ?>
				<input type="hidden" name="parent_id" value="<?= $meta->parent_id ?>" />
				<?php endif; ?>

				<div class="col-md-offset-2 col-md-10">
					<h3>Bilder</h3>

					<div>
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
					
					<ol class="product-images sortable">
						<?php foreach ($meta->images as $img): ?>
						<li class="image col-md-2">
							<img src="<?= app\widgets\ImageWidget::thumbnail($img) ?>" />
							<input type="hidden" name="image_sort[]" value="<?= $img->id ?>" />
						</li>
						<?php endforeach; ?>
					</ol>
	
				</div>				

				<div class="form-group pull-right">
					<?= Html::submitButton(Yii::t('common', 'Save'), ['class' => 'btn btn-primary']) ?>
				</div>

			<?php ActiveForm::end(); ?>
		</div>

	</div>

</div>
