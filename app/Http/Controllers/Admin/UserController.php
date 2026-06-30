<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function index()
    {


        $roleOptions = DB::table('users')->select('role')->distinct()->pluck('role')->sort()->values();
        $statusOptions = ['Aktif', 'Nonaktif'];
        $prodiList = DB::table('program_studi')->select('id_prodi', 'nama_prodi')->get();
        $prodi = DB::table('program_studi')->select('id_prodi', 'nama_prodi')->get();
        $fakultas = DB::table('fakultas')->select('id_fakultas', 'nama_fakultas')->get();



        return view('admin.users.index', compact('roleOptions', 'statusOptions', 'prodiList', 'prodi', 'fakultas'));
    }

    public function create()
    {
        $prodi = DB::table('program_studi')->select('id_prodi', 'nama_prodi')->get();
        $fakultas = DB::table('fakultas')->select('id_fakultas', 'nama_fakultas')->get();
        return view('admin.users.create', compact('prodi', 'fakultas'));
    }

    public function store(Request $request)
    {
        $messages = [
            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username sudah terpakai.',
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
            'role.required' => 'Role wajib dipilih.',
            'id_fakultas.required_if' => 'Fakultas wajib dipilih jika role BAK Fakultas.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
            'email.email' => 'Format email tidak valid.',
            'aktif.required' => 'Status akun wajib dipilih.'
        ];

        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'username' => 'required|string|max:100|unique:users,username',
            'nama_lengkap' => 'required|string|max:255',
            'role' => 'required|in:admin,bak_fakultas',
            'id_fakultas' => 'required_if:role,bak_fakultas|nullable|exists:fakultas,id_fakultas',
            'email' => 'nullable|email|max:100',
            'password' => 'required|string|min:6',
            'aktif' => 'required|boolean',
        ], $messages);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $id_prodi = null;
        if ($request->role === 'bak_fakultas' && $request->filled('id_fakultas')) {
            $firstProdi = DB::table('program_studi')->where('id_fakultas', $request->id_fakultas)->first();
            $id_prodi = $firstProdi ? $firstProdi->id_prodi : null;
        }

        $data = [
            'username' => $request->username,
            'nama_lengkap' => $request->nama_lengkap,
            'role' => $request->role,
            'id_prodi' => $id_prodi,
            'email' => $request->email,
            'aktif' => $request->aktif,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user = User::create($data);

        $this->clearUserCache();
        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'User berhasil ditambahkan.']);
        }
        return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan.');
    }

    private function clearUserCache(): void
    {
        $roles = ['admin', 'bak_fakultas'];
        foreach ($roles as $role) {
            Cache::forget("master:users_role:{$role}");
        }
    }

    public function edit($id)
    {
        $userRow = DB::table('users')->where('id_user', $id)->first();
        if (!$userRow) abort(404);
        $user = User::hydrate([(array) $userRow])->first();
        $prodi = DB::table('program_studi')->select('id_prodi', 'nama_prodi')->get();
        $fakultas = DB::table('fakultas')->select('id_fakultas', 'nama_fakultas')->get();
        $selectedFakultasId = DB::table('program_studi')->where('id_prodi', $user->id_prodi)->value('id_fakultas');
        return view('admin.users.edit', compact('user', 'prodi', 'fakultas', 'selectedFakultasId'));
    }

    public function update(Request $request, $id)
    {
        $userRow = DB::table('users')->where('id_user', $id)->first();
        if (!$userRow) abort(404);
        $user = User::hydrate([(array) $userRow])->first();

        $messages = [
            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username sudah terpakai.',
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
            'role.required' => 'Role wajib dipilih.',
            'id_fakultas.required_if' => 'Fakultas wajib dipilih jika role BAK Fakultas.',
            'password.min' => 'Password minimal 6 karakter.',
            'email.email' => 'Format email tidak valid.',
            'aktif.required' => 'Status akun wajib dipilih.'
        ];

        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'username' => 'required|string|max:100|unique:users,username,' . $id . ',id_user',
            'nama_lengkap' => 'required|string|max:255',
            'role' => 'required|in:admin,bak_fakultas',
            'id_fakultas' => 'required_if:role,bak_fakultas|nullable|exists:fakultas,id_fakultas',
            'email' => 'nullable|email|max:100',
            'password' => 'nullable|string|min:6',
            'aktif' => 'required|boolean',
        ], $messages);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = [
            'username' => $request->username,
            'nama_lengkap' => $request->nama_lengkap,
            'role' => $request->role,
            'email' => $request->email,
            'aktif' => $request->aktif,
        ];

        if ($request->role === 'bak_fakultas') {
            $firstProdi = DB::table('program_studi')->where('id_fakultas', $request->id_fakultas)->first();
            $data['id_prodi'] = $firstProdi ? $firstProdi->id_prodi : null;
        } else {
            $data['id_prodi'] = null;
        }

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        $this->clearUserCache();
        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'User berhasil diperbarui.']);
        }
        return redirect()->route('users.index')->with('success', 'User berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $userRow = DB::table('users')->where('id_user', $id)->first();
        if (!$userRow) abort(404);
        $user = User::hydrate([(array) $userRow])->first();

        // Prevent deleting oneself
        if ($user->id_user === Auth::user()->id_user) {
            if (request()->ajax()) {
                return response()->json(['success' => false, 'message' => 'Anda tidak dapat menghapus akun Anda sendiri.'], 403);
            }
            return redirect()->route('users.index')->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $user->delete();

        $this->clearUserCache();
        if (request()->ajax()) {
            return response()->json(['success' => true, 'message' => 'User berhasil dihapus.']);
        }
        return redirect()->route('users.index')->with('success', 'User berhasil dihapus.');
    }

    public function datatable(Request $request)
    {
        $query = DB::table('users')
            ->leftJoin('program_studi', 'users.id_prodi', '=', 'program_studi.id_prodi')
            ->leftJoin('fakultas', 'program_studi.id_fakultas', '=', 'fakultas.id_fakultas')
            ->select('users.*', 'program_studi.nama_prodi as prodi_nama', 'fakultas.nama_fakultas as fakultas_nama', 'fakultas.id_fakultas');

        if ($request->filled('role')) {
            $query->where('users.role', $request->role);
        }
        if ($request->filled('id_prodi')) {
            $query->where('users.id_prodi', $request->id_prodi);
        }

        return DataTables::of($query)
            ->addColumn('role', function ($u) {
                $roleLabel = ucfirst(str_replace('_', ' ', $u->role));
                return '<span class="badge badge-' . ($u->role === 'admin' ? 'success' : 'primary') . '">' . $roleLabel . '</span>';
            })
            ->addColumn('hubungan', function ($u) {
                if ($u->role === 'bak_fakultas') {
                    return $u->fakultas_nama ?? '-';
                }
                if ($u->role === 'admin') {
                    return 'Semua (Admin)';
                }
                return '-';
            })
            ->addColumn('status', fn($u) => '<span class="badge ' . ($u->aktif ? 'badge-success' : 'badge-danger') . '">' . ($u->aktif ? 'Aktif' : 'Nonaktif') . '</span>')
            ->addColumn('action', function ($row) {
                $rowJson = htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8');
                return '<div class="d-flex justify-content-center gap-2">' . '<a href="javascript:void(0)" onclick="showModal(this)" data-row="' . $rowJson . '" class="btn btn-sm btn-light btn-active-light-info text-center" data-bs-toggle="tooltip" data-bs-title="Detail"><i class="fas fa-file-alt"></i></a>' . ' ' . '<a href="javascript:void(0)" onclick="editModal(this)" data-row="' . $rowJson . '" class="btn btn-sm btn-light btn-active-light-warning text-center" data-bs-toggle="tooltip" data-bs-title="Edit"><i class="fas fa-edit"></i></a>' . ' ' . '<button type="button" onclick="confirmDelete(\'' . $row->id_user . '\')" class="btn btn-sm btn-light btn-active-light-danger text-center border-0" data-bs-toggle="tooltip" data-bs-title="Hapus"><i class="fas fa-trash-alt"></i></button>' . '</div>';
            })
            ->rawColumns(['action', 'role', 'status'])
            ->make(true);
    }
}
