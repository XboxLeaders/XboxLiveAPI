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
  <title>XboxLeaders - Region Chart</title>
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
          <li><a href="../get-started/">Get Started</a></li>
          <li class="active"><a href="../region-chart/">Region Chart</a></li>
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
          <li><a href="../community/">Community</a></li>
          <li><a href="../license/">License</a></li>
        </ul>
        <ul class="nav pull-right">
          <li><a href="../blog">Blog</a></li>
        </ul>
      </div>
    </div>
  </div>
</div>


  


<div class="jumbotron jumbotron-ad hidden-print">
  <div class="container">
    <h1><i class="icon-globe icon-large"></i>&nbsp; Xbox LIVE Region Chart</h1>
    <p>A full list of Xbox-supported regions</p>
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
        <a href="https://twitter.com/share" class="twitter-share-button" data-url="" data-text="XboxLeaders, A simple and powerful REST API for Xbox LIVE" data-counturl="https://www.xboxleaders.com" data-count="horizontal" data-via="xboxleaders" data-related="jasonclemons:Creator & Developer of XboxLeaders">Tweet</a>
      </li>
    </ul>
  </div>
</div>


<div class="container">
  
<section class="hidden-print">
  <div class="row stripe-ad">
    <div class="span8">
      <!-- Google AdSense -->
      <p class="ads">
        <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
        <!-- XboxLeaders.com Main -->
        <ins class="adsbygoogle"
          style="display:inline-block;width:728px;height:90px"
          data-ad-client="ca-pub-9916449857543818"
          data-ad-slot="6366675455"></ins>
        <script>
          (adsbygoogle = window.adsbygoogle || []).push({});
        </script>
      </p>
      <!-- END Google AdSense -->
      <p class="lead">
        XboxLeaders allows you to return results from different regions by adding a parameter to each request.
      </p>
    </div>
  </div>
</section>

<section>
  <h2 class="page-header">Xbox LIVE Region Chart</h2>
  <p>
    In order to change the region code for the results, add a parameter to each request named <code>region</code>.
    An example request would look like this: <code>https://www.xboxleaders.com/api/2.0/profile.json?gamertag=Major%20Nelson&amp;region=en-GB</code>
  </p>
  <p>All requests will default to <code>en-US</code> if no region is specified, or is not supported.</p>

  <table class="table table-striped">
  <thead>
    <th>Code</th>
    <th>Country</th>
    <th>Code</th>
    <th>Country</th>
  </thead>
  <tbody>
    <tr>
      <td>es-AR</td>
      <td>Argentina (Spanish)</td>
      <td>en-AU</td>
      <td>Australia (International English)</td>
    </tr><tr>
      <td>de-AT</td>
      <td>Austria (German)</td>
      <td>nl-BE</td>
      <td>Belgium (Dutch)</td>
    </tr><tr>
      <td>fr-BE</td>
      <td>Belgium (French)</td>
      <td>br-BR</td>
      <td>Brazil (Brazilian)</td>
    </tr><tr>
      <td>pt-br</td>
      <td>Brazilian (Portuguese)</td>
      <td>en-CA</td>
      <td>Canada (English)</td>
    </tr><tr>
      <td>fr-CA</td>
      <td>Canada (French)</td>
      <td>es-CL</td>
      <td>Chile (Spanish)</td>
    </tr><tr>
      <td>es-CO</td>
      <td>Colombia (Spanish)</td>
      <td>cs-CZ</td>
      <td>Czech Republic (Czech)</td>
    </tr><tr>
      <td>da-DA</td>
      <td>Denmark (Danish)</td>
      <td>fi-FI</td>
      <td>Finland (Finnish)</td>
    </tr><tr>
      <td>fr-FR</td>
      <td>France (French)</td>
      <td>de-DE</td>
      <td>Germany (German)</td>
    </tr><tr>
      <td>el-GR</td>
      <td>Greece (Greek)</td>
      <td>zh-HK</td>
      <td>Hong Kong (Traditional Chinese)</td>
    </tr><tr>
      <td>en-HK</td>
      <td>Hong Kong (English)</td>
      <td>hu-HU</td>
      <td>Hungary (Hungarian)</td>
    </tr><tr>
      <td>en-ID</td>
      <td>India (English)</td>
      <td>en-ID</td>
      <td>Ireland (International English)</td>
    </tr><tr>
      <td>he-IL</td>
      <td>Israel (Hebrew)</td>
      <td>it-IT</td>
      <td>Italy (Italian)</td>
    </tr><tr>
      <td>ja-JP</td>
      <td>Japan (Japanese)</td>
      <td>ko-KR</td>
      <td>Korea (Korean)</td>
    </tr><tr>
      <td>es-MX</td>
      <td>Mexico (Spanish)</td>
      <td>nl-NL</td>
      <td>Netherlands (Dutch)</td>
    </tr><tr>
      <td>en-NZ</td>
      <td>New Zealand (International English)</td>
      <td>nb-NO</td>
      <td>Norway (Norwegian)</td>
    </tr><tr>
      <td>pl-PL</td>
      <td>Poland (Polish)</td>
      <td>ru-RU</td>
      <td>Russia (Russian)</td>
    </tr><tr>
      <td>en-SA</td>
      <td>Saudi Arabia (International English)</td>
      <td>en-SG</td>
      <td>Singapore (International English)</td>
    </tr><tr>
      <td>sk-SK</td>
      <td>Slovakia (Slovakian)</td>
      <td>en-ZA</td>
      <td>South Africa (International English)</td>
    </tr><tr>
      <td>es-ES</td>
      <td>Spain (Spanish)</td>
      <td>sv-SE</td>
      <td>Sweden (Swedish)</td>
    </tr><tr>
      <td>de-CH</td>
      <td>Switzerland (German)</td>
      <td>fr-CH</td>
      <td>Switzerland (French)</td>
    </tr><tr>
      <td>zh-TW</td>
      <td>Taiwan (Traditional Chinese)</td>
      <td>tr-TR</td>
      <td>Turkey (Turkish)</td>
    </tr><tr>
      <td>en-UA</td>
      <td>United Arab Emirates (International English)</td>
      <td>en-GB</td>
      <td>United Kingdom (English)</td>
    </tr><tr>
      <td>en-US</td>
      <td>United States (English)</td>
      <td>--</td>
      <td>--</td>
    </tr>
  </tbody>
  </table>

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
