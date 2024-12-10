<?php
class User {
    private $db;
    private $session;

    public function __construct($db, $session) {
        $this->db = $db;
        $this->session = $session;
    }

    /**
     * Validate required fields
     */
    private function validateFields($data, $required_fields) {
        $errors = [];
        foreach ($required_fields as $field) {
            if (empty($data[$field])) {
                $errors[] = "Field '{$field}' cannot be blank.";
            }
        }
        return $errors;
    }

    /**
     * Add a new user to the database
     */
    public function addUser($data) {
        $required_fields = ['full-name', 'username', 'password', 'level'];
        $errors = $this->validateFields($data, $required_fields);

        if (!empty($errors)) {
            $this->session->msg("d", $errors);
            return false;
        }

        $name       = remove_junk($this->db->escape($data['full-name']));
        $username   = remove_junk($this->db->escape($data['username']));
        $password   = sha1(remove_junk($this->db->escape($data['password'])));
        $user_level = (int)$this->db->escape($data['level']);

        $query  = "INSERT INTO users (name, username, password, user_level, status) ";
        $query .= "VALUES ('{$name}', '{$username}', '{$password}', '{$user_level}', '1')";

        if ($this->db->query($query)) {
            $this->session->msg('s', "User account has been created!");
            return true;
        } else {
            $this->session->msg('d', "Sorry, failed to create account!");
            return false;
        }
    }

    /**
     * Retrieve all user groups
     */
    public function getUserGroups() {
        return find_all('user_groups');
    }
}
?>
