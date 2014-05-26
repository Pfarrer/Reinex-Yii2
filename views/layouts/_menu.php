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
				<li class="active" data-menuanchor="news"><a href="#news">News</a></li>
				<li data-menuanchor="products"><a href="#products"><?= \Yii::t('menu', 'Products') ?></a></li>
				<li data-menuanchor="company"><a href="#company"><?= \Yii::t('menu', 'Company') ?></a></li>
				<li data-menuanchor="partners"><a href="#partners"><?= \Yii::t('menu', 'Partners') ?></a></li>
				<li data-menuanchor="contact"><a href="#contact"><?= \Yii::t('menu', 'Contact') ?></a></li>
				<li data-menuanchor="legal_notice"><a href="#legal_notice"><?= \Yii::t('menu', 'Legal Notice') ?></a></li>
			</ul>
			
			<ul class="nav navbar-nav navbar-right">
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown"><img id="language_flag" src="<%= url_for "img/flags/#{I18n.locale}.png" %>" /> <b class="caret"></b></a>
					<ul class="dropdown-menu">
						<% langs.each do |lang| %>
						<li>
							<a href="<%= translated_url(lang) %>">
								<img src="<%= url_for "img/flags/#{lang}.png" %>" /> <%= t(lang) %>
							</a>
						</li>
						<% end %>
					</ul>
				</li>
			</ul>
		</div>
	
	</div>
</div>

	
