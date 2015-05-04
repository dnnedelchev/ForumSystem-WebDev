<div class="row">
    <h1><a href="/view/topic/1/1"><?= $this->topic['title'] ?></a></h1>
</div>

    <?php $answer = $this->answers[0];//foreach($this->answers as $answer) :?>

<div class="row">
    <div class="col-md-10">
        <div class="jumbotron" id="jumbo">
            <h6>Added at: 2012-10-10 16:48</h6>
            <p><?= $answer['content'] ?></p>
        </div>
    </div>

    <div class="col-md-2">
        <p><?= $answer['answer_username']?></p>
        <p><img src="/content/pesho.png"/></p>
        <p><?= $this->getCountOfUserAnswers(2);?></p>
        <p><?= "2010-20-12"?></p>

    </div>
</div>


<div class="row">
    <div class="col-md-10">
        <div class="jumbotron" id="jumbo">
            <h6>Added at: 2012-10-10 16:48</h6>
            <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?"</p>
        </div>
    </div>

    <div class="col-md-2">
        <p><?= $answer['answer_username']?></p>
        <p><img src="/content/pesho.png"/></p>
        <p><?= $this->getCountOfUserAnswers(2);?></p>
        <p><?= "2010-20-12"?></p>

    </div>
</div>

    <!--?php endforeach ?-->

<!--a href="/answer/create/<?php// $this->topicContent['id']; ?>">Add new answer.</a-->
