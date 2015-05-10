<?php
renderMessages(INFO_MESSAGES_SESSION_KEY, 'alert-info');
renderMessages(ERROR_MESSAGES_SESSION_KEY, 'alert-danger');
renderMessages(SUCCESS_MESSAGES_SESSION_KEY, 'alert-success');

function renderMessages($messagesKey, $alert) {
    if (isset($_SESSION[$messagesKey]) && count($_SESSION[$messagesKey]) > 0) {
        foreach ($_SESSION[$messagesKey] as $msg) {
            echo '<div class="row">';
                echo '<div class="col-md-4 col-md-offset-4">';
                    echo '<div class="alert alert-dismissable ' . $alert . '">';
                        echo '<strong>' . htmlspecialchars($msg) . '</strong>';
                    echo '</div>';
                echo '</div>';
            echo '</div>';
        }
    }
    $_SESSION[$messagesKey] = [];
}