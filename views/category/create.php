<div class="jumbotron" id="jumbo">
    <form class="bs-component" method="post" action="/category/create">
        <fieldset>
            <legend>Add new Category</legend>
            <div class="form-group">
                <label class="control-label" for="categoryName">Content</label>
                <input type="text" class="form-control" rows="7" id="categoryName" name="categoryName" required placeholder="Category name"
                    <?php if (isset($_POST['categoryName'])) echo 'value="' . htmlspecialchars($_POST['categoryName']) . '"'; ?>/>
            </div>
            <div class="form-group">
                <label class="control-label" for="description">Content</label>
                <textarea class="form-control" rows="7" id="description" name="description" required><?php if (isset($_POST['description'])) echo htmlspecialchars($_POST['description']); ?></textarea>
            </div>

            <button type="submit" class="btn btn-primary btn-lg col-md-offset-1">Submit</button>
        </fieldset>
    </form>
</div>