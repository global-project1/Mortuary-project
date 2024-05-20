// Modal functionality

$(document).ready(function (){
    const modal = document.querySelector('.modal');
    const catModal = document.querySelector('.cat_modal')
    const aside = document.querySelector('aside')
    const article = document.querySelector('article')

    let corpseInfo = null;
    let server_url = null;
    let catInfo = null;

    $('.addFile').click( ()=>{
        $('.form-section #file').attr('required', false)
        modal.style.transform = "translateX(0)"
    })

    $('.close-btn').click((event)=>{
        if(event.target.id === "modal"){
          modal.style.transform = "translateX(-100%)"
        }
        else {
            if(event.target.id === 'aside'){
                aside.style.display = 'none'
            }
            else{
                if(event.target.id === 'article'){
                    article.style.display = 'none'
                }
                else{
                    catModal.style.transform = "translateX(100%)"
                }
            }
        }
    })

    // The editing of the modal starts here

    $('aside button').click(async (event) =>{
        let edit_id = corpseInfo['id']
        modal.style.transform = "translateX(0)"

        setModal()
    })
    
    function setModal(){
        // Change the option of the form
        $('.modal .form-section form #hidden').val('edit')

        // Set the other values
        for(let key in corpseInfo){
            switch(key){
                case "picture":{
                    let img = $(`.modal .form-section form #${key}`)
                    img.css('display', 'block')
                    img.attr('src', `assets/images/${corpseInfo[key]}`)
                    break;
                }
                case "cat_name":{
                    $(`.modal form #corpse_cat option[value="${corpseInfo['cat_id']}"]`).attr('selected', true)
                    break;
                }
                case "gender":{
                    $(`.modal form input[name=${key}][value="${corpseInfo[key]}"]`).attr('checked', true)
                    break;
                }
                case "marital_status":{
                    $(`.modal form input[name="${key}"][value="${corpseInfo[key]}"]`).attr('checked', true)
                    break;
                }
                default:{
                    $(`.modal .form-section form #${key}`).val(corpseInfo[key])
                    break;
                }
            }
        };

        let idInput = document.createElement('input')
        idInput.setAttribute('type', 'hidden')
        idInput.setAttribute('name', 'id')
        idInput.setAttribute('value', corpseInfo['id'])

        $('.modal .form-section form').append(idInput)

        // Change the value of the submit button
        $('.modal .form-section form input[type="submit"]').val('Edit')
    }

    $('input[name="view"]').click(async (event) =>{

        server_url = "assets/data/corpse_info.php";
        event.preventDefault();
        let hidden = event.target;
        let id = hidden.dataset.corid;

        corpseInfo = await getInfo(server_url, id)

        if(corpseInfo != null){
            setAside(corpseInfo)
        }
    })

    async function getInfo(server, id){
        try {
            const resp = await $.get(server, { id });
            if (resp) {
                return JSON.parse(resp)    
            }
            else{
                console.log("fetch data error")
            }
        } catch (error) {
            console.error("Error fetching data: ", error)
        }
    }

    function setAside(corpseInfo){
        article.style.display = 'none'
        aside.style.display = 'flex'

        // set values of the aside
        for(let key in corpseInfo){
           if(key === "picture"){
                $(`aside .${key}`).attr('src', `assets/images/${corpseInfo[key]}`)
           }
           else{
            $(`aside .${key}`).text(corpseInfo[key])
           }
        };

        // Calculate the age
        let age = corpseInfo['DOD'].split('-')[0] - corpseInfo['DOB'].split('-')[0];
        $(`aside .age`).text(age)

        // calculate the mortuary duration

        let divisor = 24*3600000
        let dod = Math.floor(Date.parse(corpseInfo['deposit_date'])/divisor)
        let today = Math.floor(new Date()/divisor)
        let dor = Math.floor(Date.parse(corpseInfo['removal_date'])/divisor)

        $('aside .duration').text(today-dod)
        $('aside .dur').text(dor-dod)

        let price = ((today-dod) * corpseInfo['price'])/1000
        $('aside .total_price').text(price)
    }

    // Category modal

    $('.header .modify').click((event) =>{
        event.preventDefault()

        aside.style.display = 'none'
        article.style.display = 'flex'
        
    })

    $('article .edit_btn').click(async (event)=>{

        server_url = "assets/data/category_info.php";
        let hidden = event.target;

        console.log(hidden.dataset)
        let id = hidden.dataset.catid;

        catInfo = await getInfo(server_url, id)

        if(catInfo != null){
            setCatModal()
        }
    })
    
    function setCatModal(){
        catModal.style.transform = 'translatex(0)';
        
        for(let key in catInfo){
            $(`.cat_modal form #${key}`).val(catInfo[key])
        }

        let idInput = document.createElement('input')
        idInput.setAttribute('type', 'hidden')
        idInput.setAttribute('name', 'id')
        idInput.setAttribute('value', catInfo['cat_id'])

        $('.cat_modal .form-section form').append(idInput)
    }
})
