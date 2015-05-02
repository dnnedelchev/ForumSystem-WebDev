<?php


class BaseController {
    protected $controller;
    protected $action;
    protected $isViewRendered;

    public function __construct($controller, $action) {
        $this->controller = $controller;
        $this->action = $action;
        $this->onInit();
    }

    protected function  onInit() {
    }

    public function index() {
        $this->renderView();
    }

    public function renderView($viewName = null) {
        if (!$this->isViewRendered) {
            if ($viewName == null) {
                $viewName = $this->action;
            }
            $viewFileName = 'views/' . $this->controller . '/' . $viewName . '.php';
            include_once($viewFileName);

            $this->isViewRendered = true;
        }
    }

}