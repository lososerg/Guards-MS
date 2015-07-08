@extends('app')

@section('content')
<div class="container">
<table class="table table-hover">
  <thead>
    <th>Date</th>
    <th>Server</th>
    <th>Perpetrators</th>
    <th>Failed</th>
    <th>With fines (Total)</th>
    <th>With fines (to date)</th>
    <th>Freed</th>
    <th>Gold paid</th>
    <th>Total Cases</th>
  </thead>
  <tbody>
    @foreach($reports as $r)
    <tr>
      <td><a href="/stats/daily/{{ $r->id }}">{{ $r->date }}</a></td>
      <td>{{ $r->server }}</td>
      <td>{{ $r->total_checked }}</td>
      <td>{{ $r->total_failed }}</td>
      <td>{{ $r->total_with_penalty }}</td>
      <td>{{ $r->with_penalty_now }}</td>
      <td>{{ $r->free }}</td>
      <td>{{ $r->paid_gold/100 }}</td>
      <td>{{ $r->total_cases }}</td>
    </tr>
    @endforeach
  </tbody>
</table>
</div>
@endsection