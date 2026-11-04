<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absensi Mahasiswa</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
            background-color: #fff;
        }
        .table-absensi {
            border-collapse: separate;
            border-spacing: 0;
            width: 100%;
        }
        .table-absensi th {
            font-weight: 600;
            color: #6c757d;
            font-size: 0.85rem;
            border-bottom: 1px solid #dee2e6;
            padding: 12px 8px;
            background: #fff;
        }
        .table-absensi td {
            padding: 12px 8px;
            vertical-align: middle;
            font-size: 0.9rem;
            border: none;
        }
        
        .table-absensi tbody tr:nth-of-type(even) {
            background-color: #f8f9fa;
        }
        .table-absensi tbody tr:nth-of-type(odd) {
            background-color: #ffffff;
        }
        .mhs-nama {
            font-weight: 700;
            text-transform: uppercase;
            font-size: 0.85rem;
            color: #212529;
            margin-bottom: 2px;
        }
        .mhs-nim {
            font-size: 0.75rem;
            color: #8c98a4;
        }
        
        .badge-status {
            font-size: 0.7rem;
            font-weight: 600;
            padding: 4px 8px;
            border-radius: 4px;
            display: inline-block;
        }
        .badge-hadir {
            background-color: #e6f4ea;
            color: #137333;
        }
        .badge-absen {
            background-color: #fce8e6;
            color: #c5221f;
        }
        .badge-izin {
            background-color: #feefc3;
            color: #b06000;
        }
        .badge-sakit {
            background-color: #e8f0fe;
            color: #1a73e8;
        }
        .badge-empty {
            color: #9aa0a6;
        }
        /* Styling Radio Button */
        .status-options {
            display: flex;
            gap: 12px;
            align-items: center;
        }
        .status-options label {
            font-size: 0.8rem;
            color: #5f6368;
            cursor: pointer;
            margin-left: 2px;
        }
    </style>
</head>
<body class="container my-4">

    <h3 class="fw-bold mb-4">Absensi Mahasiswa</h3>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

   
    <div class="card p-3 mb-4 border-0 shadow-sm bg-light">
        <form method="GET" action="{{ route('absensi.index') }}" class="row g-3 align-items-end">
            <div class="col-md-5">
                <label class="form-label fw-semibold text-secondary">Mata Kuliah</label>
                <select name="matakuliah_id" class="form-select" onchange="this.form.submit()" required>
                    <option value="">-- Pilih Mata Kuliah --</option>
                    @foreach($matakuliahs as $mk)
                        <option value="{{ $mk->id }}" {{ $selected_mk == $mk->id ? 'selected' : '' }}>
                            {{ $mk->kode }} - {{ $mk->nama_matakuliah }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-5">
                <label class="form-label fw-semibold text-secondary">Tanggal</label>
                <input type="date" name="tanggal" class="form-control" value="{{ $selected_date }}" onchange="this.form.submit()" required>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-secondary w-100">Tampilkan</button>
            </div>
        </form>
    </div>

    @if($selected_mk)
    <form action="{{ route('absensi.store') }}" method="POST">
        @csrf
        <input type="hidden" name="matakuliah_id" value="{{ $selected_mk }}">
        <input type="hidden" name="tanggal" value="{{ $selected_date }}">

        <div class="table-responsive">
            <table class="table-absensi">
                <thead>
                    <tr>
                        <th width="60">No</th>
                        <th width="300">Mahasiswa</th>
                        <th width="200">Kehadiran</th>
                        <th width="250">
                            Status
                            <div class="mt-1 font-monospace" style="font-size: 0.75rem; font-weight: normal;">
                                <span class="me-2">H</span>
                                <span class="me-2">A</span>
                                <span class="me-2">I</span>
                                <span>S</span>
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($mahasiswas as $index => $mhs)
                        @php
                            $status_saat_ini = $existing_absensi[$mhs->id] ?? '';
                        @endphp
                        <tr>
                            <td class="text-secondary">{{ $index + 1 }}</td>
                            <td>
                                <div class="mhs-nama">{{ $mhs->name }}</div>
                                <div class="mhs-nim">{{ $mhs->NIM }}</div>
                            </td>
                            <td>
                                @if($status_saat_ini == 'H')
                                    <span class="badge-status badge-hadir">Hadir</span>
                                @elseif($status_saat_ini == 'A')
                                    <span class="badge-status badge-absen">Absen</span>
                                @elseif($status_saat_ini == 'I')
                                    <span class="badge-status badge-izin">Izin</span>
                                @elseif($status_saat_ini == 'S')
                                    <span class="badge-status badge-sakit">Sakit</span>
                                @else
                                    <span class="badge-empty">-</span>
                                @endif
                            </td>
                            <td>
                                <div class="status-options">
                                    <div class="form-check form-check-inline m-0">
                                        <input class="form-check-input" type="radio" name="status[{{ $mhs->id }}]" value="H" {{ $status_saat_ini == 'H' ? 'checked' : '' }}>
                                    </div>
                                    <div class="form-check form-check-inline m-0">
                                        <input class="form-check-input" type="radio" name="status[{{ $mhs->id }}]" value="A" {{ $status_saat_ini == 'A' ? 'checked' : '' }}>
                                    </div>
                                    <div class="form-check form-check-inline m-0">
                                        <input class="form-check-input" type="radio" name="status[{{ $mhs->id }}]" value="I" {{ $status_saat_ini == 'I' ? 'checked' : '' }}>
                                    </div>
                                    <div class="form-check form-check-inline m-0">
                                        <input class="form-check-input" type="radio" name="status[{{ $mhs->id }}]" value="S" {{ $status_saat_ini == 'S' ? 'checked' : '' }}>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-4 text-muted">Belum ada data mahasiswa.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(count($mahasiswas) > 0)
            <div class="mt-4 text-end">
                <button type="submit" class="btn btn-primary px-4">Simpan Absensi</button>
            </div>
        @endif
    </form>
    @else
        <div class="alert alert-info">Silakan pilih <strong>Mata Kuliah</strong> terlebih dahulu untuk menampilkan daftar mahasiswa.</div>
    @endif

</body>
</html>