@extends('app')

@section('content')
<div class="container">
  @if (Auth::user()->language == 'ru')
  <h4><a name="q-how-to-open-a-new-case" href="#q-what-is-guards-ms">Что такое Guards MS?</a></h4>
  <p>Guards MS (Guards Management System) &ndash; это веб приложение, которое вы можете использовать, чтобы отслеживать прогресс в ваших текущих делах и вести учет завершенных дел. Приложение создано с целью сделать работу Стражей более простой и организованной.</p>
  <h4><a name="q-how-to-open-a-new-case" href="#q-how-to-open-a-new-case">Как открыть новое дело?</a></h4>
  <p>Чтобы открыть новое дело кликните на ваше имя в правом верхнем углу. В выпадающем меню выберите "Открыть дело". Вас перебросит на страницу создания дела.</p>
  
  <h4><a name="q-how-to-bring-a-case-to-admin-attention" href="#q-how-to-bring-a-case-to-admin-attention">Как привлечь внимание администратора к делу?</a></h4>
  <p>Кликните на ID дела в списке дел. Вы окажетесь на станице редактирования дела. Отметьте галку "Требует внимания администратора". Нажмите "Сохранить".</p>
  @else
  <h4><a name="q-how-to-open-a-new-case" href="#q-what-is-guards-ms">What is Guards MS?</a></h4>
  <p>Guards MS (Guards Management System) is a web app that you can use to track progress of your ongoing cases and keep record of closed ones. It was built to make work of Guards more easy and organized.</p>
  <h4><a name="q-how-to-open-a-new-case" href="#q-how-to-open-a-new-case">How to open a new case?</a></h4>
  <p>In order to open a new case click on your username in the top right corner, and then on "Open Case". You'll be redirected to case creation page.</p>
  <h4><a name="q-how-to-bring-a-case-to-admin-attention" href="#q-how-to-bring-a-case-to-admin-attention">How to bring a case to admin attention?</a></h4>
  <p>Click on Case ID in the list of cases, you'll be redirected to Case Editing form. Check "Requires admin attention" option. Click "Save".</p>
  @endif
</div>
@endsection
