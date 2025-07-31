const carousel = document.querySelector("#testimonialCarousel");
if (carousel) {
    const dotGroups = carousel.querySelectorAll(".carousel-dots");

    carousel.addEventListener("slide.bs.carousel", function (e) {
        dotGroups.forEach((group) => {
            const buttons = group.querySelectorAll("button");
            buttons.forEach((btn) => btn.classList.remove("active-dot"));
            if (buttons[e.to]) buttons[e.to].classList.add("active-dot");
        });
    });
}
window.onscroll = function () {
    const btn = document.querySelector(".back-to-top");
    if (
        document.body.scrollTop > 150 ||
        document.documentElement.scrollTop > 100
    ) {
        btn.style.display = "flex";
    } else {
        btn.style.display = "none";
    }
};

function topFunction() {
    document.body.scrollTop = 0;
    document.documentElement.scrollTop = 0;
}

document.getElementById("mainBtn").addEventListener("click", function () {
    const btnGroup = document.querySelector(".btn-group");
    const icon = this.querySelector(".main-btn-icon");
    btnGroup.classList.toggle("active");

    if (btnGroup.classList.contains("active")) {
        setTimeout(() => {
            icon.classList.remove("bi-plus-lg");
            icon.classList.add("bi-x-lg");
        }, 300);
    } else {
        setTimeout(() => {
            icon.classList.remove("bi-x-lg");
            icon.classList.add("bi-plus-lg");
        }, 300);
    }
});

function toggleAnswer(trigger, id) {
    const answer = document.getElementById(id);
    const isOpen = answer.classList.contains("open");
    const itemWrapper = trigger.closest(".faq-item"); // lấy phần bọc ngoài

    if (isOpen) {
        answer.style.height = answer.scrollHeight + "px";
        requestAnimationFrame(() => {
            answer.style.transition = "height 0.4s ease";
            answer.style.height = "0";
        });
        answer.classList.remove("open");
        itemWrapper?.classList.remove("open"); // ❌ bỏ class màu khi đóng
    } else {
        answer.classList.add("open");
        answer.style.transition = "none";
        answer.style.height = "auto";
        const targetHeight = answer.scrollHeight + "px";
        answer.style.height = "0";
        requestAnimationFrame(() => {
            answer.style.transition = "height 0.4s ease";
            answer.style.height = targetHeight;
        });
        itemWrapper?.classList.add("open"); // ✅ thêm class để đổi màu
    }

    answer.addEventListener("transitionend", function handler(e) {
        if (e.propertyName === "height") {
            if (answer.classList.contains("open")) {
                answer.style.height = "auto";
            }
            answer.removeEventListener("transitionend", handler);
        }
    });
}

document.addEventListener("DOMContentLoaded", function () {
    const mainImg = document.getElementById("main-banner-img");
    const thumbs = Array.from(document.querySelectorAll(".banner-thumb"));
    let current = 0;

    function setActive(idx) {
        thumbs.forEach((thumb, i) => {
            if (i === idx) {
                thumb.classList.add("active-thumb");
            } else {
                thumb.classList.remove("active-thumb");
            }
        });
    }
    setActive(current);

    thumbs.forEach((thumb, idx) => {
        thumb.addEventListener("click", function () {
            mainImg.src = this.dataset.img;
            current = idx;
            setActive(current);
        });
    });

    document
        .getElementById("btn-rect-prev")
        .addEventListener("click", function () {
            current = (current - 1 + thumbs.length) % thumbs.length;
            mainImg.src = thumbs[current].dataset.img;
            setActive(current);
        });

    document
        .getElementById("btn-rect-next")
        .addEventListener("click", function () {
            current = (current + 1) % thumbs.length;
            mainImg.src = thumbs[current].dataset.img;
            setActive(current);
        });
});

var swiper2 = new Swiper(".mySwiper2", {
    slidesPerView: 4,
    spaceBetween: 30,
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },
    breakpoints: {
        300: {
            slidesPerView: 1,
            spaceBetween: 20,
        },
        640: {
            slidesPerView: 2,
            spaceBetween: 20,
        },
        768: {
            slidesPerView: 2,
            spaceBetween: 40,
        },
        1024: {
            slidesPerView: 4,
            spaceBetween: 50,
        },
    },
});

var swiper1 = new Swiper(".mySwiper1", {
    slidesPerView: 4,
    spaceBetween: 30,
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },
    breakpoints: {
        300: {
            slidesPerView: 1,
            spaceBetween: 20,
        },
        640: {
            slidesPerView: 1,
            spaceBetween: 20,
        },
        768: {
            slidesPerView: 2,
            spaceBetween: 40,
        },
        1024: {
            slidesPerView: 2,
            spaceBetween: 50,
        },
    },
});
var dichvuSwiper = new Swiper(".dichvuSwiper", {
    slidesPerView: 1,
    spaceBetween: 20,
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },
    breakpoints: {
        640: {
            slidesPerView: 1,
            spaceBetween: 20,
        },
        768: {
            slidesPerView: 2,
            spaceBetween: 30,
        },
        1024: {
            slidesPerView: 3,
            spaceBetween: 40,
        },
    },
});

var swiper = new Swiper(".mySwiper4", {
    slidesPerView: 4,
    spaceBetween: 30,
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },
    breakpoints: {
        300: {
            slidesPerView: 1,
            spaceBetween: 20,
        },
        640: {
            slidesPerView: 1,
            spaceBetween: 20,
        },
        768: {
            slidesPerView: 1,
            spaceBetween: 40,
        },
        1024: {
            slidesPerView: 1,
            spaceBetween: 50,
        },
    },
});

var swiper = new Swiper(".mySwiper-contact-1", {
    slidesPerView: 4,
    spaceBetween: 30,
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },
    autoplay: {
        delay: 3000, // Tự động chuyển slide mỗi 3 giây
        disableOnInteraction: false, // Vẫn tự động chạy sau khi người dùng tương tác
    },
    breakpoints: {
        300: {
            slidesPerView: 2,
            spaceBetween: 20,
        },
        640: {
            slidesPerView: 2,
            spaceBetween: 20,
        },
        768: {
            slidesPerView: 2,
            spaceBetween: 40,
        },
        1024: {
            slidesPerView: 5,
            spaceBetween: 50,
        },
    },
});

var swiper = new Swiper(".mySwiper-member", {
    slidesPerView: 3,
    spaceBetween: 30,
    loop: true,

    pagination: {
        el: ".swiper-pagination",
        clickable: true,
        dynamicBullets: true,
    },

    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },

    breakpoints: {
        // Responsive support
        0: {
            slidesPerView: 1,
        },
        576: {
            slidesPerView: 2,
        },
        992: {
            slidesPerView: 3,
        },
    },
});

document.addEventListener("DOMContentLoaded", function () {
    new Swiper(".mySwiper-member-text", {
        // Optional parameters
        direction: "horizontal",
        loop: true,
        autoplay: {
            delay: 3000,
            disableOnInteraction: false,
        },
        breakpoints: {
            0: {
                slidesPerView: 1,
                spaceBetween: 20,
            },
            576: {
                slidesPerView: 1,
                spaceBetween: 20,
            },
            768: {
                slidesPerView: 1,
                spaceBetween: 30,
            },
        },

        // Navigation arrows
        navigation: {
            nextEl: ".nav-btn-member-next",
            prevEl: ".nav-btn-member-prev",
        },
    });
});

var swiper = new Swiper(".mySwiper-contact, .mySwiper-vision", {
    slidesPerView: 4,
    spaceBetween: 20,
    loop: true, // Thêm vòng lặp vô hạn
    autoplay: {
        delay: 3000, // Thời gian delay giữa các slide (3 giây)
        disableOnInteraction: false, // Tiếp tục autoplay sau khi tương tác
    },
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },
    breakpoints: {
        0: {
            slidesPerView: 2,
            spaceBetween: 20,
        },
        300: {
            slidesPerView: 3,
            spaceBetween: 20,
        },
        480: {
            slidesPerView: 3,
            spaceBetween: 20,
        },
        576: {
            slidesPerView: 3,
            spaceBetween: 20,
        },

        640: {
            slidesPerView: 3,
            spaceBetween: 20,
        },
        768: {
            slidesPerView: 4,
            spaceBetween: 40,
        },
        1024: {
            slidesPerView: 5,
            spaceBetween: 50,
        },
    },
});

var swiper = new Swiper(".mySwiperDung", {
    slidesPerView: 4,
    spaceBetween: 10,
    freeMode: true,
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },

    breakpoints: {
        300: {
            slidesPerView: 1,
            spaceBetween: 20,
        },
        640: {
            slidesPerView: 2,
            spaceBetween: 20,
        },
        768: {
            slidesPerView: 3,
            spaceBetween: 40,
        },
        1024: {
            slidesPerView: 4,
            spaceBetween: 50,
        },
    },
});

function changeImage(src) {
    document.getElementById("mainImage1").src = src;
}
