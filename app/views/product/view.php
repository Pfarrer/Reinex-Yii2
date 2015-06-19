<?php
use app\assets\FancyboxAsset;
use app\components\Url;
use app\models\Image;
use app\models\ProductI18n;
use app\models\ProductMeta;
use app\widgets\GoBackButton;
use app\widgets\ImageUpload;
use app\widgets\ImageWidget;
use kartik\sortable\Sortable;
use yii\widgets\ActiveForm;

/** @var app\components\View $this */
/** @var ProductMeta $meta */
/** @var ProductI18n $i18n */

FancyboxAsset::register($this);
$this->registerCssFile('css/product.css');

$js = <<<JS
$(function () {
	$(".fancybox").fancybox({
		padding: 2,

		beforeShow: function () {
			/* Disable right click */
			$.fancybox.wrap.bind("contextmenu", function (e) {
				return false;
			});
		}
	});
});
JS;
$this->registerJs($js);
?>

<div class="row clearfix">

	<h1 class="col-md-9">
		<?= $i18n->name ?>
		<?php if (!Yii::$app->user->isGuest): ?>
			<small>
				<a href="<?= Url::to(['product/edit', 'id'=>$meta->id]) ?>">
					<i class="glyphicon glyphicon-pencil"></i> <?= Yii::t('product', 'Edit product') ?>
				</a>
			</small>
		<?php endif; ?>
	</h1>

	<?php if ($meta->tags): ?>
		<h3 class="col-md-3"><?= Yii::t('tag', 'Categories') ?></h3>
	<?php endif; ?>

	<div class="col-md-<?= $meta->tags ? 9 : 12 ?> body">
		<?= $this->textile($i18n->body) ?>
	</div>

	<?php if ($meta->tags): ?>
		<div class="categories col-md-3">
			<div class="list-group">
				<?php foreach ($meta->tags as $tag): ?>
					<?php if ($tag->count > 0): ?>
						<a href="<?= Url::toTag($tag) ?>" class="list-group-item">
							<?= $tag->i18n->name ?>
							<span class="badge"><?= $tag->count ?></span>
						</a>
					<?php endif; ?>
				<?php endforeach; ?>
			</div>
		</div>
	<?php endif; ?>

	<div class="images col-md-9">
		<?php if (Yii::$app->user->isGuest): ?>

			<?php foreach ($meta->images as $img): ?>
				<a class="fancybox" rel="group" href="<?= ImageWidget::full($img) ?>">
					<img src="<?= ImageWidget::thumbnail($img) ?>" alt="" />
				</a>
			<?php endforeach; ?>

		<?php else: ?>

			<?php $form = ActiveForm::begin([
				'id' => 'image-sort',
				'action' => Url::to(['sort_images', 'id'=>$meta->id]),
			]) ?>

			<?php
				$sortableImageItems = array_map(function (Image $img) {
					return [
						'content' => '<img src="'.ImageWidget::thumbnail($img).'" />'
								.'<input type="hidden" name="image_sort[]" value="'.$img->id.'" />',
					];
				}, $meta->images);
				echo Sortable::widget([
					'type' => Sortable::TYPE_GRID,
					'items' => $sortableImageItems,
				]);
			?>

			<input type="submit" class="btn btn-primary pull-right" value="Save">
			<?php if (!Yii::$app->user->isGuest): ?>
				<?= ImageUpload::widget([
					'url' => ['product/upload', 'id'=>$meta->id],
				]) ?>
			<?php endif; ?>

			<?php ActiveForm::end() ?>

		<?php endif; ?>
	</div>

	<?php if ($meta->medias): ?>
		<div class="medias">
			<script src="http://www.youtube.com/player_api"></script>

			<?php foreach ($meta->medias as $media): ?>
				<a class="fancybox fancybox.iframe" rel="group" href="<?= $media->url ?>">
					<img src="<?= ImageWidget::thumbnail($media->image) ?>" />
				</a>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>

</div>

<div class="row">
<div class="col-md-12">

	<?php foreach ($meta->children as $child): ?>

		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">
					<i><?= $meta->i18n->name ?></i>
					<?= $child->i18n->name ?>

					<?php if (!Yii::$app->user->isGuest): ?>
						<a href="<?= Url::to(['product/edit', 'id'=>$child->id]) ?>" class="pull-right">
							<i class="glyphicon glyphicon-pencil"></i> Ändern
						</a>
					<?php endif; ?>
				</h3>
			</div>
			<?php if (!empty($child->i18n->body)): ?>
				<div class="panel-body">
					<?= $this->textile($child->i18n->body) ?>
				</div>
			<?php endif; ?>
		</div>

		<div class="images">
			<?php if (Yii::$app->user->isGuest): ?>

				<?php foreach ($child->images as $img): ?>
					<a class="fancybox" rel="group" href="<?= ImageWidget::full($img) ?>">
						<img src="<?= ImageWidget::thumbnail($img) ?>" alt="" />
					</a>
				<?php endforeach; ?>

			<?php else: ?>

				<?php
					$sortableImageItems = array_map(function (Image $img) {
						return [
							'content' => '<img src="'.ImageWidget::thumbnail($img).'" />'
									.'<input type="hidden" name="image_sort[]" value="'.$img->id.'" />',
						];
					}, $meta->images);
					echo Sortable::widget([
						'type' => Sortable::TYPE_GRID,
						'items' => $sortableImageItems,
					]);
				?>


			<?php endif; ?>
		</div>

		<?php if ($child->medias): ?>
			<div class="medias">
				<script src="http://www.youtube.com/player_api"></script>

				<?php foreach ($child->medias as $media): ?>
					<a class="fancybox fancybox.iframe" rel="group" href="<?= $media->url ?>">
						<img src="<?= ImageWidget::thumbnail($media->image) ?>" />
					</a>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

	<?php endforeach; ?>

	<?= GoBackButton::widget() ?>

</div>
</div>