<?php
use app\components\Url;
use app\models\ProductMeta;

/** @var $this yii\web\View */
/** @var $products ProductMeta[] */

$this->registerJsFile(Url::base().'/js/masonry.pkgd.min.js');
?>


<div id="products-list" class="row js-masonry" data-masonry-options='{"itemSelector": ".product"}'>
	<?php foreach ($products as $product): ?>

		<div class="col-md-3 product clearfix">
			<a href="<?= Url::toProduct($product) ?>">
				<div class="thumbnail">

					<?php if ($product->frontimage): ?>
						<img src="<?= \app\widgets\ImageWidget::medium($product->frontimage) ?>"/>
					<?php endif; ?>
					<div class="caption">
						<?php if ($product->i18n): ?>
							<?= $product->i18n->name ?>
						<?php else: ?>
							<img src="<?= Url::base().'/images/flags/'.$product->i18n_any->lang.'.png' ?>">
							<?= $product->i18n_any->name ?>
						<?php endif; ?>
					</div>

				</div>
			</a>
		</div>

	<?php endforeach; ?>
</div>