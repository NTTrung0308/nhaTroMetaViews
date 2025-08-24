/**
 * Main
 */

'use strict';

let menu,
  animate;
document.addEventListener('DOMContentLoaded', function () {
  // class for ios specific styles
  if (navigator.userAgent.match(/iPhone|iPad|iPod/i)) {
    document.body.classList.add('ios');
  }
});

(function () {
  // Initialize menu
  //-----------------

  let layoutMenuEl = document.querySelectorAll('#layout-menu');
  layoutMenuEl.forEach(function (element) {
    menu = new Menu(element, {
      orientation: 'vertical',
      closeChildren: false
    });
    // Change parameter to true if you want scroll animation
    window.Helpers.scrollToActive((animate = false));
    window.Helpers.mainMenu = menu;
  });

  // Initialize menu togglers and bind click on each
  let menuToggler = document.querySelectorAll('.layout-menu-toggle');
  menuToggler.forEach(item => {
    item.addEventListener('click', event => {
      event.preventDefault();
      window.Helpers.toggleCollapsed();
    });
  });

  // Display menu toggle (layout-menu-toggle) on hover with delay
  let delay = function (elem, callback) {
    let timeout = null;
    elem.onmouseenter = function () {
      // Set timeout to be a timer which will invoke callback after 300ms (not for small screen)
      if (!Helpers.isSmallScreen()) {
        timeout = setTimeout(callback, 300);
      } else {
        timeout = setTimeout(callback, 0);
      }
    };

    elem.onmouseleave = function () {
      // Clear any timers set to timeout
      document.querySelector('.layout-menu-toggle').classList.remove('d-block');
      clearTimeout(timeout);
    };
  };
  if (document.getElementById('layout-menu')) {
    delay(document.getElementById('layout-menu'), function () {
      // not for small screen
      if (!Helpers.isSmallScreen()) {
        document.querySelector('.layout-menu-toggle').classList.add('d-block');
      }
    });
  }

  // Display in main menu when menu scrolls
  // let menuInnerContainer = document.getElementsByClassName('menu-inner'),
  //   menuInnerShadow = document.getElementsByClassName('menu-inner-shadow')[0];
  // if (menuInnerContainer.length > 0 && menuInnerShadow) {
  //   menuInnerContainer[0].addEventListener('ps-scroll-y', function () {
  //     if (this.querySelector('.ps__thumb-y').offsetTop) {
  //       menuInnerShadow.style.display = 'block';
  //     } else {
  //       menuInnerShadow.style.display = 'none';
  //     }
  //   });
  // }

  // Init helpers & misc
  // --------------------

  // Init BS Tooltip
  const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
  tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl);
  });

  // Accordion active class
  const accordionActiveFunction = function (e) {
    if (e.type == 'show.bs.collapse' || e.type == 'show.bs.collapse') {
      e.target.closest('.accordion-item').classList.add('active');
    } else {
      e.target.closest('.accordion-item').classList.remove('active');
    }
  };

  const accordionTriggerList = [].slice.call(document.querySelectorAll('.accordion'));
  const accordionList = accordionTriggerList.map(function (accordionTriggerEl) {
    accordionTriggerEl.addEventListener('show.bs.collapse', accordionActiveFunction);
    accordionTriggerEl.addEventListener('hide.bs.collapse', accordionActiveFunction);
  });

  // Auto update layout based on screen size
  window.Helpers.setAutoUpdate(true);

  // Toggle Password Visibility
  window.Helpers.initPasswordToggle();

  // Speech To Text
  window.Helpers.initSpeechToText();

  // Manage menu expanded/collapsed with templateCustomizer & local storage
  //------------------------------------------------------------------

  // If current layout is horizontal OR current window screen is small (overlay menu) than return from here
  if (window.Helpers.isSmallScreen()) {
    return;
  }

  // If current layout is vertical and current window screen is > small

  // Auto update menu collapsed/expanded based on the themeConfig
      window.Helpers.setCollapsed(false, false);
})();
// Utils
function isMacOS() {
  return /Mac|iPod|iPhone|iPad/.test(navigator.userAgent);
}
/*!
 * Color mode toggler for Bootstrap's docs (https://getbootstrap.com/)
 * Copyright 2011-2023 The Bootstrap Authors
 * Licensed under the Creative Commons Attribution 3.0 Unported License.
 */

(() => {
  'use strict'

  // Hàm lấy theme đã lưu từ localStorage
  const getStoredTheme = () => localStorage.getItem('theme')
  // Hàm lưu theme vào localStorage
  const setStoredTheme = theme => localStorage.setItem('theme', theme)

  // Hàm xác định theme ưu tiên (đã lưu hoặc theo hệ thống)
  const getPreferredTheme = () => {
    const storedTheme = getStoredTheme()
    if (storedTheme) {
      return storedTheme
    }

    // Nếu không có gì trong localStorage, dùng theme của hệ thống
    return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light'
  }

  // Hàm áp dụng theme cho toàn bộ trang
  const setTheme = theme => {
    if (theme === 'auto' && window.matchMedia('(prefers-color-scheme: dark)').matches) {
      document.documentElement.setAttribute('data-bs-theme', 'dark')
    } else {
      document.documentElement.setAttribute('data-bs-theme', theme)
    }
  }

  // Áp dụng theme ngay khi trang được tải
  setTheme(getPreferredTheme())

  // Hàm cập nhật UI (icon và menu item active) để phản ánh theme hiện tại
  const showActiveTheme = (theme, focus = false) => {
    const themeSwitcher = document.querySelector('#nav-theme') // Lấy nút dropdown chính

    if (!themeSwitcher) {
      return
    }

    const themeSwitcherText = document.querySelector('#nav-theme-text') // Lấy text (có thể không dùng)
    const activeThemeIcon = document.querySelector('.theme-icon-active') // Lấy icon chính
    const btnToActive = document.querySelector(`[data-bs-theme-value="${theme}"]`) // Lấy button trong dropdown tương ứng
    const iconOfActiveBtn = btnToActive.querySelector('i').dataset.icon // Lấy data-icon của button đó

    // Cập nhật icon chính trên navbar
    if (activeThemeIcon) {
        // Xóa các class icon cũ
        activeThemeIcon.classList.remove('bx-sun', 'bx-moon', 'bx-desktop');
        // Thêm class icon mới
        activeThemeIcon.classList.add(`bx-${iconOfActiveBtn}`);
    }
    
    // Cập nhật text (nếu bạn muốn hiển thị)
    if (themeSwitcherText) {
        themeSwitcherText.textContent = btnToActive.textContent.trim();
    }


    // Bỏ active ở tất cả các button
    document.querySelectorAll('[data-bs-theme-value]').forEach(element => {
      element.classList.remove('active')
      element.setAttribute('aria-pressed', 'false')
    })

    // Thêm active cho button được chọn
    btnToActive.classList.add('active')
    btnToActive.setAttribute('aria-pressed', 'true')

    if (focus) {
      themeSwitcher.focus()
    }
  }

  // Lắng nghe sự kiện thay đổi theme của hệ điều hành
  window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
    const storedTheme = getStoredTheme()
    if (storedTheme !== 'light' && storedTheme !== 'dark') {
      // Nếu người dùng đang chọn 'system', thì cập nhật lại theme
      setTheme(getPreferredTheme())
    }
  })

  // Thực hiện khi DOM đã tải xong
  window.addEventListener('DOMContentLoaded', () => {
    // Cập nhật UI ban đầu
    showActiveTheme(getPreferredTheme())

    // Thêm sự kiện click cho tất cả các button chọn theme
    document.querySelectorAll('[data-bs-theme-value]')
      .forEach(toggle => {
        toggle.addEventListener('click', () => {
          const theme = toggle.getAttribute('data-bs-theme-value')
          setStoredTheme(theme) // Lưu lựa chọn mới
          setTheme(theme)      // Áp dụng theme mới
          showActiveTheme(theme, true) // Cập nhật lại UI
        })
      })
  })
})()