@extends('layouts.admin.layout')
@section('title', 'Administradores')
@section('content')
    <div class="card mb-4 shadow">
        <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
            <span><i class="fas fa-person-lines-fill me-2"></i>Lista de Administradores</span>
            <a href="{{ route('admins.create') }}" class="btn btn-outline-light btn-sm" title="Adicionar Novo">
                <i class="fas fa-plus-circle"></i>
            </a>
        </div>
        <div class="card-body">
            <!-- Formulário de pesquisa -->
            <form method="GET" action="{{ route('admins.index') }}" class="mb-3">
                <div class="input-group" style="max-width: 400px;">
                    <input type="text" name="search" class="form-control" placeholder="Buscar por nome do funcionário"
                        value="{{ request('search') }}">
                    <button class="btn btn-primary" type="submit">
                        <i class="fas fa-search"></i> Buscar
                    </button>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Email</th>
                            <th>Funcionário Vinculado</th>
                            <th>Papel</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($admins as $admin)
                            <tr>
                                <td>{{ $admin->id }}</td>
                                <td>{{ $admin->email }}</td>
                                <td>{{ $admin->employee->fullName ?? 'Não vinculado' }}</td>
                                <td>
                                    @switch($admin->role)
                                        @case('admin')
                                            Administrador
                                        @break

                                        @case('director')
                                            Diretor
                                        @break

                                        @case('department_head')
                                            Chefe de Departamento
                                        @break

                                        @case('employee')
                                            Funcionário
                                        @break

                                        @default
                                            {{ ucfirst($admin->role) }}
                                    @endswitch
                                </td>
                                <td>
                                    <a href="{{ route('admins.show', $admin->id) }}" class="btn btn-warning btn-sm"
                                        style="width: 40px" title="Visualizar">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admins.edit', $admin->id) }}" class="btn btn-info btn-sm"
                                        style="width: 40px" title="Editar">
                                        <i class="fas fa-pencil"></i>
                                    </a>
                                    <form action="{{ route('admins.destroy', $admin->id) }}" method="POST"
                                        style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" title="Apagar"
                                            onclick="return confirm('Tem certeza?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                    @if ($admin->role == 'employee')
                                        <a href="{{ route('admins.contract', $admin->id) }}" class="btn btn-success btn-sm"
                                            title="Gerar Contrato">
                                            <i class="fas fa-file-earmark-pdf"></i>
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
