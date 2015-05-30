<?php

function format_arxiv_title($title)
{
    $article_data = Array();
    preg_match('/(.*)\s\((.*)\s\[(.*)\](.*)\)(.*)/i', $title, $article_data);

    if(count($article_data) == 6) {
        $title = o($article_data[1]);
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

function format_arxiv_title_bare($title)   
{    
    $article_data = Array();   
    preg_match('/(.*)\s\((.*)\s\[(.*)\](.*)\)(.*)/i', $title, $article_data);    
   
    if(count($article_data) == 6) {    
        $title = $article_data[1];   
        $article = $article_data[2];   
        $section = $article_data[3];   
        $special = trim($article_data[4]);   
   
        $title_text = $title;    
           
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
        $title = o($article_data[1]);
        $article = $article_data[2];
        $section = $article_data[3];
        $special = trim($article_data[4]);

        $title_text = "";
            if(trim($special)) {$title_text .= "<em>"; }
        $title_text .= $title;
        $title_text .= ($special ? " - [".$special."]" : "");
            if(trim($special)) {$title_text .= "</em>"; }

        $pdf_link = '<a href="http://arxiv.org/pdf/'.$article.'.pdf" class="pdf-link btn btn-default btn-xs voted-btn pdf" role="button" title="Open PDF" data-toggle-tip="tooltip" data-container="body" data-placement="bottom"><span class="glyphicon glyphicon-share"></span> PDF</a>';
        $arx_link = '<a href="http://arxiv.org/abs/'.$article.'" class="btn btn-default btn-xs voted-btn arxiv" role="button" title="Go to arXiv" data-toggle-tip="tooltip" data-container="body" data-placement="bottom"><span class="glyphicon glyphicon-share"></span> arXiv</a>';
        
        return array($title_text,$pdf_link,$arx_link);
    } else {
        return $title;
    }
}

function format_arxiv_authors($authors)
{
  $authors = explode(',', $authors);

  // call o() on link text, and change search links to search all arxivs.
  foreach ($authors as $id => $author) {
    $author_data = Array();
    $link_format = '/<a href=\"http\:\/\/arxiv\.org\/find\/(.*)\/1\/au\:(.*)">(.*)<\/a>/i';
    preg_match($link_format, trim($author), $author_data);
    if(count($author_data) == 4) {
      $new_author = "<a href='http://arxiv.org/find/all/1/au:" . $author_data[2] . "'>" . o($author_data[3]) . "</a>";
      $authors[$id] = $new_author;
    }
  }

  $authors = implode(', ', $authors);
  return $authors;
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

// return timestamps for current week's meetings.
function get_meeting_timestamps($start_or_end = "end", $papers_only = FALSE, $date = FALSE)
{
  $meetings = get_variable("dates");

  if(!$date) {
    global $params;
    $date = $params->getDate();
  }

  if(!$meetings) {
    return NULL;
  } else {
    $meeting_times = array();
    foreach ($meetings as $meeting) {
      if($start_or_end == "end") {
        $time_str = $meeting->end;
      } else {
        $time_str = $meeting->start;
      }
      if(!$papers_only || $meeting->papers) {
        $meeting_times[] = array(
            "timestamp" => strtotime($meeting->day . " this week " . $time_str, 0),
            "papers_only" => $meeting->papers
          );
      }
    }
    return $meeting_times;
  }
}

// Eventually, return an array containing a timestamp for the next and prev. meetings
// or NULL if none.
function get_adjacent_meeting_times($start_or_end = "end", $papers_only = FALSE, $date = FALSE)
{
  $meetings = get_variable("dates");
  if(!$date) {
    global $params;
    $date = $params->getDate();
  }

  if(!$meetings) {
    return NULL;
  } else {
    $meeting_times = array();
    // one meeting time is "now"
    $meeting_times[] = $reference_time = strtotime(date("D", $date) . " this week " . date("H:i", $date), 0);
    // rather than writing special handlers, just assemble a list of all possible
    // meeting times that could surround the $date.
    foreach($meetings as $meeting) {
      if(!$papers_only || $meeting->papers) {
        if($start_or_end == "end") {
          $time_str = $meeting->end;
        } else {
          $time_str = $meeting->start;
        }
        $meeting_times[] = strtotime($meeting->day . " this week " . $time_str, 0);
        $meeting_times[] = strtotime($meeting->day . " last week " . $time_str, 0);
        $meeting_times[] = strtotime($meeting->day . " next week " . $time_str, 0);
      }
    }
    // make sure there are discussions at all...
    if(count($meeting_times) < 2) {
      return NULL;
    }
    // sort them
    sort($meeting_times);

    $meeting_time_key = array_search($reference_time, $meeting_times);
    $prev_time_diff = $meeting_times[$meeting_time_key] - $meeting_times[$meeting_time_key - 1];
    $next_time_diff = $meeting_times[$meeting_time_key] - $meeting_times[$meeting_time_key + 1];

    return array(
      "prev" => $date - $prev_time_diff,
      "next" => $date - $next_time_diff,
    );

  }
}

function print_errors($errors)
{
  foreach($errors as $error_message) {
    print_alert($error_message, "danger");
  }
}

function print_alert($html_message, $level)
{
  print '<div class="alert alert-' . $level . '" role="alert">'
      . $html_message
      . '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'
    . '</div>';
}

function kill_script($html_message)
{
  print '<div class="container">';
  print '<h1>' . $html_message . '</h1>';
  print '</div>';
  require_once("private/templates/footer.php");
  die();
}

function date_sort($date_1, $date_2)
{
  $dow = array("sun" => 0, "mon" => 1, "tue" => 2, "wed" => 4, "thu" => 5, "fri" => 6, "sat" => 7);
  return $dow[$date_1->day] > $dow[$date_2->day];
}

function get_votes()
{
  global $user;
  global $coffee_conn;

  $votes = array();
  if($user->isLoggedIn()) {
    $userId = $user->id();
    $query = "SELECT * FROM votes WHERE userId = ?";
    $result = $coffee_conn->boundQuery($query, array('s', &$userId));

    $votes = array();
    foreach($result as $row) {
      $votes[$row["paperId"]] = $row["value"];
    }
  }

  return $votes;
}
