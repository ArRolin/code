<section id='edit-task-form' title='Edit task'>
	<p>Edit your task, you need to give your task a title before you submit.</p>
	<form>
		<input type='hidden' name='id' value='<?= $task['id']; ?>'/>
		<label for='title'>Title:</label>
		<input type='text' id='title' name='title' value='<?= $task["title"]; ?>' />
		<label for='details'>Details:</label>
		<textarea id='details' name='details' rows='5'><?= $task['details']; ?></textarea>
	</form>
</section>