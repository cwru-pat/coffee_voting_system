<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <meta name="description" content="CWRU Coffee Voting System">
    <meta name="author" content="CWRU PAT Group">

    <title>CWRU Coffee</title>

    <!-- Mug favicon -->
    <link rel="shortcut icon" href="<?php print path(); ?>mug.png" type="image/png" />

    <!-- bootstrap compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">-->
    <link rel="stylesheet" href="<?php print path(); ?>css/selectize.css">
    <link rel="stylesheet" href="<?php print path(); ?>css/bootstrap-datepicker3.min.css">
    <link rel="stylesheet" href="<?php print path(); ?>css/summernote.css">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="<?php print path(); ?>css/main.css">

    <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php print path(); ?>js/selectize.min.js"></script>
    <script type="text/javascript" src="<?php print path(); ?>js/bootstrap-datepicker.min.js"></script>
    <script type="text/javascript" src="<?php print path(); ?>js/summernote.min.js"></script>
    <script type="text/javascript" src="<?php print path(); ?>js/typewatch.min.js"></script>

    <script type="text/javascript" src="<?php print path(); ?>js/main.js"></script>

    <script type="text/javascript" src="<?php print path(); ?>js/rate.js"></script>
    <script type="text/javascript" src="<?php print path(); ?>js/bump.js"></script>
    <script type="text/javascript" src="<?php print path(); ?>js/toggle.js"></script>
    <script type="text/javascript" src="<?php print path(); ?>js/forms.js"></script>
    <script type="text/javascript" src="<?php print path(); ?>js/calendar.js"></script>
    <script type="text/javascript" src="<?php print path(); ?>js/search.js"></script>

    <?php
    if (isset($mathjax)? $mathjax: false) {
    ?>
        <script type="text/javascript" src="//cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML"></script>
        <script type="text/x-mathjax-config">
            MathJax.Hub.Config({tex2jax: {inlineMath: [['$','$'], ['\\(','\\)']]}});
        </script>
    <?php
    }
    ?>
</head>

<body class="<?php print isset($page_id) ? $page_id : ''; ?>">
