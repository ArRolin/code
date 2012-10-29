<?php
class Board_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

    function get($id)
    {
        $board_id = $this->db->escape($id);

        $sql = 'SELECT column_done FROM boards WHERE id=' . $board_id;
        $query = $this->db->query($sql);

        $board['column_done'] = $query->row()->column_done;

        return $board;

    }

    function get_columns($id)
    {
        $board_id = $this->db->escape($id);

        $sql = 'SELECT id, title FROM board_columns WHERE board_id=' . $board_id . ' ORDER BY arranged_order ASC';
        $query = $this->db->query($sql);

        foreach ($query->result() as $key=>$value)
        {
            $columns[$key]['id'] = $value->id;
            $columns[$key]['title'] = $value->title;
        }

        return $columns;
    }

    function get_column($column_id)
    {
        $column_id = $this->db->escape($column_id);

        $sql = 'SELECT board_id FROM board_columns WHERE id=' . $column_id;
        $query = $this->db->query($sql);

        $column['board_id'] = $query->row()->board_id;

        return $column;
    }
}