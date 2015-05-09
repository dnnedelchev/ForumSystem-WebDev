<?php

class UserController extends BaseController {
    protected $db;

    protected $isCurrentUser;

    public function onInit() {
        $this->db = new UserModel(array('table' => 'users'));
    }

    public function index() {
        $this->redirect('user', 'view');
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
                $_SESSION['isAdmin'] = $userData['isAdmin'];
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
                $_SESSION['isAdmin'] = $userData['isAdmin'];
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
        unset($_SESSION['isAdmin']);
        $this->isLoggedIn = false;

        $this->addInfoMessage("See u soon!");

        $this->redirectToUrl('/');

        // TODO redirect and msg.
    }

    public function view() {
        if (func_num_args() === 1) {
            $username = func_get_args()[0];
        } elseif (func_num_args() === 0) {
            $username = (isset($_SESSION['username'])) ? $_SESSION['username'] : "";
        } else {
            die("Лошо");
        }

        if ($_SESSION['username'] === $username) {
            $this->isCurrentUser = true;

            $this->currentUser = $this->db->getUserInformationByUserId($_SESSION['userId']);

        } else {
            $this->currentUser = $this->db->getUserInformationByUsername($username);
        }

        $this->renderView(__FUNCTION__);
    }


    public function edit() {
        $this->authorize();

        if ($this->isPost) {
            $avatarData = false;

            if (isset($_FILES['avatar'])) {
                //var_dump($_FILES['avatar']['error'][0] === 0);die;
                if ($_FILES['avatar']['error'] !== 0) {
                    die("Upload failed with error cod ");
                }

                $info = getimagesize($_FILES['avatar']['tmp_name']);
                if ($info === FALSE) {
                    die("Unable to determine image type of uploaded file");
                }
                $size = ceil($_FILES['avatar']['size'] / 1024);
                if ($size > 100) {
                    die ("invalid size");
                }

                if (($info[2] !== IMAGETYPE_GIF) && ($info[2] !== IMAGETYPE_JPEG) && ($info[2] !== IMAGETYPE_PNG)) {
                    die("Not a gif/jpeg/png");
                }
                $avatarData = file_get_contents($_FILES['avatar']['tmp_name']);
                $mimeType = $info[3]['mime'];

            }

            $editedProfile = array('username' => $_POST['username'],
                                   'name' => $_POST['personal_name'],
                                   'email' => $_POST['email'],
                                   'skype' => $_POST['skype'],
                                   'birthdate' => new DateTime($_POST['birthdate']),
                                   'avatar' => $avatarData,
                                   'mime' => $mimeType);

            $result = $this->db->editUserProfile($_SESSION['userId'], $editedProfile);

            if ($result) {
                $_SESSION['username'] = $_POST['username'];
                $this->redirect('user', 'view', array($_POST['username']));
            }
        }

        $this->currentUser = $this->db->getUserInformationByUserId($_SESSION['userId']);

        $this->renderView(__FUNCTION__);
    }

} 