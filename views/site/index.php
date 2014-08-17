<?php
use app\helpers\Url;
use app\widgets\Menu;
use app\widgets\ProductList;
use app\widgets\ContactList;
use app\widgets\ImageWidget;

/**
 * @var app\components\View $this
 */

app\assets\FullpageAsset::register($this);
app\assets\FittextAsset::register($this);
?>

<?= Menu::widget([
	'items' => Menu::frontpage()
]) ?>

<div id="fullpage">

	<?php if ($frontimages): ?>
	<div class="section" data-anchor="frontimage" id="frontimage">
		<div id="logo">
			<img src="<?= Url::to('img/logo_big.png') ?>" />
			<div><?= Yii::t('common', 'High pressure systems Ltd.') ?></div>
			<script>
				$(function () {
					$("#logo div").fitText();
				});
			</script>
		</div>

		<?php foreach ($frontimages as $fimage): ?>
		<div class="slide" style="background-image: url(<?= ImageWidget::frontimage($fimage->image) ?>)">
			<div class="text">
				<h1><?= $fimage->i18n->name ?></h1>
				<div><?= $fimage->i18n->body ?></div>
			</div>
		</div>
		<?php endforeach; ?>
	</div>
	<?php endif; ?>

	<div class="section" data-anchor="products">
		<div class="container">
			<div class="row">
				<div class="col-md-10 col-md-offset-1">
					<div class="row">
						<div class="col-md-9">
							<h1><?= Yii::t('menu', 'Products') ?></h1>

							<?= ProductList::widget([
								'products' => $products,
								'cols' => 3,
							]) ?>
						</div>

						<div class="col-md-3">
							<h2><?= Yii::t('tag', 'Categories') ?></h2>

							<div class="list-group">
								<?php foreach ($tags as $tag): ?>
								<?php if ($tag->count > 0): ?>
								<a href="<?= Url::to($tag->i18n->shortcut_active ? ['/'.$tag->i18n->shortcut_active] : ['tag/view', 'id'=>$tag->id]) ?>" class="list-group-item">
									<?= $tag->i18n->name ?>
									<span class="badge"><?= $tag->count ?></span>
								</a>
								<?php endif; ?>
								<?php endforeach; ?>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="section row" data-anchor="company">
		<div class="container">
			<div class="row">
				<div class="col-md-10 col-md-offset-1">
					<h1><?= Yii::t('menu', 'Company') ?></h1>
					<p><?= $this->textile(file_get_contents('views/site/company_profile.'.Yii::$app->language.'.textile')) ?></p>
				</div>
			</div>
		</div>
	</div>
	
	<div class="section row" data-anchor="contact">
		<div class="container">
			<div class="row">
				<div class="col-md-10 col-md-offset-1">
					<h1><?= Yii::t('menu', 'Contact') ?></h1>

					<?= ContactList::widget([
						'contacts' => $contacts,
					]) ?>
				</div>
			</div>
		</div>
	</div>

	<?php if (Yii::$app->language==='de'): ?>
	<div class="section row" data-anchor="legal_notice">
		<div class="container">
			<div class="row">
				<div class="col-md-10 col-md-offset-1">
					<h1><?= Yii::t('menu', 'Legal Notice') ?></h1>
					<p><?= $this->textile(file_get_contents('views/site/legal_notice.'.Yii::$app->language.'.textile')) ?></p>
				</div>
			</div>
		</div>
	</div>
	<?php endif; ?>
	
</div>

<script>
$(function() {
	$("#fullpage").fullpage({
		menu: "#mainmenu-items",
		autoScrolling: false,
		keyboardScrolling: false
	});
});
</script>
