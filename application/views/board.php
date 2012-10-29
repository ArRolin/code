<nav class='board'>
	<ul>
		<li id='toggle_board'><a href='#'>Detailed</a></li>
	</ul>
</nav>
<section class='board'>
	<?php if(isset($tasks)) : ?>
		<ul>
			<?php foreach($tasks as $task) : ?>
				<li <?php if($task['is_done']){ echo 'class="is_done"'; } ?>>
					<h3><?= $task['title']; ?></h3>
					<ul class='columns'>
						<?php foreach($columns as $column_key=>$column) : ?>
							<li data-column='<?= $column["id"]; ?>'>
								<h4><?= $column['title']; ?></h4>
								<?php if($task['column_id'] == $column['id']) : ?>
									<ul class='item-board'>
										<li data-task='<?= $task["id"]; ?>'>Progress</li>
									</ul>
								<?php else : ?>
									<ul class='item-board'>
										<?php if(isset($task['items'])) : ?>
											<?php foreach($task['items'] as $item) : ?>
												<?php if(empty($item['column_id']) && $column_key==0) : ?>
													<li data-item='<?= $item["id"]; ?>'><?= $item['title']; ?></li>
												<?php else : ?>
													<?php if($column['id'] == $item['column_id']) : ?>
														<li data-item='<?= $item["id"]; ?>'><?= $item['title']; ?></li>
													<?php endif; ?>
												<?php endif; ?>
											<?php endforeach; ?>
										<?php endif; ?>
									</ul>
								<?php endif; ?>
							</li>
						<?php endforeach; ?>
					</ul>
				</li>
			<?php endforeach; ?>
		</ul>
	<?php else: ?>
		<section id='empty_board'>
			<img src='<?php echo base_url(); ?>/img/empty_board.png' alt='Empty task list'/>
		</section>
	<?php endif; ?>
</section>