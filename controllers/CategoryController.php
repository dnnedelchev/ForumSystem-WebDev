<?php

class CategoryController  extends BaseController{

    private $categoriesModel;

    protected function onInit() {
        $this->categoriesModel = new CategoryModel(array('table' => 'categories'));
        $this->topicModel = new TopicModel(array('table' => 'topics'));
    }

    public function index() {
        $this->categories = $this->categoriesModel->getAllCategories();
    }


    public function view($categoryId, $page) {
        $this->categoryId = $categoryId;
        $this->topics = $this->categoriesModel->getAllTopicsByCategoryId($categoryId, $page);
        $this->topicAnswerCount = $this->topicModel->getTopicsAnswerCount();
        $this->currentPage = intval($page);
        $this->categoryId = intval($categoryId);

        $this->renderView(__FUNCTION__);
    }

    protected function getCategoryLastPageNumberById($categoryId) {
        return $this->categoriesModel->getCategoryLastPageNumberById($categoryId);
    }

} 