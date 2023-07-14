"use strict"



document.addEventListener('DOMContentLoaded', function(){
    const form = document.getElementById('form');
    const elements = form.elements;

    //alert(elements.length + " dsa");
    //alert(elements[0]);
    form.addEventListener('submit', formSend);

    async function formSend(e)
    {
        
        e.preventDefault();
        
        let error = formValidate(form);
        
        //alert('form lengt: ' + form.length);
        
        let formData = new FormData(form);
        
        //alert('formData lengt: ' + formData.length);
        


        if(error === 0){
            alert("письмо отправляется");
            let response = await fetch('sendmail.php' , {
                method: 'POST',
                body: form
            });
            if (response.ok) {
                let result = await response.json();
                alert(result.message);
                formPreview.innerHTML = '';
                form.reset();
            } else {
                alert("Ошибка");
            }
        } else {
            alert('заполните обязательные поля');
        }

    }

    function formValidate(form){
        const EMAIL_REGEXP = /^(([^<>()[\].,;:\s@"]+(\.[^<>()[\].,;:\s@"]+)*)|(".+"))@(([^<>()[\].,;:\s@"]+\.)+[^<>()[\].,;:\s@"]{2,})$/iu;

        let error = 0;
        let formReq = document.querySelectorAll('.req');
        //

        alert(formReq[0]);
        const elements = formReq.elements;

        alert(elements.length + " dsa");
        alert(elements[0]);

        let formInp = document.querySelectorAll('.input');



       //alert(formReq.length);
        //alert(formInp.length);


        for (let index = 0; index < formReq.length; index++) {
            const input = formReq[index];

            input.parentElement.classList.remove('_error');
            input.classList.remove('_error');
            
            if(input.classList.contains('_email')){
                if(EMAIL_REGEXP.test(input)){
                    input.parentElement.classList.add('_error');
                    input.classList.add('_error');
                    error++;
                }
            
            } else {
                if(input.value === ''){
                    input.parentElement.classList.add('_error');
                    input.classList.add('_error');
                    error++;
                }
            }
        }

        return error;
    }

    

    

});
