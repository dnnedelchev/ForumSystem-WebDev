<div class="jumbotron" id="jumbo">
    <form class="bs-component" method="post" action="/answer/edit/<?= $this->answer['answer_id']; ?>">
        <fieldset>
            <legend>Add new answer</legend>
            <div class="form-group">
                <input class="form-control" id="topicTitle" type="text" readonly value="Title <?= htmlspecialchars($this->answer['topic_title']); ?>">
            </div>

            <div class="form-group">
                <label class="control-label" for="content">Content</label>
                <textarea class="form-control" rows="7" id="content" name="content" required><?= $this->answer['content'];?></textarea>
            </div>

            <button type="submit" class="btn btn-primary btn-lg col-md-offset-1">Submit</button>
        </fieldset>
    </form>
</div>