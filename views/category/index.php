<div class="row">
<?php
foreach($this->categories as $category) : ?>
    <?php
    ?>
    <div class="jumbotron" id="jumbo">

        <div class="row">
            <div class="col-md-12">
                <h3><a class="text-warning" href="/category/view/<?= $category['category_id']; ?>/1"><?= htmlspecialchars($category['category_name']); ?></a></h3>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-8">
                        <h4 class="text-info"><?=htmlspecialchars($category['category_name']);?></h4>
                    </div>
                </div>
            </div>

            <div class="col-md-2">
                topics <h3><?= $category['topics_count']; ?></h3>
            </div>
        </div>

    </div>
<?php endforeach; ?>
</div>