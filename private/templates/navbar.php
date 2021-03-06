<?php

// Define some page_home => (url, Title) pairs for later use.
$nav_items = array(
    "page_home" => array(
        "url" => "",
        "title" => "Home",
        ),
    "page_votes" => array(
        "url" => "votes",
        "title" => "Current Votes",
        ),
    "page_me" => array(
        "url" => "me",
        "title" => "My Votes",
        ),
);

?>
<!-- Fixed navbar -->
<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <a role="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <a class="navbar-brand" href="<?php print path(); ?>">
                CWRU Coffee
            </a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <?php
                foreach ($nav_items as $id => $item) {
                    if (isset($page_id) && $id == $page_id) {
                        print "<li class='active'><a href='" . path() . $item["url"] . "'>" . $item["title"] . "</a></li>";
                    } else {
                        print "<li><a href='" . path() . $item["url"] . "'>" . $item["title"] . "</a></li>";
                    }
                }
                ?>
            </ul>

            <form class="navbar-form navbar-right" action="<?php print path(); ?>admin" method="POST">
                <!-- Button trigger search modal -->
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#searchModal" data-toggle-tip="tooltip" data-placement="bottom" title="Search">
                    <span class="glyphicon glyphicon-search"></span>
                </button>
                <?php
                if ($user->isLoggedin()) {
                ?>
                    <a role="button" href="<?php print path()?>add" class='btn btn-success' data-toggle="tooltip" data-placement="bottom" title="Add non-arXiv paper">
                        <span class="glyphicon glyphicon-plus"></span>
                    </a>
                <?php
                }

                if ($user->isAdmin()) {
                ?>
                    <button type="submit" class="btn btn-info" id="admin-button" data-toggle="tooltip" data-placement="bottom" title="Admin Settings">
                        <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                    </button>
                <?php
                }
                ?>
            </form>

            <?php
            if ($user->isLoggedIn()) {
            ?>
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Logged in as <?php print($user->id()); ?> <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="<?php print path(); ?>login?logout=true">Log Out</a></li>
                        </ul>
                    </li>
                </ul>
            <?php
            } else {
            ?>
                <form class="navbar-form navbar-right" action="<?php print path(); ?>login" method="POST">
                    <button type="submit" class="btn btn-success">Sign in</button>
                </form>
            <?php
            }
            ?>
        </div><!--/.nav-collapse -->
    </div><!--/.container -->
</nav>
