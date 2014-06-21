<?php
use \Yii;
use yii\helpers\Url;

use app\widgets\ImageWidget;

/**
 * @var app\components\View $this
 */

?>

<h1><?= $meta->i18n->title ?></h1>

<div class="well">
	<?= $this->textile($meta->i18n->body) ?>
</div>

<div class="product-images clearfix">
	<?php foreach ($meta->images as $img): ?>
		<div class="col-md-2 image">
			<img src="<?= ImageWidget::thumbnail($img) ?>" />
		</div>
	<?php endforeach; ?>
</div>

<?php if ($meta->children): ?>
<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">Variationen</h3>
	</div>
	<div class="panel-body">
		<?php foreach ($meta->children as $child): ?>
		<?= $this->renderFile('@app/views/product/_product.php', ['meta'=>$child]) ?>
		<?php endforeach; ?>
	</div>
</div>
<?php endif; ?>
