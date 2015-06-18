@extends('app')

@section('content')
<div class="container">
  <div class="btn-group" role="group" aria-label="...">
    <a href="/structure/{{ Auth::user()->server }}/h" class="btn btn-default">{{ trans('menu.human')}}</a>
    <a href="/structure/{{ Auth::user()->server }}/m" class="btn btn-default">{{ trans('menu.magmar')}}</a>
    @if (Auth::user()->admin) @if ($count_new == 0) @else<a href="/users" class="btn btn-default">New users <span class="badge">{{ $count_new }}</span></a>@endif
    @endif
  </div>
  <h4>
    @if ($users->first()->race == 'h')
    {{ trans('menu.human_structure') }}
    @else
    {{ trans('menu.magmar_structure') }}
    @endif
  </h4>
  <p class="text-primary">Total guards: {{ $count }}</p>
  <h5>{{ trans('departments.econom') }}</h5>
  @foreach ($users as $user)
    <ul style="list-style-type: none;">
    @if ($user->department_id == 1)
      <li>
          <!-- Start -->
          @if ($user->server == '3k')
              @if ($user->race == 'h')
                <img src='http://3k.mail.ru/images/data/clans/tks_clan_new_kuyav.gif'/>
              @elseif ($user->race == 'm')
                <img src='http://3k.mail.ru/images/data/clans/tks_clan_new_artane.gif'>
              @endif
          @elseif (($user->server == 'w2')
                or ($user->server == 'w1')
                or ($user->server == 'com')
                or ($user->server == 'de')
                or ($user->server == 'pl'))
              @if ($user->race == 'h')
                <img src='http://warofdragons.com/images/data/clans/strazhum3.gif'/>
              @elseif ($user->race == 'm')
                <img src='http://warofdragons.com/images/data/clans/v0.gif'>
              @endif
          @else      
          @endif
          <!-- Stop -->
        <a href="http://ruslan.msk.ru/user/{{ $user->id }}">{{ $user->name }}</a> 
        @if ($user->server == '3k')
              <a href="http://{{ $user->server }}.mail.ru/user_info.php?nick={{ $user->name }}" target="_blank"><img src="http://warofdragons.com/images/player_info.gif" /></a>
          @elseif ($user->server == 'w1' or $user->server == 'w2')
             <a href="http://{{ $user->server }}.dwar.ru/user_info.php?nick={{ $user->name }}" target="_blank"><img src="http://warofdragons.com/images/player_info.gif" /></a>
          @else
          <a href="http://www.warofdragons.{{ $user->server }}/user_info.php?nick={{ $user->name }}" target="_blank"><img src="http://warofdragons.com/images/player_info.gif" /></a>
          @endif - 
      @if ($user->rank == 1)
        {{ trans('ranks.trainee') }}
      @elseif ($user->rank == 2)
        {{ trans('ranks.invest') }}
      @elseif ($user->rank == 3)
        {{ trans('ranks.d_head') }}
      @elseif ($user->rank == 4)
        {{ trans('ranks.head') }}
      @endif  
      </li>
    @endif
    </ul>
  @endforeach
  <h5>{{ trans('departments.invest') }}</h5>
  @foreach ($users as $user)
    <ul style="list-style-type: none;">
    @if ($user->department_id == 2)
      <li>
          <!-- Start -->
          @if ($user->server == '3k')
              @if ($user->race == 'h')
                <img src='http://3k.mail.ru/images/data/clans/tks_clan_new_kuyav.gif'/>
              @elseif ($user->race == 'm')
                <img src='http://3k.mail.ru/images/data/clans/tks_clan_new_artane.gif'>
              @endif
          @elseif (($user->server == 'w2')
                or ($user->server == 'w1')
                or ($user->server == 'com')
                or ($user->server == 'de')
                or ($user->server == 'pl'))
              @if ($user->race == 'h')
                <img src='http://warofdragons.com/images/data/clans/strazhum3.gif'/>
              @elseif ($user->race == 'm')
                <img src='http://warofdragons.com/images/data/clans/v0.gif'>
              @endif
          @else      
          @endif
          <!-- Stop -->
        <a href="http://ruslan.msk.ru/user/{{ $user->id }}">{{ $user->name }}</a>
        @if ($user->server == '3k')
              <a href="http://{{ $user->server }}.mail.ru/user_info.php?nick={{ $user->name }}" target="_blank"><img src="http://warofdragons.com/images/player_info.gif" /></a>
          @elseif ($user->server == 'w1' or $user->server == 'w2')
             <a href="http://{{ $user->server }}.dwar.ru/user_info.php?nick={{ $user->name }}" target="_blank"><img src="http://warofdragons.com/images/player_info.gif" /></a>
          @else
          <a href="http://www.warofdragons.{{ $user->server }}/user_info.php?nick={{ $user->name }}" target="_blank"><img src="http://warofdragons.com/images/player_info.gif" /></a>
          @endif - 
      @if ($user->rank == 1)
        {{ trans('ranks.trainee') }}
      @elseif ($user->rank == 2)
        {{ trans('ranks.invest') }}
      @elseif ($user->rank == 3)
        {{ trans('ranks.d_head') }}
      @elseif ($user->rank == 4)
        {{ trans('ranks.head') }}
      @endif</li>
    @endif
    </ul>
  @endforeach
  <h5>{{ trans('departments.operat') }}</h5>
  @foreach ($users as $user)
    <ul style="list-style-type: none;">
    @if ($user->department_id == 3)
      <li>
          <!-- Start -->
          @if ($user->server == '3k')
              @if ($user->race == 'h')
                <img src='http://3k.mail.ru/images/data/clans/tks_clan_new_kuyav.gif'/>
              @elseif ($user->race == 'm')
                <img src='http://3k.mail.ru/images/data/clans/tks_clan_new_artane.gif'>
              @endif
          @elseif (($user->server == 'w2')
                or ($user->server == 'w1')
                or ($user->server == 'com')
                or ($user->server == 'de')
                or ($user->server == 'pl'))
              @if ($user->race == 'h')
                <img src='http://warofdragons.com/images/data/clans/strazhum3.gif'/>
              @elseif ($user->race == 'm')
                <img src='http://warofdragons.com/images/data/clans/v0.gif'>
              @endif
          @else      
          @endif
          <!-- Stop -->
        <a href="http://ruslan.msk.ru/user/{{ $user->id }}">{{ $user->name }}</a>
        @if ($user->server == '3k')
              <a href="http://{{ $user->server }}.mail.ru/user_info.php?nick={{ $user->name }}" target="_blank"><img src="http://warofdragons.com/images/player_info.gif" /></a>
          @elseif ($user->server == 'w1' or $user->server == 'w2')
             <a href="http://{{ $user->server }}.dwar.ru/user_info.php?nick={{ $user->name }}" target="_blank"><img src="http://warofdragons.com/images/player_info.gif" /></a>
          @else
          <a href="http://www.warofdragons.{{ $user->server }}/user_info.php?nick={{ $user->name }}" target="_blank"><img src="http://warofdragons.com/images/player_info.gif" /></a>
          @endif - 
      @if ($user->rank == 1)
        {{ trans('ranks.trainee') }}
      @elseif ($user->rank == 2)
        {{ trans('ranks.invest') }}
      @elseif ($user->rank == 3)
        {{ trans('ranks.d_head') }}
      @elseif ($user->rank == 4)
        {{ trans('ranks.head') }}
      @endif</li>
    @endif
    </ul>
  @endforeach
  <h5>{{ trans('departments.review') }}</h5>
  @foreach ($users as $user)
   <ul style="list-style-type: none;">
    @if ($user->department_id == 4)
      <li>
          <!-- Start -->
          @if ($user->server == '3k')
              @if ($user->race == 'h')
                <img src='http://3k.mail.ru/images/data/clans/tks_clan_new_kuyav.gif'/>
              @elseif ($user->race == 'm')
                <img src='http://3k.mail.ru/images/data/clans/tks_clan_new_artane.gif'>
              @endif
          @elseif (($user->server == 'w2')
                or ($user->server == 'w1')
                or ($user->server == 'com')
                or ($user->server == 'de')
                or ($user->server == 'pl'))
              @if ($user->race == 'h')
                <img src='http://warofdragons.com/images/data/clans/strazhum3.gif'/>
              @elseif ($user->race == 'm')
                <img src='http://warofdragons.com/images/data/clans/v0.gif'>
              @endif
          @else      
          @endif
          <!-- Stop -->
        <a href="http://ruslan.msk.ru/user/{{ $user->id }}">{{ $user->name }}</a>
        @if ($user->server == '3k')
              <a href="http://{{ $user->server }}.mail.ru/user_info.php?nick={{ $user->name }}" target="_blank"><img src="http://warofdragons.com/images/player_info.gif" /></a>
          @elseif ($user->server == 'w1' or $user->server == 'w2')
             <a href="http://{{ $user->server }}.dwar.ru/user_info.php?nick={{ $user->name }}" target="_blank"><img src="http://warofdragons.com/images/player_info.gif" /></a>
          @else
          <a href="http://www.warofdragons.{{ $user->server }}/user_info.php?nick={{ $user->name }}" target="_blank"><img src="http://warofdragons.com/images/player_info.gif" /></a>
          @endif - 
      @if ($user->rank == 1)
        {{ trans('ranks.trainee') }}
      @elseif ($user->rank == 2)
        {{ trans('ranks.invest') }}
      @elseif ($user->rank == 3)
        {{ trans('ranks.d_head') }}
      @elseif ($user->rank == 4)
        {{ trans('ranks.head') }}
      @endif</li>
    @endif
    </ul>
  @endforeach
</div>
@endsection