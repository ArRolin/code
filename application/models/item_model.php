<?php
class Item_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

    function get($id)
    {
        $id = $this->db->escape($id);

        $sql = 'SELECT id, title, details, task_id, column_id FROM backlog_items WHERE id=' . $id;
        $query = $this->db->query($sql);

        $item['id'] = $query->row()->id;
        $item['title'] = $query->row()->title;
        $item['details'] = $query->row()->details;
        $item['task_id'] = $query->row()->task_id;
        $item['column_id'] = $query->row()->column_id;

        return $item;
    }

    function get_items($task_id)
    {
        $task_id = $this->db->escape($task_id);

        $sql = 'SELECT id, title, details, prio, column_id FROM backlog_items WHERE task_id=' . $task_id . ' ORDER BY prio ASC';
        $query = $this->db->query($sql);

        foreach ($query->result() as $key=>$value)
        {
            $items[$key]['id'] = $value->id;
            $items[$key]['title'] = $value->title;
            $items[$key]['details'] = $value->details;
            $items[$key]['prio'] = $value->prio;
            $items[$key]['column_id'] = $value->column_id;
        }

        if(isset($items)){
            return $items;
        }
    }

    function add($task_id, $title)
    {
        $task_id = $this->db->escape($task_id);
        $title = $this->db->escape($title);

        $sql = 'UPDATE backlog_tasks SET column_id=NULL WHERE id=' . $task_id;
        $this->db->query($sql);

        $sql = 'INSERT INTO backlog_items (title, prio, task_id) VALUES (' . $title . ', 999, ' . $task_id . ')';
        $this->db->query($sql);
        $last_id = $this->db->insert_id();

        return $last_id;
    }

    function edit($id, $title, $details)
    {
        $id = $this->db->escape($id);
        $title = $this->db->escape($title);
        $details = $this->db->escape($details);

        $sql = 'UPDATE backlog_items SET title=' . $title . ' , details=' . $details . ' WHERE id=' . $id;
        $this->db->query($sql);
    }

    function delete($id)
    {
        $id = $this->db->escape($id);

        $sql = 'DELETE FROM backlog_items WHERE id=' . $id;
        $this->db->query($sql);
    }

    function delete_task_items($task_id)
    {
        $sql = 'DELETE FROM backlog_items WHERE task_id=' . $task_id;
        $this->db->query($sql);
    }

    function update_prio($id, $prio)
    {
        $id = $this->db->escape($id);
        $prio = $this->db->escape($prio);

        $sql = 'UPDATE backlog_items SET prio=' . $prio . ' WHERE id=' . $id;
        $this->db->query($sql);
    }

    function update_column_id($id, $board_column_id)
    {
        $id = $this->db->escape($id);
        $board_column_id = $this->db->escape($board_column_id);

        $sql = 'UPDATE backlog_items SET column_id=' . $board_column_id . ' WHERE id =' . $id;
        $this->db->query($sql);
    }
}