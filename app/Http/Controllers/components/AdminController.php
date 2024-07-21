<?php

namespace App\Http\Controllers\components;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\Karir;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Exports\AlumniExport;
use App\Http\Requests\ImportCsvRequest;
use App\Models\Jurusan;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

use function Termwind\render;

class AdminController extends Controller
{
    public function index(Request $request){
        if (auth()->user()->level !== 'admin') {
            abort(403, 'Unauthorized');
        }

        $user = auth()->user();
        $filter = $request->input('filter');
        $search = $request->input('search');

        $alumni = Siswa::query()->join('jurusans', 'jurusan_id', '=', 'jurusans.id')->join('users', 'user_id', '=', 'users.id')->select('siswas.*', 'jurusans.kompetensi_keahlian', 'users.name');

        if ($search) {
            $alumni = $alumni->where(function ($query) use ($search) {
                $query->where('users.name', 'like', '%' . $search . '%')->orWhere('siswas.nis', 'like', '%' . $search . '%');
            });
        }

        switch ($filter) {
            case 'name_asc':
                $alumni = $alumni->orderBy('users.name', 'asc');
                break;
            case 'name_desc':
                $alumni = $alumni->orderBy('users.name', 'desc');
                break;
            case 'kompetensi_asc':
                $alumni = $alumni->orderBy('jurusans.kompetensi_keahlian', 'asc')->orderBy('users.name', 'asc');
                break;
            case 'kompetensi_desc':
                $alumni = $alumni->orderBy('jurusans.kompetensi_keahlian', 'desc')->orderBy('users.name', 'desc');
                break;
            case 'tahun_asc':
                $alumni = $alumni->orderBy(DB::raw('YEAR(tanggal_lulus)'), 'asc');
                break;
            case 'tahun_desc':
                $alumni = $alumni->orderBy(DB::raw('YEAR(tanggal_lulus)'), 'desc');
                break;
            case 'terbaru':
                $alumni = $alumni->orderBy('siswas.created_at', 'desc');
                break;
            case 'terakhir':
                $alumni = $alumni->orderBy('siswas.created_at', 'asc');
                break;
            default:
                $alumni = $alumni->orderBy('users.name', 'asc');
                break;
        }

        $alumni = $alumni->paginate(4);
        # code...
        
        $siswaColumns = ['name', 'nis', 'nisn', 'alamat', 'nama_orang_tua','tanggal_lahir', 'tanggal_lulus'];
        $totalSiswa = Siswa::count();

        $siswaWithNullCount = Siswa::where(function($query) use ($siswaColumns) {
            foreach ($siswaColumns as $column) {
                $query->orWhereNull($column);
            }
        })->count();
    
        $siswaWithoutNullCount = $totalSiswa - $siswaWithNullCount;
    
        $data_siswa = [
            'siswas' => [
                'withNull' => $siswaWithNullCount,
                'withoutNull' => $siswaWithoutNullCount
            ],
        ];

        $karirCounts = Karir::select('jenis_karir', DB::raw('count(*) as total'))->groupBy('jenis_karir')->pluck('total', 'jenis_karir');

        $jenis_karir = [
            'Bekerja' => $karirCounts->get('Bekerja', 0),
            'Wiraswasta' => $karirCounts->get('Wiraswasta', 0),
            'Belum bekerja' => $karirCounts->get('Belum ada', 0),
            'Lanjut Studi' => $karirCounts->get('Lanjut Studi', 0)
        ];
        
        return view('admin.dashboard', compact('user', 'alumni', 'data_siswa', 'jenis_karir'));
    }
    public function create(){
        if (auth()->user()->level !== 'admin') {
            abort(403, 'Unauthorized');
        }
        $jurusan = Jurusan::all();
        $siswa = Siswa::with('jurusans')->get();
        $user = auth()->user();
        return view('admin.create-siswa', compact('user','siswa', 'jurusan'));
    }
    public function postCreate(Request $request){
        if (auth()->user()->level !== 'admin') {
            abort(403, 'Unauthorized');
        }
        $rules = [
            'name' => 'required|string|max:35',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'level' => 'required|string',
            'nis' => 'required|string|max:15|min:8|unique:siswas',
            'nisn' => 'required|string|max:10|min:8|unique:siswas',
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:20480',
            'status_siswa' => 'required|string|in:lulus',
            'kompetensi_keahlian' => 'required|exists:jurusans,id',
        ];
        $request->validate($rules);
        $avatarPath = $request->file('avatar')->store('avatars', 'public');
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'level' => $request->level,
            'avatar' => $avatarPath,
        ]);
        if ($request->level === 'siswa') {
            # code...
            Siswa::create([
                'user_id' => $user->id,
                'name' => $user->name,
                'nis' => $request->nis,
                'nisn' => $request->nisn,
                'status_siswa' => $request->status_siswa,
                'jurusan_id' => $request->kompetensi_keahlian
            ]);
        }
        return redirect()->route('admin.data-user')->withSuccess('Data has been Saved!');
    }
    
    public function detail($slug)
    {
        if (auth()->user()->level !== 'admin') {
            abort(403, 'Unauthorized');
        }

        $alumni = Siswa::where('slug', $slug)->firstOrFail();
        // if ($alumni -> slug !== $slug){
        //     return abort(404);
        // }
        $karir = $alumni->karirs()->latest()->first();
        // $karirTerakhir = $siswa->karirs()->latest()->first();
        $userAlumni = User::find($alumni->user_id);
        $pendapatanData = $alumni->karirs->map(function($karir) {
            return [ 
                'tahun' => Carbon::parse($karir->created_at)->format('Y'),
                'pendapatan' => $karir->pendapatan
            ];
        });
        $user = auth()->user();
        return view('admin.detail', compact('alumni', 'user', 'userAlumni','karir', 'pendapatanData'));
    }
    public function edit($slug){
        if (auth()->user()->level !== 'admin') {
            abort(403, 'Unauthorized');
        }
        $alumni = Siswa::where('slug', $slug)->firstOrFail();
        $karir = $alumni->karirs()->first();
        $userAlumni = User::find($alumni->user_id);
        $user = auth()->user();
        return view('admin.edit', compact('alumni', 'karir', 'user', 'userAlumni'));
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function editPost(Request $request, $id){
        if (auth()->user()->level !== 'admin') {
            abort(403, 'Unauthorized');
        }
        $request->validate([
            'name' => 'required|max:35',
            'tanggal_lahir' => 'required|date_format:d-m-Y',
            'alamat' => 'required|string',
            'nama_orang_tua' => 'required',
            'nis' => 'required|min:8',
            'nisn' => 'required|min:8',
            'kompetensi_keahlian' => 'required',
            'jurusan' => 'required',
            'tanggal_lulus' => 'required|date_format:d-m-Y',
        ]);
        
        $alumni = Siswa::with('karirs')->findOrFail($id);      
        $alumni->update([
            'name' => $request->input('name'),
            'tanggal_lahir' => $request->input('tanggal_lahir'),
            'alamat' => $request->input('alamat'),
            'nama_orang_tua' => $request->input('nama_orang_tua'),
            'nis' => $request->input('nis'),
            'nisn' => $request->input('nisn'),
            'kompetensi_keahlian' => $request->input('kompetensi_keahlian'),
            'jurusan' => $request->input('jurusan'),
            'tanggal_lulus' => $request->tanggal_lulus,
        ]);

        return redirect()->route('admin.dashboard')->withSuccess('Data has been Update!');
    }
    public function destroy($id){
        if (auth()->user()->level !== 'admin') {
            abort(403, 'Unauthorized');
        }
        $alumni = Siswa::where('id', $id)->firstOrFail();
        // dd($alumni);
        if ($alumni->karirs()->exists()) {
            $alumni->karirs()->delete();
        }
        $userId = $alumni->users;
        $user = auth()->user();
        $alumni->delete();
        if($userId && $userId->level === 'siswa'){
            $userId->delete();
        }
        return redirect()->intended('admin/dashboard')->withSuccess('Data has been Delete');
    }

    public function user(){
        if (auth()->user()->level !== 'admin') {
            abort(403, 'Unauthorized');
        }
        $userAll = User::paginate(15);
        $user = auth()->user();
        
        return view('superadmin.user-data', compact('user', 'userAll'));
    }
    public function userDetail($id, $slug){
        if (auth()->user()->level !== 'admin') {
            abort(403, 'Unauthorized');
        }
        $user = auth()->user();
        $userId = User::findOrFail($id);
        if(!$userId){
            return abort(404);
        }
        return view('superadmin.user-detail', compact('userId', 'user'));
    }
    public function destroyUser($id){
        if (auth()->user()->level !== 'admin') {
            abort(403, 'Unauthorized');
        }
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->back()->withSuccess('Data has been Delete!');
    }
    public function updateUser(Request $request, $id){
        if (auth()->user()->level !== 'admin') {
            abort(403, 'Unauthorized');
        }
        # code...
        $user = User::findOrFail($id);
        if($request->has('password')){
            $user->password = Hash::make($request->input('password'));
        }
        $user->save();
        return response()->json(['success' => 'User updated successfully']);
    }
    public function cekKarir(){
        if (auth()->user()->level !== 'admin') {
            abort(403, 'Unauthorized');
        }
        $user = auth()->user();
        $no = 1;
        $alumni = Siswa::with('karirs', 'jurusans')->get()->all();
        $years = Siswa::selectRaw('YEAR(tanggal_lulus) as tahun_lulus')->distinct()->orderBy('tahun_lulus', 'desc')->pluck('tahun_lulus');
        $bidangKarirList = Karir::distinct()->pluck('karirs.bidang');
        $alumniByYearAndKarir = [];
        $alumniByYearAndBidang = [];
        foreach ($alumni as $alumniItem) {
            $tanggalLulus = Carbon::parse($alumniItem->tanggal_lulus);
            $tahunLulus = $tanggalLulus->format('Y');
            
            foreach ($alumniItem->karirs as $karir) {
                $bidang = $karir->bidang;
                if (!isset($alumniByYearAndBidang[$tahunLulus])) {
                    $alumniByYearAndBidang[$tahunLulus] = [];
                }
                if (!isset($alumniByYearAndBidang[$tahunLulus][$bidang])) {
                    $alumniByYearAndBidang[$tahunLulus][$bidang] = 0;
                }
                $alumniByYearAndBidang[$tahunLulus][$bidang]++;
            }
        }
        $grafikData = [
            'labels' => [],
            'datasets' => [
            ]
        ];

        $uniqueBidangs = [];
        foreach ($alumniByYearAndBidang as $karirData){
            $uniqueBidangs = array_merge($uniqueBidangs, array_keys($karirData));
        }
        $uniqueBidangs = array_unique($uniqueBidangs);

        foreach ($uniqueBidangs as $bidang) {
            $grafikData['datasets'][] = [
                'label' => $bidang,
                'data' => [],
                'backgroundColor' => 'rgba(' . rand(0, 255) . ', ' . rand(0, 255) . ', ' . rand(0, 255) . ', 0.3)',
                'borderColor' => 'rgba(' . rand(0, 255) . ', ' . rand(0, 255) . ', ' . rand(0, 255) . ', 1)',
                'borderWidth' => 1
            ];
        }

        foreach ($alumniByYearAndBidang as $tahunLulus => $karirData){
            $grafikData['labels'][] = $tahunLulus;
            foreach ($uniqueBidangs as $index => $bidang){
                $grafikData['datasets'][$index]['data'][] = $karirData[$bidang] ?? 0;
            }
        }
        // foreach ($alumniByYearAndKarir as $tahunLulus => $karirData) {
        //     $grafikData['labels'][] = $tahunLulus;
        //     $grafikData['datasets'][0]['data'][] = $karirData['bekerja'] ?? 0;
        //     $grafikData['datasets'][1]['data'][] = $karirData['Perguruan tinggi'] ?? 0;
        // }              
        return view('admin.karir', compact('grafikData', 'alumni', 'no', 'years', 'bidangKarirList', 'user'));
    }
    public function rinci(){
        if (auth()->user()->level !== 'admin') {
            abort(403, 'Unauthorized');
        }
        $user = auth()->user();
        $alumni = Siswa::with('karirs', 'jurusans')->get();
        $totalAlumni = Siswa::count();
        $kompetensiKeahlian = Jurusan::pluck('kompetensi_keahlian')->toArray();
        $alumniPerKomli = [];
        $averageAlumniPerKomli = [];

        foreach ($kompetensiKeahlian as $kompetensi) {
            $count = Siswa::whereHas('jurusans', function($query) use ($kompetensi) {
                $query->where('kompetensi_keahlian', $kompetensi);
            })->count();
            $alumniPerKomli[$kompetensi] = $count;
            if ($totalAlumni > 0 ){
                $averageAlumniPerKomli[$kompetensi] = ($count / $totalAlumni) * 100;
            }else{
                $averageAlumniPerKomli[$kompetensi] = 0;
            }
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
            'Desain Komunikasi Visual' => 'rgba(164, 37, 203, 0.4)',     // Ungu
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
        return view('admin.laporan', [
            'totalAlumni' => $totalAlumni,
            'alumniPerKomli' => $alumniPerKomli,
            'averageAlumniPerKomli' => $averageAlumniPerKomli,
            'grafikData' => $grafikData,
        ], compact('alumni', 'user'));
    }

    public function dataJurusan(){
        if (auth()->user()->level !== 'admin') {
            abort(403, 'Unauthorized');
        }
        $jurusan = Jurusan::get()->all();
        $user = auth()->user();
        return view('admin.data-jurusan', compact('jurusan', 'user'));
    }
    public function JurusanForm(){
        if (auth()->user()->level !== 'admin') {
            abort(403, 'Unauthorized');
        }
        # code...
        $user = auth()->user();
        return view('admin.form-jurusan', compact('user'));
    }
    public function JurusanAdd(Request $request){
        if (auth()->user()->level !== 'admin') {
            abort(403, 'Unauthorized');
        }
        # code...
        $request->validate([
            'kompetensi_keahlian' => 'required|max:35',
            'program_studi' => 'required|max:35',
        ]);
        $jurusan = Jurusan::get();
        $jurusan->create([
            'kompetensi_keahlian' => $request->input('kompetensi_keahlian'),
        ]);
        return redirect()->route('admin.laporan.jurusan');
    }
    public function jurusanEdit($id){
        if (auth()->user()->level !== 'admin') {
            abort(403, 'Unauthorized');
        }
        # code...
        $jurusan = Jurusan::findOrFail($id);
        $jurusan->latest()->first();
        $user = auth()->user();
        return view('admin.form-edit-jurusan', compact('jurusan', 'user'));
    }
    public function jurusanUpdate(Request $request, $id){
        if (auth()->user()->level !== 'admin') {
            abort(403, 'Unauthorized');
        }
        # code...
        $request->validate([
            'kompetensi_keahlian' => 'required|max:35',
            'program_studi' => 'required|max:35',
        ]);

        $jurusan = Jurusan::findOrFail($id);
        
        $jurusan->update([
            'kompetensi_keahlian' => $request->input('kompetensi_keahlian'),
        ]);

        $jurusan->save();
        return redirect()->route('admin.laporan.jurusan')->withCookie('data has been update');
    }

    public function jurusanDestroyer($id)
    {
        if (auth()->user()->level !== 'admin') {
            abort(403, 'Unauthorized');
        }
        # code...
        $jurusan = Jurusan::findOrFail($id);
        $jurusan->delete();
        return redirect()->back();
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function showPage(Request $request)
    {
        if (auth()->user()->level !== 'admin') {
            abort(403, 'Unauthorized');
        }
        $tahunLulus = $request->input('tahun_lulus');
        $bidangKarir = $request->input('bidang');
        
        $query = Siswa::with('karirs', 'jurusans');
        
        if($tahunLulus && $tahunLulus !== 'all'){
            $query->whereYear('tanggal_lulus', $tahunLulus);
        }

        if($bidangKarir && $bidangKarir !== 'all'){
            $query->whereHas('karirs', function  ($q) use ($bidangKarir) {
                $q->where('bidang', $bidangKarir);
            });
        }

        $data = $query->get();
        $bidangKarirList = Karir::distinct()->pluck('karirs.bidang');
        $years = Siswa::selectRaw('YEAR(tanggal_lulus) as tahun_lulus')->distinct()->orderBy('tahun_lulus', 'desc')->pluck('tahun_lulus');

        // Proses data grafik
        return view('admin.pdf', compact('data', 'years', 'tahunLulus'));
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function createPDF(Request $request){   
        if (auth()->user()->level !== 'admin') {
            abort(403, 'Unauthorized');
        }
        $tahunLulus = $request->input('tahun_lulus');
        $bidangKarir = $request->input('bidang');
        
        $query = Siswa::with('karirs', 'jurusans');
        
        if($tahunLulus && $tahunLulus !== 'all'){
            $query->whereYear('tanggal_lulus', $tahunLulus);
        }

        if($bidangKarir && $bidangKarir !== 'all'){
            $query->whereHas('karirs', function  ($q) use ($bidangKarir) {
                $q->where('bidang', $bidangKarir);
            });
        }

        $data = $query->get();
        $bidangKarirList = Karir::distinct()->pluck('karirs.bidang');
        $years = Siswa::selectRaw('YEAR(tanggal_lulus) as tahun_lulus')->distinct()->orderBy('tahun_lulus', 'desc')->pluck('tahun_lulus');
        
        // proses pdf
        $options = new \Dompdf\Options();
        $options->set('isPhpEnabled', true);
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        $pdf = new \Dompdf\Dompdf($options);
        $html = view('admin.pdf', compact('data', 'years', 'tahunLulus', 'bidangKarirList'))->render();

        $exportDate = date('Y-m-d H:i:s');
        $footerHtml = '<div style="text-align: right;"><p>Ekspor Tanggal : ' . $exportDate . '</p></div>';
        $html = $footerHtml . $html;
        $pdf->loadHtml($html);
        // Atur ukuran kertas dan orientasi
        $pdf->setPaper('F4', 'landscape');
        $pdf->render();
        // Tampilkan PDF di browser
        $pdf->stream('rekap_data_karir_alumni.pdf', array("Attachment" => false));
    }
    public function exportExcel()
    {
        if (auth()->user()->level !== 'admin') {
            abort(403, 'Unauthorized');
        }
        return Excel::download(new AlumniExport, 'alumni.xlsx');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function exportCSV()
    {
        if (auth()->user()->level !== 'admin') {
            abort(403, 'Unauthorized');
        }
        return Excel::download(new AlumniExport, 'alumni.csv', \Maatwebsite\Excel\Excel::CSV);
    }
    public function importCSV(ImportCsvRequest $request)
    {
        if (auth()->user()->level !== 'admin') {
            abort(403, 'Unauthorized');
        }
        try {
            $file = $request->file('csv_file');
            $filePath = $file->getRealPath();
    
            $data = array_map(function($line){
                return str_getcsv($line, ';');
            }, file($filePath));
            // dd($data);
            $header = array_shift($data);
            
            $expectedHeaders = ['NO', 'Kompetensi Keahlian', 'NAMA SISWA', 'Alamat', 'tanggal lahir', 'Nama Orang Tua/Wali', 'NIS', 'NISN'];
            // dd($header);
            if($header !== $expectedHeaders){
                return redirect()->back()->with('error', 'Format header CSV tidak sesuai.');
            }

            $now = Carbon::now();
            $defaultAvatar = 'images/default-avatar.png';
            $bulan = [
                'Januari' => '01',
                'Februari' => '02',
                'Maret' => '03',
                'April' => '04',
                'Mei' => '05',
                'Juni' => '06',
                'Juli' => '07',
                'Agustus' => '08',
                'September' => '09',
                'Oktober' => '10',
                'November' => '11',
                'Desember' => '12',
            ];
    
            foreach ($data as $row) {
                if(count($row) !== count($header)){
                    continue;
                }
                $row = array_combine($header, $row);
                // dd($row);

                $tanggalLahir = trim($row['tanggal lahir'], ', ');
                
                foreach ($bulan as $namaBulan => $angkaBulan){
                    if(strpos($tanggalLahir, $namaBulan) !== false){
                        $tanggalLahir = str_replace($namaBulan, $angkaBulan, $tanggalLahir);
                        break;
                    }
                }
                $tanggalLahir = Carbon::createFromFormat('d m Y', $tanggalLahir);
                // dd($tanggalLahir);

                $jurusan = Jurusan::where('kompetensi_keahlian', $row['Kompetensi Keahlian'])->first();
                if (!$jurusan) {
                    // dd($jurusan);
                    return redirect()->back()->with('error', 'Jurusan dengan kompetensi keahlian ' . $row['Kompetensi Keahlian'] . ' tidak ditemukan.');
                }
                $user = User::create([
                    'name' => $row['NAMA SISWA'],
                    'email' => $row['NAMA SISWA'] . '@example.com', // Ubah ini sesuai kebutuhan
                    'password' => Hash::make('password'), // Password default
                    'level' => 'siswa',
                    'avatar' => $defaultAvatar, 
                ]);
                Siswa::updateOrCreate(
                    [
                        'nis' => $row['NIS'],
                        'nisn' => $row['NISN'],
                    ],
                    [
                        'name' => $row['NAMA SISWA'],
                        'alamat' => $row['Alamat'],
                        'tanggal_lahir' => $tanggalLahir,
                        'nama_orang_tua' => $row['Nama Orang Tua/Wali'],
                        'status_siswa' => 'lulus',
                        'tanggal_lulus' => $now,
                        'jurusan_id' => $jurusan->id,
                        'user_id' => $user->id,
                    ]
                );
            }
            return redirect()->back()->with('success', 'Data berhasil diimpor.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengimpor data: ' . $e->getMessage());
        }
    }

    public function updateProfile(Request $request, $slug){
        $user = User::where('slug', $slug)->firstOrFail();
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
        ]);

        $user->update([
            'name' => $validatedData['name'],
            'email' => $validatedData['email']
        ]);
        return response()->json(['success' => true]);
    }
}