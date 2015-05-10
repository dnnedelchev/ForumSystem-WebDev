<?php

class TopicController extends BaseController {

    private $topicsModel;

    private $usersModel;

    protected function onInit() {
        $this->topicsModel = new TopicModel(array('table' => 'topics'));
        $this->usersModel = new UserModel(array('table' => 'users'));
    }

    public function index() {
        $this->categories = $this->categoriesModel->find(array('columns' => 'name'));
    }


    public function view($topicId, $page) {
        $this->topicsModel->incrementViewCounter($topicId);

        $this->topic = $this->topicsModel->getTopicInfo($topicId);
        $this->answers = $this->topicsModel->getAllAnswersByTopicId($topicId, $page);

        $this->currentPage = intval($page);
        $this->renderView(__FUNCTION__);

    }

    public function create($categoryId) {
        $this->categoryId = $categoryId;
        $this->authorize();

        if ($this->isPost) {
            if (!isset($_POST['topicTitle']) || strlen($_POST['topicTitle']) < 3) {
                $this->addErrorMessage("Topic title should be at least 3 symbols.");
                $this->renderView(__FUNCTION__);
                die;
            }
            if (!isset($_POST['content']) || strlen($_POST['content']) < 3) {
                $this->addErrorMessage("Topic content should be at least 3 symbols.");
                $this->renderView(__FUNCTION__);
                die;
            }
            $topicTitle = $_POST['topicTitle'];
            $topicContent = $_POST['content'];
            $userId = $_SESSION['userId'];

            $result = $this->topicsModel->addNewTopic($topicTitle, $topicContent, $categoryId, $userId);

            if ($result) {
                $lastPageNumber = $this->topicsModel->getTopicLastPageNumberById($categoryId);
                $this->addSuccessMessage("Topic was created.");
                $this->redirectToUrl('/topic/view/' . $result . '/1');
            }
        }

        $this->renderView(__FUNCTION__);
    }

    public function delete($topicId) {
        $this->authorize();
        if ($this->isAdmin) {
            if ($this->topicsModel->delete($topicId)) {
                $this->addSuccessMessage("Topic was deleted");
                $this->redirect('category', 'view', array($_GET['categoryId'], 1));
                die;
            } else {
                $this->addErrorMessage("Topic cannot be deleted");
                $this->redirect('topic', 'view', array($topicId, 1));
                die;
            }
        }
    }

    public function edit($topicId) {
        $this->authorize();
        $this->topic = $this->topicsModel->getTopicInfo($topicId);

        if ($this->isPost) {
            if (!isset($_POST['topicTitle']) || strlen($_POST['topicTitle']) < 3) {
                $this->addErrorMessage("Topic title should be at least 3 symbols.");
                $this->renderView(__FUNCTION__);
                die;
            }
            if (!isset($_POST['content']) || strlen($_POST['content']) < 3) {
                $this->addErrorMessage("Topic content should be at least 3 symbols.");
                $this->renderView(__FUNCTION__);
                die;
            }
            $topicTitle = $_POST['topicTitle'];
            $topicContent = $_POST['content'];

            $result = $this->topicsModel->edit($topicTitle, $topicContent, $topicId);

            if ($result) {
                $this->addSuccessMessage("Topic was edited.");
                $this->redirectToUrl('/topic/view/' . $topicId . '/1');
                die;
            }
        }

        $this->renderView(__FUNCTION__);
    }

    protected function getCountOfUserAnswers($userId) {
        return $this->usersModel->getCountOfUserAnswersByUserId($userId);
    }

} 