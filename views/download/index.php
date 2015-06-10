<?php
use app\helpers\Url;
use app\widgets\Menu;
use kartik\sortable\Sortable;

/** @var app\components\View $this */
?>

<?= Menu::widget([
	'items' => Menu::admin()
]) ?>

<div class="container">

    <div class="row">
        <div class="col-md-12">
        
        	<h1><?= Yii::t('menu', 'Downloads') ?></h1>
        	
        	<form id="download_sort" action="<?= Url::to(['sort']) ?>" method="post">
        		<?= Sortable::widget([
	            	'showHandle' => true,
					
	            	'items' => array_map(function ($meta) {
						return [
							'content' => $this->renderFile('@app/views/download/_index_download_item.php', ['meta'=>$meta]),
						];
					}, $metas),
					
					'pluginEvents' => [
						'sortupdate' => 'function() { $("#download_sort").submit(); }',
					],
	
	            ]) ?>
	        </form>
            
            <div>
            	<a href="<?= Url::to(['download/create']) ?>">
            		<i class="glyphicon glyphicon-plus"></i>
            		<?= Yii::t('download', 'Upload a file') ?>
            	</a>
            </div>
			
        </div>
    </div>
</div>
