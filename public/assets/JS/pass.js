const icon = document.getElementById('pass_icon');
const input = document.getElementById('pass_input');


icon.onclick = () =>{
    if(input.type == 'password'){
        icon.className = 'fas fa-eye-slash'
        input.type = 'text'
    }
    else{
        icon.className = 'fas fa-eye'
        input.type = 'password'
    }
}