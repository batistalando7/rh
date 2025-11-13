@extends('layouts.admin.layout')
@section('title', 'Visualizar Tipo de Licença')
@section('content')

<div class="card my-4 shadow">
  <div class="card-header bg-secondary text-white">
    <span><i class="fas fa-eye me-2"></i>Detalhes do Tipo de Licença</span>
    <a href="{{ route('leaveType.index') }}" class="btn btn-outline-light btn-sm" title="Listagem">
      <i class="fa-solid fa-list"></i>
    </a>
  </div>
  <div class="card-body">
    <table class="table table-bordered">
      <tr>
        <th>ID</th>
        <td>{{ $data->id }}</td>
      </tr>
      <tr>
        <th>Nome</th>
        <td>{{ $data->name }}</td>
      </tr>
      <tr>
        <th>Descrição</th>
        <td>{{ $data->description ?? '-' }}</td>
      </tr>
    </table>
  </div>
</div>

@endsection
