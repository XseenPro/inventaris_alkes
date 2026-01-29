<?php

namespace App\Http\Controllers;

use App\Models\Kalibrasi;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;

class KalibrasiSertifikatController extends Controller
{
  private function sanitizeFilename(string $filename): string
  {
    $slug = Str::slug($filename);

    if (empty($slug)) {
      $invalidChars = ['/', '\\', ':', '*', '?', '"', '<', '>', '|'];
      $slug = str_replace($invalidChars, '-', $filename);
      $slug = preg_replace('/-+/', '-', $slug);
      $slug = trim($slug, '-');
    }

    return Str::limit($slug, 200, '');
  }


  public function download(Request $request, Kalibrasi $kalibrasi)
  {
    if (!$request->hasValidSignature()) {
      abort(401, 'Link tidak valid atau sudah kadaluarsa.');
    }

    if (!$kalibrasi->sertifikat_kalibrasi) {
      abort(404, 'Sertifikat tidak ditemukan.');
    }

    if (!Storage::disk('public')->exists($kalibrasi->sertifikat_kalibrasi)) {
      abort(404, 'File sertifikat tidak ditemukan.');
    }

    $password = Setting::where('key', 'export_password')->first()?->value;

    if ($password && !$request->session()->get('sertifikat_password_verified_' . $kalibrasi->id)) {
      return view('kalibrasi.sertifikat-password', [
        'kalibrasi' => $kalibrasi,
        'downloadUrl' => $request->fullUrl()
      ]);
    }

    $cleanNomorSertifikat = $this->sanitizeFilename($kalibrasi->nomor_sertifikat);

    if (empty($cleanNomorSertifikat)) {
      $cleanNomorSertifikat = 'Sertifikat-' . $kalibrasi->id;
    }

    $filePath = Storage::disk('public')->path($kalibrasi->sertifikat_kalibrasi);
    $fileName = 'Sertifikat_' . $cleanNomorSertifikat . '.pdf';

    return Response::download($filePath, $fileName, [
      'Content-Type' => 'application/pdf',
    ]);
  }

  public function verifyPassword(Request $request, Kalibrasi $kalibrasi)
  {
    $request->validate([
      'password' => 'required|string',
    ]);

    $savedPassword = Setting::where('key', 'export_password')->first()?->value;

    if ($request->password === $savedPassword) {
      $request->session()->put('sertifikat_password_verified_' . $kalibrasi->id, true);

      return redirect()->to($request->input('download_url'));
    }

    return back()->withErrors(['password' => 'Password salah.'])->withInput();
  }
}
