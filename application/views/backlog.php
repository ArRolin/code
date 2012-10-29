<nav class='backlog'>
	<ul>
		<li id='add-task'><a href='#'>Add task</a></li>
		<li id='edit-task'><a href='#'>Edit task</a></li>
		<li id='add-item'><a href='#'>Add item</a></li>
	</ul>
</nav>
<section class='backlog' data-backlog='<?= $backlog["id"]; ?>'>
	<section class='tasks'>
		<ul id='task-list'>
			<?php if(isset($tasks)) : ?>
				<?php foreach($tasks as $task): ?>
					<?php if(!$task['is_done']): echo '<li id="task_' . $task['id'] . '" data-task="' . $task['id'] . '">' . $task['title'] . '</li>'; ?>
					<?php elseif ($task['is_done']): echo '<li class="is_done" id="task_' . $task['id'] . '" data-task="' . $task['id'] . '">' . $task['title'] . '</li>';  ?>
					<?php endif; ?>
				<?php endforeach; ?>
			<?php else: ?>
				<section id='empty_task_list'>
					<img src='<?php echo base_url(); ?>/img/empty-task-list.png' alt='Empty task list'/>
				</section>
			<?php endif; ?>
		</ul>
	</section>
	<section class='items'>
		<section id='backlog-instructions'>
			<img src='<?php echo base_url(); ?>/img/backlog-instructions.png' alt='Empty task list'/>
		</section>
	</section>
</section>