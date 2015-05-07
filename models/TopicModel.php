<?php

class TopicModel extends BaseModel {
    public function __construct($args = array() ) {
        parent::__construct($args);
    }

    public function getAllAnswersByTopicId($topicId, $page) {
        $statement = $this->db->prepare("
                SELECT a.id AS answer_id, t.title, a.content , a.topic_id, a.user_id AS answer_user_id,
                       au.username AS answer_username, au.registration_date, a.publish_date
                FROM topics AS t JOIN answers AS a
                    ON t.id = a.topic_id RIGHT JOIN users AS au
                    ON a.user_id = au.id
                WHERE t.id = ?
                ORDER BY a.publish_date ASC
                LIMIT ?, ?
                ");
        $size = BaseModel::DEFAULT_PAGE_SIZE;
        $start = ($page - 1)  * $size;
        $statement->bind_param("iii", $topicId,  $start, $size);
        $statement->execute();
        $results = $this->processResults($statement->get_result());

        return $results;
    }

    public function getFirst10TopicsOrderByLastAnswer() {
        $statement = $this->db->prepare("
            SELECT t.title, t.id AS topic_id, t.created_at AS topic_created_at, t.user_id AS topic_user_id,
                   tu.username AS topic_username, au.username AS answer_username, a.publish_date,
                   a.user_id AS answer_user_id, a.id AS answer_id, t.views_counter
            FROM topics AS t LEFT JOIN answers AS a
                ON t.id = a.topic_id LEFT JOIN users AS tu
                ON t.user_id = tu.id LEFT JOIN users AS au
                ON a.user_id = au.id
            WHERE a.publish_date = (SELECT publish_date
                FROM answers
                WHERE topic_id = t.id
                ORDER BY publish_date DESC
                LIMIT 1) OR a.topic_id IS NULL
            GROUP BY t.id
            ORDER BY publish_date DESC, t.created_at DESC
            LIMIT 10
        ");

        $statement->execute();

        $results = $this->processResults($statement->get_result());

        return $results;
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

    public function getTopicLastPageNumberById($topicId) {
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

    public function addNewTopic($topicTitle, $topicContent, $categoryId, $userId) {

        $statement = $this->db->prepare("
            INSERT INTO topics (title, category_id, created_at, user_id, views_counter, content)
            VALUES (?, ?, NOW(), ?, 0, ?);
        ");

        $statement->bind_param('siis',$topicTitle, intval($categoryId), $userId, $topicContent);
        $statement->execute();

        if ($statement->insert_id) {
            return $statement->insert_id;
        } else {
            return false;
        }
    }

    public function getTopicInfo($topicId) {
        $statement = $this->db->prepare("
        SELECT t.id AS topic_id, t.title, t.category_id, t.created_at, t.user_id, t.content,
               u.username, u.registration_date
        FROM topics AS t JOIN users AS u
            ON t.user_id = u.id
        WHERE t.id = ?
        ");

        $statement->bind_param('i', $topicId);
        $statement->execute();

        $result = $this->processResults($statement->get_result());

        return $result[0];
    }
} 