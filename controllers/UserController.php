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

            $userData = $this->db->register($username, $password);

            if ($userData) {
                $_SESSION['username'] = $username;
                $_SESSION['userId'] = $userData['userId'];
                $this->isAdmin = $userData['isAdmin'];

                $this->redirect('home');
            }
        }

        $this->renderView('register');
    }

    public function login() {
        if ($this->isPost) {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $userData = $this->db->login($username, $password);

            if ($userData) {
                $_SESSION['username'] = $username;
                $_SESSION['userId'] = $userData['userid'];
                $this->isAdmin = $userData['isAdmin'];
                $this->redirectToUrl('/');
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
        $this->isLoggedIn = false;

        $this->redirectToUrl('/');

        // TODO redirect and msg.
    }
} 