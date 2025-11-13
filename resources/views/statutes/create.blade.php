@extends('layouts.admin.layout')
@section('title', 'Criar Estatuto')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card my-4 shadow">
                    <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
                        <span><i class="fas fa-file-earmark-text me-2"></i>Novo Estatuto</span>
                        <a href="{{ route('statutes.index') }}" class="btn btn-outline-light btn-sm" title="Voltar">
                            <i class="fas fa-arrow-left"></i> Voltar
                        </a>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('statutes.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" placeholder="" name="title" id="title"
                                        required>
                                    <label for="title">Título do Estatuto</label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="form-floating">
                                    <textarea class="form-control" name="description" placeholder="" style="height: 100px;" id="description" rows="5"
                                        required></textarea>
                                    <label for="description">Descrição</label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="form-floating">
                                    <input type="file" class="form-control" name="document" id="document">
                                    <label for="document" style="margin-top: -8px">Documento</label>
                                </div>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-check-circle"></i> Salvar Estatuto
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
