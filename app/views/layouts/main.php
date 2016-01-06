<?php
use app\components\View;
use yii\widgets\Breadcrumbs;
use yii\helpers\Html;
use app\assets\AppAsset;
use app\components\Url;

/* @var $this View */
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
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

		<link rel="icon" type="image/gif" href="<?= Url::base() ?>/images/powerman.gif" />

		<title>
			<?php if ($this->title) echo $this->title.' | ' ?>
			Reinex <?= Yii::t('common', 'High pressure systems Ltd.') ?>
		</title>

		<?= Html::csrfMetaTags() ?>
		<?= $this->head() ?>
	</head>
	<body style="background-<?= $this->body_background_image_url
			? 'image: url('.$this->body_background_image_url.')'
			: 'color: #454545' ?>">

		<?= $this->beginBody() ?>

		<!--[if lt IE 7]>
		<p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
		<![endif]-->
		
		<div id="menu-container">
			<?= app\widgets\Menu::widget() ?>
		</div>

		<div id="content-container" class="container">
			<?= Breadcrumbs::widget([
				'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
			]) ?>
			
			<?php $this->beginContent('@app/views/layouts/flashmessages.php') ?><?php $this->endContent() ?>
			
			<?= $content ?>
		</div>

		<footer>
			<div class="container">
				<div class="row">
					<div class="col-md-4"><?= $this->textile(Yii::t('footer', 'col1')) ?></div>
					<div class="col-md-5"><?= $this->textile(Yii::t('footer', 'col2')) ?></div>
					<div class="col-md-3"><?= $this->textile(Yii::t('footer', 'col3')) ?></div>
				</div>
			</div>
		</footer>

		<?= $this->endBody() ?>

		<?php if (YII_ENV == 'prod'): ?>
		<script>
			(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
				(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
				m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
			})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
			ga('create', 'UA-72066350-1', 'auto');
			ga('send', 'pageview');
		</script>
		<?php endif; ?>

	</body>
</html>
<?= $this->endPage() ?>
