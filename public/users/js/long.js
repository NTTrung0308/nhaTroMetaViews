
var swiper = new Swiper(".mySwiper-memeber", {
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
            slidesPerView: 1
        },
        576: {
            slidesPerView: 2
        },
        992: {
            slidesPerView: 3
        }
    }
});

var swiper = new Swiper(".mySwiper3", {
  slidesPerView: 5,
  spaceBetween: 30,
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
    300: {
      slidesPerView: 3,
      spaceBetween: 20,
    },
    640: {
      slidesPerView: 3,
      spaceBetween: 20,
    },
    768: {
      slidesPerView: 3,
      spaceBetween: 40,
    },
    1024: {
      slidesPerView: 5,
      spaceBetween: 50,
    },
  },
});
// about us--------------------------------------------------
document.querySelectorAll('.about-img-wrap').forEach(function (item) {
    item.addEventListener('mouseenter', function () {
        this.querySelector('.about-img-caption').style.bottom = '0';
    });
    item.addEventListener('mouseleave', function () {
        this.querySelector('.about-img-caption').style.bottom = '-100%';
    });
});
// end about us----------------------------------------------.




document.addEventListener('DOMContentLoaded', function () {
    // Swiper timeline đồng bộ
    var swiper2 = window.swiper2 || null;
    if (!swiper2 && window.Swiper) {
        swiper2 = new Swiper('.mySwiper-history');
        window.swiper2 = swiper2;
    }
    var timelineItems = document.querySelectorAll('.timeline-event-history');
    timelineItems.forEach(function (item, idx) {
        item.addEventListener('click', function () {
            if (window.swiper2) window.swiper2.slideTo(idx);
            timelineItems.forEach(e => e.classList.remove('active'));
            this.classList.add('active');
        });
    });
    if (window.swiper2) {
        window.swiper2.on('slideChange', function () {
            var idx = window.swiper2.realIndex;
            timelineItems.forEach(e => e.classList.remove('active'));
            if (timelineItems[idx]) timelineItems[idx].classList.add('active');
        });
    }


});
// ...existing code...

document.addEventListener('DOMContentLoaded', function () {
    // Tabs gallery
    const tabItems = document.querySelectorAll('.history-gallery-tabs .tab-item');
    const galleryGroups = document.querySelectorAll('.history-gallery-group');
    const tabUnderline = document.querySelector('.history-gallery-tabs .tab-underline');

    function updateUnderline(tab) {
        const tabRect = tab.getBoundingClientRect();
        const containerRect = tab.closest('.history-gallery-tabs').getBoundingClientRect();
        tabUnderline.style.width = `${tabRect.width}px`;
        tabUnderline.style.left = `${tabRect.left - containerRect.left}px`;
    }

    // Khởi tạo underline ở tab active đầu tiên
    const activeTab = document.querySelector('.history-gallery-tabs .tab-item.active') || tabItems[0];
    if (activeTab) updateUnderline(activeTab);

    tabItems.forEach(tab => {
        tab.addEventListener('click', function () {
            if (this.classList.contains('active')) return;
            // Đổi trạng thái active cho tab
            tabItems.forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            updateUnderline(this);

            // Ẩn tất cả gallery group
            galleryGroups.forEach(g => g.classList.remove('active-gallery'));
            // Hiện gallery group tương ứng
            const target = this.getAttribute('data-target');
            if (target) {
                const show = document.querySelector(target);
                if (show) show.classList.add('active-gallery');
            }
        });
    });

    // Cập nhật underline khi resize
    let resizeTimer;
    window.addEventListener('resize', function () {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(() => {
            const activeTab = document.querySelector('.history-gallery-tabs .tab-item.active');
            if (activeTab) updateUnderline(activeTab);
        }, 150);
    });
});





var swiper = new Swiper(".serviceSwiper", {
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