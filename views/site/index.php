<?php

app\assets\FullpageAsset::register($this);

?>

<div id="fullpage" class="container">
	
	<div class="section row" data-anchor="products">
		<div class="col-md-12">
			<div class="row">
			
				<div class="col-md-9">
					<h1><?= \Yii::t('menu', 'Products') ?></h1>
					
					<pre><?= var_dump(\Yii::$app->session) ?></pre>
				
					<div id="products">
						<% get_all('products').each do |p| %>
							<a href="<%= url_for p %>">
							<div class="product"><%= partial "product", :locals => p.data %></div>
							</a>
						<% end %>
					</div>
					
				</div>
				
				<div class="col-md-3">
					<h2><?= \Yii::t('menu', 'Categories') ?></h2>
					
					<ul>
						<% get_categories("products").each do |cat| %>
						<li><a href="#"><%= cat %></a></li>
						<% end %>
					</ul>
					
				</div>
				
			</div>
			<div class="clearfix"></div>
		</div>
	</div>
	
	<div class="section row" data-anchor="company">
		<div class="col-md-12">
			<h1><?= \Yii::t('menu', 'Company') ?></h1>
		</div>
	</div>
	
	<div class="section row" data-anchor="contact">
		<div class="col-md-12">
			<h1><?= \Yii::t('menu', 'Contact') ?></h1>
		</div>
	</div>
	
	<div class="section row" data-anchor="news">
		<% get_all('news').each do |n| %>
		<div class="slide">

			<div class="row" style="height: 100%; background-size:cover; background: url(<%= url_for 'img/news/'+n.data.image %>) no-repeat center center;">
				<div class="col-md-1"></div>

				<div class="col-md-10 news">
					<%= n.render %>
				</div>

				<div class="col-md-1"></div>
			</div>

		</div>
		
	</div>
	
</div>

<script>
$(function() {
	$("#fullpage").fullpage({
		fixedElements: ".navbar-fixed-top",
		paddingTop: "50px",
		menu: "#mainmenu-items",
		autoScrolling: false,
	});
});
</script>
