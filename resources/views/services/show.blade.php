@extends('layouts.app')

@section('content')
<h1 class="">Service {{ $service->id }}</h1>
<hr>
<fieldset>
    <input class="form-control form-control-lg" type="text" placeholder="Date" name="input" id="input">
    <div class="btn-group" data-toggle="buttons">
      <label class="btn btn-outline-primary btn-lg">
        <input type="radio" autocomplete="off"> Jour
      </label>
      <label class="btn btn-outline-primary btn-lg">
        <input type="radio" autocomplete="off"> Soir
      </label>
    </div>
</fieldset>
<form action="">
    <input type="hidden" name="timestamp" value="">
    <button type="submit" class="btn btn-default">button</button>
</form>


@endsection