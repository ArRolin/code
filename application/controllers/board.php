<?php
class Board extends CI_Controller {

	function __construct()
    {
        parent::__construct();
        $this->load->model('Board_model');
        $this->load->model('Task_model');
        $this->load->model('Item_model');
    }

    function index()
    {
        $id = 1;
        $backlog_id = 1;

        $tasks = $this->Task_model->get_tasks($backlog_id);

        if(isset($tasks))
        {
            foreach($tasks as $key=>$task)
            {
                $tasks[$key]['items'] = $this->Item_model->get_items($task['id']);
            }

            $data['tasks'] = $tasks;
        }
        $data['columns'] = $this->Board_model->get_columns($id);

        $this->load->view('header');
        $this->load->view('nav-project');
        $this->load->view('board', $data);
    }

    function update_item_position()
    {
        $post_data = $_POST;

        $column_id = $post_data['column_id'];

        $column = $this->Board_model->get_column($column_id);
        $board = $this->Board_model->get($column['board_id']);

        if(isset($post_data['task_id']))
        {
            $task_id = $post_data['task_id'];

            

            if($board['column_done'] == $column_id){
                $this->Task_model->progress_done($task_id);
            } else {
                $this->Task_model->progress_not_done($task_id);
            }

            $this->Task_model->update_column_id($task_id, $column_id);
        }
        else if(isset($post_data['item_id']))
        {
            $item_id = $post_data['item_id'];

            $this->Item_model->update_column_id($item_id, $column_id);

            $item = $this->Item_model->get($item_id);
            $task_id = $item['task_id'];
            $items = $this->Item_model->get_items($task_id);

            $is_the_task_done = true;
            
            foreach ($items as $item){
                if($board['column_done'] != $item['column_id']){
                    $is_the_task_done = false;
                }
            }

            if($is_the_task_done){
                $this->Task_model->progress_done($task_id);
            } else {
                $this->Task_model->progress_not_done($task_id);
            }
        }
    }
}