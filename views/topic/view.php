<div class="row">
    <h1><a href="/view/topic/1/1"><?= $this->topic['title'] ?></a></h1>

    <div class="col-md-9">
        <div class="jumbotron" id="jumbo">
            <h6>Added at: <?= $this->topic['created_at']; ?></h6>
            <p><?= $this->topic['content'] ?></p>
        </div>
    </div>

    <div class="col-md-3">
        <?php $registrationDate = new DateTime($this->topic['registration_date']); var_dump($registrationDate);die; ?>
        <p><a href="/user/view/<?= $this->topic['username']; ?>"><?= $this->topic['username']?></a></p>
        <p><img src="/content/pesho.png"/></p>
        <p>Answers: <?= $this->getCountOfUserAnswers($this->topic['user_id']);?></p>
        <p>Register: <?= $registrationDate->format('Y/m/d H:i') ?></p>

    </div>
</div>

    <?php foreach($this->answers as $answer) :?>
        <?php
        $registrationDate = new DateTime($answer['registration_date']);
        ?>

<div class="row" id="<?= $answer['answer_id'];?>" >
    <div class="col-md-9">
        <div class="jumbotron" id="jumbo">
            <h6>Added at: <?= $answer['publish_date']; ?></h6>
            <p><?= $answer['content'] ?></p>
        </div>
    </div>

    <div class="col-md-3">
        <p><a href="/user/view/<?= $answer['answer_username']; ?>"><?= $answer['answer_username']?></a></p>
        <p><img src="/content/pesho.png"/></p>
        <p>Answers: <?= $this->getCountOfUserAnswers($answer['answer_user_id']);?></p>
        <p>Register: <?= $registrationDate->format('Y/m/d H:i') ?></p>

    </div>
</div>

    <?php endforeach; ?>

<!--a href="/answer/create/<?php// $this->topicContent['id']; ?>">Add new answer.</a-->
