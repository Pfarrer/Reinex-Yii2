<?php

use app\helpers\Url;
use yii\helpers\Html;

$textile = new \Netcarver\Textile\Parser();

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
	<title>
		Reinex <?= Yii::t('common', 'High pressure systems Ltd.') ?>
	</title>

	<meta name="description" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="shortcut icon" href="<?= Url::base() ?>/favicon.ico" type="image/x-icon">
	<link rel="icon" href="<?= Url::base() ?>/favicon.ico" type="image/x-icon">
	
	<link rel="stylesheet" href="<?= Url::base() ?>/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?= Url::base() ?>/css/normalize.css">
	<link rel="stylesheet" href="<?= Url::base() ?>/css/reinex.css">
	
	<script src="<?= Url::base() ?>/js/jquery-1.11.1.min.js"></script>
	<script src="<?= Url::base() ?>/js/jquery-migrate-1.2.1.min.js"></script>
	<script src="<?= Url::base() ?>/js/bootstrap.min.js"></script>
	<script src="<?= Url::base() ?>/js/modernizr-2.6.2.min.js"></script>

	<?= Html::csrfMetaTags() ?>
	<?= $this->head() ?>
</head>
<body>

	<?= $this->beginBody() ?>

	<!--[if lt IE 7]>
	<p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
	<![endif]-->

	<div id="body-content">
		<?php foreach (Yii::$app->session->allFlashes as $type=>$msg): ?>
			<div class="alert alert-<?= $type ?> text-center" role="alert"><?= $msg ?></div>
		<?php endforeach; ?>
	
		<?= $content ?>
	</div>

	<footer id="footer">
		<div class="container">
			<div class="row">
				<div class="col-md-4"><?= $textile->textileThis(Yii::t('footer', 'col1')) ?></div>
				<div class="col-md-4"><?= $textile->textileThis(Yii::t('footer', 'col2')) ?></div>
				<div class="col-md-4"><?= $textile->textileThis(Yii::t('footer', 'col3')) ?></div>
			</div>
		</div>
	</footer>

	<?= $this->endBody() ?>

</body>
</html>
<?= $this->endPage() ?>
