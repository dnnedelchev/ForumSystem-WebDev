<?php

class CategoryController  extends BaseController{

    private $categoriesModel;

    protected function onInit() {
        $this->categoriesModel = new CategoryModel(array('table' => 'categories'));
    }

    public function index() {
        $this->categories = $this->categoriesModel->find(array('columns' => 'name'));
    }


} 