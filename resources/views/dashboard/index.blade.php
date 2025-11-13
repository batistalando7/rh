@extends('layouts.admin.layout')

@section('title', 'Dashboard RH-INFOSI')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Dashboard</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard</li>
    </ol>
    <p>Bem-vindo, {{ Auth::user()->employee->fullName ?? Auth::user()->email }}</p>

    @if(Auth::user()->role === 'admin' || Auth::user()->role === 'director')
        <!-- Cards -->
        <div class="row g-4">
            <!-- Total de Funcionários -->
            <div class="col-xxl-3 col-md-6">
                <div class="card stretch stretch-full">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between mb-4">
                            <div class="d-flex gap-4 align-items-center">
                                <div class="avatar-text avatar-lg bg-gray-200">
                                    <i data-feather="users"></i>
                                </div>
                                <div>
                                    <div class="fs-4 fw-bold text-dark">{{ $totalEmployees }}</div>
                                    <h3 class="fs-13 fw-semibold text-truncate-1-line">Total de Funcionários</h3>
                                </div>
                            </div>
                            <a href="{{ route('employeee.index') }}" class="">
                                <i data-feather="more-vertical"></i>
                            </a>
                        </div>
                        <div class="pt-4">
                            <div class="d-flex align-items-center justify-content-between">
                                <a href="{{ route('employeee.index') }}" class="fs-12 fw-medium text-muted text-truncate-1-line">Ver Detalhes</a>
                                <div class="w-100 text-end">
                                    <span class="fs-12 text-dark">{{ $totalEmployees }}</span>
                                    <span class="fs-11 text-muted">(100%)</span>
                                </div>
                            </div>
                            <div class="progress mt-2 ht-3">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: 100%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Funcionários Ativos -->
            <div class="col-xxl-3 col-md-6">
                <div class="card stretch stretch-full">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between mb-4">
                            <div class="d-flex gap-4 align-items-center">
                                <div class="avatar-text avatar-lg bg-gray-200">
                                    <i data-feather="user-check"></i>
                                </div>
                                <div>
                                    <div class="fs-4 fw-bold text-dark">{{ $activeEmployees }}</div>
                                    <h3 class="fs-13 fw-semibold text-truncate-1-line"> Funcionários Ativos</h3>
                                </div>
                            </div>
                            <a href="{{ route('employeee.filterByStatus', ['status' => 'active']) }}" class="">
                                <i data-feather="more-vertical"></i>
                            </a>
                        </div>
                        <div class="pt-4">
                            <div class="d-flex align-items-center justify-content-between">
                                <a href="{{ route('employeee.filterByStatus', ['status' => 'active']) }}" class="fs-12 fw-medium text-muted text-truncate-1-line">Ver Detalhes</a>
                                <div class="w-100 text-end">
                                    <span class="fs-12 text-dark">{{ $activeEmployees }}</span>
                                    <span class="fs-11 text-muted">({{ $totalEmployees > 0 ? round(($activeEmployees / $totalEmployees) * 100) : 0 }}%)</span>
                                </div>
                            </div>
                            <div class="progress mt-2 ht-3">
                                <div class="progress-bar bg-success" role="progressbar" style="width: {{ $totalEmployees > 0 ? round(($activeEmployees / $totalEmployees) * 100) : 0 }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Funcionários Destacados -->
            <div class="col-xxl-3 col-md-6">
                <div class="card stretch stretch-full">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between mb-4">
                            <div class="d-flex gap-4 align-items-center">
                                <div class="avatar-text avatar-lg bg-gray-200">
                                    <i data-feather="briefcase"></i>
                                </div>
                                <div>
                                    <div class="fs-4 fw-bold text-dark">{{ $highlightedEmployees }}</div>
                                    <h3 class="fs-13 fw-semibold text-truncate-1-line">Funcionários Destacados</h3>
                                </div>
                            </div>
                            <a href="{{ route('secondment.index') }}" class="">
                                <i data-feather="more-vertical"></i>
                            </a>
                        </div>
                        <div class="pt-4">
                            <div class="d-flex align-items-center justify-content-between">
                                <a href="{{ route('secondment.index') }}" class="fs-12 fw-medium text-muted text-truncate-1-line">Ver Detalhes</a>
                                <div class="w-100 text-end">
                                    <span class="fs-12 text-dark">{{ $highlightedEmployees }}</span>
                                    <span class="fs-11 text-muted">({{ $totalEmployees > 0 ? round(($highlightedEmployees / $totalEmployees) * 100) : 0 }}%)</span>
                                </div>
                            </div>
                            <div class="progress mt-2 ht-3">
                                <div class="progress-bar bg-warning" role="progressbar" style="width: {{ $totalEmployees > 0 ? round(($highlightedEmployees / $totalEmployees) * 100) : 0 }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Funcionários Reformados -->
            <div class="col-xxl-3 col-md-6">
                <div class="card stretch stretch-full">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between mb-4">
                            <div class="d-flex gap-4 align-items-center">
                                <div class="avatar-text avatar-lg bg-gray-200">
                                    <i data-feather="user-x"></i>
                                </div>
                                <div>
                                    <div class="fs-4 fw-bold text-dark">{{ $retiredEmployees }}</div>
                                    <h3 class="fs-13 fw-semibold text-truncate-1-line">Funcionários Reformados</h3>
                                </div>
                            </div>
                            <a href="{{ route('retirements.index') }}" class="">
                                <i data-feather="more-vertical"></i>
                            </a>
                        </div>
                        <div class="pt-4">
                            <div class="d-flex align-items-center justify-content-between">
                                <a href="{{ route('retirements.index') }}" class="fs-12 fw-medium text-muted text-truncate-1-line">Ver Detalhes</a>
                                <div class="w-100 text-end">
                                    <span class="fs-12 text-dark">{{ $retiredEmployees }}</span>
                                    <span class="fs-11 text-muted">({{ $totalEmployees > 0 ? round(($retiredEmployees / $totalEmployees) * 100) : 0 }}%)</span>
                                </div>
                            </div>
                            <div class="progress mt-2 ht-3">
                                <div class="progress-bar bg-danger" role="progressbar" style="width: {{ $totalEmployees > 0 ? round(($retiredEmployees / $totalEmployees) * 100) : 0 }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Estagiários -->
            <div class="col-xxl-3 col-md-6">
                <div class="card stretch stretch-full">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between mb-4">
                            <div class="d-flex gap-4 align-items-center">
                                <div class="avatar-text avatar-lg bg-gray-200">
                                    <i data-feather="book-open"></i>
                                </div>
                                <div>
                                    <div class="fs-4 fw-bold text-dark">{{ $totalInterns }}</div>
                                    <h3 class="fs-13 fw-semibold text-truncate-1-line">Estagiários</h3>
                                </div>
                            </div>
                            <a href="{{ route('intern.index') }}" class="">
                                <i data-feather="more-vertical"></i>
                            </a>
                        </div>
                        <div class="pt-4">
                            <div class="d-flex align-items-center justify-content-between">
                                <a href="{{ route('intern.index') }}" class="fs-12 fw-medium text-muted text-truncate-1-line">Ver Detalhes</a>
                                <div class="w-100 text-end">
                                    <span class="fs-12 text-dark">{{ $totalInterns }}</span>
                                    <span class="fs-11 text-muted">({{ $totalInterns > 0 ? 100 : 0 }}%)</span>
                                </div>
                            </div>
                            <div class="progress mt-2 ht-3">
                                <div class="progress-bar bg-info" role="progressbar" style="width: {{ $totalInterns > 0 ? 100 : 0 }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabela de Chefes de Departamento -->
        <div class="row g-4">
            <div class="col-xxl-8">
                <div class="card stretch stretch-full">
                    <div class="card-header">
                        <h5 class="card-title">Chefes de Departamento</h5>
                        <div class="card-header-action">
                            <div class="card-header-btn">
                                <div data-bs-toggle="tooltip" title="Maximize/Minimize">
                                    <a href="javascript:void(0);" class="avatar-text avatar-xs bg-success" data-bs-toggle="expand"></a>
                                </div>
                            </div>
                            <div class="dropdown">
                                <a href="javascript:void(0);" class="avatar-text avatar-sm" data-bs-toggle="dropdown" data-bs-offset="25, 25">
                                    <div data-bs-toggle="tooltip" title="Opções">
                                        <i data-feather="more-vertical"></i>
                                    </div>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a href="{{ route('employeee.index') }}" class="dropdown-item"><i data-feather="users"></i>Ver todos</a>
                                    <a href="javascript:void(0);" class="dropdown-item"><i data-feather="settings"></i>Configurações</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body custom-card-action p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr class="border-b">
                                        <th scope="row">Chefe</th>
                                        <th>Departamento</th>
                                        <th>Total de Funcionários</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($departmentHeads as $head)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center gap-3">
                                                    <div class="avatar-image">
                                                        <img src="{{ $head->photo ? asset('frontend/images/departments/' . $head->photo) : asset('public/assets/images/avatar/default.png') }}" alt="{{ $head->fullName ?? 'Sem Nome' }}" class="img-fluid" />
                                                    </div>
                                                    <a href="{{ route('employeee.show', $head->id) }}">
                                                        <span class="d-block">{{ $head->fullName ?? 'Sem Nome' }}</span>
                                                        <span class="fs-12 d-block fw-normal text-muted">{{ $head->email ?? 'Sem Email' }}</span>
                                                    </a>
                                                </div>
                                            </td>
                                            <td>{{ $head->department->title ?? 'Sem Departamento' }}</td>
                                            <td>{{ $head->department->employeee->count() }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center">Nenhum chefe de departamento encontrado.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        <ul class="list-unstyled d-flex align-items-center gap-2 mb-0 pagination-common-style">
                            <li><a href="javascript:void(0);"><i class="fas fa-arrow-left"></i></a></li>
                            <li><a href="javascript:void(0);" class="active">1</a></li>
                            <li><a href="javascript:void(0);">2</a></li>
                            <li><a href="javascript:void(0);"><i class="fas fa-dot"></i></a></li>
                            <li><a href="javascript:void(0);">8</a></li>
                            <li><a href="javascript:void(0);"><i class="bi bi-arrow-right"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Gráficos de Círculo -->
            <div class="col-xxl-4">
                <div class="card stretch stretch-full">
                    <div class="card-body">
                        <div class="hstack justify-content-between mb-4 pb-0">
                            <div>
                                <h5 class="mb-1">Distribuição de Funcionários</h5>
                                <span class="fs-12 text-muted">Percentagem por Tipo de Contrato</span>
                            </div>
                            <a href="{{ route('employeee.index') }}" class="btn btn-light-brand">Ver Todos</a>
                        </div>
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="card-body border border-dashed border-gray-5 rounded-3 position-relative">
                                    <div class="hstack justify-content-between gap-4">
                                        <div>
                                            <h6 class="fs-14 text-truncate-1-line">Efetivos</h6>
                                            <div class="fs-12 text-muted"><span class="text-dark fw-medium">Total:</span> {{ $permanentEmployees }}</div>
                                        </div>
                                        <div class="employee-progress-permanent" data-value="{{ $activeEmployees > 0 ? round(($permanentEmployees / $activeEmployees) * 100) / 100 : 0 }}"></div>
                                    </div>
                                    <div class="badge bg-gray-200 text-dark project-mini-card-badge">{{ $activeEmployees > 0 ? round(($permanentEmployees / $activeEmployees) * 100) : 0 }}%</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card-body border border-dashed border-gray-5 rounded-3 position-relative">
                                    <div class="hstack justify-content-between gap-4">
                                        <div>
                                            <h6 class="fs-14 text-truncate-1-line">Contratados</h6>
                                            <div class="fs-12 text-muted"><span class="text-dark fw-medium">Total:</span> {{ $contractEmployees }}</div>
                                        </div>
                                        <div class="employee-progress-contract" data-value="{{ $activeEmployees > 0 ? round(($contractEmployees / $activeEmployees) * 100) / 100 : 0 }}"></div>
                                    </div>
                                    <div class="badge bg-gray-200 text-dark project-mini-card-badge">{{ $activeEmployees > 0 ? round(($contractEmployees / $activeEmployees) * 100) : 0 }}%</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Funcionários por Categoria (UNICO GRÁFICO com todas as categorias) -->
        <div class="col-xxl-12 mt-4">
            <div class="card stretch stretch-full">
                <div class="card-header">
                    <h5 class="card-title">Funcionários por Categoria</h5>
                </div>

                <div class="card-body custom-card-action">
                    <!-- Gráfico único que recebe todas as categorias -->
                    <div id="allCategoriesChart" style="min-height: 360px;"></div>
                </div>

                <div class="card-footer d-md-flex flex-wrap p-4 pt-5 border-top border-gray-5">
                    <!-- Mantido vazio / minimal conforme pedido -->
                </div>
            </div>
        </div>
    @else
        <div class="alert alert-info">
            <strong>Atenção:</strong> Você tem acesso aos menus gerais do sistema, porém não pode visualizar os dados estatísticos do dashboard.
        </div>
    @endif
</div>
@endsection

@section('scripts')
@if(Auth::user()->role === 'admin' || Auth::user()->role === 'director')
    <!-- Vendors JS -->
    <script src="{{ asset('assets/vendors/js/vendors.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/js/apexcharts.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/circle-progress/1.0.0/circle-progress.min.js"></script>
    <!-- Common JS -->
    <script src="{{ asset('assets/js/common-init.min.js') }}"></script>
    <!-- Theme Customizer -->
    <script src="{{ asset('assets/js/theme-customizer-init.min.js') }}"></script>
    <script src="https://unpkg.com/feather-icons"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // substituir ícones se existir
            if (typeof feather !== 'undefined' && feather.replace) { feather.replace(); }

            // Blade → JS
            var categoryData = {!! $categoryDataJson !!} || [];
            var totalEmployees = {{ $totalEmployees }};
            var activeEmployees = {{ $activeEmployees }};
            var permanentEmployees = {{ $permanentEmployees }};
            var contractEmployees = {{ $contractEmployees }};

            // circle-progress (fallback SVG se plugin não existir)
            var valPerm = {{ $activeEmployees > 0 ? round(($permanentEmployees / $activeEmployees) * 100) / 100 : 0 }};
            var valContr = {{ $activeEmployees > 0 ? round(($contractEmployees / $activeEmployees) * 100) / 100 : 0 }};

            function createDonut(el, value, color) {
                el.innerHTML = '';
                var size = 80, stroke = 6;
                var radius = (size - stroke) / 2;
                var circumference = 2 * Math.PI * radius;
                var svgNS = "http://www.w3.org/2000/svg";
                var svg = document.createElementNS(svgNS, "svg");
                svg.setAttribute("width", size);
                svg.setAttribute("height", size);
                svg.setAttribute("viewBox", "0 0 " + size + " " + size);

                var bg = document.createElementNS(svgNS, "circle");
                bg.setAttribute("cx", size/2); bg.setAttribute("cy", size/2); bg.setAttribute("r", radius);
                bg.setAttribute("stroke-width", stroke); bg.setAttribute("fill", "none"); bg.setAttribute("stroke", "#e9ecef");
                svg.appendChild(bg);

                var fg = document.createElementNS(svgNS, "circle");
                fg.setAttribute("cx", size/2); fg.setAttribute("cy", size/2); fg.setAttribute("r", radius);
                fg.setAttribute("stroke-width", stroke); fg.setAttribute("fill", "none");
                fg.setAttribute("stroke-linecap", "round"); fg.setAttribute("transform", "rotate(-90 " + (size/2) + " " + (size/2) + ")");
                fg.setAttribute("stroke", color); fg.setAttribute("stroke-dasharray", circumference);
                fg.setAttribute("stroke-dashoffset", circumference * (1 - value));
                svg.appendChild(fg);

                var text = document.createElementNS(svgNS, "text");
                text.setAttribute("x", "50%"); text.setAttribute("y", "50%"); text.setAttribute("dominant-baseline", "middle");
                text.setAttribute("text-anchor", "middle"); text.setAttribute("font-size", "12"); text.setAttribute("fill", "#333");
                text.textContent = Math.round(value * 100) + '%';
                svg.appendChild(text);

                el.appendChild(svg);
            }

            try {
                var elPerm = document.querySelector('.employee-progress-permanent');
                var elContr = document.querySelector('.employee-progress-contract');
                if (window.jQuery && jQuery.fn && typeof jQuery.fn.circleProgress === 'function') {
                    if (elPerm) $('.employee-progress-permanent').circleProgress({ value: valPerm, size: 80, thickness: 6, fill: { gradient: ['#007bff'] }});
                    if (elContr) $('.employee-progress-contract').circleProgress({ value: valContr, size: 80, thickness: 6, fill: { gradient: ['#28a745'] }});
                } else {
                    if (elPerm) createDonut(elPerm, valPerm, '#007bff');
                    if (elContr) createDonut(elContr, valContr, '#28a745');
                }
            } catch (err) {
                console.error('circle-progress fallback error', err);
            }

            // ---------- APEXCHARTS: UNICO GRÁFICO PARA TODAS AS CATEGORIAS ----------
            try {
                if (typeof ApexCharts === 'undefined') {
                    console.warn('ApexCharts não encontrado');
                    return;
                }

                if (!Array.isArray(categoryData) || categoryData.length === 0) {
                    console.info('Sem categorias para mostrar');
                    return;
                }

                // ---------- Ajustes ----------
                // 1) columnWidth: controla a finura das barras.
                //    Ex.: '8%' = muito fino, '20%' = mais grosso.
                //    Recomendo começar em 12% e ajustar conforme necessario.
                var columnWidth = (categoryData.length > 18) ? '5%' : (categoryData.length > 10) ? '6%' : '8%';

                // 2) chartHeight: aumenta com o número de categorias para manter espaçamento.
                //    Cada categoria ocupa ~ (rowHeight) px; ajusta rowHeight se quiseres mais/menos espaço.
                var rowHeight = 28; // px por categoria (aumenta se quiseres mais espaço vertical)
                var baseHeight = 360; // minimo
                var calculated = Math.max(baseHeight, Math.min(1200, categoryData.length * rowHeight + 120)); // limitado entre base e 1200
                var chartHeight = calculated;

                // ---------- preparar arrays ----------
                var categories = categoryData.map(function(c){ return c.name; });
                var values = categoryData.map(function(c){ return c.count; });

                // Gera paleta repetida
                var palette = ['#3454D1','#4F46E5','#06B6D4','#10B981','#F59E0B','#F97316','#EF4444','#8B5CF6','#06A7E1'];
                var colors = categories.map(function(_, i){ return palette[i % palette.length]; });

                var options = {
                    series: [{ name: 'Funcionários', data: values }],
                    chart: { type: 'bar', height: chartHeight, toolbar: { show: false } },
                    plotOptions: {
                        bar: {
                            horizontal: false,
                            columnWidth: columnWidth,
                            borderRadius: 8,
                            endingShape: 'rounded'
                        }
                    },
                    dataLabels: { enabled: false },
                    xaxis: {
                        categories: categories,
                        labels: { rotate: -12, style: { colors: '#6B7280', fontSize: '12px' } },
                        axisTicks: { show: false },
                        axisBorder: { show: false }
                    },
                    yaxis: {
                        min: 0,
                        labels: { style: { colors: '#6B7280' } },
                        title: { text: 'Nº de Funcionários', style: { color: '#6B7280' } }
                    },
                    grid: { borderColor: '#E5E7EB', strokeDashArray: 4, padding: { left: 10, right: 10, top: 10, bottom: 10 } },
                    tooltip: {
                        theme: 'light',
                        y: { formatter: function(val){ return val + " funcionário" + (val !== 1 ? "s" : ""); } }
                    },
                    colors: colors,
                    fill: { opacity: 0.95 },
                    legend: { show: false },
                    responsive: [{
                        breakpoint: 768,
                        options: {
                            plotOptions: { bar: { columnWidth: '35%' } },
                            chart: { height: Math.max(280, Math.min(800, categoryData.length * 22 + 80)) },
                            xaxis: { labels: { rotate: -30 } }
                        }
                    }]
                };

                var el = document.querySelector('#allCategoriesChart');
                if (!el) { console.warn('#allCategoriesChart não encontrado'); return; }
                var chart = new ApexCharts(el, options);
                chart.render().catch(function(err){ console.error('Erro ao renderizar gráfico:', err); });

                // ------------------------------------------------------------
                // Dicas de ajuste:
                // - Para deixar as barras ainda mais finas: alterar `columnWidth` para '6%' ou '8%'.
                // - Para aumentar espaço vertical entre barras quando houver muitas categorias:
                //      aumentar var rowHeight acima (ex.: 36).
                // - As barras para estarem na mesma base usei:  yaxis.min = 0.
                // - O gráfico auto-ajusta o height com base no nº de categorias.
                // ------------------------------------------------------------
            } catch (err) {
                console.error('Erro ao inicializar categorias chart:', err);
            }
        });
    </script>
@endif
@endsection
