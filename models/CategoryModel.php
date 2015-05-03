<?php

class CategoryModel extends BaseModel {
    public function __construct($args = array() ) {
        parent::__construct($args);
    }

    public function getAllCategoriesOrderedById() {
        $statement = $this->db->prepare("
            SELECT id, name
            FROM categories
            ORDER BY id;
        ");

        $statement->execute();

        return $this->processResults($statement->get_result());
    }


    public function getAllTopicsByCategoryId($categoryId) {
        $statement = $this->db->prepare("
                SELECT t.id, t.title, t.category_id, t.createdAt
                FROM topics AS t JOIN categories AS c
                    ON t.category_id = c.id
                WHERE c.id = ?");
        $statement->bind_param("i", $categoryId);
        $statement->execute();
        $results = $this->processResults($statement->get_result());

        return $results;
    }
} 