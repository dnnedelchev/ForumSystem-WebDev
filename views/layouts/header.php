
<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="/content/styles/bootstrap.css" />
    <title><?php echo htmlspecialchars($this->title) ?></title>
</head>

<body>
<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header"><a href="/" class="navbar-brand">Forum</a></div>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li><a href="/">Home</a></li>
                <li><a href="/category">Categories</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
            <?php if (isset($this)) :?>
                <?php if($this->isLoggedIn) : ?>
                    <li><a href="/user/view/<?= $_SESSION['username']; ?>"><?= 'Welcome ' , $_SESSION['username']; ?></a></li>
                    <li><a href="/user/logout">Logout</a></li>
                <?php else : ?>
                    <li><a href="/user/login">Login</a></li>
                    <li><a href="/user/register">Register</a></li>
                <?php endif; ?>
            <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
<?php include_once('/views/layouts/messages.php'); ?>
<div class="container">
