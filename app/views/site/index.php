<?php
use app\components\Url;
use app\components\Util;
use app\models\DownloadMeta;
use app\models\FrontimageMeta;
use app\models\ProductMeta;
use app\widgets\ImageWidget;
use xj\js\fullpage\FullpageAsset;
use yii\web\View;

/** @var $this yii\web\View */
/** @var $frontimages FrontimageMeta[] */
/** @var $products ProductMeta[] */
/** @var $downloads DownloadMeta[] */
/** @var $company_profile string */
/** @var $contacts app\models\ContactMeta[] */

FullpageAsset::register($this);

$js = <<<JS
$("#fullpage").fullpage({
	menu: "#mainmenu-items",
	autoScrolling: false,
	fitToSection: false,
	keyboardScrolling: false,
	paddingTop: '80px'
});
JS;
$this->registerJs($js, View::POS_END);
?>

<div id="fullpage">

	<?php if ($this->body_background_image_url): ?>
		<div class="section row" id="frontimage"></div>
	<?php endif; ?>

	<div class="section row" data-anchor="products">
		<div class="col-md-9">
			<h2>
				<?= Yii::t('menu', 'Products') ?>
				<?php if (!Yii::$app->user->isGuest): ?>
					<small>
						<a href="<?= Url::to(['/product/edit']) ?>">
							<i class="glyphicon glyphicon-plus"></i> <?= Yii::t('product', 'Create a product') ?>
						</a>
					</small>
				<?php endif; ?>
			</h2>
			<?= \app\widgets\ProductList::widget([
				'products' => $products,
			]) ?>
		</div>
		<div class="col-md-3">
			<h3>
				<?= Yii::t('tag', 'Categories') ?>
				<?php if (!Yii::$app->user->isGuest): ?>
					<small>
						<a href="<?= Url::to(['/tag/edit']) ?>">
							<i class="glyphicon glyphicon-plus"></i> <?= Yii::t('tag', 'Create a category') ?>
						</a>
					</small>
				<?php endif; ?>
			</h3>

			<div class="list-group">
				<?php foreach ($tags as $tag): ?>
					<?php if ($tag->count > 0 || !Yii::$app->user->isGuest): ?>
						<a href="<?= Url::toTag($tag) ?>" class="list-group-item">
							<?php if ($tag->i18n): ?>
								<?= $tag->i18n->name ?>
							<?php else: ?>
								<img src="<?= Url::base().'/images/flags/'.$tag->i18n_any->lang.'.png' ?>">
								<?= $tag->i18n_any->name ?>
							<?php endif; ?>

							<span class="badge"><?= $tag->count ?></span>
						</a>
					<?php endif; ?>
				<?php endforeach; ?>
			</div>
		</div>
	</div>

	<div class="section row" data-anchor="downloads">
		<div class="col-md-12">
			<h2>
				Downloads
				<?php if (!Yii::$app->user->isGuest): ?>
					<small>
						<a href="<?= Url::to(['/download/edit']) ?>">
							<i class="glyphicon glyphicon-plus"></i> <?= Yii::t('download', 'Create a download') ?>
						</a>
					</small>
				<?php endif; ?>
			</h2>

			<div class="list-group">
				<?php foreach ($downloads as $dl): ?>
					<a href="<?= Url::to(['download/dl', 'id'=>$dl->id]) ?>" class="list-group-item" download target="_blank">
						<i class="glyphicon glyphicon-download-alt"></i>

						<?php if ($dl->i18n): ?>
							<?= $dl->i18n->name ?>
						<?php else: ?>
							<img src="<?= Url::base().'/images/flags/'.$dl->i18n_any->lang.'.png' ?>">
							<?= $dl->i18n_any->name ?>
						<?php endif; ?>

						(<?= $dl->filename.', '.Util::formatBytes($dl->filesize, 0) ?>)
					</a>

					<?php if (!Yii::$app->user->isGuest): ?>
						<a href="<?= Url::to(['/download/edit', 'id'=>$dl->id]) ?>" class="pull-right">
							<i class="glyphicon glyphicon-pencil"></i> <?= Yii::t('download', 'Edit download') ?>
						</a>
					<?php endif; ?>
				<?php endforeach; ?>
			</div>
		</div>
	</div>

	<div class="section row" data-anchor="company">
		<div class="col-md-12">
			<h2><?= Yii::t('menu', 'Company') ?></h2>
			<p><?= $this->textile($company_profile) ?></p>
		</div>
	</div>

	<div class="section row" data-anchor="contact">
		<div class="col-md-12">
			<h2><?= Yii::t('menu', 'Contact') ?></h2>
			<?= \app\widgets\ContactList::widget(['contacts' => $contacts]) ?>
		</div>
	</div>

	<?php if (Yii::$app->language === 'de'): ?>
		<div class="section row" data-anchor="legal_notice">
			<div class="col-md-12">
				<h2><?= Yii::t('menu', 'Legal Notice') ?></h2>
				<?= $this->textile(file_get_contents('../app/static/legal_notice.'.Yii::$app->language.'.textile')) ?>
			</div>
		</div>
	<?php endif; ?>

</div>