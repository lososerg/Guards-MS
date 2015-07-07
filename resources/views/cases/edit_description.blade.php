<!DOCTYPE html>
<html lang="en">
<head>
  <script src="//tinymce.cachefly.net/4.2/tinymce.min.js"></script>
  <script type="text/javascript">
          tinymce.init({
              plugins: "image link autolink textcolor",
                              default_link_target: "_blank",
                              link_assume_external_targets: true,
                              selector: "#mytextarea",
                              browser_spellcheck : true
          });
   </script>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Editing description of Case #{{ $case->id }}</title>

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
<body>
<div class="row">
    <div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-body">
          
          {!! Form::open(['action' => ['CasesController@updateDescription', $case->id], 'class' => 'form-horizontal']) !!}
          {!! Form::hidden('id', $case->id)!!}
          @if ($errors->any())
            <ul class="alert alert-danger">
              @foreach ($errors->all() as $error)
                <li style="list-style-type: none;">{{ $error }}</li>
              @endforeach
            </ul> 
          @endif
          <div class="form-group">
            <label for="comment" class="col-sm-2 control-label">{{ trans('tables.description') }}</label>
              <div class="col-sm-10">
                {!! Form::textarea('description', $case->description, ['class' => 'form-control', 'rows' => 20, 'id' => 'mytextarea']) !!}
              </div>
          </div>
          <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
              <button type="submit" class="btn btn-default">{{ trans('actions.submit') }}</button>
            </div>
          </div>
          {!! Form::close() !!}
          
				</div>
			</div>
		</div>
  </div>
  </body>
  </html>