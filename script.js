
document.addEventListener("DOMContentLoaded", function () {
  const menuIconOpen = document.querySelector(".menu-icon .open");
  const menuIconClose = document.querySelector(".menu-icon .close");
  const navMenu = document.querySelector(".nav-menu");

  menuIconOpen.addEventListener("click", () => {
    navMenu.style.display = "flex"; // Show the menu
    menuIconOpen.style.display = "none";
    menuIconClose.style.display = "flex";
  });

  menuIconClose.addEventListener("click", () => {
    navMenu.style.display = "none"; // Hide the menu
    menuIconClose.style.display = "none";
    menuIconOpen.style.display = "flex";
  });
});


document.querySelectorAll('.resto-menu').forEach(item => {
  item.addEventListener('click', () => {
    item.classList.toggle('expanded');
  });
});

window.addEventListener('load', () => {
    const scrollContent = document.querySelector('.scroll-content');
    const images = Array.from(scrollContent.children);
    const halfCount = images.length / 2;

    // Calculate total width of first half
    let halfWidth = 0;
    for (let i = 0; i < halfCount; i++) {
        halfWidth += images[i].offsetWidth;
    }

    // Calculate animation duration based on width (30px/sec speed)
    const duration = halfWidth / 30;

    // Inject dynamic keyframes
    const styleSheet = document.createElement("style");
    styleSheet.innerHTML = `
        @keyframes scrollGallery {
            from { transform: translateX(0); }
            to { transform: translateX(-${halfWidth}px); }
        }
    `;
    document.head.appendChild(styleSheet);

    // Apply animation to scroll-content
    scrollContent.style.animation = `scrollGallery ${duration}s linear infinite`;
});

const gallery = document.querySelector(".gallery");
const slides = document.querySelectorAll(".gallery .item");
const prevBtn = document.querySelector(".slider-controls .prev");
const nextBtn = document.querySelector(".slider-controls .next");

let currentSlide = 0;

function updateSlide() {
  const offset = -currentSlide * 100; // move by 100% per slide
  slides.forEach(slide => {
    slide.style.transform = `translateX(${offset}%)`;
  });
}

prevBtn.addEventListener("click", () => {
  currentSlide = (currentSlide - 1 + slides.length) % slides.length;
  updateSlide();
});

nextBtn.addEventListener("click", () => {
  currentSlide = (currentSlide + 1) % slides.length;
  updateSlide();
});



