<main>
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <div class="side-content">
        <div class="sidebar" id="sidebar">
            <ul>
                <li class="menu sub-toggle">
                    <div class="menu-item">
                        <span title="Dashboard"><a href="{{ route('admin.dashboard') }}"><i class="fa-solid fa-gauge"></i>Dashboard</a></span>
                    </div>
                    <!-- <ul class="submenu">
                        <hr>
                        <li><i class="bi bi-grid"></i>Beranda</li>
                        <hr>
                    </ul> -->
                </li>
                <hr>
                <li class="menu sub-toggle">
                    <div class="menu-item">
                        <span title="Data User"><i class="fa fa-users"></i>Data User</a></span>
                        <i class="fa-solid fa-chevron-down arrow"></i>
                    </div>
                    <ul class="submenu">
                        <hr>
                        <li><a href="{{route('admin.data-user')}}" role="button" title="Data User"><i class="fa fa-solid fa-user"></i>Data User</a></li>
                    </ul>
                </li>
                <hr>
                <li class="menu sub-toggle">
                    <div class="menu-item">
                        <span title="Data Siswa"><i class="fa fa-graduation-cap"></i>Data Alumni</span>
                        <i class="fa-solid fa-chevron-down arrow"></i>
                    </div>
                    <ul class="submenu">
                        <hr>
                        <li><a href="{{ route('admin.laporan') }}" role="button" title="Dashboard Siswa"><i class="fa fa-solid fa-user-graduate"></i>Data Siswa</a></li>
                        <hr>
                        <li><a href="{{ route('admin.laporan.jurusan') }}" role="button" title="Dashboard Jurusan"><i class="fa-regular fa-paste"></i>Data Jurusan</a></li>
                    </ul>
                </li>
                <hr>
                <li class="menu sub-toggle">
                    <div class="menu-item">
                        <span title="Data Laporan"><a href="{{ route('admin.karir') }}" role="button" title="Laporan Ringkasan"><i class="bi bi-clipboard-data"></i>Laporan</a></span>
                    </div>
                    <!-- <ul class="submenu">
                        <li><i class="fa-solid fa-diagram-project"></i>Karir</li>
                    </ul> -->
                </li>
                <hr>
                <li class="menu sub-toggle">
                    <div class="menu-item">
                        <span title="Acara Pendaftaran Kuliah / Lowongan Kerja"><i class="bx bxs-bell-ring"></i>Mading</span>
                        <i class="fa-solid fa-chevron-down arrow"></i>
                    </div>
                    <ul class="submenu">
                        <hr>
                        <li><a href="{{ route('events.admin.dashboard') }}" role="button" title="Dashboard Acara"><i class="fa fa-solid fa-image"></i>Mading Poster</a></li>
                        <hr>
                        <li><a href="{{ route('events.admin.create') }}" role="button" title="Tambah Postingan Baru"><i class="fa-regular fa-paste"></i>Post Baru</a></li>
                    </ul>
                </li>
                <hr>
                <!-- <li class="menu sub-toggle">
                    <div class="menu-item">
                        <span title="Data Laporan"><a href="{{ route('questionnaires.index') }}" role="button"><i class="fa-solid fa-circle-question"></i>Kuisioner</a></span>
                    </div>
                    <ul class="submenu">
                        <li><i class="fa-solid fa-diagram-project"></i>Karir</li>
                    </ul> 
                </li> -->
            </ul>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const subToggles = document.querySelectorAll(".sub-toggle");
            subToggles.forEach((toggle) => {
                toggle.addEventListener("click", function (e) {
                    const submenu = toggle.querySelector(".submenu");
                    const arrow = toggle.querySelector(".arrow");
                    submenu.classList.toggle("active");
                    arrow.classList.toggle("rotate");
                });
            });
        });

        function toggleSidebar() {
            const sidebar = document.getElementById("sidebar");
            const containerbody = document.getElementById("container-body");
            const toggleBtn = document.querySelector(".toggle-btn");
            const search = document.getElementsByClassName("filter-cari");
            
            if (sidebar.style.left === "0px") {
                sidebar.style.left = "-220px";
                if (window.innerWidth >= 480) {
                    containerbody.style.margin = "20px 90px";
                }else{
                    containerbody.style.margin = "20px 10px"
                    search.style.width === "850px"
                }
                toggleBtn.classList.remove("active");
            } else {
                sidebar.style.left = "0px";
                if (window.innerWidth >= 480){
                    containerbody.style.margin = "20px 100px 0px 230px";
                }else{
                    containerbody.style.margin = "20px 10px";
                    search.style.width === "650px"
                }
                toggleBtn.classList.add("active");
            }
        }
    </script>
</main>