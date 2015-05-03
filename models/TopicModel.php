<?php

class TopicModel extends BaseModel {
    public function __construct($args = array() ) {
        parent::__construct($args);
    }

    public function getAllAnswersByTopicId($topicId) {
        $statement = $this->db->prepare("
               SELECT a.id, t.title, a.content , a.topic_id, a.user_id
                FROM topics AS t JOIN answers AS a
                    ON t.id = a.topic_id
                WHERE t.id = ?");
        $statement->bind_param("i", $topicId);
        $statement->execute();
        $results = $this->processResults($statement->get_result());

        return $results;
    }

    public function getFirst10TopicsOrderByLastAnswer() {
        $statement = $this->db->prepare("
            SELECT t.title, a.publish_date, a.user_id AS answer_author_id, t.answers_counter
            FROM topics AS t JOIN answers AS a
                ON t.id = a.topic_id
            ORDER BY a.publish_date DESC;
        ");

        $statement->execute();

        return $this->processResults($statement->get_result());
    }
} 