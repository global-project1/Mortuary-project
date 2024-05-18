
const sections = document.querySelectorAll("section")
const navLinks = document.querySelectorAll("ul li")
const header = document.querySelector("header")

// Typed js
const typed = new Typed('.multiple-text',{
    strings : ['DoS Attacks', 'Phishing', 'MITM attacks', 'Social Engineering', 'Password Breaching', 'Packet Sniffing', 'DNS Spoofing'],
    typeSpeed: 120,
    backSpeed: 120,
    backDelay: 1000,
    loop: true  
})

// change nav link styles

function switchNav(){
    let top = window.scrollY;
    
    // change background
    if(top > 70){
        header.classList.add('changeable');
    }else{
        header.classList.remove('changeable')
    }

    sections.forEach(section => {

        let height = section.offsetHeight;
        let offset = section.offsetTop - 300;
        let id = section.getAttribute('id');

        if(top >= offset && top < offset + height){
            navLinks.forEach(nav =>{
                nav.classList.remove('active');

                document.querySelector(`li.${id}`).classList.add('active');

            })
     
        }
    })
}
window.addEventListener('scroll', switchNav)

// Scroll Reveal

ScrollReveal({
    reset : true,
    distance: '90px',
    duration: 2000,
    delay: 150

})

ScrollReveal().reveal('.section1 .text-area, section .heading', {origin: 'top'})

ScrollReveal().reveal('.section1 .form-section, .section3 .text-area', {origin: 'bottom'})

ScrollReveal().reveal('.section2 .desc', {origin: 'right'})
