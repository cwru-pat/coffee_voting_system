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

function path()
{
    global $config;
    $web_config = $config->get('web');
    return $web_config['path'];
}
