<?php

class UserController extends BaseController {
    protected $db;

    protected $isCurrentUser;

    public function onInit() {
        $this->title = 'Users';
        $this->db = new UserModel(array('table' => 'users'));
    }

    public function index() {
        $this->redirect('user', 'view');
    }

    public function register() {
        if ($this->isPost) {
            if (!isset($_POST['username']) || strlen($_POST['username']) < 3) {
                $this->addErrorMessage("Username should be at least 3 symbols.");
                $this->renderView(__FUNCTION__);
                die;
            }
            if (!isset($_POST['password']) || strlen($_POST['password']) < 6) {
                $this->addErrorMessage("Password should be at least 6 symbols.");
                $this->renderView(__FUNCTION__);
                die;
            }
            if (!isset($_POST['repeatPassword']) || strlen($_POST['repeatPassword']) < 6) {
                $this->addErrorMessage("Password should be at least 6 symbols.");
                $this->renderView(__FUNCTION__);
                die;
            }
            $username = $_POST['username'];
            $password = $_POST['password'];
            $repeatPassword = $_POST['repeatPassword'];

            $personalName = isset($_POST['name']) ? $_POST['name'] : NULL;
            $email = isset($_POST['email']) ? $_POST['email'] : NULL;
            $skype = isset($_POST['skype']) ? $_POST['skype'] : NULL;


            if ($repeatPassword !== $password) {
                $this->addErrorMessage("Pssswords must be equal.");
                $this->renderView(__FUNCTION__);
                die;
            }

            $userData = $this->db->register($username, $password, $personalName, $email, $skype);

            if ($userData) {
                $_SESSION['username'] = $username;
                $_SESSION['userId'] = $userData['userid'];
                $this->isAdmin = $userData['isAdmin'];
                $_SESSION['isAdmin'] = $userData['isAdmin'];
                $this->addSuccessMessage("You were successfully registered in.");
                $this->redirect('home');
                die;
            } else {
                $this->addErrorMessage("There is user register with same username already.");
                $this->renderView(__FUNCTION__);
                die;
            }
        }

        $this->renderView('register');
    }

    public function login() {
        if ($this->isPost) {
            if (!isset($_POST['username']) || strlen($_POST['username']) < 3) {
                $this->addErrorMessage("Username is required.");
                $this->renderView(__FUNCTION__);
                die;
            }
            if (!isset($_POST['password']) || strlen($_POST['password']) < 6) {
                $this->addErrorMessage("Password is required.");
                $this->renderView(__FUNCTION__);
                die;
            }
            $username = $_POST['username'];
            $password = $_POST['password'];

            $userData = $this->db->login($username, $password);

            if ($userData) {
                $_SESSION['username'] = $username;
                $_SESSION['userId'] = $userData['userid'];
                $this->isAdmin = $userData['isAdmin'];
                $_SESSION['isAdmin'] = $userData['isAdmin'];
                $this->addSuccessMessage("You are now register and log in.");
                $this->redirectToUrl('/');
                die;
            } else {
                $this->addErrorMessage("Invalid username or password");
                $this->renderView(__FUNCTION__);
                die;
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

    }

    public function view() {
        if (func_num_args() === 1) {
            $username = func_get_args()[0];
        } elseif (func_num_args() === 0) {
            $username = (isset($_SESSION['username'])) ? $_SESSION['username'] : "";
        } else {
            die;
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

    protected function getUserRating($userId) {
        return $this->db->getUserRating($userId);
    }
} 