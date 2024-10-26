const inputFields =document.querySelectorAll('input');

        inputFields.forEach(inputFields => {
            inputFields.addEventListener('input',function(){

                this.value = this.value.toUpperCase();

            });

        });

setTimeout(() => {
    const successMessages = document.getElementsByClassName('success-message');
    for (let i = 0; i < successMessages.length; i++) {
            successMessages[i].style.display = 'none';   
        }
}, 3000);
