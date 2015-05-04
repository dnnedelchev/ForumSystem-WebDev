<div class="row">
    <h1><a href="/view/topic/1/1"><?= $this->topic['title'] ?></a></h1>
</div>

    <?php foreach($this->answers as $answer) :?>
        <?php
        $registrationDate = new DateTime($answer['registration_date']);
        ?>

<div class="row">
    <div class="col-md-9">
        <div class="jumbotron" id="jumbo">
            <h6>Added at: 2012-10-10 16:48</h6>
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
