<?php
class Task extends CI_Controller {

	function __construct()
    {
        parent::__construct();
        $this->load->model('Task_model');
        $this->load->model('Item_model');
    }

    function add()
    {
        // Collects: "backlog_id" & "title"
        $post_data = $_POST;

        $backlog_id = (int) $post_data['backlog_id'];
        $title = $post_data['title'];

        if(isset($backlog_id) && 2<strlen($title)){
            $last_id = $this->Task_model->add($backlog_id, $title);
        }

        $data['last_id'] = $last_id;
        $data['title'] = $title;

        echo json_encode($data);
    }

    function add_form()
    {
        $post_data = $_POST;

        $backlog_id = $post_data['backlog_id'];

        $data['backlog']['id'] = $backlog_id;

        $this->load->view('form-add-task', $data);
    }

    function edit()
    {
        $post_data = $_POST;

        $id = $post_data['id'];
        $title = $post_data['title'];
        $details = $post_data['details'];

        if(isset($id) && 2<strlen($title)){
            $this->Task_model->edit($id, $title, $details);
        }

        $data['id'] = $id;
        $data['title'] = $title;

        echo json_encode($data);
    }

    function edit_form()
    {
        $post_data = $_POST;

        $task_id = $post_data['task_id'];

        $data['task'] = $this->Task_model->get($task_id);

        $this->load->view('form-edit-task', $data);
    }

    function delete()
    {
        $post_data = $_POST;

        $id = $post_data['task_id'];

        $this->Item_model->delete_task_items($id);
        $this->Task_model->delete($id);

        $data['id'] = $id;

        echo json_encode($data);
    }

    function delete_form()
    {
        $post_data = $_POST;

        $task_id = $post_data['task_id'];

        $data['task'] = $this->Task_model->get($task_id);

        $this->load->view('form-delete-task', $data);
    }

    function update_prio()
    {
        $post_data = $_POST;

        foreach ($post_data['task'] as $prio => $id) {
            $this->Task_model->update_prio($id, $prio);
        }
    }

    function add_to_board()
    {
        $post_data = $_POST;

        $board_column_id = $post_data['board_column_id']; 
        $id = $post_data['task_id'];

        $this->Task_model->add_to_board($id, $board_column_id);
    }
}