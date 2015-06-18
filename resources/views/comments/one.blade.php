<div class="row">
  <div class="col-md-10 col-md-offset-1">
		<div class="panel panel-default">
      <?php $user = \App\User::find($comment->author_id); ?>
		  <div class="panel-body @if($user->admin == 2) bg-info @endif">
        <div class="row">
          <label for="name" class="col-sm-2 control-label">{{ trans('menu.author') }}</label>
            <div class="col-sm-10">
              
              
              @if ($user->race == 'h')
              <img src='http://warofdragons.com/images/data/clans/strazhum3.gif'/>
              @elseif ($user->race == 'm')
              <img src='http://warofdragons.com/images/data/clans/v0.gif'>
              @else
              @endif
            <a href="/user/{{ $user->id }}">{{ $user->name }}</a>
              @if ($user->server == 'w1' or $user->server == 'w2')
              <a href="http://{{ $user->server }}.dwar.ru/user_info.php?nick={{ $user->name }}" target="_blank"><img src="http://warofdragons.com/images/player_info.gif" /></a>
              @else
            <a href="http://www.warofdragons.com/user_info.php?nick={{ $user->name }}" target="_blank"><img src="http://warofdragons.com/images/player_info.gif" /></a>
              @endif
            </div>
        </div>
        <div class="row">
          <label for="created_at" class="col-sm-2 control-label">{{ trans('menu.added_on') }}</label>
          <div class="col-sm-10">
            {{ $comment->created_at }}
          </div>
        </div>
        <div class="row">
          <label for="comment" class="col-sm-2 control-label">{{ trans('tables.comment') }}</label>
            <div class="col-sm-10">
              {!! $comment->text !!}
            </div>
        </div>
        
		  </div>
		</div>
  </div>
</div>

