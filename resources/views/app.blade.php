<?php  
$cases_count = \App\Http\Controllers\CasesController::myCasesCount();
$department_cases_count = \App\Http\Controllers\CasesController::myDepartmentCasesCount();
$admin_cases = \App\Http\Controllers\CasesController::adminCasesCount();
$helpdesk_cases = \App\Http\Controllers\CasesController::helpdeskCasesCount()
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Guards MS</title>

	<link href="{{ asset('/css/app.css') }}" rel="stylesheet">
  <link href="{{ asset('guards.css') }}" rel="stylesheet">

	<!-- Fonts -->
	<link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<body>
	<nav class="navbar navbar-default">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only">Toggle Navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="#">Guards MS</a>
			</div>

			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">
					<li><a href="{{ url('/warofdragons') }}">{{ trans('menu.home') }}</a></li>
          @if (Auth::guest())
          @else
            <li><a href="{{ url('/cases') }}">{{ trans('menu.all_cases') }}</a></li>
            <li><a href="{{ url('/cases/closed') }}">{{ trans('menu.archive') }}</a></li>
            <li><a href="{{ url('/cases/mydepartment') }}">{{ trans('menu.my_department_cases') }}
              @if ($department_cases_count)
                <span class="badge">{{ $department_cases_count }}</span>
              @endif</a></li>
          @endif
          @if (isset(Auth::user()->helpdesk) and !empty(Auth::user()->helpdesk))
            @if (Auth::user()->helpdesk)
            <li><a href="{{ url('/cases/helpdesk') }}">{{ trans('menu.helpdesk') }}
              @if($helpdesk_cases) <span class="badge">{{ $helpdesk_cases }}</span> 
              @endif</a></li>
            @endif
          @endif
          @if (isset(Auth::user()->admin) and !empty(Auth::user()->admin))
            @if (Auth::user()->admin)
              <li><a href="{{ url('/cases/foradmins') }}">{{ trans('menu.admin_cases') }} 
              @if ($admin_cases) <span class="badge">{{ $admin_cases }}</span>
              @endif</a></li>
            @endif
          @endif
          @if (isset(Auth::user()->rank) and !empty(Auth::user()->rank))
            @if (Auth::user()->admin or (Auth::user()->rank == 3))
            <li><a href="{{ url('/stats') }}">{{ trans('menu.stats') }}</a></li>
            @endif
          @endif
          <li>
            {!! Form::open(['action' => 'CasesController@search', 'method' => 'get', 'class' => 'navbar-form navbar-left', 'role' => 'search']) !!}
            {!! Form::input('search', 'q', null, ["placeholder" => trans('menu.search'), "class" => "form-control"]) !!}
            {!! Form::close() !!}
          </li>
				</ul>

				<ul class="nav navbar-nav navbar-right">
          @if (Auth::guest())
						<li><a href="{{ url('/auth/login') }}">Login</a></li>
						<li><a href="{{ url('/auth/register') }}">Register</a></li>
					@else
            <li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                
                @if (Auth::user()->server == '3k')
                  @if (Auth::user()->race == 'h')
                    <img src='http://3k.mail.ru/images/data/clans/tks_clan_new_kuyav.gif'/>
                  @elseif (Auth::user()->race == 'm')
                    <img src='http://3k.mail.ru/images/data/clans/tks_clan_new_artane.gif'/ >
                  @endif
                @else
                  @if (Auth::user()->race == 'h')<img src='http://warofdragons.com/images/data/clans/strazhum3.gif'/>
                  @elseif (Auth::user()->race == 'm')<img src='http://warofdragons.com/images/data/clans/v0.gif'>
                  @endif 
                @endif
                {{ Auth::user()->name }} <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                  <li><a href="{{ url('/case/create') }}">{{ trans('menu.open_case') }}</a></li>
                  <li><a href="{{ url('/cases/mycases') }}">{{ trans('menu.my_cases') }} @if ($cases_count)
                  <span class="badge">{{ $cases_count }}</span>
                    @endif
                </a>
                </li>
                <li><a href="/structure/{{ Auth::user()->server }}/{{ Auth::user()->race }}">{{ trans('menu.guards') }}</a></li>
                <li><a href="/user/{{ Auth::user()->id }}">{{ trans('menu.settings') }}</a>
								<li><a href="{{ url('/auth/logout') }}">{{ trans('menu.logout') }}</a></li>
							</ul>
						</li>
					@endif
				</ul>
			</div>
		</div>
	</nav>

	@yield('content')
  <!-- Scripts -->
  <!-- Yandex.Metrika counter -->
<script type="text/javascript">
 (function (d, w, c) {
 (w[c] = w[c] || []).push(function() {
 try {
 w.yaCounter30359217 = new Ya.Metrika({
 id:30359217,
 clickmap:true,
 trackLinks:true,
 accurateTrackBounce:true
 });
 } catch(e) { }
 });

 var n = d.getElementsByTagName("script")[0],
 s = d.createElement("script"),
 f = function () { n.parentNode.insertBefore(s, n); };
 s.type = "text/javascript";
 s.async = true;
 s.src = "https://mc.yandex.ru/metrika/watch.js";

 if (w.opera == "[object Opera]") {
 d.addEventListener("DOMContentLoaded", f, false);
 } else { f(); }
 })(document, window, "yandex_metrika_callbacks");
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/30359217" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="/jquery.tablesorter.min.js"></script>
   <script>$(document).ready(function() {
    // plugin call
    $("table").tablesorter({
      
    });
});</script>
</body>
</html>
