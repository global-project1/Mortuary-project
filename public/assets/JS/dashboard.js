// Modal functionality

$(document).ready(function (){
    const modal = document.querySelector('.modal');
    const aside = document.querySelector('aside')

    let corpseInfo = null;

    $('.addFile').click( ()=>{
        modal.style.transform = "translateX(0)"
    })

    $('.close-btn').click((event)=>{
       if(event.target.id == "modal"){
           modal.style.transform = "translateX(-100%)"
       }
       else{
           aside.style.display = 'none'
       }
    })

    // The editing of the modal starts here

    $('input[name="view"]').click(async (event) =>{
        event.preventDefault();
        let hidden = event.target;
        let id = hidden.dataset.corid;

        await getInfo(id)

        if(corpseInfo != null){
            setAside(corpseInfo)
        }
    })

    async function getInfo(id){
        try {
            const resp = await $.get("assets/data/corpse_info.php", { id });
            if (resp) {
                corpseInfo = JSON.parse(resp)    
            }
            else{
                console.log("fetch data error")
            }
        } catch (error) {
            console.error("Error fetching data: ", error)
        }
    }

    function setAside(corpseInfo){
        aside.style.display = 'flex'

        // set values of the aside
        for(let key in corpseInfo){
           if(key === "picture"){
                $(`aside #${key}`).attr('src', `assets/images/${corpseInfo[key]}`)
           }
           else{
            $(`aside #${key}`).text(corpseInfo[key])
           }
        };

        // Calculate the age
        let age = corpseInfo['DOD'].split('-')[0] - corpseInfo['DOB'].split('-')[0];
        $(`aside #age`).text(age)

        // calculate the mortuary duration

        let divisor = 24*3600000

        let dod = Math.floor(Date.parse(corpseInfo['deposit_date'])/divisor)
       
        let today = Math.floor(new Date()/divisor)

        let dor = Math.floor(Date.parse(corpseInfo['removal_date'])/divisor)

        $('aside #duration').text(today-dod)
        $('aside #dur').text(dor-dod)

        let price = ((today-dod) * corpseInfo['price'])/1000
        $('aside #total_price').text(price)

    }
})
