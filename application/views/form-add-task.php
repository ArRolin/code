<section id='add-task-form' title='Add task'>
	<p>Give your task a title and submit.</p>
	<form>
		<input type='hidden' name='backlog_id' value='<?= $backlog["id"]; ?>'/>
		<label for='title'>Title:</label>
		<input type='text' id='title' name='title' />
	</form>
</section>