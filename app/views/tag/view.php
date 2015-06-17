<?php
use app\components\Url;
use app\models\ProductI18n;
use app\models\ProductMeta;
use app\widgets\GoBackButton;
use app\widgets\ImageWidget;
use app\widgets\ProductList;

/** @var app\components\View $this */
/** @var ProductMeta $meta */
/** @var ProductI18n $i18n */
?>

<div class="row">
<div class="col-md-12">

	<h1>
		<?= Yii::t('tag', 'Category') ?> <i><?= $i18n->name ?></i>
		<?php if (!Yii::$app->user->isGuest): ?>
		<small>
			<a href="<?= Url::to(['tag/edit', 'id'=>$meta->id]) ?>">
				<i class="glyphicon glyphicon-pencil"></i> <?= Yii::t('tag', 'Edit category') ?>
			</a>
		</small>
		<?php endif; ?>
	</h1>

	<?php if (!empty($i18n->body)): ?>
	<div class="well body">
		<?= $this->textile($i18n->body) ?>
	</div>
	<?php endif; ?>

	<div class="col-lg-offset-1">
		<?= ProductList::widget([
			'products' => $meta->products,
		]) ?>
	</div>

	<?= GoBackButton::widget() ?>

</div>
</div>