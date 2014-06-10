<?php

use yii\helpers\Url;

?>


<div class="navbar navbar-default navbar-fixed-top" role="navigation">
	<div class="container">
	
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
				<span class="sr-only">Show menu</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="<?= Url::home() ?>"><img id="powermann" src="<?= Url::base() ?>/img/powermann.gif" /></a>
		</div>
		
		<div class="collapse navbar-collapse">
			<ul class="nav navbar-nav" id="mainmenu-items">
				<?php foreach ($items as $item): ?>
				<li data-menuanchor="<?= strtolower($item['label']) ?>">
					<a href="<?= $item['url'] ?>">
						<?= \Yii::t('menu', $item['label']) ?>
					</a>
				</li>
				<?php endforeach; ?>
			</ul>
			
			<ul class="nav navbar-nav navbar-right">
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<img id="language_flag" src="<?= Url::base() ?>/img/flags/<?= \Yii::$app->language ?>.png" /> <b class="caret"></b>
					</a>

					<ul class="dropdown-menu">
						<?php foreach (\Yii::$app->params['languages'] as $lang): ?>
						<li>
							<a href="?lang=<?= $lang ?>">
								<img src="<?= Url::base() ?>/img/flags/<?= $lang ?>.png" /> <?= \Yii::t('language', $lang) ?>
							</a>
						</li>
						<?php endforeach; ?>
					</ul>
				</li>
			</ul>
		</div>
	
	</div>
</div>
