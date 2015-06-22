<!DOCTYPE html>
<html lang="en">
<head>
  <!-- wysihtml core javascript with default toolbar functions -->
  <script src="/dist/wysihtml5x-toolbar.js"></script>

  <!-- rules defining tags, attributes and classes that are allowed -->
  <script src="/parser_rules/advanced_and_extended.js"></script>
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
                <div id="wysihtml-toolbar" style="display: none;">
                    <button data-wysihtml5-command="bold" title="CTRL+B" type="button" class="btn btn-default" aria-label="Bold">
                      <span class="glyphicon glyphicon-bold" aria-hidden="true"></span>
                    </button>
                    <button data-wysihtml5-command="italic" title="CTRL+I" type="button" class="btn btn-default" aria-label="Italic">
                      <span class="glyphicon glyphicon-italic" aria-hidden="true"></span>
                    </button>
                    <button data-wysihtml5-command="createLink" type="button" class="btn btn-default" aria-label="Italic">
                      <span class="glyphicon glyphicon-link" aria-hidden="true"></span>
                    </button>
                    <button data-wysihtml5-command="insertUnorderedList" type="button" class="btn btn-default" aria-label="Italic">
                      <span class="glyphicon glyphicon-list" aria-hidden="true"></span>
                    </button>
                    <button data-wysihtml5-action="change_view" type="button" class="btn btn-default" aria-label="Italic">
                      <span class="glyphicon glyphicon-header" aria-hidden="true"></span>
                    </button>
                    <div data-wysihtml5-dialog="createLink" style="display: none;">
                      <label>
                        Link:
                        <input data-wysihtml5-dialog-field="href" value="http://">
                      </label>
                      <a data-wysihtml5-dialog-action="save">OK</a>&nbsp;<a data-wysihtml5-dialog-action="cancel">Cancel</a>
                    </div>

                  </div>
                
                {!! Form::textarea('description', $case->description, ['class' => 'form-control', 'rows' => 20, 'id' => 'wysihtml-textarea']) !!}
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
  <script>
  var editor = new wysihtml5.Editor("wysihtml-textarea", { // id of textarea element
    toolbar:      "wysihtml-toolbar", // id of toolbar element
    parserRules:  wysihtml5ParserRules // defined in parser rules set
  });
  </script>
  </body>
  </html>