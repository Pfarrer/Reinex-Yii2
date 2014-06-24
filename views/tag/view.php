<?php
use \Yii;

use app\widgets\Menu;
use app\widgets\ProductList;

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
        
        	<h1><?= Yii::t('tag', 'Category') ?> <i><?= $i18n->name ?></i></h1>

			<?php if (!empty($i18n->body)): ?>
			<div class="well">
				<?= $this->textile($i18n->body) ?>
			</div>
			<?php endif; ?>
			
			<div class="row">
				<?= ProductList::widget([
					'products' => $meta->products,
					'cols' => 4,
				]) ?>
			</div>
			
        </div>

    </div>
</div>
