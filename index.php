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
  <title>XboxLeaders - Simple & Powerful REST API For Xbox LIVE</title>
  <meta name="description" content="XboxLeaders Xbox LIVE API - Simple & Powerful RESTful API for Xbox LIVE">
  <meta name="author" content="Jason Clemons">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!--<meta name="viewport" content="initial-scale=1; maximum-scale=1">-->

  <!--[if lt IE 9]>
  <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
  <![endif]-->

  <!-- CSS
 ================================================== -->

  <link rel="stylesheet" href="./assets/css/site.css">
  <link rel="stylesheet" href="./assets/css/pygments.css">
  <link rel="stylesheet" href="./assets/font-awesome/css/font-awesome.css">
  <!--[if IE 7]>
  <link rel="stylesheet" href="./assets/font-awesome/css/font-awesome-ie7.css">
  <![endif]-->
  <!-- Le fav and touch icons -->
  <link rel="shortcut icon" href="./assets/ico/favicon.ico">

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

      <a class="brand" href="./"><i class="icon-trophy"></i> XboxLeaders</a>
      <div class="nav-collapse collapse">
        <ul class="nav">
          <li class="hidden-tablet  active"><a href="./">Home</a></li>
          <li><a href="./get-started/">Get Started</a></li>
          <li><a href="../region-chart/">Region Chart</a></li>
          <li class="dropdown-split-left"><a href="./community/">Community</a></li>
          <li class="dropdown dropdown-split-right hidden-phone">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="icon-caret-down"></i>
            </a>
            <ul class="dropdown-menu pull-right">
              <li><a href="./forums/"><i class="icon-group icon-fixed-width"></i>&nbsp; Forums</a></li>
              <li><a href="./blog/"><i class="icon-pencil icon-fixed-width"></i>&nbsp; Blog</a></li>
            </ul>
          </li>
          <li class="dropdown-split-left"><a href="./examples/">Examples</a></li>
          <li class="dropdown dropdown-split-right hidden-phone">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="icon-caret-down"></i>
            </a>
            <ul class="dropdown-menu pull-right">
              <li><a href="./examples/">Examples</a></li>
              <li class="divider"></li>
              <li><a href="./examples/#profile"><i class="icon-user icon-fixed-width"></i>&nbsp; Profile</a></li>
              <li><a href="./examples/#games"><i class="icon-sitemap icon-fixed-width"></i>&nbsp; Games</a></li>
              <li><a href="./examples/#achievements"><i class="icon-trophy icon-fixed-width"></i>&nbsp; Achievements</a></li>
              <li><a href="./examples/#friends"><i class="icon-group icon-fixed-width"></i>&nbsp; Friends</a></li>
              <li><a href="./examples/#search"><i class="icon-search icon-fixed-width"></i>&nbsp; Search</a></li>
            </ul>
          </li>
          <li><a href="./whats-new/">
          <span class="hidden-tablet">What's </span>New</a>
          </li>
          <li><a href="./license/">License</a></li>
        </ul>
        <ul class="nav pull-right">
          <li><a href="./blog/">Blog</a></li>
        </ul>
      </div>
    </div>
  </div>
</div>


<div class="jumbotron jumbotron-index hidden-print">
  <div class="container">
    <div class="row">
      <div class="span8">
        <div class="hero-content">
          <h1>Xbox Live API</h1>
          <p>Simple & Powerful REST API For Xbox LIVE</p>
          <div class="actions">
            <a class="btn btn-primary btn-large" href="https://github.com/XboxLeaders/XboxLiveAPI/zipball/master"
               onClick="_gaq.push(['_trackEvent', 'Outbound Link', 'Download on GitHub']);">
              <i class="icon-download-alt icon-large"></i>&nbsp;&nbsp;
              Download
            </a>
          </div>
          <div class="shameless-self-promotion">
            <a href="https://github.com/XboxLeaders/XboxLiveApi"
               onClick="_gaq.push(['_trackEvent', 'Outbound Link', 'View Project on GitHub']);">
              GitHub Project</a> &nbsp;&nbsp;&middot;&nbsp;&nbsp;
            Version 2.0 &nbsp;&nbsp;&middot;&nbsp;&nbsp;
            Created &amp; Maintained by <a href="http://twitter.com/jasonclemons">Jason Clemons</a>
          </div>
        </div>
      </div>
      <div class="span4">
        <div id="iconCarousel" class="carousel slide">
          <!-- Carousel items -->
          <div class="carousel-inner">
            <div class="active item"><div><i class="icon-trophy"></i></div></div>
            <div class="item"><div><i class="icon-group"></i></div></div>
            <div class="item"><div><i class="icon-search"></i></div></div>
            <div class="item"><div><i class="icon-sitemap"></i></div></div>
          </div>
          <!-- Carousel nav -->
          <a class="carousel-control left" href="#iconCarousel" data-slide="prev"
             onClick="_gaq.push(['_trackEvent', 'iconCarousel', 'Prev']);">
            <i class="icon-circle-arrow-left"></i></a>
          <a class="carousel-control right" href="#iconCarousel" data-slide="next"
             onClick="_gaq.push(['_trackEvent', 'iconCarousel', 'Next']);">
            <i class="icon-circle-arrow-right"></i></a>
        </div>
      </div>
    </div>

  </div>
</div>

<div id="social-buttons" class="hidden-print">
  <div class="container">
    <ul class="unstyled inline">
      <li>
        <iframe class="github-btn" src="./assets/github-btn.html?user=XboxLeaders&repo=XboxLiveApi&type=watch&count=true" allowtransparency="true" frameborder="0" scrolling="0" width="100px" height="20px"></iframe>
      </li>
      <li>
        <iframe class="github-btn" src="./assets/github-btn.html?user=XboxLeaders&repo=XboxLiveApi&type=fork&count=true" allowtransparency="true" frameborder="0" scrolling="0" width="102px" height="20px"></iframe>
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
    The XboxLeaders API allows developers to access public Xbox LIVE data in order to encourage app development 
    around the Xbox LIVE service.
  </p>
  
    </div>
  </div>
  </section>


  <div id="why">
  <div class="row">
    <div class="span4">
      <h4><i class="icon-flag"></i> Easy To Use</h4>
      By using official and contributed wrappers, you can be developing apps in no time.
    </div>
    <div class="span4">
      <h4><i class="icon-pencil"></i> Developer Friendly</h4>
      Straightforward index keys and multiple endpoints for your developing needs.
    </div>
    <div class="span4">
      <h4><i class="icon-signal"></i> 99% Uptime</h4>
      The API is monitored 24/7, so any problems can and will be taken care of immediately.
    </div>
  </div>
  <div class="row">
    <div class="span4">
      <h4><i class="icon-microphone"></i> Free, as in Speech</h4>
      XboxLiveAPI is completely free for commercial use. Check out the <a href="./license/">license</a>.
    </div>
    <div class="span4">
      <h4><i class="icon-globe"></i> Multi-Region Support</h4>
      The API supports as many regions as the Xbox LIVE service. See the <a href="./region-chart/">region chart</a> for more info.
    </div>
    <div class="span4">
      <h4><i class="icon-eye-open"></i> Always Fresh</h4>
      I'm always working on adding new features, and love new ideas. Feel free to <a href="./community/">contribute</a>.
    </div>
  </div>
  <div class="row">
    <div class="span4">
      <h4><i class="icon-group"></i> Open Source</h4>
      Open Source projects are awesome! Feel free to <a href="./community/">contribute</a> in any way you can!
    </div>
    <div class="span4">
    </div>
    <div class="span4">
    </div>
  </div>

  <section id="thanks-to">
  <h2 class="page-header">Thanks To</h2>
  <div class="row">
    <div class="span4">
      <p>
        Thanks to <a href="https://twitter.com/djekl">@djekl</a> and
        <a href="https://xboxapi.com">xboxapi.com</a> for initial
        help, advice, and encouragement to make this project public.
      </p>
    </div>
    <div class="span4">
      <p>
        Thanks to <a href="https://twitter.com/davegandy">@davegandy</a> and
        <a href="https://twitter.com/fontawesome">@fontawesome</a> for designing
        and allowing use of this documentation theme.
      </p>
    </div>
    <div class="span4">
      <p>
        BIG thanks to <a href="http://linode.com">Linode</a> for hosting the
        VPS this API resides on. They, unfortunately, have to put up with me :)
      </p>
    </div>
  </div>
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
<script src="./assets/js/jquery-1.7.1.min.js"></script>
<script src="./assets/js/ZeroClipboard-1.1.7.min.js"></script>
<script src="./assets/js/bootstrap-2.3.1.min.js"></script>
<script src="./assets/js/site.js"></script>

</body>
</html>
