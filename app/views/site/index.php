<?php
/** @var $this yii\web\View */
/** @var $contacts app\models\MetaContact[] */
?>

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