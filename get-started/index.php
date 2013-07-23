<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html lang="en" xmlns="http://www.w3.org/1999/html"> <!--<![endif]-->
<head>
  <!-- Basic Page Needs
 ================================================== -->
  <meta charset="utf-8" />
  <title>XboxLeaders - Get Started</title>
  <meta name="description" content="XboxLeaders Xbox LIVE API - Simple & Powerful RESTful API for Xbox LIVE">
  <meta name="author" content="Jason Clemons">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!--<meta name="viewport" content="initial-scale=1; maximum-scale=1">-->

  <!--[if lt IE 9]>
  <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
  <![endif]-->

  <!-- CSS
 ================================================== -->

  <link rel="stylesheet" href="../assets/css/site.css">
  <link rel="stylesheet" href="../assets/css/pygments.css">
  <link rel="stylesheet" href="../assets/font-awesome/css/font-awesome.css">
  <!--[if IE 7]>
  <link rel="stylesheet" href="../assets/font-awesome/css/font-awesome-ie7.css">
  <![endif]-->
  <!-- Le fav and touch icons -->
  <link rel="shortcut icon" href="../assets/ico/favicon.ico">

  <!-- Google Analytics -->
  <script type="text/javascript">
    var _gaq = _gaq || [];
    _gaq.push(['_setAccount', 'UA-38684964-1']);
    _gaq.push(['_trackPageview']);
    (function() {
      var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
      ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
      var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
    })();
  </script>
  <!-- END Google Analytics -->
</head>
<body data-spy="scroll" data-target=".navbar">
<div class="wrapper"> <!-- necessary for sticky footer. wrap all content except footer -->
  <div class="navbar navbar-inverse navbar-static-top hidden-print">
  <div class="navbar-inner">
    <div class="container">
      <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>

      <a class="brand" href="../"><i class="icon-trophy"></i> XboxLeaders</a>
      <div class="nav-collapse collapse">
        <ul class="nav">
          <li class="hidden-tablet"><a href="../">Home</a></li>
          <li class="active"><a href="../get-started/">Get Started</a></li>
          <li><a href="../region-chart/">Region Chart</a></li>
          <li class="dropdown-split-left"><a href="../community/">Community</a></li>
          <li class="dropdown dropdown-split-right hidden-phone">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="icon-caret-down"></i>
            </a>
            <ul class="dropdown-menu pull-right">
              <li><a href="../forums/"><i class="icon-group icon-fixed-width"></i>&nbsp; Forums</a></li>
              <li><a href="../blog/"><i class="icon-pencil icon-fixed-width"></i>&nbsp; Blog</a></li>
            </ul>
          </li>
          <li class="dropdown-split-left"><a href="../examples/">Examples</a></li>
          <li class="dropdown dropdown-split-right hidden-phone">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="icon-caret-down"></i>
            </a>
            <ul class="dropdown-menu pull-right">
              <li><a href="../examples/">Examples</a></li>
              <li class="divider"></li>
              <li><a href="../examples/#profile"><i class="icon-user icon-fixed-width"></i>&nbsp; Profile</a></li>
              <li><a href="../examples/#games"><i class="icon-sitemap icon-fixed-width"></i>&nbsp; Games</a></li>
              <li><a href="../examples/#achievements"><i class="icon-trophy icon-fixed-width"></i>&nbsp; Achievements</a></li>
              <li><a href="../examples/#friends"><i class="icon-group icon-fixed-width"></i>&nbsp; Friends</a></li>
              <li><a href="../examples/#search"><i class="icon-search icon-fixed-width"></i>&nbsp; Search</a></li>
            </ul>
          </li>
          <li><a href="../whats-new/">
          <span class="hidden-tablet">What's </span>New</a>
          </li>
          <li><a href="../license/">License</a></li>
        </ul>
        <ul class="nav pull-right">
          <li><a href="../blog/">Blog</a></li>
        </ul>
      </div>
    </div>
  </div>
</div>


<div class="jumbotron jumbotron-ad hidden-print">
  <div class="container">
    <h1><i class="icon-cogs icon-large"></i>&nbsp; Get Started</h1>
    <p>Easy ways to get XboxLeaders API 2.0 onto your website</p>
  </div>
</div>

<div id="social-buttons" class="hidden-print">
  <div class="container">
    <ul class="unstyled inline">
      <li>
        <iframe class="github-btn" src="../assets/github-btn.html?user=XboxLeaders&repo=XboxLiveApi&type=watch&count=true" allowtransparency="true" frameborder="0" scrolling="0" width="100px" height="20px"></iframe>
      </li>
      <li>
        <iframe class="github-btn" src="../assets/github-btn.html?user=XboxLeaders&repo=XboxLiveApi&type=fork&count=true" allowtransparency="true" frameborder="0" scrolling="0" width="102px" height="20px"></iframe>
      </li>
      <li class="follow-btn">
        <a href="https://twitter.com/xboxleaders" class="twitter-follow-button" data-link-color="#0069D6" data-show-count="true">Follow @xboxleaders</a>
      </li>
      <li class="tweet-btn hidden-phone">
        <a href="https://twitter.com/share" class="twitter-share-button" data-url="" data-text="XboxLeaders, A simple and powerful REST API for Xbox LIVE" data-counturl="http://xboxleaders.github.com/XboxLiveApi" data-count="horizontal" data-via="xboxleaders" data-related="jasonclemons:Creator & Developer of XboxLeaders">Tweet</a>
      </li>
    </ul>
  </div>
</div>

<div class="container">
  
<section class="hidden-print">
  <div class="row stripe-ad">
    <div class="span8">
      
      <p class="lead">
        Setting up the API is pretty straightforward. To start, you'll need to have <a href="http://php.net/">PHP 5.4</a> or higher,
        as well as the JSON and cURL libraries. Apache 2.2 is also strongly recommended.
      </p>

    </div>
  </div>
</section>


<section>
  <h2 class="page-header">EASY: XboxLeaders-Provided API</h2>
  <p>By using a simple wrapper class, you can start using the API within minutes!</p>
  <ol>
    <li>
      Check out the <a href="https://github.com/XboxLeaders/apiwrapper">official PHP API wrapper</a>
      on GitHub
    </li>
    <li>
      Check out others' contributions on <a href="https://github.com/XboxLeaders/XboxLiveAPI/wiki/API-Wrappers">XboxLiveAPI Wiki</a>.
    </li>
    <li>
      Check out the <a href="../examples/">examples</a> to start using the API!
    </li>
  </ol>
</div>

<section>
  <h2 class="page-header">PRO: Set Up API Server</h2>
  <p>Use this method to set up the API on your own server. This will allow you more control over the API itself.</p>
  <ol>
    <li>
      <a href="https://www.xbox.com/live/join">Create</a> an Xbox LIVE account. Make sure to note your login 
      credentials, as you will need them later.
    </li>
    <li>
      <a href="https://github.com/XboxLeaders/XboxLiveAPI/zipball/master">Download</a> the API repository, and place the <code>/source</code> directory where you want your API to reside. It
      must be placed in a public directory.
    </li>
    <li>
      Find the file <code>/includes/bootloader.php</code>, and insert your Xbox LIVE login details in the <code>XBOX_EMAIL</code>,
      <code>XBOX_PASSWORD</code>, and <code>XBOX_GAMERTAG</code> constants.
    </li>
    <li>Check out the <a href="../examples/">examples</a> to start using the API!</li>
  </ol>
</section>

</div>

  <div class="push"><!-- necessary for sticky footer --></div>
</div>
<footer class="footer hidden-print">
  <div class="container text-center">
    <div>
      <i class="icon-flag"></i> XboxLeaders API v2.0
      <span class="hidden-phone">&middot;</span><br class="visible-phone">
      Created and Maintained by <a href="http://twitter.com/jasonclemons">Jason Clemons</a>
    </div>
    <div>
      Code licensed under <a href="http://opensource.org/licenses/mit-license.html">MIT License</a>
      <span class="hidden-phone hidden-tablet">&middot;</span><br class="visible-phone visible-tablet">
      Documentation licensed under <a href="http://creativecommons.org/licenses/by/3.0/">CC BY 3.0</a>
    </div>
    <div class="project">
      <a href="https://github.com/XboxLeaders/XboxLiveApi">GitHub Project</a> &middot;
      <a href="https://github.com/XboxLeaders/XboxLiveApi/issues">Issues</a>
    </div>
  </div>
</footer>


<script src="//platform.twitter.com/widgets.js"></script>
<script src="../assets/js/jquery-1.7.1.min.js"></script>
<script src="../assets/js/ZeroClipboard-1.1.7.min.js"></script>
<script src="../assets/js/bootstrap-2.3.1.min.js"></script>
<script src="../assets/js/site.js"></script>

</body>
</html>
