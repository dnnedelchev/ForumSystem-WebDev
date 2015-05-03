<?php

class AnswerController extends BaseController{

    protected $answersModel;

    public function onInit() {
        $this->answersModel = new AnswerModel(array('table' => 'answers'));
    }


    public function create($topicId) {
        $this->topicId = $topicId;
        if ($this->isPost) {
            $content =  htmlspecialchars($_POST['content']);

            $isAdded = $this->answersModel->create($content, $topicId, $_SESSION['userId']);

            if ($isAdded) {
                $this->redirect('topic', 'view', array($topicId));
            }

        }

        $this->renderView(__FUNCTION__);
    }
} 