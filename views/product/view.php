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
        	<h1><?= $meta->i18n->title ?></h1>

			<div class="well">
				<?= $this->textile($meta->i18n->body) ?>
			</div>
			
			<div class="product-images">
				<?php foreach ($meta->images as $img): ?>
					<div class="col-md-2 image">
						<img style="width: 100%" src="<?= ImageWidget::thumbnail($img) ?>" />
					</div>
				<?php endforeach; ?>
			</div>

        </div>

    </div>
</div>
