<?php

namespace App\Http\Controllers\components;

use App\Events\Notifikasi;
use App\Http\Controllers\Controller;
use App\Models\Acara;
use App\Models\Jurusan;
use App\Models\Karir;
use App\Models\Question;
use App\Models\Questionnaire;
use App\Models\Response;
use App\Models\Siswa;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;

class siswaController extends Controller
{
    //
    public function home($slug)
    {
        if (auth()->user()->level !== 'siswa') {
            abort(403, 'Unauthorized');
        }
        # code...
        $user = User::where('slug', $slug)->firstOrFail();
        $siswa = $user->siswas()->with('karirs')->first();
        if(!$siswa){
            abort(404);
        }
        // $karir = $siswa->karirs;

        $pendapatanData = $siswa->karirs->map(function($karir) {
            return [ 
                'tahun' => Carbon::parse($karir->created_at)->format('Y'),
                'pendapatan' => $karir->pendapatan
            ];
        });
        return view('siswa.home', compact('user', 'siswa', 'pendapatanData'));
    }
    public function editProfile($slug)
    {
        if (auth()->user()->level !== 'siswa') {
            abort(403, 'Unauthorized');
        }
        # code...
        $user = User::where('slug', $slug)->firstOrFail();
        $siswa = $user->siswas()->with('karirs')->first();
        if(!$siswa){
            abort(404);
        }
        return view('siswa.edit-profile', compact('user', 'siswa'));
    }

    public function updateProfile(Request $request, $slug){
        $user = User::where('slug', $slug)->firstOrFail();
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string|max:255',
            'nama_orang_tua' => 'required|string|max:255',
            'tanggal_lulus' => 'required|date',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);
        if ($request->hasFile('avatar')) {
            $avatarName = time() . '.' . $request->avatar->getClientOriginalExtension();
            $request->avatar->move(public_path('event'), $avatarName);
            $user->avatar = $avatarName;
            $user->save();
        }

        $user->update([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
        ]);
        $siswa = $user->siswas()->firstOrFail();
        $siswa->update([
            'tanggal_lahir' => $validatedData['tanggal_lahir'],
            'alamat' => $validatedData['alamat'],
            'nama_orang_tua' => $validatedData['nama_orang_tua'],
            'tanggal_lulus' => $validatedData['tanggal_lulus']
        ]);
        return response()->json(['success' => true]);
    }
    
    public function form_karir($slug)
    {
        if (auth()->user()->level !== 'siswa') {
            abort(403, 'Unauthorized');
        }
        # code...
        $user = User::where('slug', $slug)->first();
        if(!$user){
            abort(404);
        }
        $siswa = $user->siswas()->with('karirs')->first();
        if(!$siswa){
            abort(404);
        }
        $karirTerakhir = $siswa->karirs()->latest()->first();
        return view('siswa.form_karir', compact('user', 'siswa', 'karirTerakhir'));
    }
    public function update_karir(Request $request, $slug)
    {
        if (auth()->user()->level !== 'siswa') {
            abort(403, 'Unauthorized');
        }
        # code...
        $user = User::where('slug', $slug)->first();
        if(!$user){
            abort(404);
        }
        $siswa = $user->siswas()->with('karirs')->first();
        if(!$siswa){
            abort(404);
        }
        $request->validate([
            'profesi' => 'required|string',
            'bidang' => 'required|string',
            'jenis_karir' => 'required|in:Bekerja,Lanjut studi,Wiraswasta,Belum ada',
            'nama_tempat' => 'required|string|max:55',
            'alamat_karir' => 'required|string',
            'no_telp' => 'required|max:20|min:8',
            'email' => 'nullable|email|unique:karirs,email,' . ($siswa->karirs()->latest()->first()->id ?? 'NULL'),
            'pendapatan_range' => 'required|in:0-1000000,1000001-5000000,5000001-10000000,10000001-20000000,20000001-50000000,50000001-100000000',
            'pendapatan' => 'required|numeric|min:0|max:100000000',
            'tempat_tinggal' => 'required|string',
            'foto_tempat' => 'required|image|mimes:jpeg,png,jpg,svg|max:20480',
        ]);
        // dd($request);
        $pendapatanRange = explode('-', $request->input('pendapatan_range'));
        if ($request->input('pendapatan') < $pendapatanRange[0] || $request->input('pendapatan') > $pendapatanRange[1]) {
            return back()->withErrors(['pendapatan' => 'Pendapatan harus berada dalam rentang yang dipilih.']);
        }
        // dd($pendapatanRange);
        $email = $request->input('email_option') === 'new' ? $request->input('email') : $user->email;
        // dd($email);
        // $fileName = "alamat_{$user->slug}.jpg";
        $fotoPath = $request->file('foto_tempat')->store('alamat', 'public');
        Karir::create([
            'siswa_id' => $siswa->id,
            'email' => $email,
            'profesi' => $request->profesi,
            'bidang' => $request->bidang,
            'jenis_karir' => $request->jenis_karir,
            'nama_tempat' => $request->nama_tempat,
            'alamat_karir' => $request->alamat_karir,
            'no_telp' => $request->no_telp,
            'pendapatan' => $request->pendapatan,
            'tempat_tinggal' => $request->tempat_tinggal,
            'foto_tempat' => $fotoPath,
        ]);
        return redirect()->route('siswa.index', ['slug' => $slug])->with('Success');
    }

    public function acara_detail($slug, $id)
    {
        if (auth()->user()->level !== 'siswa') {
            abort(403, 'Unauthorized');
        }
        # code...
        $user = User::where('slug', $slug)->firstOrFail();
        $siswa = $user->siswas()->with('karirs')->first();
        if(!$siswa){
            abort(404);
        }
        $data = Acara::with('users')->findOrFail($id);
        return view('siswa.event-detail', compact('data', 'user'));
    }
    public function index_guest(Request $request)
    {
        
        # code...
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

        $alumni = $alumni->paginate(15);
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
            'Belum bekerja' => $karirCounts->get('Belum bekerja', 0),
            'Lanjut studi' => $karirCounts->get('Lanjut Studi', 0)
        ];
        $post = Acara::with('users')->get()->all();
        $siswa = Siswa::with('karirs', 'jurusans')->get();
        $totalAlumni = Siswa::count();
        $kompetensiKeahlian = Jurusan::pluck('kompetensi_keahlian')->toArray();
        $alumniByYear = [];
        foreach ($siswa as $alumniItem) {
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

        return view('siswa.index', ['totalAlumni' => $totalAlumni,'grafikData' => $grafikData,], compact('alumni', 'data_siswa', 'jenis_karir', 'post'));
    }
    public function detail_mading($id)
    {
        $mading = Acara::with('users')->findOrFail($id);
        return view('siswa.detail-mading', compact('mading'));
    }
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function buatMading($slug){
        if (auth()->user()->level !== 'siswa') {
            abort(403, 'Unauthorized');
        }
        $user = User::where('slug', $slug)->firstOrFail();
        $siswa = $user->siswas()->with('karirs')->first();
        if(!$siswa){
            abort(404);
        }
        return view('siswa.buat-mading', compact('user', 'siswa'));
    }
    
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function store_mading(Request $request) : RedirectResponse{
        if (auth()->user()->level !== 'siswa') {
            abort(403, 'Unauthorized');
        }
        $request->validate([
            'judul' => 'required',
            'description' => 'required',
            'poster' => 'image|mimes:jpeg,png,jpg,gif|max:20480',
            'jenis' => 'required|in:pekerjaan,perguruan tinggi,lainnya',
        ]);
        // $posterName = time(). '.' . $request->poster->extension();
        // $posterPath =  $request->poster->move(public_path('images'), $posterName);
        $posterPath = $request->file('poster')->store('events', 'public');

        $acara = new Acara([
            'judul' => $request->get('judul'),
            'description' => $request->get('description'),
            'jenis' => $request->get('jenis'),
            'poster' => $posterPath,
        ]);

        $acara->users()->associate(Auth::user());
        $acara->save();

        event(new Notifikasi());
        
        return redirect()->route('siswa.event-detail')->withSuccess(['success' => 'Poster acara berhasil diunggah!']);
    }
    
    public function index_acara($slug)
    {
        if (auth()->user()->level !== 'siswa') {
            abort(403, 'Unauthorized');
        }
        # code...
        $user = User::where('slug', $slug)->firstOrFail();
        $siswa = $user->siswas()->with('karirs')->first();
        if(!$siswa){
            abort(404);
        }

        $post = Acara::with('users')->get()->all();
        $questionnaires = Questionnaire::all();
        return view('siswa.event', compact('user','siswa', 'post', 'questionnaires'));
    }


    public function showQuestionnaires($slug, Questionnaire $questionnaire)
    {
        $user = User::where('slug', $slug)->firstOrFail();
        $siswa = $user->siswas()->with('karirs')->first();
        if(!$siswa){
            abort(404);
        }

        return view('siswa.show-questionnaires', compact('user', 'siswa', 'questionnaire'));
    }

    // Fungsi pertanyaan / Question functions

    public function answerQuestions($slug,Questionnaire $questionnaire){
        $user = User::where('slug', $slug)->firstOrFail();
        $siswa = $user->siswas()->with('karirs')->first();
        if(!$siswa){
            abort(404);
        }
        return view('siswa.answer-questionnaires', compact('user', 'siswa', 'questionnaire'));
    }

    public function submitAnswerSiswa($slug, Request $request, Questionnaire $questionnaire)
    {
        $user = User::where('slug', $slug)->firstOrFail();
        $siswa = $user->siswas()->with('karirs')->first();
        if(!$siswa){
            abort(404);
        }
        $responses = $request->except('_token');
        foreach ($responses as $question_id => $response) {
            Response::create([
                'user_id' => auth()->id(),
                'question_id' => $question_id,
                'response_text' => is_array($response) ? implode(',', $response) : $response
            ]);
        }
        return redirect()->route('siswa.event', $user->slug)->with(['success' => 'Answers submitted successfully']);
    }
}