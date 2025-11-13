@extends('layouts.admin.layout')
@section('title', 'Criar Tipo de Licença')
@section('content')

    <div class="card my-4 shadow">
        <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
            <span><i class="fas fa-file-contract me-2"></i>Novo Tipo de Licença</span>
            <a href="{{ route('leaveType.index') }}" class="btn btn-outline-light btn-sm" title="Ver Todos">
                {{-- Ver --}}
                <i class="fa-solid fa-list"></i>
            </a>
        </div>
        <div class="card-body">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <form method="POST" action="{{ route('leaveType.store') }}">
                        @csrf

                        <div class="mb-3">
                            <div class="form-floating">
                                <input type="text" name="name" placeholder="" class="form-control"
                                    value="{{ old('name') }}" required>
                                <label for="name">Nome</label>
                            </div>
                        </div>


                        <div class="mb-3">
                            <div class="form-floating">
                                <textarea name="description" placeholder="" style="height: 100px;" class="form-control">{{ old('description') }}</textarea>
                                <label for="description">Descrição</label>
                            </div>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-check-circle me-2"></i>Salvar Tipo de Licença
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
