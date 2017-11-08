@extends('layouts.app')

@section('content')
<h1 class="">Services</h1>
<hr>
<div class="card text-center">
  <div class="card-header">
    <ul class="nav nav-pills card-header-pills">
      <li class="nav-item">
        <a class="nav-link active" href="#">Active</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Link</a>
      </li>
      <li class="nav-item">
        <a class="nav-link disabled" href="#">Disabled</a>
      </li>
    </ul>
  </div>
  <div class="card-body">
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
                        <th>{{ $service->pretty_date }}</th>
                        <td>{{ ucfirst($service->date_type) }}</td>
                        <td>{{ $service->user->name }}</td>
                        <td>{{ $service->caisse->chiffre() }} €</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
  </div>
</div>

@endsection
