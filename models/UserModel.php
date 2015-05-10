<?php

class UserModel extends BaseModel {
    public function __construct($args = array() ) {
        parent::__construct($args);
    }

    public function register($username, $password, $personalName, $email, $skype) {

        $statement = $this->db->prepare("
                SELECT id, is_admin
                FROM users
                WHERE username = ?");
        $statement->bind_param('s', $username);
        $statement->execute();
        $result = $statement->get_result()->fetch_assoc();

        if (isset($result['id'])) {
            return null;
        }

        $hash_pass = password_hash($password, PASSWORD_BCRYPT);

        $insertStatement = $this->db->prepare("
            INSERT INTO
            users (username, pass_hash, registration_date, personal_name, email, skype)
            VALUES (?, ?, NOW(), ?, ?, ?)
        ");

        $insertStatement->bind_param('sssss', $username, $hash_pass, $personalName, $email, $skype);
        $insertStatement->execute();

        $statement->execute();
        $result = $statement->get_result()->fetch_assoc();

        return array('userid' => $result['id'], 'isAdmin' => $result['is_admin']);
    }

    public function login($username, $password) {
        $statement = $this->db->prepare("
                    SELECT id, username, pass_hash, is_admin
                    FROM users
                    WHERE username = ?");
        $statement->bind_param('s', $username);
        $statement->execute();
        $result = $statement->get_result()->fetch_assoc();

        if (password_verify($password, $result['pass_hash'])) {
            return array('userid' => $result['id'], 'isAdmin' => $result['is_admin']);
        }

        return false;
    }

    public function getUserInformationByUserId($userId) {
        $statement = $this->db->prepare("
            SELECT u.username, u.registration_date, u.personal_name, u.id AS user_id,
	               u.email, u.birthdate, count(a.id) AS answers_created, u.skype, u.avatar, u.mime_type
            FROM users AS u JOIN answers a
                ON u.id = a.user_id
            WHERE u.id = ?
        ");
        $statement->bind_param('i', $userId);
        $statement->execute();

        $result = $this->processResults($statement->get_result());

        if ($result[0]['username'] === null) {
            die;
        }

        return $result[0];
    }

    public function getUserInformationByUsername($username) {
        $statement = $this->db->prepare("
            SELECT u.username, u.registration_date, u.personal_name, u.id AS user_id,
                       u.email, u.birthdate, count(question.question_id) AS topics_created,
                       count(a.id) AS answers_created, u.skype, u.avatar, u.mime_type
            FROM users AS u LEFT JOIN answers a
                ON u.id = a.user_id JOIN (
                                    SELECT answ.topic_id AS question_id, answ.publish_date AS topic_created_at, answ.user_id AS topic_user_id,
                                        answu.username AS topic_username
                                    FROM answers AS answ JOIN users AS answu
                                        ON answ.user_id = answu.id
                                    WHERE answ.publish_date=(
                                                        SELECT publish_date
                                                        FROM answers
                                                        WHERE topic_id = answ.topic_id
                                                        ORDER BY publish_date ASC
                                                        LIMIT 1
                                                        )
                                    GROUP BY answ.topic_id
                                    ) AS question
            WHERE u.username = ?
        ");
        $statement->bind_param('s', $username);
        $statement->execute();

        $result = $this->processResults($statement->get_result());

        if ($result[0]['username'] === null) {
            die;
        }

        return $result[0];
    }

    public function editUserProfile($userId, $user) {
        $statement = $this->db->prepare("
            UPDATE users
            SET
            username = ?,
            personal_name = ?,
            email = ?,
            birthdate = STR_TO_DATE(?,'%Y-%m-%d'),
            skype = ?,
            avatar = ?,
            mime_type = ?
            WHERE id = ?
        ");

        extract($user);
        $birthdate = $birthdate->format('Y-m-d');

        $statement->bind_param('sssssssi', $username, $name, $email, $birthdate, $skype, $avatar, $mimeType, $userId);
        $statement->execute();

        if ($statement->affected_rows >= 2 || !empty($statement->error_list)) {
            die('лоооошооооо баце');
        }

        return true;
    }

    public function getCountOfUserAnswersByUserId($userId) {
        $statement = $this->db->prepare("
            SELECT count(*) AS answersCount
            FROM users AS u JOIN answers AS a
                ON u.id = a.user_id
            WHERE u.id = ?;
        ");

        $statement->bind_param('i', $userId);
        $statement->execute();

        $result = $this->processResults($statement->get_result());

        return $result[0]['answersCount'];
    }

    public function getUserRating($userId) {
        $statement = $this->db->prepare("
            SELECT count(r.id) AS votes
            FROM users AS u JOIN answer_user_rates AS r
                on u.id = r.user_id
            WHERE u.id = ?
        ");
        $statement->bind_param('i', $userId);
        $statement->execute();

        $result = $this->processResults($statement->get_result())[0]['votes'];
        return $result;
    }
} 