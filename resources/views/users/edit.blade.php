@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">User #{{ $user->id }}</div>

				<div class="panel-body">
           {!! Form::open(['action' => ['UserController@upgrate', $user->id], 'class' => 'form-horizontal']) !!} 
          <div class="form-group">
            <label for="name" class="col-sm-2 control-label">{{ trans('tables.name') }}</label>
              <div class="col-sm-10">
                {!! Form::text('name', $user->name, ['class' => 'form-control'])!!}
              </div>
          </div>
          <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
              <div class="checkbox">
                <label>
                  {!! Form::hidden('access', 0) !!}
                  {!! Form::checkbox('access', 1, $user->access) !!}
                  {{ trans('tables.access') }}
                </label>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label for="department" class="col-sm-2 control-label">{{ trans('tables.department') }}</label>
              <div class="col-sm-10">
                {!! Form::select('department_id', [
                        1 => trans('departments.econom'),
                        2 => trans('departments.invest'),
                        3 => trans('departments.operat'),
                        4 => trans('departments.review'),
                        5 => trans('departments.help'),
                      ], $user->department_id, ['class' => 'form-control']) !!}
              </div>
          </div>
          <div class="form-group">
            <label for="rank" class="col-sm-2 control-label">{{ trans('tables.rank') }}</label>
              <div class="col-sm-10">
                {!! Form::select('rank', [
                  1 => trans('ranks.trainee'),
                  2 => trans('ranks.invest'),
                  3 => trans('ranks.d_head'),
                  4 => trans('ranks.head'),
                ], $user->rank, ['class' => 'form-control']) !!}
              </div>
          </div>
          <div class="form-group">
            <label for="race" class="col-sm-2 control-label">{{ trans('tables.race') }}</label>
              <div class="col-sm-10">
                {!! Form::select('race', [
                  'h' => trans('races.h'),
                  'm' => trans('races.m'),
                ], $user->race, ['class' => 'form-control']) !!}
              </div>
          </div>
          <div class="form-group">
            <label for="race" class="col-sm-2 control-label">{{ trans('tables.server') }}</label>
              <div class="col-sm-10">
                {!! Form::select('server', [
                  'com' => '.com',
                  'de' => '.de',
                  'pl' => '.pl',
                  'w1' => 'DWAR:w1',
                  'w2' => 'DWAR:w2',
                  '3k' => '3k.mail.ru',
                ], $user->server, ['class' => 'form-control']) !!}
              </div>
          </div>
          <div class="form-group">
            <label for="telegram" class="col-sm-2 control-label">Telegram</label>
              <div class="col-sm-10">
                {!! Form::text('telegram', $user->telegram, ['class' => 'form-control']) !!}
              </div>
          </div>
          <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
              <div class="checkbox">
                <label>
                  {!! Form::hidden('helpdesk', 0) !!}
                  {!! Form::checkbox('helpdesk', 1, $user->helpdesk) !!}
                  {{ trans('tables.helpdesk') }}
                </label>
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
              <button type="submit" class="btn btn-default">{{ trans('actions.save') }}</button>
            </div>
          </div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
