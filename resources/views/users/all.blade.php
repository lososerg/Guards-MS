@extends('app')

@section('content')
<div class="container">
	<table class="table table-condensed table-hover">
    <thead>
      <tr>
        <th class="header">ID</th>
        <th class="header">{{ trans('tables.name') }}</th>
        <th class="header">{{ trans('tables.department') }}</th>
        <th class="header">{{ trans('tables.rank') }}</th>
        <th class="header">{{ trans('tables.server') }}</th>
      </tr>
    </thead>
    <tbody>
      @foreach($users as $user)
      <tr>
        <td><a href="user/{{ $user->id }}">{{ $user->id }}</td>
        <td>
          @if (isset($user->name) and !empty($user->name))
          <!-- Start -->
          @if ($user->server == '3k')
              @if ($user->race == 'h')
                <img src='http://3k.mail.ru/images/data/clans/tks_clan_new_kuyav.gif'/>
              @elseif ($user->race == 'm')
                <img src='http://3k.mail.ru/images/data/clans/tks_clan_new_artane.gif'>
              @endif
          @else
              @if ($user->race == 'h')
                <img src='http://warofdragons.com/images/data/clans/strazhum3.gif'/>
              @elseif ($user->race == 'm')
                <img src='http://warofdragons.com/images/data/clans/v0.gif'>
              @endif
          @endif
          <!-- Stop -->
            {{ $user->name }}
          
          @if ($user->server == '3k')
              <a href="http://{{ $user->server }}.mail.ru/user_info.php?nick={{ $user->name }}" target="_blank"><img src="http://warofdragons.com/images/player_info.gif" /></a>
          @elseif ($user->server == 'w1' or $user->server == 'w2')
             <a href="http://{{ $user->server }}.dwar.ru/user_info.php?nick={{ $user->name }}" target="_blank"><img src="http://warofdragons.com/images/player_info.gif" /></a>
          @else
          <a href="http://www.warofdragons.{{ $user->server }}/user_info.php?nick={{ $user->name }}" target="_blank"><img src="http://warofdragons.com/images/player_info.gif" /></a>
          @endif
          
          @endif
        </td>
        <td>
          @if (isset($user->department_id) and !empty($user->department_id))
            @if ($user->department_id == 1)
            {{ trans('departments.econom') }}
            @elseif ($user->department_id == 2)
            {{ trans('departments.invest') }}
            @elseif ($user->department_id == 3)
            {{ trans('departments.operat') }}
            @elseif ($user->department_id == 4)
            {{ trans('departments.review') }}
            @elseif ($user->department_id == 5)
            {{ trans('departments.help') }}
            @else
            @endif
          @endif
        </td>
        <td>
          @if (isset($user->rank) and !empty($user->rank))
            @if ($user->rank == 1)
            {{ trans('ranks.trainee') }}
            @elseif ($user->rank == 2)
            {{ trans('ranks.invest') }}
            @elseif ($user->rank == 3)
            {{ trans('ranks.d_head') }}
            @elseif ($user->rank == 4)
            {{ trans('ranks.head') }}
            @else
            @endif
          @endif
        </td>
        <td>
          {{ $user->server }}
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endsection
