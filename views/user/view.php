<?php
function data_uri($file, $mime)
{
    if (!isset($file)) {
        return '/content/default-user.png';
    }
    $base64   = base64_encode($file);
    return ('data:' . $mime . ';base64,' . $base64);
}
?>

<div class="jumbotron" id="jumbo">
    <div class="row">
        <div class="col-md-3">
            <p><?= htmlspecialchars($this->currentUser['username'])?></p>
            <p><?php if ($this->currentUser['personal_name']) echo htmlspecialchars($this->currentUser['personal_name']);?></p>
            <p><img src="<?php echo data_uri($this->currentUser['avatar'], $this->currentUser['mime_type']); ?>" class="img-avatar" />
            </p>
        </div>

        <div class="col-md-9">
            <p>Email: <?= $this->currentUser['email']?></p>
            <p>Registration date: <?php if ($this->currentUser['registration_date']) echo htmlspecialchars($this->currentUser['registration_date']);?></p>
            <p>Birth date: <?php if ($this->currentUser['birthdate']) echo $this->currentUser['birthdate'];?></p>
            <p>Comments created: <?= $this->currentUser['answers_created'];?></p>
            <p>Raiting: <?= $this->getUserRating($this->currentUser['user_id']);?></p>
        </div>
    </div>

    <?php if ($this->isCurrentUser) :?>
    <a href="/user/edit" class="btn btn-primary">Edit profile</a>
    <?php endif ?>

</div>