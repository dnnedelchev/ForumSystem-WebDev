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


    public function getAllTopicsByCategoryId($categoryId, $page) {
        $statement = $this->db->prepare("
                SELECT t.title, t.id AS topic_id, t.created_at AS topic_created_at, t.user_id AS topic_user_id,
                       tu.username AS topic_username, au.username AS answer_username, a.publish_date,
                       a.user_id AS answer_user_id, t.answers_counter, a.id AS answer_id, t.views_counter
                FROM categories AS c JOIN topics AS t
                    ON c.id = t.category_id LEFT JOIN answers AS a
                    ON t.id = a.topic_id LEFT JOIN users AS tu
                    ON t.user_id = tu.id LEFT JOIN users AS au
                    ON a.user_id = au.id
                WHERE c.id = ?
                GROUP BY t.id
                ORDER BY a.publish_date DESC, topic_created_at DESC
                LIMIT ?, ?
        ");

        $size = BaseModel::DEFAULT_PAGE_SIZE;
        $start = ($page - 1)  * $size;

        $statement->bind_param("iii", $categoryId, $start, $size);
        $statement->execute();
        $results = $this->processResults($statement->get_result());

        return $results;
    }
} 