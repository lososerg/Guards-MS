@extends('app')

@section('content')
<!-- wysihtml core javascript with default toolbar functions --> 
<script src="/dist/wysihtml5x-toolbar.js"></script>

<!-- rules defining tags, attributes and classes that are allowed -->
<script src="/parser_rules/advanced_and_extended.js"></script>
<script>

  function editDescription(id)
  {
    window.open("/description/edit/" + id,"mywindow4","menubar=no,resizable=yes,location=no,width=900,height=600");
  }
  function editComment(id)
  {
    window.open("/comment/edit/" + id,"mywindow3","menubar=no,resizable=yes,location=no,width=900,height=600");
  }

  function destroy(id)
  {
    window.open("/perpetrator/edit/" + id,"mywindow2","menubar=no,resizable=no,location=no,width=300,height=300");

  }
  function addPenalty(perp_id)
  {
    var id = perp_id;
    window.open("/penalty/create/" + id,"mywindow2","menubar=no,resizable=no,location=no,width=300,height=300");
  }

  function editPenalty(id)
  {

    window.open("/penalty/edit/" + id,"mywindow2","menubar=no,resizable=no,location=no,width=300,height=300");
  }
 
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
				<div class="panel-heading">
          {{ trans('menu.case') }} #{{ $case->id }} {{ trans('menu.opened') }}: {{ $case->created_at }} {{ trans('menu.updated') }} {{ $case->updated_at }}
        </div>
				<div class="panel-body">
          {!! Form::open(['action' => ['CasesController@update', $case->id], 'class' => 'form-horizontal']) !!} 
          {!! Form::hidden('id', $case->id) !!}
              <div class="form-group">
                <label for="status" class="col-sm-2 control-label">
                  {{ trans('tables.status') }}
                </label>
                <div class="col-sm-10">
                  {!! Form::select('status', [
                        1 => trans('status.new'),
                        2 => trans('status.in_progress'),
                        3 => trans('status.closed'),
                      ], $case->status, ['class' => 'form-control']) !!}
                </div>
              </div>
              <div class="form-group">
                <label for="department_id" class="col-sm-2 control-label">{{ trans('tables.department') }}</label>
                <div class="col-sm-10">
                   @if (Auth::user()->department_id == 5)
                  
                  {!! Form::select('department_id', [
                        5 => trans('departments.help'),
                      ], $case->department_id, ['class' => 'form-control']) !!}
                  
                  @elseif (Auth::user()->helpdesk)
                  
                  {!! Form::select('department_id', [
                        1 => trans('departments.econom'),
                        2 => trans('departments.invest'),
                        3 => trans('departments.operat'),
                        4 => trans('departments.review'),
                        5 => trans('departments.help'),
                      ], $case->department_id, ['class' => 'form-control']) !!}
                  
                  @else
                  
                  {!! Form::select('department_id', [
                        1 => trans('departments.econom'),
                        2 => trans('departments.invest'),
                        3 => trans('departments.operat'),
                        4 => trans('departments.review'),
                      ], $case->department_id, ['class' => 'form-control']) !!}
                  
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
                      ], $case->type, ['class' => 'form-control']) !!}
                  
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
                      ], $case->type, ['class' => 'form-control']) !!}
                  
                  @else
                  
                  {!! Form::select('type', [
                        1 => trans('types.power_leveling'),
                        2 => trans('types.autobot'),
                        3 => trans('types.rigged_fights'),
                        9 => trans('types.black_market'),
                        10 => trans('types.account_hack'),
                        4 => trans('types.other'),
                      ], $case->type, ['class' => 'form-control']) !!}
                  
                  @endif
                </div>
              </div>
              <div class="form-group">
                <label for="owner_id" class="col-sm-2 control-label">{{ trans('tables.assigned_to') }}</label>
                <div class="col-sm-10">
                  {!! Form::select('owner_id', $guards, $case->owner_id, ['class' => 'form-control']) !!}
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                  <div class="checkbox">
                    <label>
                      {!! Form::hidden('admin_attention', 0) !!}
                      {!! Form::checkbox('admin_attention', 1, $case->admin_attention) !!}
                      {{ trans('status.admin_attention') }}
                    </label>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="created_by_id" class="col-sm-2 control-label">
                  {{ trans('tables.opened_by') }}
                </label>
                <div class="col-sm-10">
                  <p class="form-control-static">
                    <a href="/user/{{ $case->created_by_id }}">{{ \App\User::find($case->created_by_id)->name }}</a>
                  </p>
                </div>
              </div>
          
             
              @if (isset($perpetrators) and !empty($perpetrators)) 
          <?php 
            $types = [
              0 => "perpetrator",
              1 => "perpetrator",
              2 => "donor",
              3 => "receiver",
              4 => "hacker",
              5 => "victim",
            ];
          ?>
          
          @foreach ($types as $k => $v)

                    @foreach ($perpetrators as $perp)
                    
                      @if ($perp->type == $k) 
                  <div class="form-group">
                    <label for="perpetrator" id="perpetrators" class="col-sm-2 control-label">
                      {{ trans('tables.' . $v) }}
                    </label>
                    <div class="col-sm-10">
                      <p class="form-control-static">
                        {{ $perp->name }}
                      @if (($case->server == 'w1') or ($case->server == 'w2')) 
                        <a href="http://{{ $perp->server }}.dwar.ru/user_info.php?nick={{ $perp->name }}" target="_blank">
                          <img src="http://warofdragons.com/images/player_info.gif" /></a> <a href="http://{{ $perp->server }}.dwar.ru/logserv/logserv.php?nick={{ $perp->name }}" target="_blank">[LS]</a>
                      @elseif ($case->server == '3k')
                        <a href="http://{{ $perp->server }}.mail.ru/user_info.php?nick={{ $perp->name }}" target="_blank">
                          <img src="http://warofdragons.com/images/player_info.gif" /></a> <a href="http://{{ $perp->server }}.mail.ru/logserv/logserv.php?nick={{ $perp->name }}" target="_blank">[LS]</a>
                      @else
                        <a href="http://www.warofdragons.{{ $perp->server }}/user_info.php?nick={{ $perp->name }}" target="_blank">
                          <img src="http://warofdragons.com/images/player_info.gif" /></a> <a href="http://warofdragons.{{ $perp->server }}/logserv/logserv.php?nick={{ $perp->name }}" target="_blank">[LS]</a>
                      @endif
                      <a href="javascript: destroy({{ $perp->id}});">[{{ trans('actions.delete')}}]</a>
                      {{-- Form::open(['action' => ['PenaltyController@destroy', $perp->id], 'style' => 'display: inline-block']) !!}
                                            <button type="submit" class="btn btn-mini btn-link">{{ trans('actions.delete') }}</button>
                                            {!! Form::close() --}}
                      @if (!$perp->penalty) 
                        <a href="javascript: addPenalty({{ $perp->id}});">[{{ trans('actions.add_penalty')}}]</a>
                      @else 
                        @if ($perp->penalty->type == 1)
                          {{ trans('types.captivity') }}
                        @elseif ($perp->penalty->type == 2)
                          {{ trans('types.poverty') }}
                        @elseif ($perp->penalty->type == 3)
                          {{ trans('types.rejection') }}
                        @endif
                    
                        @if ($perp->penalty->fine > 0)
                          @if ($perp->penalty->currency == 2)
                            @if ($perp->server == '3k')
                              <img src="http://3k.mail.ru/images/m_dmd.gif">
                            @else
                              <img src="http://warofdragons.com/images/m_dmd.gif" />
                            @endif
                          @elseif($perp->penalty->currency == 1)
                            @if ($perp->server == '3k')
                              <img src="http://3k.mail.ru/images/m_game.gif">
                            @else
                              <img src="http://warofdragons.com/images/m_game3.gif" />
                            @endif
                          @endif
                      
                          @if (($perp->penalty->fine >=100) and ($perp->penalty->currency == 1))
                            {{ number_format($perp->penalty->fine/100, 0, null, "") }}
                          @else
                            {{ $perp->penalty->fine }}
                          @endif
                        @else
                        @endif
                        <a href="javascript: editPenalty({{ $perp->penalty->id }});">[{{ trans('actions.edit')}}]</a>
                   
                      @endif </p>
                      </div>
                    </div>
          @endif
                    @endforeach

          
          @endforeach
                      
              @endif
                  
                  @if (isset($case->perpetrator) and !empty($case->perpetrator))
                  <div class="form-group">
                    <label for="perpetrator" id="perpetrators" class="col-sm-2 control-label">
                      {{ trans('tables.perpetrator') }}
                    </label>
                  <div class="col-sm-10">
                  <p class="form-control-static">{{ $case->perpetrator }} 
                    @if (($case->server == 'w1') or ($case->server == 'w2')) 
                    <a href="http://{{ $case->server }}.dwar.ru/user_info.php?nick={{ $case->perpetrator }}" target="_blank"><img src="http://warofdragons.com/images/player_info.gif" /></a> <a href="http://{{ $case->server }}.dwar.ru/logserv/logserv.php?nick={{ $case->perpetrator }}" target="_blank">[LS]</a>
                    @else<a href="http://www.warofdragons.{{ $case->server }}/user_info.php?nick={{ $case->perpetrator }}" target="_blank"><img src="http://warofdragons.com/images/player_info.gif" /></a> <a href="http://warofdragons.{{ $case->server }}/logserv/logserv.php?nick={{ $case->perpetrator }}" target="_blank">[LS]</a>@endif</p>
                  </div>
                  </div>
                  @endif
                
              

          <div id="dynamicInput">
                <div class="form-group">
                <label for="perpetrators[1][]" class="col-sm-2 control-label">{{ trans('tables.perpetrator') }}</label>
                  <div class='col-sm-10'> <input class='form-control' name='perpetrators[1][]' type='text'></div>
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
          

              @if ((isset($case->fine) and !empty($case->fine)) and (isset($case->currency) and !empty($case->currency)))
              @else

              @endif
          @if ((isset($case->fine) and !empty($case->fine)) and (isset($case->currency) and !empty($case->currency)))
              <div class="form-group">
                <label for="fine" class="col-sm-2 control-label">{{ trans('tables.fine') }}</label>
                <div class="col-sm-3">
                  @if (isset($case->fine) and !empty($case->fine))
                  <p class="form-control-static">
                    @if ($case->currency == 2)
                      <img src="http://warofdragons.com/images/m_dmd.gif" />
                    @elseif($case->currency == 1)
                      @if ($case->fine >= 100)
                        <img src="http://warofdragons.com/images/m_game3.gif" />
                      @else
                        <img src="http://warofdragons.com/images/m_game2.gif" />
                      @endif
                    @endif
                    @if (($case->fine >=100) and ($case->currency == 1))
                    {{ number_format($case->fine/100, 0, null, "") }}
                    @else
                    {{ $case->fine }}
                    @endif
                    {{--<script>
                    
                      
function openwindow()
{
	window.open("/edit_fine/{{ $case->id }}","mywindow","menubar=no,resizable=no,location=no,width=250,height=230");
}

                    
                    </script>
                    <a href="javascript: openwindow()">[{{ trans('actions.edit') }}]</a>
                  </p>--}}
                  @else
                  {{-- Form::text('fine', $case->fine, ['class' => 'form-control']) --}}
                  @endif
                </div>
              </div>
          @endif
              <div class="form-group">
                <label for="status" class="col-sm-2 control-label">{{ trans('tables.description') }}</label>
                <div class="col-sm-10">
                  @if (!empty($case->description) and isset($case->description))
                  <div class="form-control-static"><?= $case->description ?></div>
                  @if (($case->created_by_id === Auth::user()->id) or
                                     ($case->owner_id === Auth::user()->id) or
                                     (Auth::user()->admin))
                                      <a href="javascript: editDescription({{ $case->id }});">[{{ trans('actions.edit_description') }}]</a>
                                    @endif
                  @else 
                  {!! Form::textarea('description', $case->description, ['class' => 'form-control']) !!}
                  @endif
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
  @if ($case->comments->count())
  <?php $comments = $case->comments->reverse(); ?>
  @foreach ($comments as $comment)
  @include('comments.one')
  @endforeach
  @endif
  
  <div class="row">
    <div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-body">
          
          {!! Form::open(['action' => 'CommentController@store', 'class' => 'form-horizontal']) !!}
          
          @if ($errors->any())
            <ul class="alert alert-danger">
              @foreach ($errors->all() as $error)
                <li style="list-style-type: none;">{{ $error }}</li>
              @endforeach
            </ul> 
          @endif
          {!! Form::hidden('case_id', $case->id) !!}
          <div class="form-group">
            <label for="comment" class="col-sm-2 control-label">{{ trans('tables.comment') }}</label>
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
                
                {!! Form::textarea('comment', null, ['class' => 'form-control', 'rows' => 3, 'id' => 'wysihtml-textarea']) !!}
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
</div>
<script>
var editor = new wysihtml5.Editor("wysihtml-textarea", { // id of textarea element
  toolbar:      "wysihtml-toolbar", // id of toolbar element
  parserRules:  wysihtml5ParserRules // defined in parser rules set 
});
</script>
@endsection