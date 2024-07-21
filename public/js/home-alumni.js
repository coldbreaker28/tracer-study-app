let text = document.getElementById('text');
let parallax1 = document.getElementById('Parallax1');
let parallax2_1 = document.getElementById('Parallax2-1');
let parallax2_2 = document.getElementById('Parallax2-2');
let parallax3_1 = document.getElementById('Parallax3-1');
let parallax3_2 = document.getElementById('Parallax3-2');

window.addEventListener('scroll', () => {
    let value = window.scrollY;

    text.style.marginTop = value * 2.5 + "px";
    parallax2_1.style.left = value * -0.5 + "px";
    parallax2_2.style.left = value * 1 + "px";
    // parallax3_1.style.top = value * 1.5 + "px";
    parallax3_1.style.left = value * -1 + "px";
    parallax3_2.style.left = value * 0.5 + "px";
});

// Tangkap referensi elemen-elemen pada bagian-bagian halaman
let homeSection = document.getElementById('home');
let aboutSection = document.getElementById('about');
let serviceSection = document.getElementById('service');
let contactSection = document.getElementById('contact');

// Tambahkan event listener untuk mengatur pergeseran halus
window.addEventListener('scroll', () => {
    let scrollPosition = window.scrollY;

    if (scrollPosition >= homeSection.offsetTop && scrollPosition < aboutSection.offsetTop) {
        // Logika pergerakan elemen untuk bagian Home
        // Misalnya, Anda bisa mengubah style elemen "text" di bagian Home
        text.style.marginTop = (scrollPosition - homeSection.offsetTop) * 2.5 + "px";
    } else if (scrollPosition >= aboutSection.offsetTop && scrollPosition < serviceSection.offsetTop) {
        // Logika pergerakan elemen untuk bagian About
        text.style.marginTop = (scrollPosition - aboutSection.offsetTop) * 2.5 + "px";
    } else if (scrollPosition >= serviceSection.offsetTop && scrollPosition < contactSection.offsetTop) {
        // Logika pergerakan elemen untuk bagian Service
        text.style.marginTop = (scrollPosition - serviceSection.offsetTop) * 2.5 + "px";
    } else if (scrollPosition >= contactSection.offsetTop) {
        // Logika pergerakan elemen untuk bagian Contact
        text.style.marginTop = (scrollPosition - contactSection.offsetTop) * 2.5 + "px";
    }
});

