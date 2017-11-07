@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Services</div>

                <div class="panel-body">
                    @foreach ($services as $service)
                        <h4>Date</h4>
                        <p>{{ $service->pretty_date }} - {{$service->date_type }}</p>

                        <h4>Etat</h4>
                        <p>{{ $service->etat }}</p>

                        <h4>Bonus</h4>
                        <p>{{ $service->calcBonus() }}</p>

                        <h4>Respo</h4>
                        <p>{{ $service->user->username }}</p>

                        <h4>Ekip</h4>
                        {{ $service->horaires->count() }}

                        <h4>Bar</h4>
                        {{ $service->horaires('bar')->count() }}

                        <h4>Cuisine</h4>
                        {{ $service->horaires('cuisine')->count() }}

                        <h4>Chiffre</h4>
                        <p>{{ $service->caisse->chiffre() }}</p>

                        <h4>Avances</h4>
                        @foreach ($service->caisse->getAvances() as $avance)
                            <p>{{ \App\User::find($avance->qui)->username }} - {{ $avance->value }} €</p>
                        @endforeach

                        <h4>Remarques</h4>
                        @foreach ($service->comments as $comment)
                            <p>{{ $comment->getType()->name }} : {{ $comment->content }}</p>
                        @endforeach

                        <hr>
                    @endforeach
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
