@extends('app')

@section('content')
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

<script>  
  var counter = 1;
function addInput(divName, type){
  var newdiv = document.createElement('div');
  if (type == 1) {
    newdiv.innerHTML = "<div class='form-group'><label for='perpetrators[" + type + "][]' class='col-sm-2 control-label'>{{ trans('tables.perpetrator') }} </label> <div class='col-sm-10'> <input class='form-control' name='perpetrators[" + type + "][]' type='text'></div></div>";
    
  } else if (type == 2) {
  
    newdiv.innerHTML = "<div class='form-group'><label for='perpetrators[" + type + "][]' class='col-sm-2 control-label'>{{ trans('tables.donor') }} </label> <div class='col-sm-10'> <input class='form-control' name='perpetrators[" + type + "][]' type='text'></div></div>";
    
  } else if (type == 3) {
  
    newdiv.innerHTML = "<div class='form-group'><label for='perpetrators[" + type + "][]' class='col-sm-2 control-label'>{{ trans('tables.receiver') }} </label> <div class='col-sm-10'> <input class='form-control' name='perpetrators[" + type + "][]' type='text'></div></div>";
    
  } else if (type == 4) {
    
    newdiv.innerHTML = "<div class='form-group'><label for='perpetrators[" + type + "][]' class='col-sm-2 control-label'>{{ trans('tables.hacker') }} </label> <div class='col-sm-10'> <input class='form-control' name='perpetrators[" + type + "][]' type='text'></div></div>";
  
  } else if (type == 5) {
    
    newdiv.innerHTML = "<div class='form-group'><label for='perpetrators[" + type + "][]' class='col-sm-2 control-label'>{{ trans('tables.victim') }} </label> <div class='col-sm-10'> <input class='form-control' name='perpetrators[" + type + "][]' type='text'></div></div>";
  
  }

          document.getElementById(divName).appendChild(newdiv);
          counter++;

  }
</script>
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Opening new case</div>

				<div class="panel-body">
          {!! Form::open(['action' => 'CasesController@store', 'class' => 'form-horizontal']) !!} 
          @if ($errors->any())
            <ul class="alert alert-danger">
              @foreach ($errors->all() as $error)
                <li style="list-style-type: none;">{{ $error }}</li>
              @endforeach
            </ul> 
          @endif
              <div class="form-group">
                <label for="status" class="col-sm-2 control-label">{{ trans('tables.status') }}</label>
                <div class="col-sm-10">
                  {!! Form::select('status', [
                        1 => trans('status.new'),
                        2 => trans('status.in_progress'),
                        3 => trans('status.closed'),
                      ], 1, ['class' => 'form-control']) !!}
                </div>
              </div>
              <div class="form-group">
                <label for="department_id" class="col-sm-2 control-label">{{ trans('tables.department') }}</label>
                <div class="col-sm-10">
                  @if (Auth::user()->department_id == 5)
                  
                  {!! Form::select('department_id', [
                        5 => trans('departments.help'),
                      ], null, ['class' => 'form-control']) !!}
                  
                  @elseif (Auth::user()->helpdesk)
                  
                  {!! Form::select('department_id', [
                        1 => trans('departments.econom'),
                        2 => trans('departments.invest'),
                        3 => trans('departments.operat'),
                        4 => trans('departments.review'),
                        5 => trans('departments.help'),
                      ], null, ['class' => 'form-control']) !!}
                  
                  @else
                  
                  {!! Form::select('department_id', [
                        1 => trans('departments.econom'),
                        2 => trans('departments.invest'),
                        3 => trans('departments.operat'),
                        4 => trans('departments.review'),
                      ], null, ['class' => 'form-control']) !!}
                  
                  @endif
                </div>
              </div>
              <div class="form-group">
                <label for="type" class="col-sm-2 control-label">{{ trans('tables.type') }}</label>
                <div class="col-sm-10">
                  @if (Auth::user()->department_id == 5)
                   
                  {!! Form::select('type', [
                        5 => trans('types.help_quest'),
                        6 => trans('types.help_item'),
                        7 => trans('types.help_client'),
                        8 => trans('types.help_fights'),
                        4 => trans('types.other'),
                      ], null, ['class' => 'form-control']) !!}
                  
                  @elseif (Auth::user()->helpdesk)
                  
                  {!! Form::select('type', [
                        1 => trans('types.power_leveling'),
                        2 => trans('types.autobot'),
                        3 => trans('types.rigged_fights'),
                        9 => trans('types.black_market'),
                        10 => trans('types.account_hack'),
                        5 => trans('types.help_quest'),
                        6 => trans('types.help_item'),
                        7 => trans('types.help_client'),
                        8 => trans('types.help_fights'),
                        4 => trans('types.other'),
                      ], null, ['class' => 'form-control']) !!}
                  
                  @else
                  
                  {!! Form::select('type', [
                        1 => trans('types.power_leveling'),
                        2 => trans('types.autobot'),
                        3 => trans('types.rigged_fights'),
                        9 => trans('types.black_market'),
                        10 => trans('types.account_hack'),
                        4 => trans('types.other'),
                      ], null, ['class' => 'form-control']) !!}
                  
                  @endif
                </div>
              </div>
              <div class="form-group">
                <label for="owner_id" class="col-sm-2 control-label">{{ trans('tables.assigned_to') }}</label>
                <div class="col-sm-10">
                  {!! Form::select('owner_id', $guards, Auth::user()->id, ['class' => 'form-control']) !!}
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                  <div class="checkbox">
                    <label>
                      {!! Form::hidden('admin_attention', 0) !!}
                      {!! Form::checkbox('admin_attention', 1) !!}
                      {{ trans('status.admin_attention') }}
                    </label>
                  </div>
                </div>
          </div>
              <div class="form-group">
                <label for="created_by_id" class="col-sm-2 control-label">{{ trans('tables.opened_by') }}</label>
                <div class="col-sm-10">
                  <p class="form-control-static">
                    <a href="/user/{{ Auth::user()->id }}">{{ Auth::user()->name }}</a>
                  </p>
                </div>
              </div>


          <div id="dynamicInput">
                <div class="form-group">
                  <label for='perpetrators[1][]' class='col-sm-2 control-label'>{{ trans('tables.perpetrator') }} </label> <div class='col-sm-10'> <input class='form-control' name='perpetrators[1][]' type='text'></div>

              </div>
            </div>
          <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
              <a class="btn btn-default btn-xs" href="javascript: addInput('dynamicInput', '1');">
                {{trans('actions.add_perpetrator')}}
              </a>
              
              <a class="btn btn-primary btn-xs" href="javascript: addInput('dynamicInput', '2');">
                {{trans('actions.add_donor')}}
              </a>
              <a class="btn btn-success btn-xs" href="javascript: addInput('dynamicInput', '3');">
                {{trans('actions.add_receiver')}}
              </a>
              <a class="btn btn-info btn-xs" href="javascript: addInput('dynamicInput', '4');">
                {{trans('actions.add_hacker')}}
              </a>
              <a class="btn btn-warning btn-xs" href="javascript: addInput('dynamicInput', '5');">
                {{trans('actions.add_victim')}}
              </a>
              
            </div>
          </div>
                <!-- two end ifs were here-->
              <div class="form-group">
                <label for="status" class="col-sm-2 control-label">{{ trans('tables.description') }}</label>
                <div class="col-sm-10">
                  {!! Form::textarea('description', null, ['class' => 'form-control', 'id' => 'mytextarea']) !!}
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                  <button type="submit" class="btn btn-primary">{{ trans('actions.save') }}</button>
                </div>
              </div>
          {!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
