<?php

class CategoryModel extends BaseModel {
    public function __construct($args = array() ) {
        parent::__construct($args);
    }

    public function getAllCategoriesOrderedById() {
        $statement = $this->db->prepare("
            SELECT id, name, description
            FROM categories
            ORDER BY id;
        ");

        $statement->execute();

        return $this->processResults($statement->get_result());
    }

    public function getCategoryInfo($categoryId) {
        $statement = $this->db->prepare("
            SELECT id, name, description
            FROM categories
            WHERE id = ?;
        ");
        $statement->bind_param('i', $categoryId);
        $statement->execute();

        return $this->processResults($statement->get_result())[0];
    }


    public function getAllTopicsByCategoryId($categoryId, $page) {
        $statement = $this->db->prepare("
                    SELECT a.publish_date AS lastAnswerPublishDate, t.title, t.id as topic_id, topic_created_at,
                            topic_user_id, topic_username, au.username AS answer_username,
                            a.user_id AS answer_user_id, t.views_counter, a.id AS answer_id, c.name AS category_name
                    FROM answers as a right join topics AS t
                        ON a.topic_id = t.id join categories AS c
                        ON t.category_id = c.id LEFT JOIN users AS au
                        ON a.user_id = au.id JOIN (
                                                    SELECT answ.topic_id AS question_id, answ.id, answ.publish_date AS topic_created_at,
                                                        answ.user_id AS topic_user_id, answu.username AS topic_username
                                                    FROM answers AS answ JOIN users AS answu
                                                        ON answ.user_id = answu.id
                                                    WHERE answ.publish_date=(
                                                                        SELECT publish_date
                                                                        FROM answers
                                                                        WHERE topic_id = answ.topic_id
                                                                        ORDER BY publish_date ASC
                                                                        LIMIT 1
                                                                        )
                                                    GROUP BY answ.topic_id
                                                    ) AS question
                        ON t.id = question.question_id
                    WHERE c.id = ? AND a.publish_date = (
                                                SELECT publish_date
                                                FROM answers
                                                WHERE topic_id = t.id
                                                ORDER BY publish_date DESC
                                                LIMIT 1)
                    GROUP BY t.id
                    ORDER BY lastAnswerPublishDate
                    LIMIT ?, ?
"                   );
//                SELECT a.publish_date AS lastAnswerPublishDate, t.title, t.id as topic_id, t.created_at AS topic_created_at,
//                    t.user_id AS topic_user_id, tu.username AS topic_username, au.username AS answer_username,
//                    a.user_id AS answer_user_id, t.views_counter, a.id AS answer_id
//                FROM answers as a right join topics as t
//                    ON a.topic_id = t.id join categories as c
//                    ON t.category_id = c.id LEFT JOIN users AS tu
//                    ON t.user_id = tu.id LEFT JOIN users AS au
//                    ON a.user_id = au.id
//                WHERE c.id = ? AND a.publish_date = (
//                            SELECT publish_date
//                            FROM answers
//                            WHERE topic_id = t.id
//                            ORDER BY publish_date DESC
//                            LIMIT 1)
//                GROUP BY t.id
//                LIMIT ?, ?
//        ");
                //                SELECT t.title, t.id AS topic_id, t.created_at AS topic_created_at, t.user_id AS topic_user_id,
//                       tu.username AS topic_username, au.username AS answer_username, a.publish_date,
//                       a.user_id AS answer_user_id, t.answers_counter, a.id AS answer_id, t.views_counter
//                FROM categories AS c JOIN topics AS t
//                    ON c.id = t.category_id LEFT JOIN answers AS a
//                    ON t.id = a.topic_id LEFT JOIN users AS tu
//                    ON t.user_id = tu.id LEFT JOIN users AS au
//                    ON a.user_id = au.id
//                WHERE c.id = ?
//                GROUP BY t.id
//                ORDER BY a.publish_date DESC, topic_created_at DESC

        $size = BaseModel::DEFAULT_PAGE_SIZE;
        $start = ($page - 1)  * $size;

        $statement->bind_param("iii", $categoryId, $start, $size);
        $statement->execute();
        $results = $this->processResults($statement->get_result());



        return $results;
    }

    public function getCategoryLastPageNumberById($categoryId) {
        $statement = $this->db->prepare("
            SELECT count(id) AS results
            FROM topics
            WHERE category_id = ?
        ");
        $statement->bind_param('i', $categoryId);
        $statement->execute();

        $result = $this->processResults($statement->get_result())[0]['results'];

        $lastPageNumber = ceil($result / BaseModel::DEFAULT_PAGE_SIZE);// + 1;

        return $lastPageNumber;

    }

    public function getAllCategories() {
        $statement = $this->db->prepare("
            SELECT c.id AS category_id, c.name AS category_name, c.description, count(t.id) AS topics_count
            FROM categories AS c LEFT JOIN topics AS t
                on c.id = t.category_id
            GROUP BY c.id
        ");

        $statement->execute();

        $result = $this->processResults($statement->get_result());

        return $result;
    }

    public function delete($categoryId) {
        $statement = $this->db->prepare("
            DELETE FROM categories
            WHERE id = ?
        ");

        $statement->bind_param('i', $categoryId);
        $statement->execute();

        if ($statement->affected_rows === 1) {
            return true;
        }

        return false;
    }

    public function addNewCategory($categoryName, $description) {
        $statement = $this->db->prepare("
            INSERT INTO categories (name, description)
            VALUES (?, ?)
        ");

        $statement->bind_param('ss', $categoryName, $description);
        $statement->execute();

        if ($statement->insert_id) {
            return $statement->insert_id;
        }

        return false;
    }
} 