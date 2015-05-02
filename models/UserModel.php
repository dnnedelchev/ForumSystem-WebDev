<?php

class UserModel extends BaseModel {
    public function __construct($args = array() ) {
        parent::__construct($args);
    }

    public function register($username, $password) {
        $statement = $this->db->prepare("SELECT id FROM users WHERE username = ?");
        $statement->bind_param('s', $username);
        $statement->execute();
        $result = $statement->get_result()->fetch_assoc();

        if (isset($result['id'])) {
            return null;
        }

        $hash_pass = password_hash($password, PASSWORD_BCRYPT);

        $insertStatement = $this->db->prepare("INSERT INTO users (username, pass_hash) VALUES (?, ?)");

        $insertStatement->bind_param('ss', $username, $hash_pass);
        $insertStatement->execute();

        $statement->execute();
        $result = $statement->get_result()->fetch_assoc();

        return $result['id'];
    }

    public function login($username, $password) {
        $statement = $this->db->prepare("SELECT id, username, pass_hash FROM users WHERE username = ?");
        $statement->bind_param('s', $username);
        $statement->execute();
        $result = $statement->get_result()->fetch_assoc();

        if (password_verify($password, $result['pass_hash'])) {
            return $result['id'];
        }

        return false;
    }
} 