<?php
class Project extends CI_Controller {

	function __construct()
    {
        parent::__construct();
        $this->load->model('Project_model');
    }

    function index()
    {
        $data['projects'] = $this->Project_model->get_projects();

        $this->load->view('header');
        $this->load->view('nav-project');
        $this->load->view('project', $data);
    }
}