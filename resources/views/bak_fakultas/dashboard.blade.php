@extends('layout.main')

@section('title', 'Dashboard BAAK Fakultas')

@section('content')
<div class="app-main flex-column flex-row-fluid" id="kt_app_main">
    <div class="d-flex flex-column flex-column-fluid">
        <div id="kt_app_content" class="app-content flex-column-fluid mt-7">
            <div id="kt_app_content_container" class="app-container container-fluid">
                
                {{-- Welcome Banner --}}
                <div class="card border-transparent shadow-sm mb-5" style="background: linear-gradient(112.14deg, #10B981 0%, #059669 100%);">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between flex-wrap gap-4">
                            <div class="d-flex flex-column">
                                <h2 class="text-white fw-bold fs-2 mb-2">Dashboard BAAK Fakultas</h2>
                                <div class="text-white opacity-75 fs-6 fw-semibold">Kelola antrian verifikasi dan alur penerbitan SKPI.</div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Stats Grid --}}
                <div class="row g-5 g-xl-8 mb-8">
                    @php
                        $statCards = [
                            ['label' => 'Perlu Verifikasi', 'value' => $stats['pending'], 'color' => 'warning', 'icon' => 'ki-time'],
                            ['label' => 'Sedang Diproses', 'value' => $stats['verifikasi'], 'color' => 'info', 'icon' => 'ki-arrows-circle'],
                            ['label' => 'Permohonan Cetak', 'value' => $stats['permohonan_cetak_count'], 'color' => 'primary', 'icon' => 'ki-printer'],
                            ['label' => 'Sudah Tercetak', 'value' => $stats['completed'], 'color' => 'success', 'icon' => 'ki-check-circle'],
                            ['label' => 'Total Verifikasi', 'value' => $stats['sudah_verifikasi'], 'color' => 'dark', 'icon' => 'ki-chart-bar'],
                        ];
                    @endphp
                    @foreach($statCards as $sc)
                    <div class="col">
                        <div class="card bg-{{ $sc['color'] }} hoverable card-xl-stretch mb-xl-8">
                            <div class="card-body">
                                <i class="ki-duotone {{ $sc['icon'] }} text-white fs-2x ms-n1"><span class="path1"></span><span class="path2"></span></i>
                                <div class="text-white fw-bold fs-2 mb-2 mt-5">{{ $sc['value'] }}</div>
                                <div class="fw-semibold text-white">{{ $sc['label'] }}</div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                {{-- Card for Tabs and Table --}}
                <div class="card shadow-sm border border-dashed border-dark rounded">
                    <div class="card-header border-0 pt-6">
                        <div class="card-title">
                            <div class="d-flex align-items-center position-relative my-1">
                                <h3 class="card-title align-items-start flex-column">
                                    <span class="card-label fw-bolder fs-3 mb-1">Antrian Pengajuan SKPI</span>
                                </h3>
                            </div>
                        </div>
                        <div class="card-toolbar">
                            <div class="d-flex justify-content-end gap-3" data-kt-customer-table-toolbar="base">
                                <select id="filter-prodi" class="form-select form-select-solid form-select form-select-solid-sm form-select form-select-solid-solid w-150px">
                                    <option value="">Semua Prodi</option>
                                    @foreach ($prodis as $prodi)
                                        <option value="{{ $prodi }}">{{ $prodi }}</option>
                                    @endforeach
                                </select>
                                <select id="filter-status" class="form-select form-select-solid form-select form-select-solid-sm form-select form-select-solid-solid w-150px" style="display: none;">
                                    <option value="">Semua Status</option>
                                    @foreach ($statuses as $status)
                                        @if ($status !== 'diajukan')
                                            <option value="{{ $status }}">{{ ucwords(str_replace('_', ' ', $status)) }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card-body pt-0">
                        <ul class="nav nav-tabs nav-line-tabs mb-5 fs-6">
                            <li class="nav-item">
                                <a class="nav-link active tab-btn" data-bs-toggle="tab" href="#" data-tab="belum">
                                    <i class="ki-duotone ki-time fs-2 me-2"><span class="path1"></span><span class="path2"></span></i> Belum Verifikasi
                                    <span class="badge badge-light-warning ms-2" id="count-belum">{{ $stats['pending'] }}</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link tab-btn" data-bs-toggle="tab" href="#" data-tab="permohonan_cetak">
                                    <i class="ki-duotone ki-printer fs-2 me-2"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i> Permohonan Cetak
                                    <span class="badge badge-light-primary ms-2" id="count-permohonan-cetak">{{ $stats['permohonan_cetak_count'] }}</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link tab-btn" data-bs-toggle="tab" href="#" data-tab="sudah">
                                    <i class="ki-duotone ki-check-circle fs-2 me-2"><span class="path1"></span><span class="path2"></span></i> Sudah Verifikasi
                                    <span class="badge badge-light-success ms-2" id="count-sudah">{{ $stats['sudah_verifikasi'] }}</span>
                                </a>
                            </li>
                        </ul>
                    
                        <table id="table-bak-fakultas" class="table align-middle table-row-dashed fs-6 gy-5">
                            <thead>
                                <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                    <th class="min-w-150px">Mahasiswa</th>
                                    <th class="min-w-150px">Prodi</th>
                                    <th class="min-w-100px">Tanggal</th>
                                    <th class="min-w-100px">Verifikasi</th>
                                    <th class="min-w-100px">Progress</th>
                                    <th class="min-w-100px">Status</th>
                                    <th class="text-center min-w-100px">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="fw-bold text-gray-800">
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
    <script src="{{ asset('assets/plugins/custom/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/custom/datatables/dataTables.bootstrap5.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            var activeTab = 'belum';

            var table = $('#table-bak-fakultas').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('bak_fakultas.datatable') }}',
                    data: function(d) {
                        d.prodi = $('#filter-prodi').val();
                        d.status = $('#filter-status').val();
                        d.tab = activeTab;
                    }
                },
                language: {
                    url: '/i18n/id.json'
                },
                pageLength: 10,
                order: [],
                columns: [
                    { data: 'mahasiswa' },
                    { data: 'prodi' },
                    { data: 'tanggal' },
                    { data: 'verifikasi' },
                    { data: 'progress' },
                    { data: 'status' },
                    { data: 'aksi', orderable: false, searchable: false, className: 'text-center' }
                ]
            });

            $('#filter-prodi, #filter-status').on('change', function() {
                table.draw();
            });

            $('.tab-btn').on('click', function(e) {
                e.preventDefault();
                $('.tab-btn').removeClass('active');
                $(this).addClass('active');
                activeTab = $(this).data('tab');

                if (activeTab === 'belum' || activeTab === 'permohonan_cetak') {
                    $('#filter-status').val('').hide();
                } else {
                    $('#filter-status').show();
                }

                table.column(4).visible(true);
                table.column(5).visible(true);

                table.draw();
            });
        });
    </script>
@endsection