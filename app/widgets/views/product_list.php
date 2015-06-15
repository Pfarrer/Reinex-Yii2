<?php
use app\components\Url;
use app\models\ProductMeta;

/** @var $this yii\web\View */
/** @var $products ProductMeta[] */
?>

<?php if (!Yii::$app->user->isGuest): ?>
<div class="row">
	<div class="col-md-12">
		<a href="<?= Url::to(['/product/create']) ?>">
			<i class="glyphicon glyphicon-plus"></i> <?= Yii::t('product', 'Create a product') ?>
		</a>
	</div>
</div>
<?php endif; ?>

<div class="row" id="products">
	<?php foreach ($products as $product): ?>

		<div class="col-md-3 product clearfix">
			<a href="<?= Url::toProduct($product) ?>">
				<div class="thumbnail">

					<?php if ($product->frontimage): ?>
						<img src="<?= \app\widgets\ImageWidget::medium($product->frontimage) ?>"/>
					<?php endif; ?>
					<div class="caption"><?= $product->i18n->name ?></div>

				</div>
			</a>
		</div>

	<?php endforeach; ?>
</div>