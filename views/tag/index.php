<?php
use \Yii;
use yii\helpers\Html;
use yii\helpers\Url;
use app\widgets\Menu;

/**
 * @var app\components\View $this
 * @var app\models\Metaproduct[] $products
 */

?>

<?= Menu::widget([
	'items' => Menu::admin()
]) ?>

<div class="container">

    <div class="row">
        <div class="col-md-12">
        
        	<h1>Tags</h1>
            
            <div>
            	<a href="<?= Url::to(['tag/create']) ?>">
            		<i class="glyphicon glyphicon-plus"></i>
            		<?= Yii::t('tag', 'Create a tag') ?>
            	</a>
            </div>

            <ul class="list-group">
				<?php foreach ($metas as $id=>$tag): ?>
            	<li class="list-group-item">
            		<a href="<?= Url::to(['tag/edit', 'id'=>$tag->id]) ?>">
            			<i class="glyphicon glyphicon-pencil"></i>
            			<?php if ($tag->i18n): ?>
            				<?= $tag->i18n->name ?>
            			<?php else: ?>
            				<i><?= Yii::t('common', 'Translation missing!') ?></i>
            			<?php endif; ?>
            		</a>
            	</li>
            	<?php endforeach; ?>
            </ul>
            
        </div>
    </div>
</div>
