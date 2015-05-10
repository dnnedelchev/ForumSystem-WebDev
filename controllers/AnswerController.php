<?php

class AnswerController extends BaseController{

    protected $answersModel;

    public function onInit() {
        $this->answersModel = new AnswerModel(array('table' => 'answers'));
    }


    public function create($topicId) {
        $this->authorize();
        $this->topicId = $topicId;
        $this->answerInfo = $this->answersModel->getAnswerInfoByTopicId($topicId);

        if ($this->isPost) {
            if (!isset($_POST['content']) || strlen($_POST['content']) < 3) {
                $this->addErrorMessage("Content cannot be empty.");
                $this->renderView(__FUNCTION__);
                die;
            }
            $content =  $_POST['content'];

            $answerId = $this->answersModel->create($content, $topicId, $_SESSION['userId']);

            if ($answerId) {
                $redirectUrl = '/topic/view/' . $topicId . '/' . $this->answersModel->getTopicLastPageNumberById($topicId) . '#' . $answerId;
                $this->addSuccessMessage("Answer was created.");
                $this->redirectToUrl($redirectUrl);
            }

        }

        $this->renderView(__FUNCTION__);
    }

    public function edit($answerId) {
        $this->authorize();
        if (!$this->isAdmin) {
            die;
        }
        $this->answer = $this->answersModel->getAnswerInfo($answerId);

        if ($this->isPost) {
            $content = $_POST['content'];

            $result = $this->answersModel->edit($answerId, $content);

            if ($result) {
                $topicId = $this->answer['topic_id'];
                $page = $this->answer['page'];
                $this->redirectToUrl('/topic/view/' . $topicId . '/' . $page . '#' . $answerId);
                die;
            }
        }

        $this->renderView(__FUNCTION__);
    }

    public function delete($answerId) {
        $this->authorize();
        if (!$this->isAdmin) {
            die;
        }
        $this->answerInfo = $this->answersModel->getAnswerInfo($answerId);
        if ($this->answersModel->delete($answerId)) {
            $this->addSuccessMessage("Answer was deleted");
            $this->redirect('topic', 'view', array($this->answerInfo['topic_id'], 1));
            die;
        } else {
            $this->addErrorMessage("Topic cannot be deleted");
            $this->redirect('topic', 'view', array($topicId, 1));
            die;
        }
    }

    public function add ($answerId) {
        $this->authorize();
        $userId = $_SESSION['userId'];
        $isVoted = $this->answersModel->isVoted($answerId, $userId);
        $page = $this->answersModel->getAnswerPage($answerId);

        if ($isVoted) {
            $this->redirectToUrl('/topic/view/' . $_GET['topicId'] .'/' . $page . '#' .$answerId);
            die;
        }

        $this->answersModel->addVote($answerId, $userId);
        $this->redirectToUrl('/topic/view/' . $_GET['topicId'] .'/' . $page . '#' .$answerId);
        die;
    }

    public function substract ($answerId) {
        $this->authorize();
        $userId = $_SESSION['userId'];
        $isVoted = $this->answersModel->isVoted($answerId, $userId);
        $page = $this->answersModel->getAnswerPage($answerId);

        if ($isVoted) {
            $this->redirectToUrl('/topic/view/' . $_GET['topicId'] .'/' . $page . '#' .$answerId);
            die;
        }

        $this->answersModel->substractVote($answerId, $userId);
        $this->redirectToUrl('/topic/view/' . $_GET['topicId'] .'/' . $page . '#' .$answerId);
        die;
    }
} 