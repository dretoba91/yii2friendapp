<?php

use yii\helpers\Html;
use yii\widgets\LinkPager;
?>

<span class=" push-right">
<a class="btn btn-success" href="/index.php/friendsapp/userfriends?id=<?= Yii::$app->user->identity->id ?>">Friends
	<span class="btn-group-vertical"><?=$user->getAcceptedfriends()->count() +  $user->getfriendsAccepted()->count()?></span>
</a>
</span>

<h1 class="page-header">People you may know 
<span class=" pull-right">

<a class="btn btn-danger" href="leavingrequest?id=<?= Yii::$app->user->identity->id ?>">Leavingrequest 
	<span class="btn-group-vertical"><?=$user->getOutgoingfriends()->count() ?></span>
</a>

<a class="btn btn-info" href="friendsapp/incomingrequest?id=<?= Yii::$app->user->identity->id ?>">Incomingrequest
<span class="btn-group-vertical"><?=$user->getIncomingfriends()->count() ?></span>
</a>
</span>
</h1>

<?php if(!empty($users)) : ?>

	<div class="col-sm-5">
	<ul class="list-group">
	<?php foreach($users as $suggestedFriend) : ?>
		<?php if(($FRIENDquery->where(['user_id' => $suggestedFriend->id, 'status' => $status_ACCEPTED])->count() == 0) || ($FRIENDquery->where(['friend_id' => $suggestedFriend->id, 'status' => $status_ACCEPTED])->count() == 0) || ($FRIENDquery->where(['user_id' => $suggestedFriend->id, 'status' => $status_PENDING])->count() == 0) || ($FRIENDquery->where(['friend_id' => $toBeFriend->id, 'status' => $status_PENDING])->count() == 0)): ?>

		<li class="list-group-item"><?= $suggestedFriend->first_name; ?> <?= $suggestedFriend->last_name; ?> <a class="btn btn-primary" href="friendsapp/add?id=<?= $suggestedFriend->id ?>" style="margin-left: 250px">Add</a></li>

		<?php else: ?>

		<?php if(($FRIENDquery->where(['user_id' => $toBeFriend->id, 'status' => $status_ACCEPTED])->count() > 0) || ($FRIENDquery->where(['friend_id' => $toBeFriend->id, 'status' => $status_ACCEPTED])->count() > 0) || ($FRIENDquery->where(['user_id' => $toBeFriend->id, 'status' => $status_PENDING])->count() > 0) || ($FRIENDquery->where(['friend_id' => $toBeFriend->id, 'status' => $status_PENDING])->count() > 0)) : ?>
			<?php continue;?>

		<?php else: ?>
			<li class="list-group-item"><?= $toBeFriend->first_name; ?> <?= $toBeFriend->last_name; ?> <a class="btn btn-primary" href="index.php/friendsapp/add?id=<?= $toBeFriend->id ?>">Add</a></li>

		<?php endif; ?>

	<?php endif?>
	<?php  endforeach; ?>
	</ul>
	</div>

<?php else: ?>

<p>No user</p>


<?php endif; ?>

<?= LinkPager::widget(['pagination'=>$pagination]);?>

