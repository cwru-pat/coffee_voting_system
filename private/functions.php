<?php

function format_arxiv_title($title)
{
    $article_data = Array();
    preg_match('/(.*)\s\((.*)\s\[(.*)\](.*)\)(.*)/i', $title, $article_data);

    if(count($article_data) == 6) {
        $title = $article_data[1];
        $article = $article_data[2];
        $section = $article_data[3];
        $special = trim($article_data[4]);

        $title_text = "";
            if(trim($special)) {$title_text .= "<em>"; }
        $title_text .= $title;
        $title_text .= '- [<a href="http://arxiv.org/pdf/'.$article.'.pdf" class="pdf-link">PDF</a>] - [<a href="http://arxiv.org/abs/'.$article.'">Article</a>]';
        $title_text .= ($special?" - [".$special."]":"");
            if(trim($special)) {$title_text .= "</em>"; }

        return $title_text;
    } else {
        return $title;
    }
}

function format_arxiv_title2($title)
{
    $article_data = Array();
    preg_match('/(.*)\s\((.*)\s\[(.*)\](.*)\)(.*)/i', $title, $article_data);

    if(count($article_data) == 6) {
        $title = $article_data[1];
        $article = $article_data[2];
        $section = $article_data[3];
        $special = trim($article_data[4]);

        $title_text = '<a href="http://arxiv.org/abs/'.$article.'">'.$title.'</a>';
        
        return $title_text;
    } else {
        return $title;
    }
}


function format_arxiv_title_voted($title)
{
    $article_data = Array();
    preg_match('/(.*)\s\((.*)\s\[(.*)\](.*)\)(.*)/i', $title, $article_data);

    if(count($article_data) == 6) {
        $title = $article_data[1];
        $article = $article_data[2];
        $section = $article_data[3];
        $special = trim($article_data[4]);

        $title_text = "";
            if(trim($special)) {$title_text .= "<em>"; }
        $title_text .= $title;
        $title_text .= ($special ? " - [".$special."]" : "");
            if(trim($special)) {$title_text .= "</em>"; }

        $pdf_link = '<a href="http://arxiv.org/pdf/'.$article.'.pdf" class="pdf-link btn btn-default btn-xs voted-btn pdf" type="button">PDF</a>';
        $arx_link = '<a href="http://arxiv.org/abs/'.$article.'" class="btn btn-default btn-xs voted-btn arxiv" type="button">arXiv</a>';
        
        return array($title_text,$pdf_link,$arx_link);
    } else {
        return $title;
    }
}

function path()
{
    global $config;
    $web_config = $config->get('web');
    return $web_config['path'];
}

function get_variable($name)
{
    global $coffee_conn;
    $result = $coffee_conn->boundQuery(
            "SELECT value FROM variables WHERE name=? LIMIT 1",
            array('s', &$name)
        );
    if(!$result) {
        return NULL;
    }

    $variable = unserialize($result[0]["value"]);
    if($variable) {
        return $variable;
    }

    return NULL;
}

function set_variable($name, $value)
{
    global $coffee_conn;
    $result = $coffee_conn->boundQuery(
            "SELECT value FROM variables WHERE name=? LIMIT 1",
            array('s', &$name)
        );

    if($result) {
        $query = "UPDATE variables SET value=? WHERE name=?";
    } else {
        $query = "INSERT INTO variables (value, name) VALUES (?, ?)";
    }

    $value = serialize($value);
    $coffee_conn->boundCommand($query,
            array('ss', &$value, &$name)
        );
}

function o($value, $flags = ENT_QUOTES)
{
  return htmlentities($value, $flags, 'UTF-8', FALSE);
}
