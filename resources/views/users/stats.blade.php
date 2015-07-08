<?php
  $all_created = App\Http\Controllers\CasesController::countTotalCreatedCases();
  $all_new = App\Http\Controllers\CasesController::countTotalCases(1);
  $all_in_progress = App\Http\Controllers\CasesController::countTotalCases(2);
  $all_closed = App\Http\Controllers\CasesController::countTotalCases(3);
  $all_total = $all_new + $all_in_progress + $all_closed;
  $all_new_share = @(number_format((($all_new/$all_total)*100), 1)).'%';
  $all_in_progress_share = @(number_format((($all_in_progress/$all_total)*100), 1)).'%';
  $all_closed_share = @(number_format((($all_closed/$all_total)*100), 1)).'%';
  $fines_coins = App\Http\Controllers\CasesController::calculateGivenFines()[0];
  $fines_diamonds = App\Http\Controllers\CasesController::calculateGivenFines()[1];
?>

@extends('app')

@section('content')
<div class="container">
  <p class="text-primary">Stats for the last <b>7 days:</b></p>
  <ul style="list-style-type: none;" class="text-primary">
    <li>{{ trans('status.new') }} - <b>{{ $all_new }}</b> <em>({{ $all_new_share }})</em>,</li>
    <li>{{ trans('status.in_progress') }} - <b>{{ $all_in_progress }}</b> <em>({{ $all_in_progress_share }})</em>,</li>
    <li>{{ trans('status.closed') }} - <b>{{ $all_closed }}</b> <em>({{ $all_closed_share }})</em>,</li>
    <li>Total - <b>{{ $all_total }}</b>,</li>
    <li>Created - <b>{{ $all_created }}</b>.</li>
    <li>Fines issued: @if (Auth::user()->server == '3k') <img src="http://3k.mail.ru/images/m_game.gif"> @else<img src="http://warofdragons.com/images/m_game3.gif" />@endif @if($fines_coins >= 100) {{ number_format($fines_coins/100, 0, null, "") }} @else {{ $fines_coins}}  @endif, @if (Auth::user()->server == '3k') <img src="http://3k.mail.ru/images/m_dmd.gif"> @else<img src="http://warofdragons.com/images/m_dmd.gif" />@endif {{ $fines_diamonds }}.</li>
  </ul>
  <p><a href="/stats/list">Go to <b>Daily Stats</b></a></p>
	<table class="table table-condensed table-hover">
    <thead>
      <tr>
        <th class="header">ID</th>
        <th class="header">{{ trans('tables.name') }}</th>
        <th class="header">{{ trans('tables.department') }}</th>
        <th class="header">{{ trans('tables.rank') }}</th>
        <th class="header">{{ trans('status.new') }}</th>
        <th class="header">{{ trans('status.in_progress') }}</th>
        <th class="header">{{ trans('status.closed') }}</th>
        <th class="header">Created</th>
        <th class="header">Fines issued</th>
        <th class="header">Fines issued</th>
      </tr>
    </thead>
    <tbody>
      @foreach($users as $user)
      <?php $new = App\Http\Controllers\CasesController::countCases($user->id, 1);
            $in_progress = App\Http\Controllers\CasesController::countCases($user->id, 2);
            $closed = App\Http\Controllers\CasesController::countCases($user->id, 3);
            $created = App\Http\Controllers\CasesController::countCreatedCases($user->id);
            $fines_coins =App\Http\Controllers\CasesController::fineAmountDistributionCases($user->id)[0];
            $fines_diamonds =App\Http\Controllers\CasesController::fineAmountDistributionCases($user->id)[1];
      ?>
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
          @if (($user->server == 'w1') or ($user->server == 'w2')) 
              <a href="http://{{ $user->server }}.dwar.ru/user_info.php?nick={{ $user->name }}" target="_blank"><img src="http://warofdragons.com/images/player_info.gif"></a>
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
          <a href="show/user/cases/new/{{ $user->id }}">{{ $new }}</a>
        </td>
        <td><a href="show/user/cases/inprogress/{{ $user->id }}">{{ $in_progress }}</a></td>
        <td><a href="show/user/cases/closed/{{ $user->id }}">{{ $closed }}</a></td>
        <td><a href="show/user/cases/created/{{ $user->id }}">{{ $created }}</a></td>
        <td>@if (Auth::user()->server == '3k') <img src="http://3k.mail.ru/images/m_game.gif"> @else<img src="http://warofdragons.com/images/m_game3.gif" />@endif @if($fines_coins >= 100) {{ number_format($fines_coins/100, 0, null, "") }} @else {{ $fines_coins}}  @endif</td>
        <td>@if (Auth::user()->server == '3k') <img src="http://3k.mail.ru/images/m_dmd.gif"> @else<img src="http://warofdragons.com/images/m_dmd.gif" />@endif {{ $fines_diamonds }}</td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endsection
