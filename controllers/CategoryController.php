<?php

class CategoryController  extends BaseController{

    private $categoriesModel;

    protected function onInit() {
        $this->title = 'Categories';
        $this->categoriesModel = new CategoryModel(array('table' => 'categories'));
        $this->topicModel = new TopicModel(array('table' => 'topics'));
    }

    public function index() {
        $this->categories = $this->categoriesModel->getAllCategories();
    }


    public function view($categoryId, $page) {
        $this->categoryId = $categoryId;
        $this->categoryName = $this->categoriesModel->getCategoryInfo($categoryId)['name'];
        $this->topics = $this->categoriesModel->getAllTopicsByCategoryId($categoryId, $page);
        $this->topicAnswerCount = $this->topicModel->getTopicsAnswerCount();
        $this->currentPage = intval($page);
        $this->categoryId = intval($categoryId);

        $this->renderView(__FUNCTION__);
    }

    protected function getCategoryLastPageNumberById($categoryId) {
        return $this->categoriesModel->getCategoryLastPageNumberById($categoryId);
    }

    public function delete($categoryId) {
        $this->authorize();
        if ($this->isAdmin) {
            if ($this->categoriesModel->delete($categoryId)) {
                $this->addSuccessMessage("Category was deleted");
                $this->redirect('/');
                die;
            } else {
                $this->addErrorMessage("Category cannot be deleted");
                $this->redirect('category', 'view', array($categoryId, 1));
                die;
            }
        }

        die;
    }

    public function create() {
        $this->authorize();

        if ($this->isPost) {
            if (!isset($_POST['categoryName']) || strlen($_POST['categoryName']) < 3) {
                $this->addErrorMessage("Category name should be at least 3 symbols.");
                $this->renderView(__FUNCTION__);
                die;
            }
            if (!isset($_POST['description']) || strlen($_POST['description']) < 3) {
                $this->addErrorMessage("Description should be at least 3 symbols.");
                $this->renderView(__FUNCTION__);
                die;
            }
            $categoryName = $_POST['categoryName'];
            $description = $_POST['description'];

            $result = $this->categoriesModel->addNewCategory($categoryName, $description);

            if ($result) {

                $this->redirectToUrl('/category/view/' . $result . '/1');
            }
        }

        $this->renderView(__FUNCTION__);
    }

} 