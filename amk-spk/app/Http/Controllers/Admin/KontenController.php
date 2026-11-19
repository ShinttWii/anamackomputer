<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KontenController extends Controller
{
    public function index()
    {
        $settings = SiteSetting::all()->keyBy('kunci');
        return view('admin.konten.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'hero_judul'       => 'nullable|string|max:200',
            'hero_deskripsi'   => 'nullable|string|max:500',
            'tentang_deskripsi'=> 'nullable|string|max:600',
            'logo'             => 'nullable|image|mimes:png,jpg,jpeg,svg,webp|max:2048',
            'banner_hero'      => 'nullable|image|mimes:png,jpg,jpeg,webp|max:4096',
        ], [
            'logo.image'       => 'File harus berupa gambar.',
            'logo.mimes'       => 'Format logo: PNG, JPG, SVG, atau WEBP.',
            'logo.max'         => 'Ukuran logo maksimal 2MB.',
            'banner_hero.image'=> 'File harus berupa gambar.',
            'banner_hero.mimes'=> 'Format banner: PNG, JPG, atau WEBP.',
            'banner_hero.max'  => 'Ukuran banner maksimal 4MB.',
        ]);

        // Simpan teks
        foreach (['hero_judul', 'hero_deskripsi', 'tentang_deskripsi'] as $key) {
            if ($request->filled($key)) {
                SiteSetting::set($key, $request->input($key));
            }
        }

        // Upload logo
        if ($request->hasFile('logo')) {
            $this->hapusGambarLama('logo');
            $path = $request->file('logo')->store('konten', 'public');
            SiteSetting::set('logo', $path);
        }

        // Upload banner hero
        if ($request->hasFile('banner_hero')) {
            $this->hapusGambarLama('banner_hero');
            $path = $request->file('banner_hero')->store('konten', 'public');
            SiteSetting::set('banner_hero', $path);
        }

        return back()->with('success', 'Konten berhasil diperbarui.');
    }

    public function hapusGambar(Request $request, string $kunci)
    {
        $this->hapusGambarLama($kunci);
        SiteSetting::set($kunci, null);
        return back()->with('success', 'Gambar berhasil dihapus.');
    }

    private function hapusGambarLama(string $kunci): void
    {
        $nilai = SiteSetting::get($kunci);
        if ($nilai && Storage::disk('public')->exists($nilai)) {
            Storage::disk('public')->delete($nilai);
        }
    }
}
