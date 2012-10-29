<section id='add-item-form' title='Add item'>
	<p>Give your item a title and submit.</p>
	<form>
		<input type='hidden' name='task_id' value='<?= $task['id']; ?>'/>
		<label for='title'>Title:</label>
		<input type='text' id='title' name='title' />
	</form>
</section>