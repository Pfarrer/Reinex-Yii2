<?php
/** @var $this yii\web\View */
use app\components\Url;

/** @var $company_profile string */
/** @var $contacts app\models\ContactMeta[] */

\xj\js\fullpage\FullpageAsset::register($this);

$js = <<<JS
$("#fullpage").fullpage({
	menu: "#mainmenu-items",
	autoScrolling: false,
	fitToSection: false,
	keyboardScrolling: false,
	paddingTop: '80px'
});
JS;
$this->registerJs($js);
?>

<div id="fullpage">

	<div class="section row">
		<div class="col-md-12">
			Frontimages go here...
		</div>
	</div>

	<div class="section row" data-anchor="products">
		<div class="col-md-12">
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
			<?= \app\widgets\ProductList::widget() ?>
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