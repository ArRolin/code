<?php
class Item extends CI_Controller {

	function __construct()
    {
        parent::__construct();
        $this->load->model('Item_model');
        $this->load->model('Task_model');
    }

    function get_items()
    {
        // Collects: "task_id"
        $post_data = $_POST;

        $task_id = (int) $post_data['task_id'];

        if(isset($task_id)){
            $data['task'] = $this->Task_model->get($task_id);
            $data['items'] = $this->Item_model->get_items($task_id);

            $this->load->view('item-list', $data);
        }
    }

    function add()
    {
        // Collects: "taks_id" & "title"
        $post_data = $_POST;

        $task_id = (int) $post_data['task_id'];
        $title = $post_data['title'];

        if(isset($task_id) && 2<strlen($title)){
            $last_id = $this->Item_model->add($task_id, $title);
        }

        $this->Task_model->progress_not_done($task_id);

        $data['task_id'] = $task_id;
        
        echo json_encode($data);
    }

    function add_form()
    {
        $post_data = $_POST;

        $task_id = $post_data['task_id'];

        $data['task'] = $this->Task_model->get($task_id);

        $this->load->view('form-add-item', $data);
    }

    function edit()
    {
        $post_data = $_POST;

        $id = $post_data['id'];
        $title = $post_data['title'];
        $details = $post_data['details'];

        if(isset($id) && 2<strlen($title)){
            $this->Item_model->edit($id, $title, $details);
        }

        $item = $this->Item_model->get($id);

        $data['task_id'] = $item['task_id'];

        echo json_encode($data);
    }

    function edit_form()
    {
        $post_data = $_POST;

        $id = $post_data['id'];

        $data['item'] = $this->Item_model->get($id);

        $this->load->view('form-edit-item', $data);
    }

    function delete()
    {
        $post_data = $_POST;

        $id = $post_data['item_id'];

        $item = $this->Item_model->get($id);

        $this->Item_model->delete($id);

        $remaning_items[] = $this->Item_model->get_items($item['task_id']);

        $task = $this->Task_model->get($item['task_id']);

        if(empty($remaning_items[0])){
            $this->Task_model->no_items_update_column_id_to_default($item['task_id'], $task['backlog_id']);
        }

        $data['task_id'] = $item['task_id'];

        echo json_encode($data);
    }

    function delete_form()
    {
        $post_data = $_POST;

        $id = $post_data['id'];

        $data['item'] = $this->Item_model->get($id);

        $this->load->view('form-delete-item', $data);
    }

    function update_prio()
    {
        $post_data = $_POST;

        foreach ($post_data['item'] as $prio => $id) {
            $this->Item_model->update_prio($id, $prio);
        }
    }
}