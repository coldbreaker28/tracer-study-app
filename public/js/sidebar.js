function toggleSidebar() {
    const sidebar = document.getElementById("sidebar");
    const containerbody = document.getElementById("container-body");
    const toggleBtn = document.querySelector(".toggle-btn");

    if (sidebar.style.left === "0px") {
        sidebar.style.left = "-220px";
        containerbody.style.margin = "20px 90px";
        toggleBtn.classList.remove("active");
    } else {
        sidebar.style.left = "0px";
        containerbody.style.margin = "20px 100px 0px 230px";
        toggleBtn.classList.add("active");
    }
}