<?php
use \Yii;
use yii\helpers\Url;

use app\widgets\Menu;
use app\widgets\ImageWidget;

/**
 * @var app\components\View $this
 */

?>

<?= Menu::widget([
	'items' => Menu::frontpage()
]) ?>

<div class="container">
    <div class="row">
    	<div class="col-md-10 col-md-offset-1">
        	<h1><?= $meta->i18n->name ?></h1>

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

			<?php foreach ($meta->children as $child): ?>
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><?= $child->i18n->name ?></h3>
				</div>
				<div class="panel-body">
					<?= $this->textile($child->i18n->body) ?>
				</div>
			</div>
			<?php endforeach; ?>
		</div>
    </div>
</div>
