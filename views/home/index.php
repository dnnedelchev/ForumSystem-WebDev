<div class="row">
    <div class="col-md-4">
        <?php foreach($this->categories as $category) :?>
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title"><a href="category/view/<?= $category['id']?>/1"><?= $category['name']?></a></h3>
            </div>
            <div class="panel-body">
                <?= $category['description']?>
            </div>
        </div>
        <?php endforeach;?>

    </div>

    <div class="col-md-8">
    <?php
        foreach($this->topics as $topic) : ?>
        <?php

            $lastAnswerPublishDate = new DateTime($topic['publish_date']);
            //var_dump($topic['answer_id']);die;
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
                        <h4 class="text-info"><a class="text-info" href="/topic/view/<?= $topic['topic_id']; ?>/<?= $lastPageNumber;?>#<?=$topic['answer_id'];?>">Last answer</a>: <a class="text-info" href="/user/view/<?= $topic['answer_user_id']; ?>"><?= $topic['answer_username']; ?></a> at <?= $lastAnswerPublishDate->format('Y/m/d H:i'); ?></h4>
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