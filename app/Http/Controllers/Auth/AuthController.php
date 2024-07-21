<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Aluni;
use App\Models\Guru;
use App\Models\Jurusan;
use App\Models\Karir;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('auth.login');
    }

    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function registration()
    {
        $jurusan = Jurusan::all();
        $siswa = Siswa::with('jurusans')->get();
        return view('auth.registration', compact('siswa', 'jurusan'));
    }

        /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postLogin(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        $credentials = $request->only('email', 'password');

        if(Auth::attempt($credentials)){
            $request->session()->regenerate();
            $slug = Auth::user()->slug;
            switch (Auth::user()->level) {
                case 'admin':
                    return redirect()->intended('admin/dashboard')->withSuccess('You have successfully logged in as admin!');
                case 'siswa':
                    return redirect()->route('siswa.index', ['slug' => $slug])->withSuccess('You have successfully logged in as siswa!');
                case 'guru':
                    return redirect()->intended('/')->withSuccess(['Success' => 'You have successfully logged in as guru!']);
                default:
                    return redirect()->intended('/')->withErrors(['Error' => 'Maaf, Pengguna tidak terdaftar dalam Aplikasi']);
            }        
        }
        return redirect()->route('login')->withErrors(['error' => 'Email atau password salah. Silakan coba lagi.']);
    }

        /**
     * Handle a registration attempt.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postRegistration(Request $request){
        $rules = [
            'name' => 'required|string|max:35',
            'email' => 'required|email|',
            'password' => 'required|min:6',
            'level' => 'required|in:siswa,guru',
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:20480',
        ];

        if ($request->level === 'siswa') {
            $rules += [
                'tanggal_lahir' => 'required|date',
                'alamat' => 'required|string',
                'nama_orang_tua' => 'required|string|max:50',
                'nis' => 'required|string|max:20',
                'nisn' => 'required|string|max:20',
                'status_siswa' => 'required|in:Belum lulus,Lulus',
                'tanggal_lulus' => 'required|date',
                'kompetensi_keahlian' => 'required|exists:jurusans,id',
            ];
        }

        if ($request->level === 'guru') {
            $rules += [
                'jabatan' => 'required|string',
                'alamat_guru' => 'required|string',
            ];
        }

        $validateData = $request->validate($rules);
        // dd($validateData);
        $avatarPath = $request->file('avatar')->store('avatars', 'public');
        
        if ($request->level === 'siswa') {
            $siswa = Siswa::where('name', 'LIKE',  '%' . $request->name . '%')
                            ->where('nis', $request->nis)
                            ->where('nisn', $request->nisn)
                            ->first();
            // dd($siswa);
            if ($siswa) {
                $user = $siswa->users;
                $emailExists = User::where('email', $request->email)->where('id', '!=', $user->id)->exists();
                if ($emailExists) {
                    # code...
                    return redirect()->back()->withErrors(['email' => 'Email sudah digunakan oleh pengguna lain.']);
                }
                // dd($user);
                if ($user) {
                    $user->update([
                        'name' => $request->name,
                        'email' => $request->email,
                        'password' => Hash::make($request->password),
                        'level' => $request->level,
                        'avatar' => $avatarPath,
                    ]);
                    $siswa->update([
                        'name' => $user->name,
                        'tanggal_lahir' => $request->tanggal_lahir,
                        'alamat' => $request->alamat,
                        'nama_orang_tua' => $request->nama_orang_tua,
                        'status_siswa' => $request->status_siswa,
                        'tanggal_lulus' => $request->tanggal_lulus,
                        'jurusan_id' => $request->kompetensi_keahlian,
                    ]);
                    // dd($siswa);
                } else {
                    return redirect()->back()->withErrors(['user' => 'User terkait dengan siswa tidak ditemukan.']);
                }
            } else {
                return redirect()->back()->withErrors(['nis' => 'NIS dan NISN tidak valid atau tidak ditemukan.']);
            }
        } else {
            // dd('Creating new user');
            $emailExists = User::where('email', $request->email)->exists();
            if ($emailExists) {
                return redirect()->back()->withErrors(['email' => 'Email sudah digunakan oleh pengguna lain.']);
            }
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'level' => $request->level,
                'avatar' => $avatarPath,
            ]);
        }
        if ($request->level === 'guru') {
            Guru::create([
                'user_id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'jabatan' => $request->jabatan,
                'alamat_guru' => $request->alamat_guru,
            ]);
        }

        Auth::login($user);
        
        $slug = $user->slug;
        switch ($user->level) {
            case 'admin':
                return redirect()->intended('admin/dashboard')->withSuccess('You have successfully registered and logged in as admin!');
            case 'siswa':
                return redirect()->route('siswa.index', ['slug' => $slug])->withSuccess('You have successfully registered and logged in as siswa!');
            case 'guru':
                return redirect()->route('guru.index', ['slug' => $slug])->withSuccess('You have successfully registered and logged in as guru!');
            default:
                return redirect()->intended('/')->withErrors(['Error' => 'Registration successful, but user level is not recognized.']);
        }
    }    
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function dashboard()
    {
        if(Auth::check()){
            // return view('dashboard');
            $slug = Auth::user()->slug;
            switch (Auth::user()->role) {
                case 'admin':
                    return redirect()->intended('admin/dashboard')->withSuccess('You have successfully logged in as admin!');
                case 'siswa':
                    return redirect()->route('siswa.index', ['slug' => $slug])->withSuccess('You have successfully logged in as siswa!');
                default:
                    return redirect()->intended('/')->withSuccess('You have successfully logged in as guru!');
            }
        }

        return redirect("login")->withSuccess('Opps! You do not have access');
    }
    /**
     * Write code on Method
     *
     * @return response()
     */
    // public function create(array $data, $avatarPath)
    // {
    //     return User::create([
    //         'name' => $data['name'],
    //         'email' => $data['email'],
    //         'password' => Hash::make($data['password']),
    //         'role' => $data['role'],
    //         'jabatan' => $data['jabatan'],
    //         'avatar' => $avatarPath,
    //     ]);
            // if ($request->level === 'siswa') {
        //     Siswa::updateOrCreate(
        //         ['user_id' => $user->id],
        //         [
        //             'name' => $request->name,
        //             'tanggal_lahir' => $request->tanggal_lahir,
        //             'alamat' => $request->alamat,
        //             'nama_orang_tua' => $request->nama_orang_tua,
        //             'nis' => $request->nis,
        //             'nisn' => $request->nisn,
        //             'status_siswa' => $request->status_siswa,
        //             'tanggal_lulus' => $request->tanggal_lulus,
        //             'jurusan_id' => $request->kompetensi_keahlian,
        //         ]
        //     );
        // }
    // }
    
    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/');
    }

    public function profile($slug)
    {
        if (auth()->user()->level !== 'admin') {
            abort(403, 'Unauthorized');
        }
        $user = User::where('slug', $slug)->firstOrFail();
        return view('auth.edit_profile', compact('user'));
    }

    public function update_profile(Request $request, $slug)
    {
        $user = User::where('slug', $slug)->firstOrFail();
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];

        if ($request->hasFile('avatar')) {
            $avatarName = time() . '.' . $request->avatar->getClientOriginalExtension();
            $request->avatar->move(public_path('event'), $avatarName);
            $user->avatar = $avatarName;
        }

        $user->save();

        return response()->json(['success' => true]);
    }
}
