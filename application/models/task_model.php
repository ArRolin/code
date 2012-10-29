<?php
class Task_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

    function get($id)
    {
        $id = $this->db->escape($id);

        $sql = 'SELECT id, title, details, backlog_id, column_id FROM backlog_tasks WHERE id=' . $id;
        $query = $this->db->query($sql);

            $task['id'] = $query->row()->id;
            $task['title'] = $query->row()->title;
            $task['details'] = $query->row()->details;
            $task['backlog_id'] = $query->row()->backlog_id;
            $task['column_id'] = $query->row()->column_id;

        if(isset($task))
        {
            return $task;
        }
    }

    function get_tasks($backlog_id)
    {
        $backlog_id = $this->db->escape($backlog_id);

        $sql = 'SELECT id, title, prio, column_id, is_done FROM backlog_tasks WHERE backlog_id=' . $backlog_id . ' ORDER BY prio ASC';
        $query = $this->db->query($sql);

        foreach ($query->result() as $key=>$value)
        {
            $tasks[$key]['id'] = $value->id;
            $tasks[$key]['title'] = $value->title;
            $tasks[$key]['prio'] = $value->prio;
            $tasks[$key]['column_id'] = $value->column_id;
            $tasks[$key]['is_done'] = $value->is_done;
        }

        if(isset($tasks))
        {
            return $tasks;
        }
    }

    function add($backlog_id, $title)
    {
        $backlog_id = $this->db->escape($backlog_id);
        $title = $this->db->escape($title);

        $sql = 'SELECT id FROM boards WHERE backlog_id=' . $backlog_id;
        $query = $this->db->query($sql);
        $board_id = $query->row()->id;

        $sql = 'SELECT id FROM board_columns WHERE arranged_order=1 AND board_id=' . $board_id;
        $query = $this->db->query($sql);
        $column_id =  $query->row()->id;

        $sql = 'INSERT INTO backlog_tasks (title, prio, backlog_id, column_id) VALUES (' . $title . ', 999, ' . $backlog_id . ', ' . $column_id . ')';
        $query = $this->db->query($sql);
        $last_id = $this->db->insert_id();

        return $last_id;
    }

    function edit($id, $title, $details)
    {
        $id = $this->db->escape($id);
        $title = $this->db->escape($title);
        $details = $this->db->escape($details);

        $sql = 'UPDATE backlog_tasks SET title=' . $title . ' , details=' . $details . ' WHERE id=' . $id;
        $this->db->query($sql);
    }

    function delete($id)
    {
        $id = $this->db->escape($id);

        $sql = 'DELETE FROM backlog_tasks WHERE id=' . $id;
        $this->db->query($sql);
    }

    function update_prio($id, $prio)
    {
        $id = $this->db->escape($id);
        $prio = $this->db->escape($prio);

        $sql = 'UPDATE backlog_tasks SET prio=' . $prio . ' WHERE id=' . $id;
        $this->db->query($sql);
    }

    function update_column_id($id, $board_column_id)
    {
        $id = $this->db->escape($id);
        $board_column_id = $this->db->escape($board_column_id);

        $sql = 'UPDATE backlog_tasks SET column_id=' . $board_column_id . ' WHERE id =' . $id;
        $this->db->query($sql);
    }

    function add_to_board($id, $column_id)
    {
        $id = $this->db->escape($id);
        $column_id = $this->db->escape($column_id);

        $sql = 'INSERT INTO backlog_tasks_in_board_columns (backlog_task_id, board_column_id) VALUES (' . $id . ', ' . $column_id . ')';
        $this->db->query($sql);
    }

    function no_items_update_column_id_to_default($id, $backlog_id)
    {
        $id = $this->db->escape($id);
        $backlog_id = $this->db->escape($backlog_id);

        $sql = 'SELECT id FROM boards WHERE backlog_id=' . $backlog_id;
        $query = $this->db->query($sql);
        $board_id = $query->row()->id;

        $sql = 'SELECT id FROM board_columns WHERE arranged_order=1 AND board_id=' . $board_id;
        $query = $this->db->query($sql);
        $column_id =  $query->row()->id;

        $sql = 'UPDATE backlog_tasks SET column_id=' . $column_id . ' WHERE id =' . $id;
        $this->db->query($sql);
    }

    function progress_done($id)
    {
        $id = $this->db->escape($id);
        $sql = 'UPDATE backlog_tasks SET is_done=true WHERE id =' . $id;
        $query = $this->db->query($sql);
    }

    function progress_not_done($id)
    {
        $id = $this->db->escape($id);
        $sql = 'UPDATE backlog_tasks SET is_done=false WHERE id =' . $id;
        $query = $this->db->query($sql);
    }
}