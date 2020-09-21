<?php

use yii\helpers\Html;
use yii\widgets\LinkPager;

?>

<h1 class="page-header">Friends</h1>

<?php if(!empty($query)) : ?>

    <ul>
	<?php foreach($query as $value) : ?>
		<?php if($value->status == $status_PENDING || $value->status == $status_REJECTED) : ?>
			<?php continue;?>
			
			<?php elseif($value->user_id == Yii::$app->user->identity->id) : ?>
			<li class="list-group-item"><?= $value->friend->first_name; ?> <?= $value->friend->last_name; ?> </li>
			<?php else: ?>
			<li class="list-group-item"><?= $value->user->first_name; ?> <?= $value->user->last_name; ?> </li>
			<?php endif; ?>
		

	<?php  endforeach; ?>
</ul>

<?php else: ?>

<p>You have no friend yet</p>


<?php endif; ?></br></br></br>

<a href="/index.php/friendsapp">go back</a>