<?php
use app\assets\FancyboxAsset;
use app\components\Url;
use app\models\Image;
use app\models\ProductI18n;
use app\models\ProductMeta;
use app\widgets\GoBackButton;
use app\widgets\ImageList;
use app\widgets\ImageUpload;
use app\widgets\ImageWidget;
use Embed\Embed;
use kartik\sortable\Sortable;
use yii\widgets\ActiveForm;

/** @var app\components\View $this */
/** @var ProductMeta $meta */
/** @var ProductI18n $i18n */

FancyboxAsset::register($this);
$this->registerCssFile(Url::base().'/css/product.css');

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
		<?= ImageList::widget([
			'meta' => $meta,
		]) ?>
	</div>

	<?php if ($meta->youtube_playlist_id): ?>
		<div class="col-md-9">
			<iframe width="640" height="360"
					src="https://www.youtube-nocookie.com/embed/videoseries?list=<?= $meta->youtube_playlist_id ?>"
					frameborder="0" allowfullscreen>
			</iframe>
		</div>
	<?php endif; ?>

	<div class="col-md-9">

		<?php if (!Yii::$app->user->isGuest): ?>
			<a href="<?= Url::to(['product/edit', 'parent_id'=>$meta->id]) ?>">
				<i class="glyphicon glyphicon-pencil"></i> <?= Yii::t('product', 'Create a product variant') ?>
			</a>
		<?php endif; ?>

		<?php foreach ($meta->children as $child): ?>

			<div class="variant panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">
						<?php if ($child->i18n): ?>
							<?= $child->i18n->name ?>
						<?php else: ?>
							<img src="<?= Url::base().'/images/flags/'.$child->i18n_any->lang.'.png' ?>">
							<?= $child->i18n_any->name ?>
						<?php endif; ?>

						<?php if (!Yii::$app->user->isGuest): ?>
							<a href="<?= Url::to(['product/edit', 'id'=>$child->id]) ?>" class="pull-right">
								<i class="glyphicon glyphicon-pencil"></i> <?= Yii::t('product', 'Edit product variant') ?>
							</a>
						<?php endif; ?>
					</h3>
				</div>
				<div class="panel-body">
					<?php if ($child->i18n && !empty($child->i18n->body) || (!$child->i18n && $child->i18n_any && !empty($child->i18n_any->body))): ?>
						<?= $this->textile($child->i18n ? $child->i18n->body : $child->i18n_any->body) ?>
					<?php endif; ?>

					<div class="images">
						<?= ImageList::widget([
							'meta' => $child,
						]) ?>
					</div>
				</div>
			</div>

		<?php endforeach; ?>

		<?= GoBackButton::widget() ?>

	</div>
</div>