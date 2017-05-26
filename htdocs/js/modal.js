"use strict";

// Get the modal
var modal = document.getElementById('modal');
// var modalContent = document.getElementById('modal-content');
var link = document.getElementById('modal_activator');
var closeButton = document.getElementById('close_modal');
var registerActivator = document.getElementById('register');
var registerContainer = document.getElementById('container-register');
var loginContainer = document.getElementById('login-container');
var regText = document.getElementById('reg-text');

link.addEventListener('click', function () {
    modal.style.display = 'flex';
    loginContainer.style.display = 'flex';
    loginContainer.style.opacity = '1';
    regText.style.opacity = '1';
});

closeButton.addEventListener('click', function () {
    modal.style.display = 'none';
});

registerActivator.addEventListener('click', function() {
    registerContainer.style.display = 'flex';
    loginContainer.style.opacity = '0';
    regText.style.opacity = '0';

    window.setTimeout(function() {
        loginContainer.style.display = 'none';
        regText.style.display = 'none';
        registerContainer.style.opacity = 1;
    }, 1000);

});

// containerRegister.addEventListener('click', function () {
//     window.setTimeout(function() {
//     }, 1000);
// });

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
        loginContainer.style.display = 'flex';
        regText.style.display = 'block';
        registerContainer.style.display = "none";
    }
};
