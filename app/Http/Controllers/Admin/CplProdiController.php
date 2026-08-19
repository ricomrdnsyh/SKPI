<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CplProdi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Controllers\Traits\FilterByProdi;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\CplProdiImport;
use App\Exports\CplProdiTemplateExport;

class CplProdiController extends Controller
{
    use FilterByProdi;

    public function index()
    {
        $allowedProdis = $this->getAllowedProdiIds();
        $prodiList = $this->getProdiOptions($allowedProdis);

        if ($allowedProdis === null) {
            $kurikulumList = DB::table('kurikulum')
                ->leftJoin('program_studi', 'kurikulum.id_prodi', '=', 'program_studi.id_prodi')
                ->select('kurikulum.*', 'program_studi.nama_prodi as prodi_nama')
                ->get();
        } else {
            $kurikulumList = DB::table('kurikulum')
                ->leftJoin('program_studi', 'kurikulum.id_prodi', '=', 'program_studi.id_prodi')
                ->select('kurikulum.*', 'program_studi.nama_prodi as prodi_nama')
                ->whereIn('kurikulum.id_prodi', $allowedProdis)
                ->get();
        }

        $user = Auth::user();
        if ($allowedProdis === null) {
            $prodi = DB::table('program_studi')->select('id_prodi', 'nama_prodi', 'id_fakultas')->get();
            $fakultas = DB::table('fakultas')->select('id_fakultas', 'nama_fakultas')->get();
            $kurikulums = DB::table('kurikulum')
                ->leftJoin('program_studi', 'kurikulum.id_prodi', '=', 'program_studi.id_prodi')
                ->select('kurikulum.*', 'program_studi.nama_prodi as prodi_nama')
                ->get();
        } else {
            $prodi = DB::table('program_studi')->whereIn('id_prodi', $allowedProdis)->get();
            $fakultas = [];
            $kurikulums = DB::table('kurikulum')
                ->leftJoin('program_studi', 'kurikulum.id_prodi', '=', 'program_studi.id_prodi')
                ->select('kurikulum.*', 'program_studi.nama_prodi as prodi_nama')
                ->whereIn('kurikulum.id_prodi', $allowedProdis)
                ->get();
        }
        $kategori = DB::table('kategori_cpl')->select('id_kategori', 'kode_kategori', 'nama_kategori', 'urutan')->orderBy('urutan')->get();

        return view('admin.cpl.index', compact('prodiList', 'kurikulumList', 'prodi', 'kurikulums', 'kategori', 'fakultas'));
    }


    public function create()
    {
        $user = Auth::user();
        $allowedProdis = $this->getAllowedProdiIds($user);

        if ($allowedProdis === null) {
            $prodi = DB::table('program_studi')->select('id_prodi', 'nama_prodi')->get();
            $kurikulums = DB::table('kurikulum')
                ->leftJoin('program_studi', 'kurikulum.id_prodi', '=', 'program_studi.id_prodi')
                ->select('kurikulum.*', 'program_studi.nama_prodi as prodi_nama')
                ->get();
        } else {
            $prodi = DB::table('program_studi')->whereIn('id_prodi', $allowedProdis)->get();
            $kurikulums = DB::table('kurikulum')
                ->leftJoin('program_studi', 'kurikulum.id_prodi', '=', 'program_studi.id_prodi')
                ->select('kurikulum.*', 'program_studi.nama_prodi as prodi_nama')
                ->whereIn('kurikulum.id_prodi', $allowedProdis)
                ->get();
        }
        $kategori = DB::table('kategori_cpl')->select('id_kategori', 'kode_kategori', 'nama_kategori', 'urutan')->orderBy('urutan')->get();
        return view('admin.cpl.create', compact('prodi', 'kurikulums', 'kategori'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $allowedProdis = $this->getAllowedProdiIds($user);

        if ($allowedProdis !== null && !in_array($request->id_prodi, $allowedProdis)) {
            abort(403, 'Akses prodi tidak diizinkan.');
        }

        $request->validate([
            'id_prodi' => 'required|exists:program_studi,id_prodi',
            'id_kurikulum' => 'required|exists:kurikulum,id_kurikulum',
            'id_kategori' => 'required|exists:kategori_cpl,id_kategori',
            'kode_cpl' => 'required|string|max:20',
            'deskripsi_cpl' => 'required|string',
            'urutan' => 'nullable|integer',
        ]);

        CplProdi::create($request->all());

        return redirect()->route('cpl.index')->with('success', 'Data CPL Prodi berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $row = DB::table('cpl_prodi')->where('id_cpl', $id)->first();
        if (!$row) abort(404);
        $cpl = CplProdi::hydrate([(array) $row])->first();
        $user = Auth::user();
        $allowedProdis = $this->getAllowedProdiIds($user);

        if ($allowedProdis !== null && !in_array($cpl->id_prodi, $allowedProdis)) {
            abort(403, 'Akses ditolak.');
        }

        if ($allowedProdis === null) {
            $prodi = DB::table('program_studi')->select('id_prodi', 'nama_prodi')->get();
            $kurikulums = DB::table('kurikulum')
                ->leftJoin('program_studi', 'kurikulum.id_prodi', '=', 'program_studi.id_prodi')
                ->select('kurikulum.*', 'program_studi.nama_prodi as prodi_nama')
                ->get();
        } else {
            $prodi = DB::table('program_studi')->whereIn('id_prodi', $allowedProdis)->get();
            $kurikulums = DB::table('kurikulum')
                ->leftJoin('program_studi', 'kurikulum.id_prodi', '=', 'program_studi.id_prodi')
                ->select('kurikulum.*', 'program_studi.nama_prodi as prodi_nama')
                ->whereIn('kurikulum.id_prodi', $allowedProdis)
                ->get();
        }
        $kategori = DB::table('kategori_cpl')->select('id_kategori', 'kode_kategori', 'nama_kategori', 'urutan')->orderBy('urutan')->get();
        return view('admin.cpl.edit', compact('cpl', 'prodi', 'kurikulums', 'kategori'));
    }

    public function update(Request $request, $id)
    {
        $row = DB::table('cpl_prodi')->where('id_cpl', $id)->first();
        if (!$row) abort(404);
        $cpl = CplProdi::hydrate([(array) $row])->first();
        $user = Auth::user();
        $allowedProdis = $this->getAllowedProdiIds($user);

        if ($allowedProdis !== null && !in_array($cpl->id_prodi, $allowedProdis)) {
            abort(403, 'Akses ditolak.');
        }

        if ($allowedProdis !== null && !in_array($request->id_prodi, $allowedProdis)) {
            abort(403, 'Akses prodi tidak diizinkan.');
        }

        $request->validate([
            'id_prodi' => 'required|exists:program_studi,id_prodi',
            'id_kurikulum' => 'required|exists:kurikulum,id_kurikulum',
            'id_kategori' => 'required|exists:kategori_cpl,id_kategori',
            'kode_cpl' => 'required|string|max:20',
            'deskripsi_cpl' => 'required|string',
            'urutan' => 'nullable|integer',
        ]);

        $cpl->update($request->all());

        return redirect()->route('cpl.index')->with('success', 'Data CPL Prodi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $row = DB::table('cpl_prodi')->where('id_cpl', $id)->first();
        if (!$row) abort(404);
        $cpl = CplProdi::hydrate([(array) $row])->first();
        $user = Auth::user();
        $allowedProdis = $this->getAllowedProdiIds($user);

        if ($allowedProdis !== null && !in_array($cpl->id_prodi, $allowedProdis)) {
            abort(403, 'Akses ditolak.');
        }

        $cpl->delete();
        if (request()->ajax()) {
            return response()->json(['success' => true, 'message' => 'Data CPL Prodi berhasil dihapus.']);
        }
        return redirect()->route('cpl.index')->with('success', 'Data CPL Prodi berhasil dihapus.');
    }

    public function datatable(Request $request)
    {
        $user = Auth::user();
        $allowedProdis = $this->getAllowedProdiIds($user);

        $query = DB::table('cpl_prodi')
            ->leftJoin('program_studi', 'cpl_prodi.id_prodi', '=', 'program_studi.id_prodi')
            ->leftJoin('kurikulum', 'cpl_prodi.id_kurikulum', '=', 'kurikulum.id_kurikulum')
            ->leftJoin('kategori_cpl', 'cpl_prodi.id_kategori', '=', 'kategori_cpl.id_kategori')
            ->select(
                'cpl_prodi.*',
                'program_studi.nama_prodi as prodi_nama',
                'kurikulum.nama_kurikulum as kurikulum_nama',
                'kategori_cpl.nama_kategori as kategori_nama'
            );

        if ($allowedProdis !== null) {
            $query->whereIn('cpl_prodi.id_prodi', $allowedProdis);
        }

        if ($request->filled('id_prodi')) {
            $query->where('cpl_prodi.id_prodi', $request->id_prodi);
        }
        if ($request->filled('id_kurikulum')) {
            $query->where('cpl_prodi.id_kurikulum', $request->id_kurikulum);
        }
        if ($request->filled('id_fakultas')) {
            $query->where('program_studi.id_fakultas', $request->id_fakultas);
        }

        return DataTables::of($query)
            ->filterColumn('prodi', function ($query, $keyword) {
                $query->where('program_studi.nama_prodi', 'like', "%{$keyword}%");
            })
            ->filterColumn('kurikulum', function ($query, $keyword) {
                $query->where('kurikulum.nama_kurikulum', 'like', "%{$keyword}%");
            })
            ->filterColumn('kategori', function ($query, $keyword) {
                $query->where('kategori_cpl.nama_kategori', 'like', "%{$keyword}%");
            })
            ->filterColumn('deskripsi', function ($query, $keyword) {
                $query->where('cpl_prodi.deskripsi_cpl', 'like', "%{$keyword}%");
            })
            ->addColumn('prodi', fn($c) => $c->prodi_nama ?? '-')
            ->addColumn('kurikulum', fn($c) => $c->kurikulum_nama ?? '-')
            ->addColumn('kategori', fn($c) => $c->kategori_nama ?? '-')
            ->addColumn('deskripsi', fn($c) => Str::limit($c->deskripsi_cpl, 50))
            ->addColumn('action', function ($row) {
                $rowJson = htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8');
                return '<div class="d-flex justify-content-center gap-2">' . '<a href="javascript:void(0)" onclick="showModal(this)" data-row="' . $rowJson . '" class="btn btn-sm btn-light btn-active-light-info text-center" data-bs-toggle="tooltip" data-bs-title="Detail"><i class="fas fa-file-alt"></i></a>' . ' ' . '<a href="javascript:void(0)" onclick="editModal(this)" data-row="' . $rowJson . '" class="btn btn-sm btn-light btn-active-light-warning text-center" data-bs-toggle="tooltip" data-bs-title="Edit"><i class="fas fa-edit"></i></a>' . ' ' . '<button type="button" onclick="confirmDelete(\'' . $row->id_cpl . '\')" class="btn btn-sm btn-light btn-active-light-danger text-center border-0" data-bs-toggle="tooltip" data-bs-title="Hapus"><i class="fas fa-trash-alt"></i></button>' . '</div>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function downloadTemplate()
    {
        try {
            while (ob_get_level() > 0) {
                ob_end_clean();
            }
            \PhpOffice\PhpSpreadsheet\Shared\File::setUseUploadTempDirectory(true);
            return Excel::download(new CplProdiTemplateExport, 'Template_Import_CPL_Prodi.xlsx');
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('Gagal download template CPL: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return response('TERJADI ERROR (Harap screenshot ini): ' . $e->getMessage() . ' di baris ' . $e->getLine() . ' pada ' . $e->getFile(), 500);
        }
    }

    public function import(Request $request)
    {
        $user = Auth::user();
        $allowedProdis = $this->getAllowedProdiIds($user);

        $request->validate([
            'id_prodi' => 'required|exists:program_studi,id_prodi',
            'id_kurikulum' => 'required|exists:kurikulum,id_kurikulum',
            'file_excel' => 'required|mimes:xlsx,xls,csv|max:5120',
        ], [
            'file_excel.mimes' => 'File harus berformat Excel (.xlsx atau .xls) atau CSV.'
        ]);

        if ($allowedProdis !== null && !in_array($request->id_prodi, $allowedProdis)) {
            abort(403, 'Akses prodi tidak diizinkan.');
        }

        try {
            // Suppress open_basedir warnings dari ZipArchive internal file_exists()
            // Bug PHP: zip:// stream wrapper memanggil file_exists('/xl/worksheets/sheet1.xml')
            // yang dianggap path filesystem absolut oleh open_basedir
            $previousHandler = set_error_handler(function ($errno, $errstr) {
                if (strpos($errstr, 'open_basedir') !== false) {
                    return true; // Suppress warning, jangan convert ke exception
                }
                return false; // Biarkan error lain ditangani handler default
            });

            \PhpOffice\PhpSpreadsheet\Shared\File::setUseUploadTempDirectory(true);

            $file = $request->file('file_excel');
            $ext = strtolower($file->getClientOriginalExtension());

            // Simpan file ke storage dengan ekstensi yang benar
            $filename = 'import_' . uniqid() . '.' . $ext;
            $path = $file->storeAs('temp', $filename);

            $readerType = \Maatwebsite\Excel\Excel::XLSX;
            if ($ext === 'xls') {
                $readerType = \Maatwebsite\Excel\Excel::XLS;
            } elseif ($ext === 'csv') {
                $readerType = \Maatwebsite\Excel\Excel::CSV;
            }

            Excel::import(
                new CplProdiImport($request->id_prodi, $request->id_kurikulum),
                $path,
                'local',
                $readerType
            );

            // Restore error handler & cleanup temp file
            restore_error_handler();
            \Illuminate\Support\Facades\Storage::delete($path);

            return response()->json(['success' => true, 'message' => 'Data CPL Prodi berhasil diimport.']);
        } catch (\Illuminate\Validation\ValidationException $e) {
            restore_error_handler();
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal: <br>' . implode('<br>', $e->errors()['import_error'] ?? ['Terjadi kesalahan pada data.'])
            ], 422);
        } catch (\Exception $e) {
            restore_error_handler();
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage()], 500);
        }
    }
}
