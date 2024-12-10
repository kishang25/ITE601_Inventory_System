<?php
class Group {
    private $db;
    private $session;

    public function __construct($db, $session) {
        $this->db = $db;
        $this->session = $session;
    }

    public function addGroup($data) {
        $errors = $this->validateGroup($data);

        if (!empty($errors)) {
            $this->session->msg("d", $errors);
            return false;
        }

        $name = remove_junk($this->db->escape($data['group-name']));
        $level = remove_junk($this->db->escape($data['group-level']));
        $status = remove_junk($this->db->escape($data['status']));

        $query = "INSERT INTO user_groups (group_name, group_level, group_status) VALUES ('{$name}', '{$level}', '{$status}')";

        if ($this->db->query($query)) {
            $this->session->msg('s', "Group has been created!");
            return true;
        } else {
            $this->session->msg('d', "Sorry, failed to create Group!");
            return false;
        }
    }

    private function validateGroup($data) {
        $errors = [];
        $req_fields = ['group-name', 'group-level'];
        foreach ($req_fields as $field) {
            if (empty($data[$field])) {
                $errors[] = "Field {$field} cannot be blank.";
            }
        }

        if ($this->findByGroupName($data['group-name'])) {
            $errors[] = "Entered Group Name already exists in the database.";
        }

        if ($this->findByGroupLevel($data['group-level'])) {
            $errors[] = "Entered Group Level already exists in the database.";
        }

        return $errors;
    }

    private function findByGroupName($name) {
        $name = $this->db->escape($name);
        $query = "SELECT * FROM user_groups WHERE group_name = '{$name}' LIMIT 1";
        return $this->db->query($query)->num_rows > 0;
    }

    private function findByGroupLevel($level) {
        $level = (int) $this->db->escape($level);
        $query = "SELECT * FROM user_groups WHERE group_level = '{$level}' LIMIT 1";
        return $this->db->query($query)->num_rows > 0;
    }
}
