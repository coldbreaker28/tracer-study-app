<?php

namespace App\Http\Controllers\components;

use App\Events\AcaraCreated;
use App\Events\Notifikasi;
use App\Http\Controllers\Controller;
use App\Models\Acara;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AcaraController extends Controller
{
    public function index()
    {
        if (auth()->user()->level !== 'admin') {
            abort(403, 'Unauthorized');
        }
        $user = auth()->user();
        $post = Acara::with('users')->get();
        return view('events.acara-admin', compact('post', 'user'));
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function indexSuper()
    {
        $post = Acara::with('users')->get()->all();
        return view('events.acara-dashboard-super', compact('post'));
    }
    
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function create()
    {
        if (auth()->user()->level !== 'admin') {
            abort(403, 'Unauthorized');
        }
        $user = auth()->user();
        return view('events.acara-post', compact('user'));
    }

        /**
     * Write code on Method
     *
     * @return response()
     */
    public function superCreate()
    {
        return view('events.acara-post-super');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function store(Request $request) : RedirectResponse{
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
        
        return redirect()->route('events.admin.dashboard')->withSuccess('Poster acara berhasil diunggah!');
    }

    public function superStore(Request $request) : RedirectResponse
    {
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
        
        echo '<script>
        Swal.fire({
            title: "Notifikasi Baru!",
            text: "Poster Baru Berhasil Ditambahkan.",
            icon: "success",
            showCancelButton: false,
            confirmButtonText: "Tutup"
        });
        </script>';

        return redirect()->route('events.super-admin.dashboard')->withSuccess('Poster acara berhasil diunggah!');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function editEvent($id)
    {
        if (auth()->user()->level !== 'admin') {
            abort(403, 'Unauthorized');
        }
        $user = auth()->user();
        $data = Acara::with('users')->findOrFail($id);
        return view('events.acara-edit', compact('data', 'user'));
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required',
            'jenis' => 'required|in:pekerjaan,perguruan tinggi,lainnya',
            'description' => 'required',
        ]);

        $event = Acara::findOrFail($id);

        $event->judul = $request->input('judul');
        $event->description = $request->input('description');
        $event->jenis = $request->input('jenis');

        $event->save();

        return redirect()->route('events.admin.dashboard')->with('success', 'Poster berhasil diperbarui.');
    }

    public function superUpdate(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required',
            'jenis' => 'required|in:pekerjaan,perguruan tinggi,lainnya',
            'description' => 'required',
        ]);

        $event = Acara::findOrFail($id);

        $event->judul = $request->input('judul');
        $event->description = $request->input('description');
        $event->jenis = $request->input('jenis');

        $event->save();

        return redirect()->route('events.super-admin.dashboard')->with('success', 'Poster berhasil diperbarui.');
    }

     /**
     * Write code on Method
     *
     * @return response()
     */
    public function showEvent($id)
    {
        $data = Acara::with('users')->findOrFail($id);
        if (auth()->user()->level !== 'admin') {
            abort(403, 'Unauthorized');
        }
        $user = auth()->user();
        return view('events.acara-detail', compact('data', 'user'));
    }

     /**
     * Write code on Method
     *
     * @return response()
     */
    public function superShowEvent($id)
    {
        $data = Acara::with('users')->findOrFail($id);
        if (auth()->user()->level !== 'admin') {
            abort(403, 'Unauthorized');
        }
        $user = auth()->user();
        return view('events.acara-detail-super', compact('data', 'user'));
    }

     /**
     * Write code on Method
     *
     * @return response()
     */
    public function destroy($id)
    {
        $data = Acara::findOrFail($id);
        $data->delete();
        return redirect()->route('events.admin.dashboard')->withSuccess('Data has been delete!');
    }

    public function superDestroy($id)
    {
        $data = Acara::findOrFail($id);
        $data->delete();
        return redirect()->route('events.super-admin.dashboard')->withSuccess('Data has been delete!');
    }
}