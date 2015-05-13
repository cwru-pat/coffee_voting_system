<!-- Fixed navbar -->
<nav class="navbar navbar-inverse navbar-fixed-top">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="/coffee">CWRU Coffee</a>
    </div>
    <div id="navbar" class="navbar-collapse collapse">
      <ul class="nav navbar-nav">
        <li class="active"><a href="/coffee">Home</a></li>
        <li><a href="/coffee/votes.php">Current Votes</a></li>
        <li><a href="/coffee/me.php">My Votes</a></li>
      </ul>
      <?php if($user->isLoggedIn()) { ?>
        <ul class="nav navbar-nav navbar-right">
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Logged in as <?php print($user->id()); ?> <span class="caret"></span></a>
            <ul class="dropdown-menu" role="menu">
              <li><a href="/coffee/login.php?logout">Log Out</a></li>
            </ul>
          </li>
        </ul>
      <?php } else { ?>
        <form class="navbar-form navbar-right" action="/coffee/login.php" method="POST">
          <button type="submit" class="btn btn-success">Sign in</button>
        </form>
      <?php } ?>
    </div><!--/.nav-collapse -->
  </div>
</nav>
