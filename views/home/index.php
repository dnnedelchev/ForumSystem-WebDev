<div class="row">
    <div class="col-md-3">
            <ul>
        <?php foreach($this->categories as $category) :?>
            <li><a href="category/view/<?= $category['id']; ?>"><?= $category['name']; ?></a></li>
        <?php endforeach;?>
        </ul>
    </div>

    <div class="col-md-9">
        <ul>
        <?php foreach($this->topics as $topic) :?>
            <li><?= $topic['title']; ?></li>
        <?php endforeach; ?>
        </ul>
    </div>
</div>