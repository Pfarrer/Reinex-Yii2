<?php
use \Yii;

use app\helpers\Url;
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

<div class="container" id="product">

	<div class="row">
    	<div class="col-md-10 col-md-offset-1">
    		<h1>
        		<?= $meta->i18n->name ?>
        		<?php if (!Yii::$app->user->isGuest): ?>
        		<small class="pull-right">
		    		<a href="<?= Url::to(['product/edit', 'id'=>$meta->id]) ?>">
			    		<i class="glyphicon glyphicon-pencil"></i> Ändern
		    		</a>
        		</small>
        		<?php endif; ?>
        	</h1>
    	
			<div class="well body">
				<?= $this->textile($meta->i18n->body) ?>
				
				<?php if ($meta->tags): ?>
				<div class="categories">
					<hr />
					<?= Yii::t('tag', 'Categories') ?>:
					<?php foreach ($meta->tags as $tag): ?>
					<a href="<?= Url::to($tag->i18n->shortcut_active ? ['/'.$tag->i18n->shortcut_active] : ['tag/view', 'id'=>$tag->id]) ?>" class="badge">
						<?= $tag->i18n->name ?>
					</a>
					<?php endforeach; ?>
				</div>
				<?php endif; ?>
			</div>

			<div class="images">
				<?php foreach ($meta->images as $img): ?>
				<a class="fancybox" rel="group" href="<?= ImageWidget::full($img) ?>">
					<img src="<?= ImageWidget::thumbnail($img) ?>" alt="" />
				</a>
				<?php endforeach; ?>
			</div>

			<?php if ($meta->medias): ?>
			<div class="medias">
				<script src="http://www.youtube.com/player_api"></script>

				<?php foreach ($meta->medias as $media): ?>
					<a class="fancybox fancybox.iframe" rel="group" href="<?= $media->url ?>">
						<img src="<?= ImageWidget::thumbnail($media->image) ?>" />
					</a>
				<?php endforeach; ?>
			</div>
			<?php endif; ?>

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
    </div>
    
    <div class="row">
    	<div class="col-md-10 col-md-offset-1">
    		<?php foreach ($meta->children as $child): ?>

				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">
							<i><?= $meta->i18n->name ?></i>
							<?= $child->i18n->name ?>

							<?php if (!Yii::$app->user->isGuest): ?>
								<a href="<?= Url::to(['product/edit', 'id'=>$child->id]) ?>" class="pull-right">
									<i class="glyphicon glyphicon-pencil"></i> Ändern
								</a>
							<?php endif; ?>
						</h3>
					</div>
					<?php if (!empty($child->i18n->body)): ?>
					<div class="panel-body">
						<?= $this->textile($child->i18n->body) ?>
					</div>
					<?php endif; ?>
				</div>

				<div class="images">
					<?php foreach ($child->images as $img): ?>
						<a class="fancybox" rel="group" href="<?= ImageWidget::full($img) ?>">
							<img src="<?= ImageWidget::thumbnail($img) ?>" alt="" />
						</a>
					<?php endforeach; ?>
				</div>

				<?php if ($child->medias): ?>
					<div class="medias">
						<script src="http://www.youtube.com/player_api"></script>

						<?php foreach ($child->medias as $media): ?>
							<a class="fancybox fancybox.iframe" rel="group" href="<?= $media->url ?>">
								<img src="<?= ImageWidget::thumbnail($media->image) ?>" />
							</a>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>

			<?php endforeach; ?>
    	</div>
    </div>
</div>

