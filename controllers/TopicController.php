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

        $this->topic = $this->topicsModel->get($topicId)[0];
        $this->answers = $this->topicsModel->getAllAnswersByTopicId($topicId, $page);

        $this->renderView(__FUNCTION__);

    }


    protected function getCountOfUserAnswers($userId) {
        return $this->usersModel->getCountOfUserAnswersByUserId($userId);
    }

} 