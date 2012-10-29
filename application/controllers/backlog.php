<?php
class Backlog extends CI_Controller {

	function __construct()
    {
        parent::__construct();
        $this->load->model('Task_model');
        $this->load->model('Item_model');
    }

    function index()
    {
    	$id = 1;
        $data['backlog']['id'] = $id;
    	$data['tasks'] = $this->Task_model->get_tasks($id);
        $this->load->view('header');
        $this->load->view('nav-project');
        $this->load->view('backlog', $data);
    }
}