<?php
use app\helpers\Url;
use app\widgets\Menu;
use kartik\sortable\Sortable;

/**
 * @var app\components\View $this
 */

app\assets\ProductSortAsset::register($this);
?>

<?= Menu::widget([
	'items' => Menu::admin()
]) ?>

<div class="container">

    <div class="row">
        <div class="col-md-12">
        
        	<h1><?= Yii::t('product', 'Products') ?></h1>
        	
        	<form id="product_sort" action="<?= Url::to(['sort']) ?>" method="post">
        		<?= Sortable::widget([
	            	'showHandle' => true,
					
	            	'items' => array_map(function ($meta) {
						return [
							'content' => $this->renderFile('@app/views/product/_index_product_item.php', ['meta'=>$meta]),
						];
					}, $products),
					
					'pluginEvents' => [
						'sortupdate' => 'function() { $("#product_sort").submit(); }',
					],
	
	            ]) ?>
	        </form>
            
            <div>
            	<a href="<?= Url::to(['product/create']) ?>">
            		<i class="glyphicon glyphicon-plus"></i>
            		<?= Yii::t('product', 'Create a product') ?>
            	</a>
            </div>
			
        </div>
    </div>
</div>
