<?php
use app\helpers\Url;

/**
 * @var app\components\View $this
 */
?>
<a href="<?= Url::to(['edit', 'id'=>$meta->id]) ?>">
	<i class="glyphicon glyphicon-pencil"></i>
    <?= $meta->i18n ? $meta->i18n->name : '<i>'.Yii::t('common', 'Translation missing!').'</i>' ?>
</a>

<input type="hidden" name="sorted_ids[]" value="<?= $meta->id ?>" />

<div class="pull-right">
	<a href="<?= Url::to(['product/create', 'parent'=>$meta->id]) ?>">
		<i class="glyphicon glyphicon-plus"></i>
	</a>
	<a class="danger" href="<?= Url::to(['delete', 'id'=>$meta->id]) ?>" onclick="return confirm('Wirklich löschen?')">
		<i class="glyphicon glyphicon-trash"></i>
	</a>
</div>
<div class="clearfix"></div>

<?php if ($meta->children): ?>
<ul class="list-group products-list">
	<?php foreach ($meta->children as $product): ?>
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
			<a class="danger" href="<?= Url::to(['product/delete', 'id'=>$product->id]) ?>" onclick="return confirm('Wirklich löschen?')">
				<i class="glyphicon glyphicon-trash"></i>
			</a>
		</div>
		
	</li>
	<?php endforeach; ?>
</ul>
<?php endif; ?>
