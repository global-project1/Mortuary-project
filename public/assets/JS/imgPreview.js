// Img preview code

function displayImage(e){
    if(e.files[0]){
        const img = document.querySelector('#img-preview')
        img.style.display = "block";
        
        let reader = new FileReader
        reader.onload = function(e){
            img.setAttribute('src', e.target.result)
        }

        reader.readAsDataURL(e.files[0])
    }
}