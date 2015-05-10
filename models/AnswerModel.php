<?php

class AnswerModel extends BaseModel {
    public function __construct($args = array() ) {
        parent::__construct($args);
    }

    public function create($content, $topic_id, $user_id) {
        $statement = $this->db->prepare("
            INSERT INTO answers
            (content, topic_id, user_id, publish_date)
            VALUES (?, ?, ?, NOW())
        ");

        $statement->bind_param('sii', $content, $topic_id, $user_id);
        $statement->execute();

        if ($statement->affected_rows === 1) {
            return $statement->insert_id;
        } else {
            return false;
        }

    }

    public function getTopicLastPageNumberById($topicId) {
        $statement = $this->db->prepare("
            SELECT count(id) AS results
            FROM answers
            WHERE topic_id = ?
        ");
        $statement->bind_param('i', $topicId);
        $statement->execute();

        $result = $this->processResults($statement->get_result())[0];

        $lastPageNumber = ceil($result['results'] / 10);// + 1;

        return $lastPageNumber;
    }

    public function getAnswerInfoByTopicId($topicId) {
        $statement = $this->db->prepare("
            SELECT t.title AS topic_title
            FROM answers AS a JOIN topics AS t
              ON a.topic_id = t.id
            WHERE t.id = ?
        ");
        $statement->bind_param('i', $topicId);
        $statement->execute();
        return $this->processResults($statement->get_result())[0];
    }

    public function getAnswerInfo($answerId) {
        $statement = $this->db->prepare("
            SELECT t.title AS topic_title, t.id AS topic_id, a.id AS answer_id,
                   a.content AS content
            FROM answers AS a JOIN topics AS t
              ON a.topic_id = t.id
            WHERE a.id = ?
        ");

        $statement->bind_param('i', $answerId);
        $statement->execute();

        $result = $this->processResults($statement->get_result())[0];

        $statement = $this->db->prepare("
            SELECT count(a.id) AS count_answers
            FROM answers AS a JOIN topics AS t
              ON a.topic_id = t.id
            WHERE t.id=?
        ");

        $statement->bind_param('i', $result['topic_id']);
        $statement->execute();
        $page = ceil($this->processResults($statement->get_result())[0]['count_answers'] / BaseModel::DEFAULT_PAGE_SIZE);

        $result['page'] = $page;
        return $result;
    }

    public function edit($answerId, $content) {
        $statement = $this->db->prepare("
            UPDATE answers
            SET
            content = ?
            WHERE id = ?;
        ");

        $statement->bind_param('si', $content, $answerId);
        $statement->execute();

        if (!$statement->error) {
            return true;
        } else {
            return false;
        }
    }

    public function delete($answerId) {
        $statement = $this->db->prepare("
            DELETE FROM answers
            WHERE id = ?
        ");

        $statement->bind_param('i', $answerId);
        $statement->execute();

        if ($statement->affected_rows === 1) {
            return true;
        }

        return false;
    }

    public function isVoted($answerId, $userId) {
        $statement = $this->db->prepare("
            SELECT count(*) AS votes
            FROM answer_user_rates
            WHERE answer_id = ? AND user_id = ?;
        ");
        $statement->bind_param('ii', $answerId, $userId);
        $statement->execute();
        $result = $this->processResults($statement->get_result());

        if ($result[0]['votes'] === 1) {
            return true;
        }

        return false;
    }

    public function addVote($answerId, $userId) {
        $statement = $this->db->prepare("
            UPDATE answers
            SET
            rating = rating + 1
            WHERE id = ?;
        ");
        $statement->bind_param('i', $answerId);
        $statement->execute();

        $statement = $this->db->prepare("
            INSERT INTO answer_user_rates
            (answer_id, user_id)
            VALUES
            (?, ?);
        ");
        $statement->bind_param('ii', $answerId, $userId);
        $statement->execute();
    }

    public function substractVote($answerId, $userId) {
        $statement = $this->db->prepare("
            UPDATE answers
            SET
            rating = rating - 1
            WHERE id = ?;
        ");
        $statement->bind_param('i', $answerId);
        $statement->execute();

        $statement = $this->db->prepare("
            INSERT INTO answer_user_rates
            (answer_id, user_id)
            VALUES
            (?, ?);
        ");
        $statement->bind_param('ii', $answerId, $userId);
        $statement->execute();
    }

    public function getAnswerPage($answerId) {
        $statement = $this->db->prepare("
            SELECT COUNT(a.id) AS results
            FROM answers AS a JOIN topics AS t
                ON a.topic_id = t.id
            WHERE a.publish_date < (SELECT publish_date FROM answers WHERE id = ?)
        ");
        $statement->bind_param('i', $answerId);
        $statement->execute();

        $results = $this->processResults($statement->get_result())[0]['results'];
        $results = ($results === 0) ? 1 : $results;
        $page = ceil($results / BaseModel::DEFAULT_PAGE_SIZE);

        return $page;
    }
} 