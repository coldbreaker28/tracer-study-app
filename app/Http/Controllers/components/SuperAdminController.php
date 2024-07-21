<?php

namespace App\Http\Controllers\components;

use App\Http\Controllers\Controller;
use App\Models\Alumni;
use App\Models\User;
use App\Models\Jurusan;
use App\Models\Karir;
use Carbon\Carbon;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Exports\AlumniExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class SuperAdminController extends Controller
{
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function index()
    {
        if (auth()->user()->role !== 'superadmin') {
            abort(403, 'Unauthorized');
        }
        $alumni = Alumni::with('jurusans')->get()->all();
        return view('superadmin.dashboard', compact('alumni'));
    }
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function create(){
        if (auth()->user()->role !== 'superadmin') {
            abort(403, 'Unauthorized');
        }
        return view('superadmin.create');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function postCreate(Request $request)
    {
        $validatedDataJurusan = $request->validate([
            'jurusan' => 'required|in:Teknik Komputer dan Informatika,Teknik Otomotif,Agrobisnis Pengolahan Hasil Pertanian,Teknik Mesin',
            'kompetensi_keahlian' => 'required|in:Multimedia,Teknik Kendaraan Ringan Otomotif,Agrobisnis Pengolahan Hasil Pertanian,Teknik Pemesinan,Teknik Pengelasan',
        ]);
        $validatedDataAlumni = $request->validate([
            'name' => 'required|max:35',
            'tanggal_lahir' => 'required',
            'alamat' => 'required',
            'nama_orang_tua' => 'required|max:35',
            'nis' => 'required|min:8',
            'nisn' => 'required|min:8',
            'nomor_ujian_nasional' => 'required|min:6',
            'tanggal_lulus' => 'required',
        ]);

        // $validatedDataAlumni['tanggal_lahir'] = Carbon::createFromFormat('Y/m/d', $request->input('tanggal_lahir'))->format('Y/m/d');
        // $validatedDataAlumni['tanggal_lulus'] = Carbon::createFromFormat('Y/m/d', $request->input('tanggal_lulus'))->format('Y/m/d');

        $validatedDataKarir = $request->validate([
            'karir' => 'required|string',
            'jenis_karir' => 'required|in:Pekerjaan,Perguruan Tinggi',
            'alamat_karir' => 'required|string',
        ]);

        $jurusan = Jurusan::create($validatedDataJurusan);

        $karir = Karir::create($validatedDataKarir);

        $alumni = new Alumni($validatedDataAlumni);
        $alumni->jurusans()->associate($jurusan);
        $alumni->karirs()->associate($karir);
        $alumni->save();

        return redirect()->intended('super-admin/dashboard')->withSuccess('Data has been Saved!');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function detail($id)
    {
        $alumni = Alumni::with('jurusans', 'karirs')->findOrFail($id);
        if(!$alumni){
            return abort(404);
        }
        return view('superadmin.detail', compact('alumni'));
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function edit($id)
    {
        $alumni = Alumni::with('jurusans', 'karirs')->findOrFail($id);
        if(!$alumni){
            return abort(404);
        }
        return view('superadmin.edit', compact('alumni'));
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function editPost(Request $request, $id)
    {
        $validatedDataJurusan = $request->validate([
            'jurusan' => 'required|in:Teknik Komputer dan Informatika,Teknik Otomotif,Agrobisnis Pengolahan Hasil Pertanian,Teknik Mesin',
            'kompetensi_keahlian' => 'required|in:Multimedia,Teknik Kendaraan Ringan Otomotif,Agrobisnis Pengolahan Hasil Pertanian,Teknik Pemesinan,Teknik Pengelasan',
        ]);

        $validatedDataAlumni = $request->validate([
            'name' => 'required|max:35',
            'tanggal_lahir' => 'required',
            'alamat' => 'required|string',
            'nama_orang_tua' => 'required|max:35',
            'nis' => 'required|min:8',
            'nisn' => 'required|min:8',
            'nomor_ujian_nasional' => 'required|min:6',
            'tanggal_lulus' => 'required',
        ]);
        
        $validatedDataKarir = $request->validate([
            'karir' => 'required|string',
            'jenis_karir' => 'required|in:Pekerjaan,Perguruan Tinggi',
            'alamat_karir' => 'required|string',
        ]);

        $alumni = Alumni::with('jurusans', 'karirs')->findOrFail($id);      
        // Update data jurusan
        $jurusans = $alumni->jurusans;
        $jurusans->jurusan = $request->input('jurusan');
        $jurusans->kompetensi_keahlian = $request->input('kompetensi_keahlian');
        $jurusans->save();

        // Update data karir
        $karirs = $alumni->karirs;
        $karirs->karir = $request->input('karir');
        $karirs->jenis_karir = $request->input('jenis_karir');
        $karirs->alamat_karir = $request->input('alamat_karir');
        $karirs->save();

        $alumni->update([
            'name' => $request->input('name'),
            'tanggal_lahir' => $request->input('tanggal_lahir'),
            'alamat' => $request->input('alamat'),
            'nama_orang_tua' => $request->input('nama_orang_tua'),
            'nis' => $request->input('nis'),
            'nisn' => $request->input('nisn'),
            'nomor_ujian_nasional' => $request->input('nomor_ujian_nasional'),
            'tanggal_lulus' => $request->input('tanggal_lulus'),
            // Update kolom lainnya sesuai kebutuhan
        ]);

        return redirect()->route('super-admin.dashboard')->withSuccess('Data has been Update!');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function destroy($id)
    {
        $alumni = Alumni::with('jurusans', 'karirs')->findOrFail($id);
        
        $alumni->delete();

        if($alumni->jurusans){
            $alumni->jurusans->delete();
        }
        
        if($alumni->karirs){
            $alumni->karirs->delete();
        }

        return redirect()->intended('super-admin/dashboard')->withSuccess('Data has been Delete');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function user()
    {
        if (auth()->user()->role !== 'superadmin') {
            abort(403, 'Unauthorized');
        }
        $user = User::all();
        return view('superadmin.user-data', compact('user'));
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function userDetail($id)
    {
        $user = User::findOrFail($id);
        if(!$user){
            return abort(404);
        }
        return view('superadmin.user-detail', compact('user'));
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function editUser($id)
    {
        $user = User::findOrFail($id);
        return view('superadmin.user-edit', compact('user'));
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function editUserPost(Request $request, $id)
    {
        $request->validate([
            'name'=> 'required|string|max:35|unique:users',
            'jabatan' => 'required|in:alumni,guru,staf administrasi,wakil kepala sekolah,kepala sekolah',

        ]);
        $user = User::findOrFail($id);
        $user -> name = $request->input('name');
        $user -> jabatan = $request->input('jabatan');
        $user->save();
        return redirect()->route('super-admin.user')->withSuccess('Data has been Update!');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function destroyUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->intended('super-admin/dashboard')->withSuccess('Data has been Delete!');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function cekKarir()
    {
        $alumniData = Alumni::with('jurusans', 'karirs')->get();
        $alumni = $alumniData->all();
        $alumniByYearAndKarir = [];
        foreach ($alumni as $alumniItem) {
            $tanggalLulus = Carbon::parse($alumniItem->tanggal_lulus);
            $tahunLulus = $tanggalLulus->format('Y');
            $jenisKarir = $alumniItem->karirs->jenis_karir;
            if (!isset($alumniByYearAndKarir[$tahunLulus])) {
                $alumniByYearAndKarir[$tahunLulus] = [];
            }
            if (!isset($alumniByYearAndKarir[$tahunLulus][$jenisKarir])) {
                $alumniByYearAndKarir[$tahunLulus][$jenisKarir] = 0;
            }
            $alumniByYearAndKarir[$tahunLulus][$jenisKarir]++;
        }
        $grafikData = [
            'labels' => [], // Daftar tahun lulus
            'datasets' => [
                [
                    'label' => 'Pekerjaan',
                    'data' => [],
                    'backgroundColor' => 'rgba(255, 99, 132, 0.2)', // Warna merah untuk 'pekerjaan'
                    'borderColor' => 'rgba(255, 99, 132, 1)',
                    'borderWidth' => 1
                ],
                [
                    'label' => 'Perguruan Tinggi',
                    'data' => [],
                    'backgroundColor' => 'rgba(54, 162, 235, 0.2)', // Warna biru untuk 'perguruan tinggi'
                    'borderColor' => 'rgba(54, 162, 235, 1)',
                    'borderWidth' => 1
                ]
            ]
        ];        
        foreach ($alumniByYearAndKarir as $tahunLulus => $karirData) {
            $grafikData['labels'][] = $tahunLulus;
            $grafikData['datasets'][0]['data'][] = $karirData['Pekerjaan'] ?? 0;
            $grafikData['datasets'][1]['data'][] = $karirData['Perguruan Tinggi'] ?? 0;
        }              
        return view('superadmin.karir', compact('grafikData', 'alumniData'));
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function rinci()
    {
        $alumni = Alumni::with('jurusans', 'karirs')->get()->all();
        
        $totalAlumni = Alumni::count();

        $kompetensiKeahlian = [
            'Multimedia',
            'Teknik Kendaraan Ringan Otomotif',
            'Agrobisnis Pengolahan Hasil Pertanian',
            'Teknik Pemesinan',
            'Teknik Pengelasan',
        ];

        $alumniPerKomli = [];
        $averageAlumniPerKomli = [];

        foreach ($kompetensiKeahlian as $kompetensi) {
            $count = Jurusan::where('kompetensi_keahlian', $kompetensi)->count();
            $alumniPerKomli[$kompetensi] = $count;
            $averageAlumniPerKomli[$kompetensi] = ($count / $totalAlumni) * 100;
        }

        // Menghitung data berdasarkan tahun lulus
        $alumniByYear = [];
        foreach ($alumni as $alumniItem) {
            $tahunLulus = Carbon::parse($alumniItem->tanggal_lulus)->format('Y');
            if (!isset($alumniByYear[$tahunLulus])) {
                $alumniByYear[$tahunLulus] = [];
            }
            $alumniByYear[$tahunLulus][] = $alumniItem;
        }

        $grafikData = [
            'labels' => array_keys($alumniByYear),
            'datasets' => [],
        ];

        $warnaKompetensi = [
            'Multimedia' => 'rgba(164, 37, 203, 0.4)',     // Ungu
            'Teknik Kendaraan Ringan Otomotif' => 'rgba(162, 158, 162, 0.4)',  // Abu-abu
            'Agrobisnis Pengolahan Hasil Pertanian' => 'rgba(255, 165, 0, 0.4)',  // Oranye
            'Teknik Pemesinan' => 'rgba(43, 194, 234, 0.4)',   // Biru
            'Teknik Pengelasan' => 'rgba(227, 57, 29, 0.4)',  // Merah Tua
        ];

        foreach ($kompetensiKeahlian as $kompetensi) {
            $data = [
                'label' => $kompetensi,
                'data' => [],
                'backgroundColor' => $warnaKompetensi[$kompetensi],
                'borderColor' => $warnaKompetensi[$kompetensi],
                'borderWidth' => 1,
            ];

            foreach ($grafikData['labels'] as $tahun) {
                $data['data'][] = count(array_filter($alumniByYear[$tahun], function ($alumniItem) use ($kompetensi) {
                    return $alumniItem->jurusans->kompetensi_keahlian === $kompetensi;
                }));
            }

            $grafikData['datasets'][] = $data;
        }

        return view('superadmin.laporan', [
            'totalAlumni' => $totalAlumni,
            'alumniPerKomli' => $alumniPerKomli,
            'averageAlumniPerKomli' => $averageAlumniPerKomli,
            'grafikData' => $grafikData,
        ], compact('alumni'));
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function showPage()
    {
        $data = Alumni::with('jurusans', 'karirs')->get()->all();
        return view('superadmin.pdf', compact('data'));
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function createPDF()
    {
        $alumni = Alumni::with('jurusans', 'karirs')->get();
        $data = $alumni->all();
        
        $options = new Options();
        $options->set('isPhpEnabled', true);

        $pdf = new Dompdf();

        $html = view('admin.pdf', compact('data'))->render();

        $exportDate = date('Y-m-d H:i:s');
        $footerHtml = '<div style="text-align: right;"><p>Ekspor Tanggal : ' . $exportDate . '</p></div>';
        
        $html = $footerHtml . $html;

        $pdf->loadHtml($html);

        $pdf->setPaper('F4', 'landscape');

        $pdf->render();

        $pdf->stream('document-list.pdf');

        // untuk save ke direktori
        // return $pdf->save(public_path('rekap-karir-alumni-per-tahun-ini.pdf'));

        // unduh langsung PDF
        // return $pdf->download('rekap-karir-alumni-per-tahun-ini.pdf');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function exportExcel()
    {
        return Excel::download(new AlumniExport, 'alumni.xlsx');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function exportCSV()
    {
        return Excel::download(new AlumniExport, 'alumni.csv', \Maatwebsite\Excel\Excel::CSV);
    }
}