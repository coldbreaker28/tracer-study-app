<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Hai {{ $user->name }}</title>
    <script src="https://kit.fontawesome.com/e10155b56c.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="{{ asset('css/form-karir.css') }}">
</head>
<div>
    <!-- Very little is needed to make a happy life. - Marcus Aurelius -->
    <div class="container">
        <form action="{{ route('siswa.update_karir', [$user->slug]) }}" enctype="multipart/form-data" method="POST" class="form">
            @csrf
             <div class="nama">
                <label for="jenis_karir">Jenis Profesi Anda Saat ini:</label>
                <select name="jenis_karir" id="jenis_karir" required>
                    <option value="Bekerja">Bekerja</option>
                    <option value="Wiraswasta">Wiraswasta</option>
                    <option value="Lanjut studi">Lanjut Studi</option>
                    <option value="Belum ada">Belum Bekerja</option>
                </select>
                @error('jenis_karir')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
            <div class="nama">
                <label for="profesi">Profesi Anda Saat Ini : </label>
                <input type="text" name="profesi" id="profesi" required placeholder="Profesi anda saat ini......"
                    value="{{ $karirTerakhir->profesi ?? '-'}}">
                @error('profesi')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
            <div class="nama">
                <label for="bidang">Bidang profesi Anda Saat Ini : </label>
                <input type="text" name="bidang" id="bidang" required placeholder="Profesi anda saat ini......"
                    value="{{ $karirTerakhir->bidang ?? '-'}}">
                @error('bidang')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
            <div class="nama">
                <label for="nama_tempat">Nama Instansi : </label>
                <input type="text" name="nama_tempat" id="nama_tempat" required placeholder="Nama Tempat Profesi anda saat ini......"
                    value="{{ $karirTerakhir->nama_tempat ?? '-'}}">
                @error('nama_tempat')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
            <div class="nama">
                <label for="foto_tempat">Foto Tempat Instansi Anda : </label>
                <input type="file" name="foto_tempat" id="foto_tempat" required>
                @error('foto_tempat')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
            <div class="nama">
                <label for="alamat_karir">Alamat Instansi : </label>
                <input name="alamat_karir" id="alamat_karir" type="text" placeholder="Alamat tempat profesi anda saat ini..."
                    value="{{ $karirTerakhir->alamat_karir ?? '-'}}"></input>
                @error('alamat_karir')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
            <div class="nama">
                <label for="no_telp">Nomor Telepon Anda : </label>
                <input type="text" name="no_telp" id="no_telp" required placeholder="No. telpon anda saat ini......"
                    value="{{ $karirTerakhir->no_telp ?? '-'}}">
                @error('no_telp')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
            <div class="nama">
                <label>Email:</label>
                <div class="email-group">
                    <input type="radio" name="email_option" value="existing" id="existing_email" checked>
                    <label for="existing_email">
                        <span>Gunakan Email Lama ({{ $user->email }})</span>
                    </label>
                    <input type="radio" name="email_option" value="new" id="new_email">
                    <label for="new_email">
                        <span>Gunakan Email Baru</span>
                    </label>
                    <div class="email-input" id="email_input_container">
                        <input type="email" name="email" id="email" placeholder="Masukkan email baru" disabled>
                        @error('email')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="nama">
                <label for="pendapatan">Pendapatan anda saat ini : </label>
                <div class="range-container">
                    <select name="pendapatan_range" id="pendapatan_range" required onchange="updateRange(this.value)">
                        <option value="0-1000000" {{ old('pendapatan_range', $karirTerakhir->pendapatan ?? '') == '0-1000000' ? 'selected' : '' }}>0 - 1 Juta</option>
                        <option value="1000001-5000000" {{ old('pendapatan_range', $karirTerakhir->pendapatan ?? '') == '1000001-5000000' ? 'selected' : '' }}>1 Juta - 5 Juta</option>
                        <option value="5000001-10000000" {{ old('pendapatan_range', $karirTerakhir->pendapatan ?? '') == '5000001-10000000' ? 'selected' : '' }}>5 Juta - 10 Juta</option>
                        <option value="10000001-20000000" {{ old('pendapatan_range', $karirTerakhir->pendapatan ?? '') == '10000001-20000000' ? 'selected' : '' }}>10 Juta - 20 Juta</option>
                        <option value="20000001-50000000" {{ old('pendapatan_range', $karirTerakhir->pendapatan ?? '') == '20000001-50000000' ? 'selected' : '' }}>20 Juta - 50 Juta</option>
                        <option value="50000001-100000000" {{ old('pendapatan_range', $karirTerakhir->pendapatan ?? '') == '50000001-100000000' ? 'selected' : '' }}>50 Juta - 100 Juta</option>
                    </select>
                    <input type="range" name="pendapatan" id="pendapatan" required min="0" max="1000000"
                        value="{{ old('pendapatan', $karirTerakhir->pendapatan ?? 0) }}" oninput="updateRangeValue(this.value)">
                    <span class="range-value" id="rangeValue">{{old('pendapatan', $karirTerakhir->pendapatan ?? 0)}}</span>
                </div>
                @error('pendapatan')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
            <div class="nama">
                <label for="tempat_tinggal">Alamat tempat tinggal anda saat ini : </label>
                <input name="tempat_tinggal" id="tempat_tinggal" type="text" placeholder="Alamat tempat tinggal anda saat ini..."
                    value="{{ $karirTerakhir->tempat_tinggal ?? '-'}}"></input>
                @error('tempat_tinggal')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
            <div class="but">
                <a href="{{ route('siswa.index', [$user->slug]) }}" role="button" id="res">kembali</a>
                <button type="submit" id="sub">Simpan</button>
            </div>
        </form>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const emailRadios = document.querySelectorAll('input[name="email_option"]');
        const emailInputContainer = document.getElementById('email_input_container');
        const emailInput = document.getElementById('email');

        emailRadios.forEach(radio => {
            radio.addEventListener('change', () => {
                if (document.getElementById('new_email').checked) {
                    emailInputContainer.classList.add('active');
                    emailInput.disabled = false;
                } else {
                    emailInputContainer.classList.remove('active');
                    emailInput.disabled = true;
                }
            });
        });

        // Update initial state based on the checked radio button
        if (document.getElementById('new_email').checked) {
            emailInputContainer.classList.add('active');
            emailInput.disabled = false;
        } else {
            emailInputContainer.classList.remove('active');
            emailInput.disabled = true;
        }
    });
</script>
<script>
    function updateRange(range) {
        const [min, max] = range.split('-').map(Number);
        const rangeInput = document.getElementById('pendapatan');
        rangeInput.min = min;
        rangeInput.max = max;
        rangeInput.value = min;
        updateRangeValue(min);
    }
    function updateRangeValue(value) {
        document.getElementById('rangeValue').textContent = value;
    }
</script>