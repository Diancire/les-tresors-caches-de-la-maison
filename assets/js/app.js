/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import '../scss/app.scss';
import '../js/message_flash';
import '../js/textarea';

const toggle_btn = document.querySelector('.navbar_icon_burger')
const toggle_btn_icon = document.querySelector('.navbar_icon_burger i')
const dropdown_menu = document.querySelector('.navbar_dropdown_menu')

toggle_btn.onclick = function () {
  dropdown_menu.classList.toggle('is-open');
  const isOpen = dropdown_menu.classList.contains('is-open')
  toggle_btn_icon.classList = isOpen ? "fa fa-xmark" : "fa fa-bars"
}

const toggle_categories_btn = document.querySelector('.dropdown_categories_icon_btn')
const toggle_categories_btn_icon = document.querySelector('.dropdown_categories_icon_btn i')
const dropdown_categories_menu = document.querySelector('.dropdown_categories_menu')

toggle_categories_btn.onclick = function () {
  dropdown_categories_menu.classList.toggle('is-open');
  const isOpen =  dropdown_categories_menu.classList.contains('is-open')
  toggle_categories_btn_icon.classList = isOpen ? "fa-solid fa-chevron-up" : "fa-solid fa-chevron-down" 
}
const scrollToTopBtn = document.getElementById("scrollToTopBtn");
window.addEventListener("scroll", function () {
  if (document.documentElement.scrollTop > 100) {
    scrollToTopBtn.style.display = "block";
  } else {
    scrollToTopBtn.style.display = "none";
  }
});

function scrollToTop() {
  document.documentElement.scrollTo({
    top: 0,
    behavior: "smooth"
  });
}

scrollToTopBtn.addEventListener("click", scrollToTop);