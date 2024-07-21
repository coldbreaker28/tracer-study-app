<div class="pagination">
<button id="prev-page-alumni">&lt;</button>
<span id="page-num-alumni">page </span>
<button id="next-page-alumni">&gt;</button>
</div>
var alumniData = @JSON($alumni);
var currentPageAlumni = 1;
var rowsPerPageAlumni = 8;
var totalPagesAlumni = Math.ceil(alumniData.length / rowsPerPageAlumni);
var prevPageBtnAlumni = document.getElementById("prev-page-alumni");
var nextPageBtnAlumni = document.getElementById("next-page-alumni");
var pageNumAlumni = document.getElementById("page-num-alumni");
function updateTableAlumni() {
    var startAlumni = (currentPageAlumni - 1) * rowsPerPageAlumni;
    var endAlumni = startAlumni + rowsPerPageAlumni;
    var pageDataAlumni = alumniData.slice(startAlumni, endAlumni);
    var tableBodyAlumni = document.querySelector("table tbody");
    tableBodyAlumni.innerHTML = "";
    pageDataAlumni.forEach(function (alumni, index) {
        var row = tableBodyAlumni.insertRow();
        var rowNum = (startAlumni + index + 1);
        row.insertCell(0).textContent = rowNum;
        row.insertCell(1).textContent = alumni.name;
        row.insertCell(2).textContent = alumni.tanggal_lahir;
        row.insertCell(3).textContent = alumni.alamat;
        row.insertCell(4).textContent = alumni.nama_orang_tua;
        row.insertCell(5).textContent = alumni.nis;
        row.insertCell(6).textContent = alumni.nisn;
        row.insertCell(7).textContent = alumni.nomor_ujian_nasional;

        var date = new Date(alumni.tanggal_lulus);
        row.insertCell(8).textContent = date.getFullYear();
    });
    pageNumAlumni.textContent = "Page " + currentPageAlumni;

    if (currentPageAlumni === 1) {
        prevPageBtnAlumni.style.display = "none";
    }else{
        prevPageBtnAlumni.style.display = "";
    }

    if (endAlumni >= alumniData.length){
        nextPageBtnAlumni.style.display = "none";
    }else{
        nextPageBtnAlumni.style.display = "";
    }
}
prevPageBtnAlumni.addEventListener("click", function () {
    if (currentPageAlumni > 1){
        currentPageAlumni--;
        updateTableAlumni();
    }
});
nextPageBtnAlumni.addEventListener("click", function () {
    if(currentPageAlumni < totalPagesAlumni){
        currentPageAlumni++;
        updateTableAlumni();
    }
});
updateTableAlumni();
// =======================================================================================