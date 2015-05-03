<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="../../content/styles/bootstrap.css" />
    <title>TITLE</title>
</head>

<body>
<header>
    <div class="navbar navbar-default">
        <div class="container">
            <div class="navbar-header"></div>
            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <li><a href="/">Home</a></li>
                    <li><a href="/category">Categories</a></li>
                    <li><a href="/topic">Topics</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                <?php if($this->isLoggedIn) : ?>
                    <li><?php echo 'Welcome ' , $_SESSION['username']; ?></li>
                    <li><a href="/user/logout">Logout</a></li>
                <?php else : ?>
                    <li><a href="/user/login">Login</a></li>
                    <li><a href="/user/register">Register</a></li>
                <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
</header>
<div class="container">

