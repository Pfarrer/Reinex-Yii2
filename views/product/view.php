<?php
use \Yii;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var yii\web\View $this
 */

?>

<div class="container">

    <div class="row">
        <div class="col-md-6">
        
        	<pre>
        		<?= var_dump($meta->attributes) ?>
            </pre>
            
        </div>
        
        <div class="col-md-6">
        
        	<pre>
        		<?= var_dump($meta->i18ns) ?>
            </pre>
            
        </div>
    </div>
</div>
