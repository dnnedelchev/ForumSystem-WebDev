<div class="jumbotron" id="jumbo">
    <div class="row">
        <div class="col-md-3">
            <p><?= $this->currentUser['username']?></p>
            <p><?php if ($this->currentUser['personal_name']) echo $this->currentUser['personal_name'];?></p>
            <p><img src="/content/pesho.png"/></p>
        </div>

        <div class="col-md-9">
            <p>Email: <?= $this->currentUser['email']?></p>
            <p>Registration date: <?php if ($this->currentUser['registration_date']) echo $this->currentUser['registration_date'];?></p>
            <p>Birth date: <?php if ($this->currentUser['birthdate']) echo $this->currentUser['birthdate'];?></p>
            <p>Topics created: <?= $this->currentUser['topics_created'];?></p>
            <p>Answers created: <?= $this->currentUser['answers_created'];?></p>
        </div>
    </div>

    <?php if ($this->isCurrentUser) :?>
    <a href="/user/edit" class="btn btn-primary">Edit profile</a>
    <?php endif ?>

</div>