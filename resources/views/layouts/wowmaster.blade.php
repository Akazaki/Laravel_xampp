<html>
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="content-language" content="ja" />
    <meta http-equiv="content-style-type" content="text/css" />
    <meta http-equiv="content-script-type" content="text/javascript" />
    <meta name="robots" content="noindex,nofollow" />
    <title>@yield('title')｜WOW</title>
    <!--css-->
    <link rel="stylesheet" href="/public/wow/common/css/import.css" type="text/css" media="all" />
    <!--js-->
    <script type="text/javascript" src="/public/wow/common/js/jquery.js"></script>
    <script type="text/javascript" src="/public/wow/common/js/rollover.js"></script>
    <script type="text/javascript" src="/public/wow/common/js/iepngfix.js"></script>
    <script type="text/javascript" src="/public/wow/common/js/iepngrollover.js"></script>
    <script type="text/javascript" src="/public/wow/common/js/jquery.accordion.js"></script>
    </head>
    <body>
    <div class="container">
    <div id="header">
    <div id="topBox">
    <h1><a href="./dashboard"><img src="/public/wow/common/img/header_logo.gif" alt="Contents Management Flamework WOW" width="81" height="14" /></a></h1>
    <div id="gpol">
    <p><a href="/" target="_blank">Webサイトへ</a></p>
    @if(Auth::check())
        <div><a href="{{action('WowController@signout')}}">ログアウト</a></div>
    @else
        <div><a href="{{action('WowController@register')}}"><i class="fa fa-shopping-cart" aria-hidden="true"></i> 新規登録</a></div>
        <div><a href="{{action('WowController@login')}}"><i class="fa fa-shopping-cart" aria-hidden="true"></i> ログイン</a></div>
    @endif
    </div>
    </div>
    <div id="bottomBox">
    <ul>
    <li>&nbsp;</li>
    </ul>
    <div id="time_logout">
    <div id="time"><img src="/public/wow/common/img/time.gif" alt="現在の時刻" width="15" height="15" /><span data-offset="9">19:14:34</span></div>
    <div id="account"><img src="/public/wow/common/img/account.gif" alt="アカウント" width="1" height="15" /><span>ログイン名：{{ Auth::user()->label_text }}</span></div>
    <div id="logout"><a href="/wow/signout"><img src="/public/wow/common/img/logout.gif" alt="ログアウト" width="68" height="25" border="0" class="imgover" /></a></div>
    </div>
    </div>
    </div>
    <!--//header-->

    <div id="wrapper">
    <table border="0" cellpadding="0" cellspacing="0" id="liquid">
    <tr>

    <td id="leftSide" class="mainColTop"><!-- leftSide start -->
    <ul><li><a href="dashboard.php" class="parentNon icon00">ダッシュボード</a></li>
    <li><a href="news.php?default=list" class="parentNon icon09 ">投稿管理</a></li><li class="open blue"><span class="parent icon07">商品管理</span>
    <ul class="open blue">
    <li><a href="product.php?default=list">容器</a></li>
    <li><a href="caps.php?default=list">キャップ</a></li>
    <li><a href="accessory.php?default=list">付属品</a></li>
    <li><a href="other.php?default=list">容器以外の商品</a></li>
    </ul>
    </li>
    <li><a href="member.php?default=list" class="parentNon icon08">会員管理</a>
    </li>
    <li><img src="/public/wow/common/img/side_naviend.gif" alt="メニューエンド" width="194" height="43" border="0" /></li>
    </ul>
    <div style="height:200px; width:10px;">　</div>
    </td>
        @yield('content')
    </tr>
    </table>
    <!--//wrapper-->
    </div>

    <div id="footer">
    <div id="footLeft"></div>
    <div id="footRight"><!--a href="#"><img src="/public/wow/common/img/footer_navi01.gif" alt="プライバシーポリシー" width="101" height="12" border="0" class="rollover" /></a><a href="#"><img src="/public/wow/common/img/footer_navi02.gif" alt="ヘルプ" width="32" height="12" border="0" class="rollover" /></a--></div>
    </div>
    </div>
    </body>
</html>