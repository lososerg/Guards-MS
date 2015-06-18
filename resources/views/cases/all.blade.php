@extends('app')

@section('content')
<div class="container">
	@if ($cases->count())
  <table class="table table-condensed table-hover">
    <thead>
      <tr>
        <th class="header">ID</th>
        <th class="header">{{ trans('tables.date') }}</th>
        <th class="header">{{ trans('tables.status') }}</th>
        <th class="header">{{ trans('tables.department') }}</th>
        <th class="header">{{ trans('tables.type') }}</th>
        <th class="header">{{ trans('tables.owner') }}</th>
        <th class="header">{{ trans('tables.perpetrator') }}</th>
        @if((Auth::user()->admin == 2) or (Auth::user()->admin == 1))
        <th>{{ trans('tables.action') }}</th>
        @endif
      </tr>
    </thead>
    <tbody>
      @foreach($cases as $case)
      <?php $creator = \App\User::find($case->created_by_id) ?>
      <tr @if($creator->admin == 2) class="info" @endif>
        <td><a href="/case/{{ $case->id }}">{{ $case->id }}</a></td>
        <td>{{ $case->updated_at }}</td>
        <td>
          @if (isset($case->status) and !empty($case->status))
            @if ($case->status == 1)
            {{ trans('status.new') }}
            @elseif ($case->status == 2)
            {{ trans('status.in_progress') }}
            @elseif ($case->status == 3)
            {{ trans('status.closed') }}
            @else
            @endif
          @endif
        </td>
        <td>
          @if (isset($case->department_id) and !empty($case->department_id))
            @if ($case->department_id == 1)
            {{ trans('departments.econom') }}
            @elseif ($case->department_id == 2)
            {{ trans('departments.invest') }}
            @elseif ($case->department_id == 3)
            {{ trans('departments.operat') }}
            @elseif ($case->department_id == 4)
            {{ trans('departments.review') }}
            @elseif ($case->department_id == 5)
            {{ trans('departments.help') }}
            @else
            @endif
          @endif
        </td>
        <td>
          @if (isset($case->type) and !empty($case->type))
            @if ($case->type == 1)
            {{ trans('types.power_leveling') }}
            @elseif ($case->type == 2)
            {{ trans('types.autobot') }}
            @elseif ($case->type == 3)
            {{ trans('types.rigged_fights') }}
            @elseif ($case->type == 5)
            {{ trans('types.help_quest') }}
            @elseif ($case->type == 6)
            {{ trans('types.help_item') }}
            @elseif ($case->type == 7)
            {{ trans('types.help_client') }}
            @elseif ($case->type == 8)
            {{ trans('types.help_fights') }}
            @elseif ($case->type == 4)
            {{ trans('types.other') }}
            @elseif ($case->type == 9)
            {{ trans('types.black_market') }}
            @elseif ($case->type == 10)
            {{ trans('types.account_hack') }}
            @else
            @endif
          @endif
        </td>
        <td>
          @if ($case->owner_id)
            @if ($case->server == '3k')
              @if (\App\User::find($case->owner_id)->race == 'h')
                <img src='http://3k.mail.ru/images/data/clans/tks_clan_new_kuyav.gif'/>
              @elseif (\App\User::find($case->owner_id)->race == 'm')
                <img src='http://3k.mail.ru/images/data/clans/tks_clan_new_artane.gif'>
              @endif
              <a href="/user/{{ $case->owner_id }}">{{ \App\User::find($case->owner_id)->name }}
            @else
              @if (\App\User::find($case->owner_id)->race == 'h')
                <img src='http://warofdragons.com/images/data/clans/strazhum3.gif'/>
              @elseif (\App\User::find($case->owner_id)->race == 'm')
                <img src='http://warofdragons.com/images/data/clans/v0.gif'>
              @endif
              <a href="/user/{{ $case->owner_id }}">{{ \App\User::find($case->owner_id)->name }}
            @endif
          @endif
        </td>
        <td>
          <?php $c = App\Cases::find($case->id); ?>
          
          @if ($c->perpetrators->count() > 1)
          {{ $c->perpetrators->first()->name }}
          @if (($c->server == 'w1') or ($c->server == 'w2')) 
          <a href="http://{{ $c->server }}.dwar.ru/user_info.php?nick={{ $c->perpetrators->first()->name }}" target="_blank"><img src="http://warofdragons.com/images/player_info.gif" /></a>
          @elseif ($c->server == '3k')
          <a href="http://{{ $c->server }}.mail.ru/user_info.php?nick={{ $c->perpetrators->first()->name }}" target="_blank"><img src="http://warofdragons.com/images/player_info.gif" /></a>
          @else <a href="http://www.warofdragons.{{ $c->perpetrators->first()->server }}/user_info.php?nick={{ $c->perpetrators->first()->name }}" target="_blank"><img src="http://warofdragons.com/images/player_info.gif" /></a>@endif <a href="/case/{{ $case->id }}#perpetrators">[...]</a>
          @elseif ($c->perpetrators->count() > 0)
          {{ $c->perpetrators->first()->name }}
          @if (($c->server == 'w1') or ($c->server == 'w2')) 
          <a href="http://{{ $c->server }}.dwar.ru/user_info.php?nick={{ $c->perpetrators->first()->name }}" target="_blank"><img src="http://warofdragons.com/images/player_info.gif" /></a>
          @else <a href="http://www.warofdragons.{{ $c->perpetrators->first()->server }}/user_info.php?nick={{ $c->perpetrators->first()->name }}" target="_blank"><img src="http://warofdragons.com/images/player_info.gif" /></a>@endif 
          @endif
          @if ($case->perpetrator)
            @if (isset($case->perpetrator) and !empty($case->perpetrator))
            {{ $case->perpetrator }} 
          @if (($case->server == 'w1') or ($case->server == 'w2')) 
          <a href="http://{{ $case->server }}.dwar.ru/user_info.php?nick={{ $case->perpetrator }}" target="_blank"><img src="http://warofdragons.com/images/player_info.gif" /></a>
          @else <a href="http://www.warofdragons.{{ $case->server }}/user_info.php?nick={{ $case->perpetrator }}" target="_blank"><img src="http://warofdragons.com/images/player_info.gif" /></a>@endif
            @endif
          @endif
        </td>
        @if((Auth::user()->admin == 2) or (Auth::user()->admin == 1))
        <td>
          {!! Form::open(['action' => ['CasesController@delete', $case->id]]) !!}
          <button type="submit" class="btn btn-mini btn-link">{{ trans('actions.delete') }}</button>
          {!! Form::close()!!}
        </td>
        @endif
      </tr>
      @endforeach
    </tbody>
  </table>
  <div class="row">
    <div style="text-align: center;">
      <?php 
        if (isset($no_pagination) and !empty($no_pagination)){
          if ($no_pagination) 
          {} 
        } else {
            echo $cases->render(); 
          }
        
      ?>
    </div>
  </div>
  @else
  <p>No cases found</p>
  @endif
</div>
@endsection
