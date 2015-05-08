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

        $this->topic = $this->topicsModel->getTopicInfo($topicId);
        $this->answers = $this->topicsModel->getAllAnswersByTopicId($topicId, $page);
        $this->currentPage = intval($page);

        $this->renderView(__FUNCTION__);

    }

    public function create($categoryId) {
        $this->categoryId = $categoryId;
        // var_dump($this->$categoryId);die;
        $this->authorize();

        if ($this->isPost) {
            $topicTitle = $_POST['topicTitle'];
            $topicContent = $_POST['content'];
            $userId = $_SESSION['userId'];

            $result = $this->topicsModel->addNewTopic($topicTitle, $topicContent, $categoryId, $userId);

            if ($result) {
                $lastPageNumber = $this->topicsModel->getTopicLastPageNumberById($categoryId);
                $this->redirectToUrl('/topic/view/' . $result . '/1');
            }
        }

        $this->renderView(__FUNCTION__);
    }


    protected function getCountOfUserAnswers($userId) {
        return $this->usersModel->getCountOfUserAnswersByUserId($userId);
    }

} 