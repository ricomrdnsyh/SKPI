<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SsoController extends Controller
{
    public function sso(Request $request)
    {
        $url = config('services.sso.me_url');
        $access_token = $request->access_token;
        $xToken = config('services.sso.x_token');
        $UserAgent = $request->header('User-Agent');

        if (!$access_token) {
            return redirect()->route('login')->with('error', 'Access token is missing');
        }

        $response = $this->makeCurlRequest($url, $access_token, $xToken, $UserAgent);

        if (isset($response['success']) && $response['success'] && $response['data'] != null) {
            $responseData = $response['data'];

            if (isset($responseData['nim'])) {
                if ($responseData['id_jenis_keluar'] != 1) {
                    return redirect('/')->with('error', 'Belum bisa buka SKPI karena status Anda belum lulus.');
                }

                $save['nama_lengkap'] = $responseData['nama'];
                $save['tempat_lahir'] = $responseData['tempat_lahir'] ?? null;
                $save['tanggal_lahir'] = $responseData['tanggal_lahir'] ?? null;
                $save['id_prodi'] = $responseData['id_prodi'];
                $save['id_kurikulum'] = $responseData['id_kurikulum'] ?? null;
                $save['email'] = $responseData['email'];
                $save['status'] = $responseData['id_jenis_keluar'] == 1 ? 'Lulus' : 'Aktif';

                $mahasiswa = Mahasiswa::updateOrCreate(['nim' =>  $responseData['nim']], $save);

                Auth::guard('mahasiswa')->login($mahasiswa);

                $callbackUrl = str_replace(config('services.sso.public_url'), config('services.sso.api_url'), $responseData['callback_session']);
                $logoutUrl = str_replace(config('services.sso.public_url'), config('services.sso.api_url'), $responseData['logout_session']);

                $phpSessionId = $request->session()->getId();

                $data = [
                    "logout" => url('/sso/logout/' . $phpSessionId),
                ];
                $this->makeCurlRequest($callbackUrl, $access_token, $xToken, $UserAgent, $data);
                $request->session()->put('logout_session', $logoutUrl);

                return redirect()->route('dashboard');
            } else if (isset($responseData['id_penduduk'])) {

                $user = User::where('username', $responseData['id_penduduk'])->first();

                if (!$user) {
                    return redirect('/')->with('error', 'User belum terdaftar atau tidak punya akses.');
                }

                Auth::guard('web')->login($user);

                $callbackUrl = str_replace(config('services.sso.public_url'), config('services.sso.api_url'), $responseData['callback_session']);
                $logoutUrl   = str_replace(config('services.sso.public_url'), config('services.sso.api_url'), $responseData['logout_session']);

                $phpSessionId = $request->session()->getId();

                $data = [
                    "logout" => url('/sso/logout/' . $phpSessionId),
                ];

                $this->makeCurlRequest($callbackUrl, $access_token, $xToken, $UserAgent, $data);
                $request->session()->put('logout_session', $logoutUrl);

                return redirect()->route('dashboard');
            } else {
                return redirect()->route('login')->with('error', 'Data pengguna tidak valid dari SSO.');
            }
        } else {
            return redirect()->route('login')->with('error', 'Gagal terhubung dengan SSO.');
        }
    }

    public function logout(string $sessionId)
    {
        Auth::guard('web')->logout();
        Auth::guard('mahasiswa')->logout();

        $sessionPath = config('session.files');
        $sessionFile = $sessionPath . '/' . $sessionId;

        if (file_exists($sessionFile)) {
            unlink($sessionFile);
        }

        session()->flush();
        session()->invalidate();
        session()->regenerateToken();

        return response()->json(['message' => 'Logout successful'], 200);
    }

    private function makeCurlRequest($url, $authorizationToken, $xToken, $UserAgent, $data = null)
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POST => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTPHEADER => array_filter([
                "Authorization: Bearer $authorizationToken",
                "X-Token: $xToken",
                "User-Agent: $UserAgent",
                $data ? "Content-Type: application/json" : null,
            ]),
            CURLOPT_POSTFIELDS => $data ? json_encode($data) : null,
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return ['success' => false, 'error' => "cURL Error: " . $err];
        }
        $decodedResponse = json_decode($response, true);

        return $decodedResponse;
    }
}
