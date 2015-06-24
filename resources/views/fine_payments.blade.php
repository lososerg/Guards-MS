@extends('app')

@section('content')
<h3>COM</h3>
<ul>
  <li>Обработано нарушителей: {{ $handled_perpetrators_count['com'] }}</li>
  <li>С ошибкой в нике {{ $failed_users_count['com'] }}</li>
  <li>Со штрафом в золоте (всего) {{ $had_penalty['com'] }}</li>
  <li>Со штрафом в золоте (сейчас) {{ $have_penalty['com'] }}</li>
  <li>Освободились: {{ $free['com'] }}</li>
  <li>Заплачено золота: {{ $gold_paid['com'] / 100 }}</li>
</ul>

-<h3>DE</h3>
<ul>
<li>Обработано нарушителей: {{ $handled_perpetrators_count['de'] }}</li>
<li>С ошибкой в нике {{ $failed_users_count['de'] }}</li>
<li>Со штрафом в золоте (всего) {{ $had_penalty['de'] }}</li>
<li>Со штрафом в золоте (сейчас) {{ $have_penalty['de'] }}</li>
<li>Освободились: {{ $free['de'] }}</li>
<li>Заплачено золота: {{ $gold_paid['de'] / 100 }}</li>
</ul>
<h3>PL</h3>
<ul>
<li>Обработано нарушителей: {{ $handled_perpetrators_count['pl'] }}</li>
<li>С ошибкой в нике {{ $failed_users_count['pl'] }}</li>
<li>Со штрафом в золоте (всего) {{ $had_penalty['pl'] }}</li>
<li>Со штрафом в золоте (сейчас) {{ $have_penalty['pl'] }}</li>
<li>Освободились: {{ $free['pl'] }}</li>
<li>Заплачено золота: {{ $gold_paid['pl'] / 100 }}</li>
</ul>
<h3>W1</h3>
<ul>
<li>Обработано нарушителей: {{ $handled_perpetrators_count['w1'] }}</li>
<li>С ошибкой в нике {{ $failed_users_count['w1'] }}</li>
<li>Со штрафом в золоте (всего) {{ $had_penalty['w1'] }}</li>
<li>Со штрафом в золоте (сейчас) {{ $have_penalty['w1'] }}</li>
<li>Освободились: {{ $free['w1'] }}</li>
<li>Заплачено золота: {{ $gold_paid['w1'] / 100 }}</li>
</ul>
<h3>W2</h3>
<ul>
<li>Обработано нарушителей: {{ $handled_perpetrators_count['w2'] }}</li>
<li>С ошибкой в нике {{ $failed_users_count['w2'] }}</li>
<li>Со штрафом в золоте (всего) {{ $had_penalty['w2'] }}</li>
<li>Со штрафом в золоте (сейчас) {{ $have_penalty['w2'] }}</li>
<li>Освободились: {{ $free['w2'] }}</li>
<li>Заплачено золота: {{ $gold_paid['w2'] / 100 }}</li>
</ul>

@endsection