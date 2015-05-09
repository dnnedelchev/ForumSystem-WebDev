<?php
function data_uri($file, $mime)
{
    $base64 = base64_encode($file);
    return ('data:' . $mime . ';base64,' . $base64);
}
?>

<div class="row">
    <h1><a href="/view/topic/1/1"><?= htmlspecialchars($this->topic['title']); ?></a></h1>

    <div class="col-md-8">
        <div class="jumbotron" id="jumbo">
            <h6>Added at: <?= $this->topic['created_at']; ?></h6>
            <p><?= htmlspecialchars($this->topic['content']); ?></p>
        </div>
    </div>

    <div class="col-md-1">
        <a href="#" class="btn btn-primary btn-xs">+</a>
        <a href="#" class="btn btn-primary btn-xs">-</a>
    </div>

    <div class="col-md-3">
        <?php $registrationDate = new DateTime($this->topic['registration_date']);?>
        <p><a href="/user/view/<?= htmlspecialchars($this->topic['username']); ?>"><?= htmlspecialchars($this->topic['username'])?></a></p>
        <p><img src="<?php echo data_uri($this->topic['avatar'], $this->topic['mime_type']); ?>" class="img-avatar"/></p>
        <p>Answers: <?= $this->getCountOfUserAnswers($this->topic['user_id']);?></p>
        <p>Register: <?= $registrationDate->format('Y/m/d H:i') ?></p>

    </div>

</div>
    <?php $lastPageNumber = 0;?>
    <?php foreach($this->answers as $answer) :?>
        <?php
        $lastPageNumber = $this->getTopicLastPageNumberById($this->topic['topic_id']);
        $registrationDate = new DateTime($answer['registration_date']);
        ?>

<div class="row" id="<?= $answer['answer_id'];?>" >
    <div class="col-md-9">
        <div class="jumbotron" id="jumbo">
            <h6>Added at: <?= $answer['publish_date']; ?></h6>
            <p><?= htmlspecialchars($answer['content']); ?></p>

            <a href="/answer/edit/<?=$answer['answer_id']?>" class="btn btn-primary">Edit</a>
            <a href="/answer/delete/<?=$answer['answer_id']?>" class="btn btn-primary">Delete</a>

        </div>
    </div>

    <div class="col-md-3">
        <p><a href="/user/view/<?= htmlspecialchars($answer['answer_username']); ?>"><?= htmlspecialchars($answer['answer_username']);?></a></p>
        <p><img src="<?php echo data_uri($this->topic['avatar'], $this->topic['mime_type']); ?>" class="img-avatar"/></p>
        <p>Answers: <?= $this->getCountOfUserAnswers($answer['answer_user_id']);?></p>
        <p>Register: <?= $registrationDate->format('Y/m/d H:i') ?></p>

    </div>
</div>

    <?php endforeach; ?>

<!--a href="/answer/create/<?php// $this->topicContent['id']; ?>">Add new answer.</a-->


<div class="row">
    <div class="col-md-6">
        <ul class="pagination pagination-lg">
            <?php
            $isStartDisabledClass = '';
            $isEndDisabledClass = '';
            $lastPageNumber = $this->getTopicLastPageNumberById($this->topic['topic_id']);

            if ($this->currentPage === 1) {
                $isStartDisabledClass = 'class="disabled"';
            }
            if ($this->currentPage === $lastPageNumber) {
                $isEndDisabledClass = 'class="disabled"';
            }
            ?>
            <li <?= $isStartDisabledClass?>><a href="/category/view/<?=$this->topic['topic_id'];?>/1">«</a></li>
            <?php
            if ($this->currentPage <= 5) {
                $startIndex = 1;
            } elseif($this->currentPage + 5 >= $lastPageNumber) {
                $startIndex = $lastPageNumber - 5;
            }

            $endIndex = ($startIndex + 5 >= $lastPageNumber) ? $lastPageNumber : $startIndex + 5;
            ?>
            <?php for ($i = $startIndex; $i <= $endIndex; $i += 1 ) :?>
                <?php
                if ($this->currentPage === $i) {
                    $isActiveClass = 'class="active"';
                } else {
                    $isActiveClass = '';
                } ?>
                <li <?= $isActiveClass; ?>><a href="/category/view/<?=$this->topic['topic_id'];?>/<?= $i;?>"><?= $i?></a></li>

            <?php endfor ?>
            <li><a href="/category/view/<?=$this->topic['topic_id'];?>/<?= $lastPageNumber;?>" <?= $isEndDisabledClass?>>»</a></li>
        </ul>
    </div>
    <div class="col-md-6">
        <div class="pager">
            <?php if ($this->isAdmin) : ?>
                <a href="/topic/delete/<?=$this->topic['topic_id']?>?categoryId=<?=$this->topic['category_id'];?>" class="btn btn-primary btn-lg">Delete topic</a>
                <a href="/topic/edit/<?=$this->topic['topic_id']?>" class="btn btn-primary btn-lg">Edit topic</a>
            <?php endif?>
            <a href="/answer/create/<?=$this->topic['topic_id']?>" class="btn btn-primary btn-lg pull-right">Add new answer to topic.</a>
        </div>
    </div>

</div>