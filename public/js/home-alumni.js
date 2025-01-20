let text = document.getElementById('text');
let parallax1 = document.getElementById('Parallax1');
let parallax2_1 = document.getElementById('Parallax2-1');
let parallax2_2 = document.getElementById('Parallax2-2');
let parallax3_1 = document.getElementById('Parallax3-1');
let parallax3_2 = document.getElementById('Parallax3-2');

window.addEventListener('scroll', () => {
    let value = window.scrollY;

    text.style.marginTop = value * 2.5 + "px";
    // text.style.transform = `translateY(${value * 2.5}px)`;
    parallax2_1.style.transform = `translateX(${value * -0.5}px)`;
    parallax2_2.style.transform = `translateX(${value * 1}px)`;
    // parallax3_1.style.top = value * 1.5 + "px";
    parallax3_1.style.transform = `translateX(${value * -1}px)`;
    parallax3_2.style.transform = `translateX(${value * 0.5}px)`;
});

// Tangkap referensi elemen-elemen pada bagian-bagian halaman
let homeSection = document.getElementById('home');
let aboutSection = document.getElementById('about');
let serviceSection = document.getElementById('service');
let contactSection = document.getElementById('contact');

window.addEventListener('scroll', () => {
    let scrollPosition = window.scrollY;

    if (scrollPosition >= homeSection.offsetTop && scrollPosition < aboutSection.offsetTop) {
        text.style.marginTop = (scrollPosition - homeSection.offsetTop) * 2.5 + "px";
    } else if (scrollPosition >= aboutSection.offsetTop && scrollPosition < serviceSection.offsetTop) {
        text.style.marginTop = (scrollPosition - aboutSection.offsetTop) * 2.5 + "px";
    } else if (scrollPosition >= serviceSection.offsetTop && scrollPosition < contactSection.offsetTop) {
        text.style.marginTop = (scrollPosition - serviceSection.offsetTop) * 2.5 + "px";
    } else if (scrollPosition >= contactSection.offsetTop) {
        text.style.marginTop = (scrollPosition - contactSection.offsetTop) * 2.5 + "px";
    }
});
document.addEventListener("DOMContentLoaded", () => {
    const sections = document.querySelectorAll("section");
    const observerOptions = {
        root: null, // Menggunakan viewport
        threshold: 0.1, // Jalankan saat 10% elemen terlihat
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                // Tambahkan logika animasi atau efek di sini
                console.log("Bagian terlihat:", entry.target.id);
            }
        });
    }, observerOptions);

    sections.forEach((section) => {
        observer.observe(section);
    });
});

document.querySelectorAll(".menu-item").forEach(item => {
    item.addEventListener("click", (event) => {
        event.preventDefault();
        const targetId = item.getAttribute("href").replace("#", "");
        const targetSection = document.getElementById(targetId);

        if (targetSection) {
            targetSection.scrollIntoView({ behavior: "smooth" });
        }
    });
});
