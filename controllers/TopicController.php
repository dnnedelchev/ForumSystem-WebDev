<?php

class TopicController extends BaseController {

    private $topicsModel;

    protected function onInit() {
        $this->topicsModel = new TopicModel(array('table' => 'topics'));
    }

    public function index() {
        $this->categories = $this->categoriesModel->find(array('columns' => 'name'));
    }


    public function view($topicId) {

        $this->topicContent = $this->topicsModel->get($topicId)[0];

        $this->answers = $this->topicsModel->getAllAnswersByTopicId($topicId);

        $this->renderView(__FUNCTION__);

    }

} 