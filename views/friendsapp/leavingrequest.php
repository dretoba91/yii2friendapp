<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;
?>



<h1 class="page-header">Send Friend request</h1>

<div class="col-sm-5">
<?php if(!empty($user)) : ?>
	
		<ul>
			<?php foreach($user->outgoingfriends as $friends) : ?>
				<li class="list-group-item">
					<?= $friends->friend->first_name;?> <?= $friends->friend->last_name;?>
		 			    <a class="btn btn-danger" href="cancel?id=<?= $user->id ?>&friends=<?= $friends->friend_id ?>" style="margin-left: 200px">Cancel</a> 
				</li>

			<?php  endforeach; ?>
		</ul>

		
		
		<?php else: ?>

      <p>No user</p>
	

<?php endif; ?>

</div>



	




<a href="/index.php/friendsapp">go back</a>