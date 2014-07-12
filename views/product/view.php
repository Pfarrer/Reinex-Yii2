<?php
use \Yii;
use yii\helpers\Url;

use app\widgets\Menu;
use app\widgets\ImageWidget;

/**
 * @var app\components\View $this
 */

\app\assets\FancyboxAsset::register($this);

?>

<?= Menu::widget([
	'items' => Menu::frontpage()
]) ?>

<div class="container">
    <div class="row">
    	<div class="col-md-10 col-md-offset-1">
        	<h1><?= $meta->i18n->name ?></h1>
        </div>
    </div>
    
	<div class="row">
    	<div class="col-md-<?= $meta->tags ? 8 : 10 ?> col-md-offset-1">
			<div class="well">
				<?= $this->textile($meta->i18n->body) ?>
			</div>

			<div class="images">
				<?php foreach ($meta->images as $img): ?>
				<a class="fancybox" rel="group" href="<?= ImageWidget::full($img) ?>"><img src="<?= ImageWidget::thumbnail($img) ?>" alt="" /></a>
				<?php endforeach; ?>
			</div>

			<script>
				$(function () {
					$(".fancybox").fancybox({
						padding: 2,

						beforeShow: function () {
							/* Disable right click */
							$.fancybox.wrap.bind("contextmenu", function (e) {
								return false;
							});
						}
					});
				});
			</script>
		</div>
		
		<?php if ($meta->tags): ?>
		<div class="col-md-2">
			<div class="list-group">
				<?php foreach ($meta->tags as $tag): ?>
				<a href="<?= Url::to(['tag/view', 'id'=>$tag->id]) ?>" class="list-group-item">
					<?= $tag->i18n->name ?>
					<span class="badge"><?= $tag->count ?></span>
				</a>
				<?php endforeach; ?>
			</div>
		</div>
		<?php endif; ?>
		
    </div>
    
    <div class="row">
    	<div class="col-md-10 col-md-offset-1">
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

