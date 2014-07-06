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
        </div>
    </div>
    
	<div class="row">
    	<div class="col-md-8 col-md-offset-1">
			<div class="well">
				<?= $this->textile($meta->i18n->body) ?>
			</div>

			<div class="camera_wrap">
				<?php foreach ($meta->images as $img): ?>
				<div data-src="<?= ImageWidget::thumbnail($img) ?>"
					data-thumb="<?= ImageWidget::thumbnail($img) ?>">
				</div>
				<?php endforeach; ?>
			</div>
			
			<script src="<?= Url::base() ?>/js/jquery.camera.min.js"></script>
			<script>
				$(function () {
					$(".camera_wrap").camera({
						thumbnails: true,
						playPause: false,
						pauseOnClick: false,
						fx: 'simpleFade'
					});
				});
			</script>

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
		
		<div class="col-md-2">
			<?php if ($meta->tags && !empty($meta->tags)): ?>
			<div class="list-group">
				<?php foreach ($meta->tags as $tag): ?>
				<a href="<?= Url::to(['tag/view', 'id'=>$tag->id]) ?>" class="list-group-item">
					<?= $tag->i18n->name ?>
					<span class="badge"><?= $tag->count ?></span>
				</a>
				<?php endforeach; ?>
			</div>
			<?php endif; ?>
		</div>
    </div>
</div>


<!-- angelina heger -->
