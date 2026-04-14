const container = document.getElementById('container');
const signUpBtn = document.getElementById('signUpBtn');
const signInBtn = document.getElementById('signInBtn');

if (signUpBtn) {
    signUpBtn.addEventListener('click', () => {
        container.classList.add('right-panel-active');
    });
}

if (signInBtn) {
    signInBtn.addEventListener('click', () => {
        container.classList.remove('right-panel-active');
    });
}
