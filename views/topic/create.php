
<div class="jumbotron" id="jumbo">
    <form class="bs-component" method="post" action="/topic/create/<?= $this->categoryId; ?>">
        <div class="form-group">
            <label class="control-label" for="topicTitle">Topic Title</label>
            <input class="form-control" id="topicTitle" type="text" name="topicTitle" placeholder="Enter topic title" required>
        </div>

        <div class="form-group">
            <label class="control-label" for="content">Content</label>
            <textarea class="form-control" rows="7" id="content" name="content" required></textarea>
        </div>

        <button type="submit" class="btn btn-primary btn-lg col-md-offset-1">Submit</button>
    </form>
</div>