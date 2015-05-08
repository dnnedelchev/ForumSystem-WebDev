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

    public function getAnswerLastPageNumberById($answerId) {
        $statement = $this->db->prepare("
            SELECT count(a.id) AS results
            FROM topics AS t JOIN answers AS a
                ON t.id = a.topic_id
            WHERE t.id = ?
        ");
        $statement->bind_param('i', $topicId);
        $statement->execute();

        $result = $this->processResults($statement->get_result())[0];

        $lastPageNumber = intval($result['results'] / 10) + 1;

        return $lastPageNumber;
    }

} 