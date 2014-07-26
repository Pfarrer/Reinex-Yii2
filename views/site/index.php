<?php

use app\helpers\Url;
use app\widgets\Menu;
use app\widgets\ProductList;

app\assets\FullpageAsset::register($this);

/**
 * @var app\components\View $this
 */
?>

<?= Menu::widget([
	'items' => Menu::frontpage()
]) ?>

<div id="fullpage" class="container">

	<div class="section row">
		<div id="backstretch_container" style="background-size: cover"></div>
		<script>

		</script>
	</div>

	<div class="section row" data-anchor="products">
		<div class="col-md-10 col-md-offset-1">
			<div class="row">
				<div class="col-md-9">
					<h1><?= Yii::t('menu', 'Products') ?></h1>
					<div class="row">
						<?= ProductList::widget([
							'products' => $products,
							'cols' => 3,
						]) ?>
					</div>
				</div>

				<div class="col-md-3">
					<h2><?= Yii::t('tag', 'Categories') ?></h2>

					<div class="well list-group">
						<?php foreach ($tags as $tag): ?>
						<?php if ($tag->count > 0): ?>
						<a href="<?= Url::to(['tag/view', 'id'=>$tag->id]) ?>" class="list-group-item">
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
	
	<div class="section row" data-anchor="company">
		<div class="col-md-10 col-md-offset-1">
			<h1><?= Yii::t('menu', 'Company') ?></h1>
			<p><?= $this->textile(file_get_contents('views/site/company_profile.'.Yii::$app->language.'.textile')) ?></p>
		</div>
	</div>

	<div class="section row" data-anchor="partners">
		<div class="col-md-10 col-md-offset-1">
			<h1 class="text-center" style="margin-bottom: 2em"><?= Yii::t('menu', 'Partner') ?></h1>

			<div class="centered" style="margin-bottom: 2em;">
				<img src="<?= Url::base() ?>/img/leistikow.gif" />
			</div>

			<div class="row">

				<div class="col-md-6 centered">
					<h3><strong>FRANKFURT / MAIN</strong></h3>

					<p>
						Joachim Leistikow GmbH<br />
						Altkoenigstraße 2<br />
						D-61138 Niederdorfelden
					</p>

					<p>
						<a href="http://www.leistikow-gmbh.de" target="_blank">www.leistikow-gmbh.de</a>
					</p>
				</div>
				<div class="col-md-6 centered">
					<h3><strong>BERLIN</strong></h3>

					<p>
						LEISTIKOW-UTAG GmbH<br />
						Rosenthaler Straße 29-36<br />
						D-13127 Berlin-Buchholz
					</p>

					<p>
						<a href="http://www.leistikow-utag.de" target="_blank">www.leistikow-utag.de</a>
					</p>
				</div>

			</div>

		</div>
	</div>
	
	<div class="section row" data-anchor="contact">
		<div class="col-md-10 col-md-offset-1">
			<h1><?= Yii::t('menu', 'Contact') ?></h1>
		</div>
	</div>

	<?php if (Yii::$app->language==='de'): ?>
	<div class="section row" data-anchor="legal_notice">
		<div class="col-md-10 col-md-offset-1">
			<h1><?= Yii::t('menu', 'Legal Notice') ?></h1>
			<p><?= $this->textile(file_get_contents('views/site/legal_notice.'.Yii::$app->language.'.textile')) ?></p>
		</div>
	</div>
	<?php endif; ?>
	
</div>

<script>
$(function() {
	$("#fullpage").fullpage({
		fixedElements: ".navbar-fixed-top",
		paddingTop: "51px",
		menu: "#mainmenu-items",
		autoScrolling: false,
		keyboardScrolling: false
	});

	if ($("#mainmenu-items li.active").length === 0) {
		$("#mainmenu-items li:first").addClass("active");
	}
});
</script>
