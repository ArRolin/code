<h3>Task</h3>
	<p class='title'><?= $task['title']; ?></p>
<h3>Details</h3>
<?php if((isset($task['details'])) && (2<strlen($task['details']))) : ?>
	<p class='details'><?= $task['details']; ?></p>
<?php else : ?>
	<p class='details'>You can add additional details by editing your task.</p>
<?php endif; ?>
<h3>Item list</h3>
<?php if(isset($items)) : ?>
	<ul id='item-list'>
		<?php foreach($items as $item) : ?>
			<li id='item_<?= $item["id"]; ?>' data-item='<?= $item["id"]; ?>'>
				<a href='#'>edit</a>
				<span class='ui-icon ui-icon-notice'></span><span><?= $item['title']; ?></span>
				<?php if((isset($item['details'])) && (2<strlen($item['details']))) :?>
					<p><?= $item['details']; ?></p>
				<?php endif; ?>
			</li>
		<?php endforeach; ?>
	</ul>
<?php else : ?>
	<p class='item-instructions'>The item list is empty, you can add a item in the upper right corner.</p>
	<ul id='item-list'></ul>
<?php endif; ?>