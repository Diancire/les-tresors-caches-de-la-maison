function removeFlashMessages() {
    var flashMessages = document.querySelectorAll('.flash');
    flashMessages.forEach(function (message) {
        setTimeout(function () {
            message.style.display = 'none';
        }, 10000); 
    });
}

window.addEventListener('load', removeFlashMessages);