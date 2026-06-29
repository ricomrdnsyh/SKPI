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
        return view('admin.users.index', compact('roleOptions', 'statusOptions', 'prodiList'));
    }

    public function create()
    {
        $prodi = DB::table('program_studi')->select('id_prodi', 'nama_prodi')->get();
        $fakultas = DB::table('fakultas')->select('id_fakultas', 'nama_fakultas')->get();
        return view('admin.users.create', compact('prodi', 'fakultas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:100|unique:users,username',
            'nama_lengkap' => 'required|string|max:255',
            'role' => 'required|in:admin,bak_fakultas',
            'id_fakultas' => 'required_if:role,bak_fakultas|nullable|exists:fakultas,id_fakultas',
            'email' => 'nullable|email|max:100',
            'password' => 'required|string|min:6',
            'aktif' => 'required|boolean',
        ]);

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

        $request->validate([
            'username' => 'required|string|max:100|unique:users,username,' . $id . ',id_user',
            'nama_lengkap' => 'required|string|max:255',
            'role' => 'required|in:admin,bak_fakultas',
            'id_fakultas' => 'required_if:role,bak_fakultas|nullable|exists:fakultas,id_fakultas',
            'email' => 'nullable|email|max:100',
            'password' => 'nullable|string|min:6',
            'aktif' => 'required|boolean',
        ]);

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
        return redirect()->route('users.index')->with('success', 'User berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $userRow = DB::table('users')->where('id_user', $id)->first();
        if (!$userRow) abort(404);
        $user = User::hydrate([(array) $userRow])->first();

        // Prevent deleting oneself
        if ($user->id_user === Auth::user()->id_user) {
            return redirect()->route('users.index')->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $user->delete();

        $this->clearUserCache();
        return redirect()->route('users.index')->with('success', 'User berhasil dihapus.');
    }

    public function datatable(Request $request)
    {
        $query = DB::table('users')
            ->leftJoin('program_studi', 'users.id_prodi', '=', 'program_studi.id_prodi')
            ->leftJoin('fakultas', 'program_studi.id_fakultas', '=', 'fakultas.id_fakultas')
            ->select('users.*', 'program_studi.nama_prodi as prodi_nama', 'fakultas.nama_fakultas as fakultas_nama');

        if ($request->filled('role')) {
            $query->where('users.role', $request->role);
        }
        if ($request->filled('id_prodi')) {
            $query->where('users.id_prodi', $request->id_prodi);
        }

        return DataTables::of($query)
            ->addColumn('role', function ($u) {
                $roleLabel = ucfirst(str_replace('_', ' ', $u->role));
                return '<span class="badge badge-' . ($u->role === 'admin' ? 'emerald' : 'blue') . '">' . $roleLabel . '</span>';
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
            ->addColumn('status', fn($u) => '<span class="badge ' . ($u->aktif ? 'badge-emerald' : 'badge-rose') . '">' . ($u->aktif ? 'Aktif' : 'Nonaktif') . '</span>')
            ->addColumn('action', function ($row) {
                $editRoute = route('users.edit', $row->id_user);
                $deleteRoute = route('users.destroy', $row->id_user);
                return '<div class="flex justify-start gap-1">'
                    . '<a href="' . $editRoute . '" class="btn-edit"><i class="fa-solid fa-pen-to-square"></i></a>'
                    . '<form method="POST" action="' . $deleteRoute . '" onsubmit="return confirm(\'Yakin?\')">'
                    . csrf_field() . method_field('DELETE')
                    . '<button type="submit" class="btn-destroy"><i class="fa-solid fa-trash-can"></i></button>'
                    . '</form></div>';
            })
            ->rawColumns(['action', 'role', 'status'])
            ->make(true);
    }
}
