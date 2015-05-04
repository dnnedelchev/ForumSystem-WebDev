<?php

class CategoryController  extends BaseController{

    private $categoriesModel;

    protected function onInit() {
        $this->categoriesModel = new CategoryModel(array('table' => 'categories'));
        $this->topicModel = new TopicModel(array('table' => 'topics'));
    }

    public function index() {
        $this->categories = $this->categoriesModel->find(array('columns' => 'name'));
    }


    public function view($categoryId, $page) {
        $this->topics = $this->categoriesModel->getAllTopicsByCategoryId($categoryId, $page);
        $this->topicAnswerCount = $this->topicModel->getTopicsAnswerCount();

        $this->renderView(__FUNCTION__);
    }



} 