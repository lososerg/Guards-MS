@extends('app')

@section('content')
<div class="container">
<h3>Invalid usernames</h3>
<table class="table table-hover">
  <thead>
    <th>Date</th>
    <th>Server</th>
    <th>Perpetrator ID</th>
    <th>Name</th>
    <th>Case ID</th>
  </thead>
  <tbody>
  @if(isset($failed) && !empty($failed))
    @foreach($failed as $f)
        <tr>
          <td>{{ $f->date }}</td>
          <td>{{ $f->server }}</td>
          <td>{{ $f->perp_id }}</td>
          <td>{{ $f->perp_name }}</td>
          <td><a href="http://ruslan.msk.ru/case/{{ $f->case_id }}">{{ $f->case_id }}</a></td>
        </tr>
        @endforeach
  @else
  <span>No data</span>
  @endif
  </tbody>
</table>
<br />
<hr>
<br />
<h3>Freed users</h3>
<table class="table table-hover">
  <thead>
    <th>Date</th>
    <th>Server</th>
    <th>Perpetrator ID</th>
    <th>Name</th>
    <th>Case ID</th>
    <th>Gold Paid</th>
  </thead>
  <tbody>
  @if(isset($freed) && !empty($freed))
      @foreach($freed as $fr)
          <tr>
            <td>{{ $fr->date }}</td>
            <td>{{ $fr->server }}</td>
            <td>{{ $fr->perp_id }}</td>
            <td>{{ $fr->perp_name }}</td>
            <td><a href="http://ruslan.msk.ru/case/{{ $fr->case_id }}">{{ $fr->case_id }}</a></td>
            <td>{{ $fr->gold_paid }}</td>
          </tr>
          @endforeach
    @else
    <span>No data</span>
    @endif
  </tbody>
</table>
</div>
@endsection