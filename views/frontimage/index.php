<?php
use app\helpers\Url;
use app\widgets\Menu;
use kartik\sortable\Sortable;

/**
 * @var app\components\View $this
 * @var app\models\MetaFrontimage[] $metas
 */
?>

<?= Menu::widget([
	'items' => Menu::admin()
]) ?>

<div class="container">

    <div class="row">
        <div class="col-md-12">
        
        	<h1>Frontimages</h1>
            
            <div>
            	<a href="<?= Url::to(['create']) ?>">
            		<i class="glyphicon glyphicon-plus"></i>
            		<?= Yii::t('tag', 'Create a Frontimage') ?>
            	</a>
            </div>
            
            <form id="frontimage_sort" action="<?= Url::to(['sort']) ?>" method="post">
	            <?= Sortable::widget([
	            	'showHandle' => true,
					
	            	'items' => array_map(function ($meta) {
						return [
							'content' => $this->renderFile('@app/views/frontimage/_index_frontimage_item.php', ['meta'=>$meta]),
						];
					}, $metas),
					
					'pluginEvents' => [
						'sortupdate' => 'function() { $("#frontimage_sort").submit(); }',
					],
	
	            ]) ?>
			</form>
            
        </div>
    </div>
</div>
