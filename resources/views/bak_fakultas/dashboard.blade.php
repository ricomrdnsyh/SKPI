@extends('layouts.app')

@section('title', 'Dashboard BAAK Fakultas')

@section('content')
    <div class="space-y-6">
        {{-- Welcome Banner --}}
        <div class="card overflow-hidden animate-fade-in">
            <div class="relative px-6 py-6 bg-linear-to-br from-unuja-800 via-unuja-700 to-unuja-900">
                <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle at 20% 50%, rgba(255,255,255,0.3) 0%, transparent 50%), radial-gradient(circle at 80% 20%, rgba(255,255,255,0.2) 0%, transparent 40%);"></div>
                <div class="relative">
                    <h2 class="text-xl font-black text-white tracking-tight">Dashboard BAAK Fakultas</h2>
                    <p class="text-sm text-white/50 mt-1">Kelola antrian verifikasi dan alur penerbitan SKPI.</p>
                </div>
            </div>
        </div>

        {{-- Stats --}}
        <div class="grid grid-cols-2 md:grid-cols-5 gap-4 stagger-children">
            @php
                $statCards = [
                    ['label' => 'Perlu Verifikasi', 'value' => $stats['pending'], 'gradient' => 'from-amber-400 to-orange-500', 'icon' => 'fa-hourglass-half'],
                    ['label' => 'Sedang Diproses', 'value' => $stats['verifikasi'], 'gradient' => 'from-blue-400 to-indigo-500', 'icon' => 'fa-spinner'],
                    ['label' => 'Permohonan Cetak', 'value' => $stats['permohonan_cetak_count'], 'gradient' => 'from-emerald-400 to-green-500', 'icon' => 'fa-print'],
                    ['label' => 'Sudah Tercetak', 'value' => $stats['completed'], 'gradient' => 'from-green-400 to-emerald-600', 'icon' => 'fa-circle-check'],
                    ['label' => 'Total Verifikasi', 'value' => $stats['sudah_verifikasi'], 'gradient' => 'from-slate-400 to-gray-500', 'icon' => 'fa-chart-bar'],
                ];
            @endphp
            @foreach($statCards as $sc)
            <div class="stat-card animate-fade-in relative overflow-hidden group">
                <div class="absolute top-0 right-0 w-20 h-20 rounded-full bg-linear-to-br {{ $sc['gradient'] }} opacity-[0.06] -translate-y-4 translate-x-4 group-hover:scale-150 transition-transform duration-500"></div>
                <div class="relative flex items-start justify-between">
                    <div>
                        <p class="stat-label">{{ $sc['label'] }}</p>
                        <p class="stat-value">{{ $sc['value'] }}</p>
                    </div>
                    <div class="w-9 h-9 flex items-center justify-center text-white text-xs shrink-0 rounded-xl shadow-lg bg-linear-to-br {{ $sc['gradient'] }}">
                        <i class="fa-solid {{ $sc['icon'] }}"></i>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Tabs --}}
        <div class="tab-bar">
            <button type="button"
                class="tab-btn active"
                data-tab="belum">
                <i class="fa-solid fa-hourglass-half"></i>
                Belum Verifikasi
                <span class="px-2 py-0.5 text-[10px] font-bold bg-amber-100 text-amber-800 rounded-full ml-1"
                    id="count-belum">{{ $stats['pending'] }}</span>
            </button>
            <button type="button"
                class="tab-btn"
                data-tab="permohonan_cetak">
                <i class="fa-solid fa-print"></i>
                Permohonan Cetak
                <span class="px-2 py-0.5 text-[10px] font-bold bg-emerald-100 text-emerald-800 rounded-full ml-1"
                    id="count-permohonan-cetak">{{ $stats['permohonan_cetak_count'] }}</span>
            </button>
            <button type="button"
                class="tab-btn"
                data-tab="sudah">
                <i class="fa-solid fa-circle-check"></i>
                Sudah Verifikasi
                <span class="px-2 py-0.5 text-[10px] font-bold bg-gray-200 text-gray-600 rounded-full ml-1"
                    id="count-sudah">{{ $stats['sudah_verifikasi'] }}</span>
            </button>
        </div>

        {{-- Filters --}}
        <div class="filter-bar">
            <div class="filter-label">
                <i class="fa-solid fa-filter"></i>
                <span>Filter</span>
            </div>
            <select id="filter-prodi" class="filter-select">
                <option value="">Semua Prodi</option>
                @foreach ($prodis as $prodi)
                    <option value="{{ $prodi }}">{{ $prodi }}</option>
                @endforeach
            </select>
            <select id="filter-status" class="filter-select" style="display: none;">
                <option value="">Semua Status</option>
                @foreach ($statuses as $status)
                    @if ($status !== 'diajukan')
                        <option value="{{ $status }}">{{ ucwords(str_replace('_', ' ', $status)) }}</option>
                    @endif
                @endforeach
            </select>
        </div>

        {{-- Table --}}
        <div class="card overflow-hidden animate-fade-in" style="animation-delay: 0.15s">
            <div class="card-header bg-linear-to-r from-unuja-50/80 to-transparent">
                <i class="fa-solid fa-rotate-left text-unuja-600"></i>
                <h3 class="font-bold text-gray-900 text-sm">Antrian Pengajuan SKPI</h3>
            </div>
            <div class="table-wrapper">
                <table id="table-bak-fakultas" class="display w-full">
                    <thead>
                        <tr>
                            <th class="th">Mahasiswa</th>
                            <th class="th">Prodi</th>
                            <th class="th">Tanggal</th>
                            <th class="th">Verifikasi</th>
                            <th class="th">Progress</th>
                            <th class="th">Status</th>
                            <th class="th text-center">Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
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
                    { data: 'aksi', orderable: false, searchable: false }
                ]
            });

            $('#filter-prodi, #filter-status').on('change', function() {
                table.draw();
            });

            $('.tab-btn').on('click', function() {
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
@endpush