@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">User #{{ $user->id }}</div>

				<div class="panel-body">
          <div class="row">
            <label for="name" class="col-sm-2 control-label">{{ trans('tables.name') }}</label>
              <div class="col-sm-10">
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
               
              {{ $user->name }}
              
          @if ($user->server == '3k')
              <a href="http://{{ $user->server }}.mail.ru/user_info.php?nick={{ $user->name }}" target="_blank"><img src="http://warofdragons.com/images/player_info.gif" /></a>
          @elseif ($user->server == 'w1' or $user->server == 'w2')
             <a href="http://{{ $user->server }}.dwar.ru/user_info.php?nick={{ $user->name }}" target="_blank"><img src="http://warofdragons.com/images/player_info.gif" /></a>
          @else
          <a href="http://www.warofdragons.{{ $user->server }}/user_info.php?nick={{ $user->name }}" target="_blank"><img src="http://warofdragons.com/images/player_info.gif" /></a>
          @endif
              </div>
          </div>
          <div class="row">
            <label for="department" class="col-sm-2 control-label">{{ trans('tables.department') }}</label>
              <div class="col-sm-10">
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
              </div>
          </div>
          <div class="row">
            <label for="rank" class="col-sm-2 control-label">{{ trans('tables.rank') }}</label>
              <div class="col-sm-10">
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
              </div>
          </div>
          <div class="row">
            <label for="telegram" class="col-sm-2 control-label">Telegram</label>
              <div class="col-sm-10">
                <a href="https://telegram.me/{{ $user->telegram }}" target="_blank">{{ $user->telegram }}</a>
              </div>
          </div>
          <hr>
          @if (Auth::user()->admin)
          {!! Form::open(['action' => ['UserController@edit', $user->id], 'class' => 'form-horizontal']) !!}
          <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
              <button type="submit" class="btn btn-default">{{ trans('actions.edit') }}</button>
            </div>
          </div>
          {!! Form::close() !!}
          @endif
          @if ($user->id == Auth::user()->id)
          <hr>
          {!! Form::open(['action' => 'UserController@changeLanguage', 'class' => 'form-inline']) !!}
          <div class="form-group">
            {!! Form::hidden('id', $user->id) !!}
            <label for="language">Lang</label>
              
                {!! Form::select('language', [
                        'en' => 'en',
                        'de' => 'de',
                        'pl' => 'pl',
                        'ru' => 'ru',
                      ], $user->language, ['class' => 'form-control']) !!}
              
          </div>
          <button type="submit" class="btn btn-default">{{ trans('actions.save') }}</button>
          {!! Form::close() !!}
          @endif
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
