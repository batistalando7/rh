@extends('layouts.admin.layout')
@section('title','Categorias de Carta')
@section('content')

<div class="card mb-4 shadow">
  <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
    <span><i class="fas fa-tags me-2"></i>Categorias de Carta</span>
    <div>
      <a href="{{ route('licenseCategories.create') }}" class="btn btn-outline-light btn-sm">
        <i class="fas fa-plus-circle"></i> Nova
      </a>
    </div>
  </div>

  <div class="card-body">
    @if(session('msg'))
      <div class="alert alert-success">{{ session('msg') }}</div>
    @endif

    @if($categories->count())
      <div class="table-responsive">
        <table id="datatablesSimple" class="table table-striped table-hover">
          <thead>
            <tr>
              <th>ID</th>
              <th>Nome</th>
              <th>Descrição</th>
              <th style="width: 58px;">Ação</th>
            </tr>
          </thead>
          <tbody>
            @foreach($categories as $licenseCategory)
              <tr>
                <td>{{ $licenseCategory->id }}</td>
                <td>{{ $licenseCategory->name }}</td>
                <td>{{ Str::limit($licenseCategory->description, 50) }}</td>
                <td>
                  <a href="{{ route('licenseCategories.edit', $licenseCategory->id) }}"
                     class="btn btn-info btn-sm" title="Editar">
                    <i class="fas fa-pencil"></i>
                  </a>
                  <a href="#"
                     data-url="{{ route('licenseCategories.delete', $licenseCategory->id) }}"
                     class="btn btn-danger btn-sm delete-btn" title="Apagar">
                    <i class="fas fa-trash"></i>
                  </a>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    @else
      <p class="text-center">Nenhuma categoria cadastrada.</p>
    @endif
  </div>
</div>

@endsection
