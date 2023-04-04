const registerForm = document.getElementById('registerForm');
const loginForm = document.getElementById('loginForm');
const showRegisterButton = document.getElementById('showRegister');
const showLoginButton = document.getElementById('showLogin');

showRegisterButton.addEventListener("click", showRegister);
showLoginButton.addEventListener("click", showLogin);

function showLogin(){
    loginForm.style.display = 'block'
    registerForm.style.display = 'none'
}

function showRegister(){
    registerForm.style.display = 'block'
    loginForm.style.display = 'none'
}