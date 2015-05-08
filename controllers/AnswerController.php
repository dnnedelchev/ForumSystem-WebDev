<?php

class AnswerController extends BaseController{

    protected $answersModel;

    public function onInit() {
        $this->answersModel = new AnswerModel(array('table' => 'answers'));
    }


    public function create($topicId) {
        $this->authorize();
        $this->topicId = $topicId;
        $this->answerInfo = $this->answersModel->getAnswerInfo($topicId);

        if ($this->isPost) {
            $content =  $_POST['content'];

            $answerId = $this->answersModel->create($content, $topicId, $_SESSION['userId']);

            if ($answerId) {
                $redirectUrl = '/topic/view/' . $topicId . '/' . $this->answersModel->getTopicLastPageNumberById($topicId) . '#' . $answerId;
                $this->redirectToUrl($redirectUrl);
            }

        }

        $this->renderView(__FUNCTION__);
    }
} 