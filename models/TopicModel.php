<?php

class TopicModel extends BaseModel {
    public function __construct($args = array() ) {
        parent::__construct($args);
    }

    public function getAllAnswersByTopicId($topicId, $page) {
        $statement = $this->db->prepare("
                SELECT a.id, t.title, a.content , a.topic_id, a.user_id, au.username AS answer_username
                FROM topics AS t JOIN answers AS a
                    ON t.id = a.topic_id RIGHT JOIN users AS au
                    ON a.user_id = au.id
                WHERE t.id = ?
                LIMIT ?, ?
                ");
        $size = 10;
        $page = ($page - 1)  * $size;
        $statement->bind_param("iii", $topicId,  $page, $size );
        $statement->execute();
        $results = $this->processResults($statement->get_result());

        return $results;
    }

    public function getFirst10TopicsOrderByLastAnswer() {
        $statement = $this->db->prepare("
            SELECT t.title, t.id AS topic_id, t.created_at AS topic_created_at, t.user_id AS topic_user_id,
                   tu.username AS topic_username, au.username AS answer_username, a.publish_date,
                   a.user_id AS answer_user_id, t.answers_counter, a.id AS answer_id, t.views_counter
            FROM topics AS t JOIN answers AS a
                ON t.id = a.topic_id JOIN users AS tu
                ON t.user_id = tu.id JOIN users AS au
                ON a.user_id = au.id
            GROUP BY t.id
            ORDER BY a.publish_date DESC
            LIMIT 10
        ");

        $statement->execute();

        return $this->processResults($statement->get_result());
    }

    public function getTopicsAnswerCount() {
        $statement = $this->db->prepare("
            SELECT t.id, count(a.id) as answers_count
            FROM forum.topics AS t LEFT JOIN answers AS a
                ON a.topic_id = t.id
            GROUP BY t.id;
        ");

        $statement->execute();

        $topicAnswerCount = array();

        $results = $this->processResults($statement->get_result());

        foreach ($results as $row) {
            $topicAnswerCount[$row['id']] = $row['answers_count'];
        }

        return $topicAnswerCount;
    }
} 