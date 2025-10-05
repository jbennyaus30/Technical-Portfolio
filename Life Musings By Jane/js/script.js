

let navbarDiv = document.querySelector('.navbar');
window.addEventListener('scroll', () => {
    if(document.body.scrollTop > 40 || document.documentElement.scrollTop > 40){
        navbarDiv.classList.add('navbar-scroll');       
    }

    else{
        navbarDiv.classList.remove('navbar-scroll');
    }
})


const navbarToggleDiv = document.getElementById('navbarToggle');
const navbarShowBtnJs = document.getElementById('navbarShowBtn');
const navbarCloseBtnJs = document.getElementById('navbarCloseBtn');

// To Show Navigation bar
navbarShowBtnJs.addEventListener('click', () => {
    navbarToggleDiv.classList.add('navbarToggle-rmw');
});

// Close the Side Navigation Bar
navbarCloseBtnJs.addEventListener('click', () => {
    navbarToggleDiv.classList.remove('navbarToggle-rmw');
});

document.addEventListener('click', (e) => {
    if(e.target.id != "navbarToggle" && e.target.id != "navbarShowBtn" && e.target.parentElement.id != "navbarShowBtn"){
        navbarToggleDiv.classList.remove('navbarToggle-rmw');
    }
});

