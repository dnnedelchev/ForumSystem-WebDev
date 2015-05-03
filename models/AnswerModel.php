<?php

class AnswerModel extends BaseModel {
    public function __construct($args = array() ) {
        parent::__construct($args);
    }

    public function create($content, $topic_id, $user_id) {
        $statement = $this->db->prepare("
            INSERT INTO `answers`
            (`content`, `topic_id`, `user_id`)
            VALUES (?, ?, ?)
        ");

        $statement->bind_param('sii', $content, $topic_id, $user_id);
        $statement->execute();

        if ($statement->affected_rows === 1) {
            return true;
        } else {
            return false;
        }

    }

} 