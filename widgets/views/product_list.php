<?php
use \yii\helpers\Url;

/**
 * @var app\components\View $this
 */
?>

<div class="row">
	<?php foreach ($products as $product): ?>
	<div class="col-md-<?= 12/$cols ?>">
		<a href="<?= Url::to(['product/view', 'id'=>$product->id]) ?>">
			<div class="thumbnail">

				<?php if ($product->frontimage): ?>
				<img src="<?= app\widgets\ImageWidget::medium($product->frontimage) ?>" />
				<?php endif; ?>
				<div class="caption"><h3><?= $product->i18n->name ?></h3></div>

			</div>
		</a>
	</div>
	<?php endforeach; ?>
</div>
