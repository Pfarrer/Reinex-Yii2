<?php
use yii\helpers\Html;
use yii\helpers\Url;
use app\widgets\Menu;

/**
 * @var yii\web\View $this
 */

?>

<?= Menu::widget([
	'items' => Menu::admin()
]) ?>

<div class="container">

    <div class="row">
        <div class="col-md-12">
            
            <div class="clearfix">
            	<h1 class="pull-left">Admin Dashboard</h1>
            	<div class="pull-right">
            		<a href="<?= Url::to(['admin/logout']) ?>">
            			<i class="glyphicon glyphicon-log-out"></i> Logout
            		</a>
            	</div>
            </div>

			<ul class="list-group">
				
				<li class="list-group-item">
					<a href="<?= Url::to(['/product']) ?>">
						<?= \Yii::t('product', 'Products') ?>
					</a>
					<span class="badge">0</span>
				</li>
				
				<li class="list-group-item">
					<a href="<?= Url::to(['/tag']) ?>">Tags</a>
					<span class="badge">0</span>
				</li>
				
			</ul>
            
        </div>
    </div>
</div>
