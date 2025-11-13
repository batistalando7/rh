@extends('layouts.admin.layout')
@section('title', 'Editar Manutenção')
@section('content')
<div class="card my-4 shadow">
    <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
        <span><i class="fas fa-tools me-2"></i>Editar Manutenção #{{ $maintenance->id }}</span>
        <a href="{{ route('maintenance.index') }}" class="btn btn-outline-light btn-sm">
            <i class="fa-solid fa-list"></i>
        </a>
    </div>
    <div class="card-body">
        <form action="{{ route('maintenance.update', $maintenance->id) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')

            <!-- Viatura -->
            <h5 class="mb-3">Informações da Viatura</h5>
            <div class="row g-3 mb-3">
                <div class="col-md-12">
                    <div class="form-floating">
                        <select name="vehicleId" id="vehicleId" class="form-select" required onchange="loadVehicleDetails(this.value)">
                            <option value="">Selecione a Viatura</option>
                            @foreach ($vehicles as $v)
                                <option value="{{ $v->id }}"
                                    data-brand="{{ $v->brand }}"
                                    data-model="{{ $v->model }}"
                                    data-year="{{ $v->yearManufacture }}"
                                    data-plate="{{ $v->plate }}"
                                    {{ old('vehicleId', $maintenance->vehicleId) == $v->id ? 'selected' : '' }}>
                                    {{ $v->plate }} - {{ $v->brand }} {{ $v->model }}
                                </option>
                            @endforeach
                        </select>
                        <label for="vehicleId">Viatura</label>
                    </div>
                </div>
            </div>
            <div id="vehicleDetails" class="row g-3 mb-3" style="display: {{ old('vehicleId', $maintenance->vehicleId) ? 'flex' : 'none' }};">
                <div class="col-md-3"><strong>Marca:</strong> <span id="brand">{{ $maintenance->vehicle->brand }}</span></div>
                <div class="col-md-3"><strong>Modelo:</strong> <span id="model">{{ $maintenance->vehicle->model }}</span></div>
                <div class="col-md-3"><strong>Ano:</strong> <span id="year">{{ $maintenance->vehicle->yearManufacture }}</span></div>
                <div class="col-md-3"><strong>Placa:</strong> <span id="plate">{{ $maintenance->vehicle->plate }}</span></div>
            </div>

            <!-- Tipo -->
            <h5 class="mb-3">Tipo de Manutenção</h5>
            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <div class="form-floating">
                        <select name="type" id="type" class="form-select" required onchange="toggleSubtypes(this.value)">
                            <option value="">Selecione o Tipo</option>
                            <option value="Preventive" {{ old('type', $maintenance->type) == 'Preventive' ? 'selected' : '' }}>Preventiva</option>
                            <option value="Corrective" {{ old('type', $maintenance->type) == 'Corrective' ? 'selected' : '' }}>Corretiva</option>
                            <option value="Repair" {{ old('type', $maintenance->type) == 'Repair' ? 'selected' : '' }}>Reparo</option>
                        </select>
                        <label>Tipo Principal</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating">
                        <input type="text" name="subType" class="form-control" value="{{ old('subType', $maintenance->subType) }}" placeholder="Ex: troca_oleo">
                        <label>Subtipo Específico</label>
                    </div>
                </div>
            </div>

            <!-- Serviços -->
            <div id="subtypesSection" style="display: {{ old('type', $maintenance->type) ? 'block' : 'none' }};">
                <h6>Selecione Serviços Realizados:</h6>
                <div class="row g-2">
                    @php $services = old('services', $maintenance->services ?? []); @endphp

                    <!-- Preventiva -->
                    <div id="preventive" style="display: {{ old('type', $maintenance->type) == 'Preventive' ? 'block' : 'none' }};">
                        <div class="col-md-3 form-check">
                            <input type="checkbox" class="form-check-input services" name="services[troca_oleo]" value="troca_oleo"
                                {{ array_key_exists('troca_oleo', $services) ? 'checked' : '' }}
                                onchange="toggleServiceDetails('troca_oleo', this.checked)"> Troca de Óleo
                        </div>
                        <div class="col-md-3 form-check">
                            <input type="checkbox" class="form-check-input services" name="services[troca_filtro_ar]" value="troca_filtro_ar"
                                {{ array_key_exists('troca_filtro_ar', $services) ? 'checked' : '' }}
                                onchange="toggleServiceDetails('troca_filtro_ar', this.checked)"> Troca Filtro Ar
                        </div>
                        <div class="col-md-3 form-check">
                            <input type="checkbox" class="form-check-input services" name="services[troca_filtro_oleo]" value="troca_filtro_oleo"
                                {{ array_key_exists('troca_filtro_oleo', $services) ? 'checked' : '' }}
                                onchange="toggleServiceDetails('troca_filtro_oleo', this.checked)"> Troca Filtro Óleo
                        </div>
                        <div class="col-md-3 form-check">
                            <input type="checkbox" class="form-check-input services" name="services[verificacao_pneus]" value="verificacao_pneus"
                                {{ array_key_exists('verificacao_pneus', $services) ? 'checked' : '' }}> Verificação Pneus
                        </div>
                        <div class="col-md-3 form-check">
                            <input type="checkbox" class="form-check-input services" name="services[verificacao_liquidos]" value="verificacao_liquidos"
                                {{ array_key_exists('verificacao_liquidos', $services) ? 'checked' : '' }}> Verificação Líquidos
                        </div>
                    </div>

                    <!-- Corretiva -->
                    <div id="corrective" style="display: {{ old('type', $maintenance->type) == 'Corrective' ? 'block' : 'none' }};">
                        <div class="col-md-3 form-check">
                            <input type="checkbox" class="form-check-input services" name="services[troca_pastilhas]" value="troca_pastilhas"
                                {{ array_key_exists('troca_pastilhas', $services) ? 'checked' : '' }}
                                onchange="toggleServiceDetails('troca_pastilhas', this.checked)"> Troca Pastilhas Freio
                        </div>
                        <div class="col-md-3 form-check">
                            <input type="checkbox" class="form-check-input services" name="services[troca_discos]" value="troca_discos"
                                {{ array_key_exists('troca_discos', $services) ? 'checked' : '' }}
                                onchange="toggleServiceDetails('troca_discos', this.checked)"> Troca Discos Freio
                        </div>
                        <div class="col-md-3 form-check">
                            <input type="checkbox" class="form-check-input services" name="services[troca_bateria]" value="troca_bateria"
                                {{ array_key_exists('troca_bateria', $services) ? 'checked' : '' }}> Troca Bateria
                        </div>
                        <div class="col-md-3 form-check">
                            <input type="checkbox" class="form-check-input services" name="services[troca_pneus]" value="troca_pneus"
                                {{ array_key_exists('troca_pneus', $services) ? 'checked' : '' }}> Troca Pneus
                        </div>
                    </div>

                    <!-- Reparo -->
                    <div id="repair" style="display: {{ old('type', $maintenance->type) == 'Repair' ? 'block' : 'none' }};">
                        <div class="col-md-3 form-check">
                            <input type="checkbox" class="form-check-input services" name="services[reparo_motor]" value="reparo_motor"
                                {{ array_key_exists('reparo_motor', $services) ? 'checked' : '' }}> Reparo Motor
                        </div>
                        <div class="col-md-3 form-check">
                            <input type="checkbox" class="form-check-input services" name="services[reparo_transmissao]" value="reparo_transmissao"
                                {{ array_key_exists('reparo_transmissao', $services) ? 'checked' : '' }}> Reparo Transmissão
                        </div>
                        <div class="col-md-3 form-check">
                            <input type="checkbox" class="form-check-input services" name="services[reparo_suspensao]" value="reparo_suspensao"
                                {{ array_key_exists('reparo_suspensao', $services) ? 'checked' : '' }}> Reparo Suspensão
                        </div>
                        <div class="col-md-3 form-check">
                            <input type="checkbox" class="form-check-input services" name="services[reparo_freios]" value="reparo_freios"
                                {{ array_key_exists('reparo_freios', $services) ? 'checked' : '' }}> Reparo Freios
                        </div>
                    </div>

                    <div class="col-md-12 form-check">
                        <input type="checkbox" class="form-check-input" name="services[outros]" value="outros"
                            {{ array_key_exists('outros', $services) ? 'checked' : '' }}
                            onchange="toggleOtherServices(this.checked)"> Outros
                    </div>
                </div>

                <!-- Detalhes com Lixeira + Preenchimento -->
                <div id="serviceDetails" class="mt-3">
                    @if ($services && is_array($services))
                        @foreach (['troca_oleo', 'troca_filtro_ar', 'troca_filtro_oleo', 'troca_pastilhas', 'troca_discos'] as $svc)
                            @if (isset($services[$svc]) && is_array($services[$svc]))
                                <div class="service-detail-row row g-3 mt-2" id="detail-{{ $svc }}">
                                    @if ($svc === 'troca_oleo')
                                        <div class="col-md-5">
                                            <input type="text" name="services[{{ $svc }}][tipo]" value="{{ $services[$svc]['tipo'] ?? '' }}" placeholder="Tipo de Óleo" class="form-control">
                                        </div>
                                        <div class="col-md-5">
                                            <input type="text" name="services[{{ $svc }}][quantidade]" value="{{ $services[$svc]['quantidade'] ?? '' }}" placeholder="Quantidade" class="form-control">
                                        </div>
                                    @else
                                        <div class="col-md-10">
                                            <input type="text" name="services[{{ $svc }}][tipo]" value="{{ $services[$svc]['tipo'] ?? '' }}" placeholder="Tipo" class="form-control">
                                        </div>
                                    @endif
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-sm btn-danger" onclick="removeDetail('{{ $svc }}')">×</button>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    @endif
                </div>

                <div id="otherServices" class="mt-3" style="display: {{ array_key_exists('outros', $services) ? 'block' : 'none' }};">
                    <div class="form-floating">
                        <textarea name="services[outros_details]" class="form-control" style="height: 80px">{{ $services['outros_details'] ?? '' }}</textarea>
                        <label>Outros Detalhes</label>
                    </div>
                </div>
            </div>

            <!-- Dados da Manutenção -->
            <div class="row g-3 mt-3">
                <div class="col-md-3">
                    <div class="form-floating">
                        <input type="date" name="maintenanceDate" class="form-control" value="{{ old('maintenanceDate', $maintenance->maintenanceDate) }}" required max="{{ date('Y-m-d') }}">
                        <label>Data da Manutenção</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-floating">
                        <input type="number" name="mileage" class="form-control" value="{{ old('mileage', $maintenance->mileage) }}" required min="0" step="0.01">
                        <label>Quilometragem Atual (km)</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-floating">
                        <input type="number" name="cost" class="form-control" value="{{ old('cost', $maintenance->cost) }}" required min="0" step="0.01">
                        <label>Custo (Kz)</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-floating">
                        <input type="date" name="nextMaintenanceDate" class="form-control" value="{{ old('nextMaintenanceDate', $maintenance->nextMaintenanceDate) }}">
                        <label>Próxima Data</label>
                    </div>
                </div>
            </div>

            <div class="row g-3 mt-2">
                <div class="col-md-6">
                    <div class="form-floating">
                        <input type="number" name="nextMileage" class="form-control" value="{{ old('nextMileage', $maintenance->nextMileage) }}" min="0" step="0.01">
                        <label>Próxima Quilometragem (km)</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating">
                        <textarea name="description" class="form-control" style="height: 80px">{{ old('description', $maintenance->description) }}</textarea>
                        <label>Descrição</label>
                    </div>
                </div>
            </div>

            <div class="row g-3 mt-2">
                <div class="col-md-12">
                    <div class="form-floating">
                        <textarea name="piecesReplaced" class="form-control" style="height: 60px">{{ old('piecesReplaced', $maintenance->piecesReplaced) }}</textarea>
                        <label>Peças Substituídas</label>
                    </div>
                </div>
            </div>

            <!-- Responsável -->
            <h5 class="mb-3 mt-4">Responsável</h5>
            <div class="row g-3 mb-3">
                <div class="col-md-4">
                    <div class="form-floating">
                        <input type="text" name="responsibleName" class="form-control" value="{{ old('responsibleName', $maintenance->responsibleName) }}" required maxlength="100">
                        <label>Nome</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating">
                        <input type="tel" name="responsiblePhone" class="form-control" value="{{ old('responsiblePhone', $maintenance->responsiblePhone) }}" maxlength="20">
                        <label>Telefone</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating">
                        <input type="email" name="responsibleEmail" class="form-control" value="{{ old('responsibleEmail', $maintenance->responsibleEmail) }}">
                        <label>Email</label>
                    </div>
                </div>
            </div>

            <!-- Documentos com "Ver" -->
            <div class="row g-3 mt-3">
                <div class="col-md-6">
                    <div class="form-floating">
                        <textarea name="observations" class="form-control" style="height: 80px">{{ old('observations', $maintenance->observations) }}</textarea>
                        <label>Observações</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-floating">
                        <input type="file" name="invoice_pre" class="form-control" accept=".pdf,.jpg,.png">
                        <label>Fatura Prévia</label>
                    </div>
                    @if ($maintenance->invoice_pre)
                        <div class="mt-1">
                            <a href="{{ Storage::url($maintenance->invoice_pre) }}" target="_blank" class="text-primary small">
                                <i class="fas fa-eye me-1"></i> Ver atual
                            </a>
                        </div>
                    @endif
                </div>
                <div class="col-md-3">
                    <div class="form-floating">
                        <input type="file" name="invoice_post" class="form-control" accept=".pdf,.jpg,.png">
                        <label>Fatura Concluída</label>
                    </div>
                    @if ($maintenance->invoice_post)
                        <div class="mt-1">
                            <a href="{{ Storage::url($maintenance->invoice_post) }}" target="_blank" class="text-primary small">
                                <i class="fas fa-eye me-1"></i> Ver atual
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <div class="d-grid gap-2 col-md-4 mx-auto mt-4">
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="fas fa-check-circle me-2"></i>Atualizar Manutenção
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function loadVehicleDetails(id) {
    const opt = document.querySelector(`#vehicleId option[value="${id}"]`);
    if (opt && id) {
        document.getElementById('brand').textContent = opt.dataset.brand;
        document.getElementById('model').textContent = opt.dataset.model;
        document.getElementById('year').textContent = opt.dataset.year;
        document.getElementById('plate').textContent = opt.dataset.plate;
        document.getElementById('vehicleDetails').style.display = 'flex';
    } else {
        document.getElementById('vehicleDetails').style.display = 'none';
    }
}

function toggleSubtypes(type) {
    const section = document.getElementById('subtypesSection');
    section.style.display = type ? 'block' : 'none';
    ['preventive', 'corrective', 'repair'].forEach(id => document.getElementById(id).style.display = 'none');
    if (type) document.getElementById(type.toLowerCase()).style.display = 'block';
}

function toggleServiceDetails(service, checked) {
    const container = document.getElementById('serviceDetails');
    const existing = document.getElementById(`detail-${service}`);

    if (checked && !existing) {
        let html = '';
        if (service === 'troca_oleo') {
            html = `<div class="service-detail-row row g-3 mt-2" id="detail-${service}">
                <div class="col-md-5"><input type="text" name="services[${service}][tipo]" placeholder="Tipo de Óleo" class="form-control"></div>
                <div class="col-md-5"><input type="text" name="services[${service}][quantidade]" placeholder="Quantidade" class="form-control"></div>
                <div class="col-md-2"><button type="button" class="btn btn-sm btn-danger" onclick="removeDetail('${service}')">×</button></div>
            </div>`;
        } else {
            html = `<div class="service-detail-row row g-3 mt-2" id="detail-${service}">
                <div class="col-md-10"><input type="text" name="services[${service}][tipo]" placeholder="Tipo" class="form-control"></div>
                <div class="col-md-2"><button type="button" class="btn btn-sm btn-danger" onclick="removeDetail('${service}')">×</button></div>
            </div>`;
        }
        container.insertAdjacentHTML('beforeend', html);
    } else if (!checked && existing) {
        existing.remove();
    }
}

function removeDetail(service) {
    const el = document.getElementById(`detail-${service}`);
    if (el) el.remove();
    const checkbox = document.querySelector(`input[name="services[${service}]"]`);
    if (checkbox) checkbox.checked = false;
}

function toggleOtherServices(checked) {
    document.getElementById('otherServices').style.display = checked ? 'block' : 'none';
}


document.addEventListener('DOMContentLoaded', function () {
    const type = document.getElementById('type').value;
    if (type) toggleSubtypes(type);
    loadVehicleDetails({{ old('vehicleId', $maintenance->vehicleId) }});
});
</script>
@endsection