<?php

class UserController extends BaseController {
    protected $db;


    public function onInit() {
        $this->db = new UserModel(array('table' => 'users'));
    }

    public function register() {
        if ($this->isPost) {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $userId = $this->db->register($username, $password);

            if ($userId) {
                $_SESSION['username'] = $username;
                $_SESSION['userId'] = $userId;

                $this->redirect('home');
            }
        }

        $this->renderView('register');
    }

    public function login() {
        if ($this->isPost) {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $userId = $this->db->login($username, $password);

            if ($userId) {
                $_SESSION['username'] = $username;
                $_SESSION['userId'] = $userId;
                // TODO $this->redirect()
            } else {
                // TODO error msg
            }
        }

        $this->renderView('login');
    }

    public function logout() {
        unset($_SESSION['username']);
        unset($_SESSION['userId']);
    }
} 