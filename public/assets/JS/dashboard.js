// Modal functionality

$(document).ready(function (){
    const modal = document.querySelector('.modal');

    let courseInfo = null;

    $('.addFile').click( ()=>{
        modal.style.transform = "translateX(0)"
    })

    $('.close-btn').click(()=>{
        modal.style.transform = "translateX(-100%)"
    })

    $('input[name="view"]').click((event) =>{
        event.preventDefault();
        let hidden = event.target;

        let id = hidden.dataset.courseid;

        getInfo(id)

        if(courseInfo != null){
            setModal(courseInfo)
        }
    })

    async function getInfo(id){
        try {
            const resp = await $.get("assets/data/courseInfo.php", { id });
            if (resp) {
                courseInfo = JSON.parse(resp)    
            }
            else{
                console.log("fetch data error")
            }
        } catch (error) {
            console.error("Error fetching data: ", error)
        }
    }

    function setModal(courseInfo){
        modal.style.transform = "scale(1)"
        // Set the values of the inputs in the modal

        $('#hidden').val('edit');
        $('#cname').val(courseInfo['pd_name']);
        $('#price').val(courseInfo['price']);
        $('#number').val(courseInfo['chapters']);
        $('#text').val(courseInfo['description']);
        $('#cat').val(courseInfo['cat_name']);

        $('#img-preview').css('display', 'block')
        $('#img-preview').attr('src', `../assets/images/course_images/${courseInfo['pic']}`);

        const elm = document.createElement('input');
        elm.setAttribute('name', "editId")
        elm.setAttribute('value', courseInfo['pd_id'])
        elm.setAttribute('type', "hidden")

        document.querySelector('.form-section form').appendChild(elm);


        $('#submit').val("Update");

    }
})
