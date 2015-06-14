<?php
use yii\widgets\Breadcrumbs;
use yii\helpers\Html;
use app\assets\AppAsset;
use app\components\Url;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>

<?= $this->beginPage() ?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="description" content="">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<link rel="icon" type="image/gif" href="<?= Url::base() ?>/images/powerman.gif" />

		<title>
			<?php if ($this->title) echo $this->title.' | ' ?>
			Reinex <?= Yii::t('common', 'High pressure systems Ltd.') ?>
		</title>

		<?= Html::csrfMetaTags() ?>
		<?= $this->head() ?>
	</head>
	<body>
		<?= $this->beginBody() ?>

		<!--[if lt IE 7]>
		<p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
		<![endif]-->

		<div id="content-container" class="container">
			<?= Breadcrumbs::widget([
				'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
			]) ?>
			
			<?php $this->beginContent('@app/views/layouts/flashmessages.php') ?><?php $this->endContent() ?>
			
			<?= $content ?>
		</div>

		<footer id="footer" class="container">
			<div class="row">
				<div class="col-md-4"><?= $this->textile(Yii::t('footer', 'col1')) ?></div>
				<div class="col-md-4"><?= $this->textile(Yii::t('footer', 'col2')) ?></div>
				<div class="col-md-4"><?= $this->textile(Yii::t('footer', 'col3')) ?></div>
			</div>
		</footer>

		<?= $this->endBody() ?>
	</body>
</html>
<?= $this->endPage() ?>
