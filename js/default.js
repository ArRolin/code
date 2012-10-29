$(document).ready(function() {
	backlog();
	board();
});

function backlog()
{
	onclick_load_items();
	resizable_backlog();
	sortable_tasks();
	add_task();
}

function board()
{
	toggle_board_view();
	sortable_column_items();
}

function onclick_load_items()
{
	$('#task-list li').unbind('click');
	$('#task-list li').click(function(){
		var task_id = $(this).data('task');
		load_items(task_id);
	});
}

function load_items(task_id)
{
	$('section.items').empty();
	$.ajax({
		type: 'POST',
		url: 'item/get_items',
		data: { task_id: task_id },
		success: function(html){
			$('section.items').append(html);
			sortable_items();
			task_functions(task_id);
		}
	});
}

function task_functions(task_id)
{
	add_item(task_id);
	edit_task(task_id);
	edit_item();
	$('#item-list li').click(function() {
		$('#item-list li p').hide();
		$(this).find('p').show();
	});
	
	$('#item-list li').each(function() {
		if($(this).find('p').length) {
			$(this).find('.ui-icon').show();
		}
	});
}

function resizable_backlog()
{
	$('section.tasks').resizable({
		'handles': 'e',
	});
}

function sortable_tasks()
{
	$('#task-list').sortable({
		'axis': 'y',
		'start': function(event,ui){
            ui.placeholder.height(ui.item.height());
        },
		'update': function(){
            $.ajax({
                type: 'POST',
                url: 'task/update_prio',
                data: $('#task-list').sortable('serialize')
            }); 
		}
	});
}

function sortable_items()
{
	$('#item-list').sortable({
		'axis': 'y',
		'start': function(event,ui){
            ui.placeholder.height(ui.item.height());
        },
		'update': function(){
            $.ajax({
                type: 'POST',
                url: 'item/update_prio',
                data: $('#item-list').sortable('serialize')
            }); 
		}
	});
}

function sortable_column_items()
{
	$('.columns').each(function(){
		$('.item-board', this).sortable({
			'connectWith': $('.item-board', this),
			'receive': function(event, ui){
				$.ajax({
		            type: 'POST',
		            url: 'board/update_item_position',
		            data: { task_id: ui.item.data('task'), item_id: ui.item.data('item'), column_id: $(this).parent('.columns li').data('column') },
		            success: function() {
		            	$('.columns').each(function(){
		            		var total_items = $('.item-board li', this).length;
		            		var done_items = $('.item-board', this).last().children('li').length;
		            		if(total_items==done_items){
		            			$(this).parent('li').addClass('is_done');
		            		} else {
		            			$(this).parent('li').removeClass('is_done');
		            		}
		            	});
		            }
		        });
			},
			'start': function(e,ui){
	            ui.placeholder.height(ui.item.height());
	        },
		});
	});
}

function toggle_board_view()
{
	$('#toggle_board a').toggle(function(){
		$('.columns > li').width('100%');
		$('.item-board li').css('white-space', 'normal');
		$('#toggle_board a').empty().append('Overview');
	}, function() {
		$('.columns > li').width('25%');
		$('.item-board li').css('white-space', 'nowrap');
		$('#toggle_board a').empty().append('Detailed');
	});
}

function add_task()
{
	$('#add-task a').unbind('click');
	$('#add-task a').click(function() {
		$('#add-task-form').remove();
		$.ajax({
			type: 'POST',
			url: 'task/add_form',
			data: { backlog_id: $('section.backlog').data('backlog') },
			success: function(html){
				$('body').append(html);
				$('#add-task-form').dialog({
					autoOpen: false,
					height: 250,
					width: 600,
					buttons: {
						Submit: function() {
							$.ajax({
								type: 'POST',
								url: 'task/add',
								data: $("#add-task-form form").serialize(),
								dataType: 'json',
								success: function(json){
									$('#empty_task_list').remove();
									$('#task-list').append('<li id="task_' + json['last_id'] + '" data-task="' + json['last_id'] + '">' + json['title'] + '</li>');
									onclick_load_items();
								}
							});
							$(this).dialog("close");
						},
						Cancel: function() {
							$(this).dialog( "close" );
						}
					}
				});
				$("#add-task-form").dialog( "open" );
			}
		});
	});
}

function edit_task(task_id)
{
	$('#edit-task').show();
	$('#edit-task a').unbind('click');
	$('#edit-task a').click(function() {
		$('#edit-task-form').remove();
		$.ajax({
			type: 'POST',
			url: 'task/edit_form',
			data: { task_id: task_id },
			success: function(html){
				$('body').append(html);
				$('#edit-task-form').dialog({
					autoOpen: false,
					height: 300,
					width: 600,
					buttons: {
						Submit: function() {
							$.ajax({
								type: 'POST',
								url: 'task/edit',
								data: $('#edit-task-form form').serialize(),
								dataType: 'json',
								success: function(json){
									$('#task_' + json['id']).empty();
									$('#task_' + json['id']).append(json['title']);
									load_items(json['id']);
								}
							});
							$(this).dialog('close');
						},
						Delete: function() {
							delete_task(task_id);
						},
						Cancel: function() {
							$(this).dialog('close');
						}
					}
				});
				$('#edit-task-form').dialog('open');
			}
		});
	});
}

function delete_task(task_id)
{
	$('#delete-task-form').remove();
	$.ajax({
		type: 'POST',
		url: 'task/delete_form',
		data: { task_id: task_id },
		success: function(html){
			$('body').append(html);
			$('#delete-task-form').dialog({
				autoOpen: false,
				height: 150,
				width: 350,
				buttons: {
					'Delete permanently': function() {
						$.ajax({
							type: 'POST',
							url: 'task/delete',
							data: $("#delete-task-form form").serialize(),
							dataType: 'json',
							success: function(json){
								$('#edit-task, #add-item').hide();
								$('section.items').empty();
								$('#task_' + json['id']).remove();
								$('#edit-task-form').dialog('close');
								$('#delete-task-form').dialog('close');
							}
						});
					},
					Cancel: function() {
						$(this).dialog('close');
					}
				}
			});
			$('#delete-task-form').dialog('open');
		}
	});
}

function add_item(id)
{
	$('#add-item').show();
	$('#add-item a').unbind('click');
	$('#add-item a').click(function() {
		$('#add-item-form').remove();
		$.ajax({
			type: 'POST',
			url: 'item/add_form',
			data: { task_id: id },
			success: function(html){
				$('body').append(html);
				$('#add-item-form').dialog({
					autoOpen: false,
					height: 250,
					width: 600,
					buttons: {
						Submit: function() {
							$.ajax({
								type: 'POST',
								url: 'item/add',
								data: $("#add-item-form form").serialize(),
								dataType: 'json',
								success: function(json){
									load_items(json['task_id']);
									$('#task_' + json['task_id']).removeClass('is_done');
								}
							});
							$(this).dialog('close');
						},
						Cancel: function() {
							$(this).dialog('close');
						}
					}
				});
				$('#add-item-form').dialog('open');
			}
		});
	});
}

function edit_item()
{
	$('#item-list li a').unbind('click');
	$('#item-list li a').click(function() {
		$('#edit-item-form').remove();
		var id = $(this).parent('li').data('item');
		$.ajax({
			type: 'POST',
			url: 'item/edit_form',
			data: { id: id },
			success: function(html){
				$('body').append(html);
				$('#edit-item-form').dialog({
					height: 300,
					width: 600,
					buttons: {
						Submit: function() {
							$.ajax({
								type: 'POST',
								url: 'item/edit',
								data: $('#edit-item-form form').serialize(),
								dataType: 'json',
								success: function(json){
									load_items(json['task_id']);
								}
							});
							$(this).dialog('close');
						},
						Delete: function() {
							delete_item(id);
						},
						Cancel: function() {
							$(this).dialog('close');
						}
					}
				});
			}
		});
	});
}

function delete_item(id)
{
	$('#delete-item-form').remove();
	$.ajax({
		type: 'POST',
		url: 'item/delete_form',
		data: { id: id },
		success: function(html){
			$('body').append(html);
			$('#delete-item-form').dialog({
				autoOpen: false,
				height: 150,
				width: 350,
				buttons: {
					'Delete permanently': function() {
						$.ajax({
							type: 'POST',
							url: 'item/delete',
							data: $("#delete-item-form form").serialize(),
							dataType: 'json',
							success: function(json){
								load_items(json['task_id']);
							}
						});
					},
					Cancel: function() {
						$(this).dialog('close');
					}
				}
			});
			$('#delete-item-form').dialog('open');
		}
	});
}