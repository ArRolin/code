<?php
class Project_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

    function get_projects()
    {
        $sql = 'SELECT id, title FROM projects';
        $query = $this->db->query($sql);

        foreach ($query->result() as $key=>$value)
        {
            $projects[$key]['id'] = $value->id;
            $projects[$key]['title'] = $value->title;
        }

        return $projects;
    }
}