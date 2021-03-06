<?php


class BaseController {
    protected $controller;
    protected $action;
    protected $isViewRendered;
    protected $isPost = false;
    protected $user;
    protected $isLoggedIn;
    protected $isAdmin;

    public function __construct($controller, $action) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->isPost = true;
        }

        if (isset($_SESSION['username'])) {
            $this->isLoggedIn = true;
            $this->isAdmin =
                isset($_SESSION['isAdmin']) ? $_SESSION['isAdmin'] : 0;
        }

        $this->controller = $controller;
        $this->action = $action;
        $this->onInit();
    }

    protected function  onInit() {
    }

    public function index() {
        $this->renderView();
    }

    public function renderView($viewName = null, $isPartial = false) {
        if (!$this->isViewRendered) {
            if ($viewName == null) {
                $viewName = $this->action;
            }

            if (!$isPartial) {
                include_once('views/layouts/header.php');
            }
            $viewFileName = 'views/' . $this->controller . '/' . $viewName . '.php';
            include_once($viewFileName);

            if (!$isPartial) {
                include_once('views/layouts/footer.php');
            }

            $this->isViewRendered = true;
        }
    }

    protected function redirectToUrl($url) {
        header("Location: $url");
        die;
    }

    protected function redirect($controller = null, $action = null, $params = []) {
        if ($controller == null) {
            $controller = $this->controller;
        }
        $url = "/$controller/$action";

        $paramsUrlEncoded = array_map('urlencode', $params);
        $paramsJoined = implode('/', $paramsUrlEncoded);
        if ($paramsJoined != '') {
            $url .= '/' . $paramsJoined;
        }
        $this->redirectToUrl($url);
    }


    public function authorize() {
        if (!$this->isLoggedIn) {
            $this->addErrorMessage('Please login.');
            $this->redirect('user', 'login');
        }
    }

    protected function getTopicLastPageNumberById($topicId) {
        $topicModel = new TopicModel(array('table' => 'topics'));
        return $topicModel->getTopicLastPageNumberById($topicId);
    }

    private function addMessage($msgSessionkey, $msgText) {
        if (!isset($_SESSION[$msgSessionkey])) {
            $_SESSION[$msgSessionkey] = [];
        }
        array_push($_SESSION[$msgSessionkey], $msgText);

    }

    protected function addErrorMessage($errorMsg) {
        $this->addMessage(ERROR_MESSAGES_SESSION_KEY, $errorMsg);
    }

    protected function addInfoMessage($infoMsg) {
        $this->addMessage(INFO_MESSAGES_SESSION_KEY, $infoMsg);
    }

    protected function addSuccessMessage($succsessMsg) {
        $this->addMessage(SUCCESS_MESSAGES_SESSION_KEY, $succsessMsg);
    }

}