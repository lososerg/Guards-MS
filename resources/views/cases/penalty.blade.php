<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Editing penalty</title>

	<link href="{{ asset('/css/app.css') }}" rel="stylesheet">

	<!-- Fonts -->
	<link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
{!! Form::open(['action' => 'PenaltyController@store']) !!}
  {!! Form::hidden('perpetrator_id', $id)!!}
<div class="form-group">
  <label for="type" class="col-sm-2 control-label">Curse Type</label>
  <div class="col-sm-2">
    {!! Form::select('type', [
                       1 => trans('types.captivity'),
                        2 => trans('types.poverty'),
                        3 => trans('types.rejection')
                      ], null, ['class' => 'form-control']) !!}
  </div>
</div>  
  
<div class="form-group">
  <label for="currency" class="col-sm-2 control-label">{{ trans('tables.currency') }}</label>
  <div class="col-sm-2">
    {!! Form::select('currency', [
                        1 => trans('tables.coins'),
                        2 => trans('tables.diamonds'),
                      ], null, ['class' => 'form-control']) !!}
  </div>
</div>
<div class="form-group">
  <label for="fine" class="col-sm-2 control-label">{{ trans('tables.fine') }}</label>
  <div class="col-sm-2">{!! Form::text('fine', null, ['class' => 'form-control']) !!}</div>
</div>
<div class="form-group">
  <div class="col-sm-offset-2 col-sm-10">
    <button type="submit" class="btn btn-default">{{ trans('actions.submit') }}</button>
  </div>
</div>
{!! Form::close() !!}