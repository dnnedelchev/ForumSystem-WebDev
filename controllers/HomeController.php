<?php


class HomeController extends BaseController{
    protected $dbCategories;
    protected $dbTopics;


    public function onInit() {
        $this->dbCategories = new CategoryModel(array('table' => 'categories'));
        $this->dbTopics = new TopicModel(array('table' => 'topics'));

    }


    public function index() {
        $this->categories = $this->dbCategories->getAllCategoriesOrderedById();
        $this->topics = $this->dbTopics->getFirst10TopicsOrderByLastAnswer();
    }
} 