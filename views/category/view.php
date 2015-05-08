<!--<ul>-->
<!--    --><?php ////foreach($this->topics as $topic) :?>
<!--        <li><a href="/topic/view/--><?//= $topic['id'] ?><!--">--><?//= $topic['title'] ?><!--</a></li>-->
<!--    --><?php ////endforeach?>
<!--</ul>-->
<div class="row">
<?php
$lastPageNumber = 0;
foreach($this->topics as $topic) : ?>
    <?php
    $lastAnswerPublishDate = new DateTime($topic['lastAnswerPublishDate']);
    $topicCreatedDate = new DateTime($topic['topic_created_at']);

    $lastPageNumber = $this->getTopicLastPageNumberById($topic['topic_id']);
    ?>
    <div class="jumbotron" id="jumbo">

        <div class="row">
            <div class="col-md-12">
                <h3><a class="text-warning" href="/topic/view/<?= $topic['topic_id']; ?>/1"><?= $topic['title']; ?></a></h3>
            </div>
        </div>

        <div class="row">

            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-8">
                        <h4 class="text-info">Created by: <a class="text-info" href="/user/view/<?= $topic['topic_user_id'];?>"><?=$topic['topic_username'];?></a> at <?= $topicCreatedDate->format('Y/m/d H:i'); ?></h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <?php if ($topic['answer_id'] === null): ?>
                            <h4 class="text-info"><a class="text-info" href="/topic/view/<?= $topic['topic_id']; ?>/1">Last answer</a>: No answers in this topic yet.</h4>
                        <?php else: ?>
                            <h4 class="text-info"><a class="text-info" href="/topic/view/<?php echo $topic['topic_id'] . "/" .  $lastPageNumber; ?>#<?=$topic['answer_id'];?>">Last answer</a>: <a class="text-info" href="/user/view/<?= $topic['answer_user_id']; ?>"><?= $topic['answer_username']; ?></a> at <?= $lastAnswerPublishDate->format('Y/m/d H:i'); ?></h4>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                views <h3><?= $topic['views_counter']; ?></h3>
            </div>
            <div class="col-md-2">
                answers <h3><?= $this->topicAnswerCount[$topic['topic_id']]; ?></h3>
            </div>
        </div>

    </div>
<?php endforeach; ?>
</div>

<div class="row">
    <div class="col-md-6">
        <ul class="pagination pagination-lg">
    <?php
    $isStartDisabledClass = '';
    $isEndDisabledClass = '';
    $categoryLastPage = $this->getCategoryLastPageNumberById($this->categoryId);

    if ($this->currentPage === 1) {
        $isStartDisabledClass = 'class="disabled"';
    }
    if ($this->currentPage === $categoryLastPage) {
        $isEndDisabledClass = 'class="disabled"';
    }
    ?>
    <li <?= $isStartDisabledClass?>><a href="/category/view/<?=$this->categoryId;?>/1">«</a></li>
<?php
if ($this->currentPage <= 5) {
    $startIndex = 1;
} elseif($this->currentPage + 5 >= $categoryLastPage) {
    $startIndex = $categoryLastPage - 5;
}

$endIndex = ($startIndex + 5 >= $categoryLastPage) ? $categoryLastPage : $startIndex + 5;
?>
<?php for ($i = $startIndex; $i <= $endIndex; $i += 1 ) :?>
    <?php
    if ($this->currentPage === $i) {
        $isActiveClass = 'class="active"';
    } else {
        $isActiveClass = '';
    } ?>
    <li <?= $isActiveClass; ?>><a href="/category/view/<?=$this->categoryId;?>/<?= $i;?>"><?= $i?></a></li>

<?php endfor ?>
    <li><a href="/category/view/<?=$this->categoryId;?>/<?= $categoryLastPage;?>" <?= $isEndDisabledClass?>>»</a></li>
</ul>
    </div>
    <div class="col-md-6">
        <div class="pager">
            <a href="/topic/create/<?=$this->categoryId;?>" class="btn btn-primary btn-lg pull-right">Add new topic.</a>
        </div>
    </div>

</div>