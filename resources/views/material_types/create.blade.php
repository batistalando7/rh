@extends('layouts.admin.layout')
@section('title', 'Novo Tipo — ' . ucfirst($category))

@section('content')
    <div class="card mb-4 shadow" style="margin-top: 1.5rem;">
        <div class="card-header bg-secondary text-white">
            <i class="fas fa-tags me-2"></i> Novo Tipo — {{ ucfirst($category) }}
        </div>
        <div class="card-body">
            <div class="row justify-content-center">
                <div class="col-md-6"> {{-- Reduz e centraliza --}}
                    <form action="{{ route('material-types.store', ['category' => $category]) }}" method="POST">
                        @csrf
                        <input type="hidden" name="category" value="{{ $category }}">

                        <div class="mb-3">
                            <div class="form-floating">
                                <input type="text" name="name" placeholder="" class="form-control" required>
                                <label for="name">Nome do Tipo</label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-floating">
                                <textarea name="description" placeholder="" class="form-control" style="height: 100px;"></textarea>
                                <label for="description">Descrição (opcional)</label>
                            </div>
                        </div>

                        <div class="text-center">
                            <button class="btn btn-success">
                                <i class="fas fa-save me-1"></i> Salvar
                            </button>
                            <a href="{{ route('material-types.index', ['category' => $category]) }}"
                                class="btn btn-secondary ms-2">
                                Cancelar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
