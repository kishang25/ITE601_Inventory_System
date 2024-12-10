<?php
class Group
{
    private $db;
    private $session; // You also need to use $session if you're using session messages

    // Constructor: Accepts a database connection instance
    public function __construct($database, $session)
    {
        $this->db = $database;
        $this->session = $session; // Assign the session instance
    }

    // CREATE: Add a new group
    public function create($name, $level, $status)
    {
        $name   = $this->db->escape($name);
        $level  = (int)$this->db->escape($level);
        $status = (int)$this->db->escape($status);

        $query = "INSERT INTO user_groups (group_name, group_level, group_status) ";
        $query .= "VALUES ('{$name}', '{$level}', '{$status}')";

        return $this->db->query($query);
    }

    // READ: Get all groups
    public function findAll()
    {
        $result = $this->db->query("SELECT * FROM user_groups");
        $groups = [];
        while ($row = $this->db->fetch_assoc($result)) {
            $groups[] = $row;
        }
        return $groups;
    }

    // READ: Find a group by ID
    public function findById($id)
    {
        $id = (int)$id;
        $result = $this->db->query("SELECT * FROM user_groups WHERE id = '{$id}' LIMIT 1");

        if (!$result) {
            return false; // Query failed
        }
        return $this->db->fetch_assoc($result) ?? false;
    }

    // UPDATE: Update group details
    public function update($id, $name, $level, $status)
    {
        $id     = (int)$id;
        $name   = $this->db->escape($name);
        $level  = (int)$this->db->escape($level);
        $status = (int)$this->db->escape($status);

        $query = "UPDATE user_groups SET 
                    group_name = '{$name}', 
                    group_level = '{$level}', 
                    group_status = '{$status}' 
                  WHERE id = '{$id}'";

        $result = $this->db->query($query);
        return $result && $this->db->affected_rows() === 1;
    }

    // DELETE: Delete a group by ID
    public function delete($id)
    {
        $id = (int)$id;
        $query = "DELETE FROM user_groups WHERE id = '{$id}'";
        return $this->db->query($query);
    }

    // Add Group (Add another method for the same functionality if needed)
    public function addGroup($data)
    {
        // Ensure all required fields are present
        if (empty($data['group-name']) || empty($data['group-level']) || !isset($data['status'])) {
            $this->session->msg('d', 'Please fill all the fields');
            return false;
        }

        $group_name = $this->db->escape($data['group-name']);
        $group_level = (int)$data['group-level'];
        $status = (int)$data['status'];

        // Query to insert new group
        $query = "INSERT INTO user_groups (group_name, group_level, group_status) VALUES ('{$group_name}', '{$group_level}', '{$status}')";
        $result = $this->db->query($query);

        // Check if insertion was successful
        if ($result && $this->db->affected_rows() === 1) {
            $this->session->msg('s', 'Group added successfully!');
            return true;
        } else {
            $this->session->msg('d', 'Failed to add the group!');
            return false;
        }
    }
}
?>
