<?php
use app\components\Url;
use app\models\Image;
use app\models\ProductMeta;
use app\widgets\ImageUpload;
use app\widgets\ImageWidget;
use kartik\sortable\Sortable;
use yii\bootstrap\ActiveForm;

/** @var $this yii\web\View */
/** @var $meta ProductMeta */
?>

<?php if (Yii::$app->user->isGuest): ?>

	<?php foreach ($meta->images as $img): ?>
		<a class="fancybox" rel="group" href="<?= ImageWidget::full($img) ?>">
			<img src="<?= ImageWidget::thumbnail($img) ?>" alt="" />
		</a>
	<?php endforeach; ?>

<?php else: ?>

	<?php $form = ActiveForm::begin([
		'id' => 'image-sort',
		'action' => Url::to(['edit_images', 'id'=>$meta->id]),
	]) ?>

	<?php
		$sortableImageItems = array_map(function (Image $img) {
			return [
				'content' => '<img src="'.ImageWidget::thumbnail($img).'" />'
					.'<input type="checkbox" name="image_selected[]" value="'.$img->id.'" />'
					.'<input type="hidden" name="image_sort[]" value="'.$img->id.'" />',
			];
		}, $meta->images);
		echo Sortable::widget([
			'type' => Sortable::TYPE_GRID,
			'items' => $sortableImageItems,
		]);
	?>

	<button type="submit" class="btn btn-primary pull-right" name="action" value="sort">
		<i class="glyphicon glyphicon-retweet"></i>
		Save order
	</button>

	<button type="submit" class="btn btn-warning pull-right" name="action" value="move">
		<i class="glyphicon glyphicon-share-alt"></i>
		Move selected
	</button>

	<button type="submit" class="btn btn-warning pull-right" name="action" value="delete">
		<i class="glyphicon glyphicon-trash"></i>
		Delete selected
	</button>

	<?= ImageUpload::widget([
		'url' => ['product/upload', 'id'=>$meta->id],
	]) ?>

	<?php ActiveForm::end() ?>

<?php endif; ?>