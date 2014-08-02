<?php
use app\helpers\Url;

/**
 * @var app\components\View $this
 */
?>

<ul class="list-group products-list">
	<?php foreach ($products as $product): ?>
	<li class="list-group-item">
		<a href="<?= Url::to(['product/edit', 'id'=>$product->id]) ?>">
			<i class="glyphicon glyphicon-pencil"></i>
			<?php if ($product->i18n): ?>
				<?= $product->i18n->name ?>
			<?php else: ?>
				<i><?= Yii::t('common', 'Translation missing!') ?></i>
			<?php endif; ?>
		</a>

		<div class="pull-right">
			<a href="<?= Url::to(['product/create', 'parent'=>$product->id]) ?>">
				<i class="glyphicon glyphicon-plus"></i>
			</a>
			<a class="danger" href="<?= Url::to(['product/delete', 'id'=>$product->id]) ?>" onclick="return confirm('Wirklich löschen?')">
				<i class="glyphicon glyphicon-trash"></i>
			</a>
		</div>
		
		<?php if ($product->children): ?>
		<?= $this->renderFile('@app/views/product/_products_list.php', ['products'=>$product->children]) ?>
		<?php endif; ?>
	</li>
	<?php endforeach; ?>
</ul>
