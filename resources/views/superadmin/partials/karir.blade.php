<table class="responsive-table-output daftar-table">
    <thead>
        <tr>
            <th scope="col">No.</th>
            <th scope="col">NISN</th>
            <th scope="col">Nama Lengkap</th>
            <th scope="col">Kompetensi Keahlian</th>
            <th scope="col">Tahun Lulus</th>
            <th scope="col">Perusahaan/Instansi</th>
            <th scope="col">Profesi</th>
            <th scope="col">Bidang</th>
            <th scope="col">Jenis Karir</th>
            <th scope="col">Alamat Karir yang Ditempuh</th>
            <th scope="col">Pendapatan</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($alumni as $item)
            @php
                $karirCount = $item->karirs->count();
            @endphp
            @if ($karirCount > 0)
                @foreach ($item->karirs as $index => $karir)
                    <tr>
                        @if ($index == 0)
                            <td rowspan="{{ $karirCount }}">{{ $no++ }}</td>
                            <td rowspan="{{ $karirCount }}">{{ $item->nisn }}</td>
                            <td rowspan="{{ $karirCount }}">{{ $item->name }}</td>
                            <td rowspan="{{ $karirCount }}">{{ $item->jurusans->kompetensi_keahlian ?? '-' }}</td>
                            <td rowspan="{{ $karirCount }}" style="text-align: center;">{{ \Carbon\Carbon::parse($item->tanggal_lulus)->format('Y') }}</td>
                        @endif
                        <td>{{ $karir->nama_tempat ?? '-'}}</td>
                        <td>{{ $karir->profesi ?? '-'}}</td>
                        <td>{{ $karir->bidang ?? '-'}}</td>
                        <td>{{ $karir->jenis_karir ?? '-'}}</td>
                        <td>{{ $karir->alamat_karir ?? '-'}}</td>
                        <td>Rp. {{ number_format($karir->pendapatan, 0, ',', '.' ?? '-') }}</td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $item->nisn }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->jurusans->kompetensi_keahlian ?? '-' }}</td>
                    <td style="text-align: center;">{{ \Carbon\Carbon::parse($item->tanggal_lulus)->format('Y') }}</td>
                    <td colspan="6">Data karir tidak tersedia</td>
                </tr>
            @endif
        @endforeach
    </tbody>
</table>
<br>
<div class="head-content">
    <!-- <h3>Data Alumni dengan Karir</h3> -->
    <!-- <button class="read-btn" onclick="downloadPDF()"><i class="fa-solid fa-file-pdf"></i> Download PDF</button> -->
    <!-- <a href="{{ route('admin.sheet.get') }}" class="read-btn" role="button" title="Export to PDF"><i class="fa-solid fa-file-pdf"> | </i> ekspor ke PDF</a> -->
    <form action="{{ route('admin.sheet.pdf') }}" method="get">
        <div class="nama">
            <label for="tahun_lulus">Pilih Tahun Lulus:</label><br>
            <select name="tahun_lulus" id="tahun_lulus">
                <option value="all">Semua Tahun</option>
                @foreach($years as $year)
                    <option value="{{ $year }}">{{ $year ?? '-'}}</option>
                @endforeach
            </select>
        </div>
        <div class="nama">
            <label for="kompetensi">Pilih Kompetensi Keahlian:</label><br>
            <select name="kompetensi" id="kompetensi">
                <option value="all">Semua Kompetensi</option>
                @foreach($kompetensiList as $kompetensi)
                    <option value="{{ $kompetensi }}">{{ $kompetensi ?? '-' }}</option>
                @endforeach
            </select>
        </div>
        <!-- <div class="nama">
            <label for="bidang">Pilih Bidang Karir:</label><br>
            <select name="bidang" id="bidang">
                <option value="all">Semua Bidang</option>
                @foreach($bidangKarirList as $bidang)
                    <option value="{{ $bidang }}">{{ $bidang ?? '-' }}</option>
                @endforeach
            </select>
        </div> -->
        <button class="read-btn" type="submit"><i class="fa-solid fa-file-pdf"> | </i> Ekspor PDF </button>
    </form>
</div>
<div class="pagination-links">
    {{ $alumni->links() }}
</div>