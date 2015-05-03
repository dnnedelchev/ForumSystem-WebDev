<ul>
    <?php foreach($this->topics as $topic) :?>
        <li><a href="/topic/view/<?= $topic['id'] ?>"><?= $topic['name'] ?></a></li>
    <?php endforeach?>
</ul>