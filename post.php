<?php

$page_id = "page_admin";
$mathjax = true;

require_once "private/site.php";

require_once "private/templates/header.php";
require_once "private/templates/navbar.php";

$postId = $params->get("post-id");

$post = $coffee_conn->boundQuery("SELECT * FROM papers WHERE id = ?", array('i', &$postId));
if (count($post) == 0) {
    kill_script("Post not found.");
} else {
    ?>
    <div class="container">
        <?php
            $paper = $post[0];
            include_once 'private/templates/paper.php';
        ?>
    </div>
    <?php
}

require_once "private/templates/footer.php";
