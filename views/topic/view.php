<div>

    <h1><?= $this->topicContent['title'] ?></h1>

</div>

<div>
    <?php foreach($this->answers as $answer) :?>
        <div>
            <p><?= $answer['content'] ?></p>
        </div>
    <?php endforeach ?>

</div>

<a href="/answer/create/<?= $this->topicContent['id']; ?>">Add new answer.</a>