import "../sass/index.scss";
import {createApp} from "vue"
import App from "../vue/App.vue"
import {createPinia} from "pinia"


document.addEventListener("DOMContentLoaded", function () {
    const pinia = createPinia();
    createApp(App).use(pinia).mount("#app-calculator")

    const menuItems = document.querySelectorAll(".menu-item-has-children");

    if (window.innerWidth >= 768) {
        // Functionality for desktop devices
        menuItems.forEach(function (item) {
            let timer;

            item.addEventListener("mouseenter", function () {
                const subMenu = this.querySelector(".sub-menu");
                if (subMenu) {
                    subMenu.style.display = "flex";
                }
            });

            item.addEventListener("mouseleave", function () {
                const subMenu = this.querySelector(".sub-menu");
                if (subMenu) {
                    timer = setTimeout(function () {
                        subMenu.style.display = "none";
                    }, 300);
                }
            });

            item.addEventListener("mouseenter", function () {
                clearTimeout(timer);
            });
        });
    } else {
        // Functionality for mobile devices
        menuItems.forEach(function (item) {
            item.addEventListener("click", function () {
                const subMenu = this.querySelector(".sub-menu");

                if (subMenu) {
                    if (
                        subMenu.style.display === "none" ||
                        subMenu.style.display === ""
                    ) {
                        subMenu.style.display = "flex";
                        subMenu.style.zIndex = 99999;
                    } else {
                        subMenu.style.display = "none";
                    }
                }
            });
        });
    }

    const openBtn = document.querySelector(".btn-open");
    const closeBtn = document.querySelector(".btn-close");
    const menu = document.querySelector(".navigation");

    // Evento para el botón de cierre
    openBtn.addEventListener("click", () => {
        menu.style.display = "flex";
        closeBtn.style.display = "flex";
        openBtn.style.display = "none";
        document.body.style.overflow = 'hidden';
    });

    // Evento para el botón de apertura
    closeBtn.addEventListener("click", () => {
        menu.style.display = "none";
        closeBtn.style.display = "none";
        openBtn.style.display = "flex";
        document.body.style.overflow = 'auto';

    });

    document.querySelectorAll(".submenu").forEach((menu) => {
        menu.addEventListener("click", () => {
            menu.style.display = "flex";
        });
    });

    //   remove classname from header

    let header = document.querySelector(".contentHeader");

    if (header && window.location.pathname !== "/") {
        header.style.position = "relative";
        header.style.maxHeight = "unset";
        header.style.background = "white";
        header.classList.add("header-second");
    }
});

document.addEventListener("DOMContentLoaded", function () {
    const navLinks = document.querySelectorAll('.navigation a');

    navLinks.forEach(function(link) {
        const href = link.getAttribute('href');

        // Detecta si no hay href o es un "#" (placeholder común)
        if (!href || href === '#') {
            const span = document.createElement('span');

            // Copia el contenido y clases
            span.innerHTML = link.innerHTML;
            span.className = link.className;

            // Sustituye el <a> por <span>
            link.parentNode.replaceChild(span, link);
        }
    });
});


//Intersection observer for animations
document.addEventListener("DOMContentLoaded", function () {
    const supportedAnimations = [
        "fade_in",
        "slide_up",
        "slide_left",
        "slide_right",
        "zoom_in",
        "rotate_in"
    ];

    const elementsToAnimate = [];

    supportedAnimations.forEach(type => {
        // Selecciona solo elementos con animación activa
        const found = document.querySelectorAll(`.animation--${type}.active--animation-yes`);
        found.forEach(el => elementsToAnimate.push(el));
    });

    if (elementsToAnimate.length === 0) return; // Nada que hacer

    const observer = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add("is-visible");
                observer.unobserve(entry.target); // Solo una vez
            }
        });
    }, {
        threshold: 0.2,
    });

    elementsToAnimate.forEach(el => observer.observe(el));
});
