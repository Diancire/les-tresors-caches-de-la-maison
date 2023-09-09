/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import '../scss/app.scss';

const toggle_btn = document.querySelector('.navbar_icon_burger')
const toggle_btn_icon = document.querySelector('.navbar_icon_burger i')
const dropdown_menu = document.querySelector('.navbar_dropdown_menu')

toggle_btn.onclick = function () {
    dropdown_menu.classList.toggle('is-open');
    const isOpen = dropdown_menu.classList.contains('is-open')
    toggle_btn_icon.classList = isOpen ? "fa fa-xmark" : "fa fa-bars"
}