<?php

use yii\helpers\Html;
use yii\widgets\LinkPager;

?>

<h1 class="page-header">Recieved Friend request</h1>

<section>
<div class="col-sm-5">
<?php if(!empty($user)) : ?>

<ul>
	<?php foreach($user->incomingfriends as $friends) : ?>
		<li class="list-group-item">
			<?= $friends->user->first_name; ?> <?= $friends->user->last_name; ?> 
			<a class="btn btn-primary" href="accept?id=<?= $friends->friend_id ?>&friends=<?= $user->id ?>" style="margin-left: 150px">Accept</a>
			<a class="btn btn-warning" href="reject?id=<?= $friends->friend_id ?>&friends=<?= $user->id ?>">Reject</a>
		</li>

	<?php  endforeach; ?>
</ul>

<?php else: ?>

<p>No user</p>


<?php endif; ?>
</div>
</section>







<section>
    <p><a href="/index.php/friendsapp">go back</a></p>
</section>
