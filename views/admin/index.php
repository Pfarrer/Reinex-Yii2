<?php
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var yii\web\View $this
 */

?>

<div class="container">

    <div class="row">
        <div class="col-md-12">
            
            <div class="clearfix">
            	<h1 class="pull-left">Admin Dashboard</h1>
            	<div class="pull-right">
            		<a href="<?= Url::to(['admin/logout']) ?>">
            			<i class="glyphicon glyphicon-log-out"></i> Logout
            		</a>
            	</div>
            </div>
            
        </div>
    </div>
</div>
