@extends('layouts.app')

@section('content')
<h1 class="">Services</h1>
<hr>
<table class="table table-striped table-sm">
    <thead class="thead-light">
        <tr>
            <th>Service du</th>
            <th>J/S</th>
            <th>Respo</th>
            <th>Chiffre</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($services as $service)
            <tr>
                <th><a href="/{{$service->id}}">{{ $service->pretty_date }}</a></th>
                <td>{{ ucfirst($service->date_type) }}</td>
                <td>{{ $service->user->name }}</td>
                <td>{{ $service->caisse->chiffre() }} €</td>
            </tr>
        @endforeach
    </tbody>
</table>


@endsection
