<section id='edit-item-form' title='Edit item'>
	<p>Edit your item, you need to give your item a title before you submit.</p>
	<form>
		<input type='hidden' name='id' value='<?= $item["id"]; ?>'/>
		<label for='title'>Title:</label>
		<input type='text' id='title' name='title' value='<?php if(isset($item["id"])){ echo $item["title"]; } ?>' />
		<label for='details'>Details:</label>
		<textarea id='details' name='details' rows='5'><?php if(isset($item['details'])){ echo $item['details']; } ?></textarea>
	</form>
</section>