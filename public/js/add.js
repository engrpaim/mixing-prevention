
function addModel(){
    const form = document.getElementById('specs-model-form');
    if (form.checkValidity()) {
        const finish = document.getElementById('finish').textContent;
       // const process1 = document.getElementById('process_1').textContent;
        /*
        const maxWidth = document.getElementById('max_tolerance_width').value;
        const minWidth = document.getElementById('min_tolerance_width').value;
        const length = document.getElementById('length').value;
        const maxLength = document.getElementById('max_tolerance_length').value;
        const minLength = document.getElementById('min_tolerance_length').value;
        const thickness = document.getElementById('thickness').value;
        const maxThickness = document.getElementById('max_tolerance_thickness').value;
        const minThickness = document.getElementById('min_tolerance_thickness').value;

        const detailsMessage = `

            <strong>MODEL NAME:</strong>:</strong> ${modelName}<br>
            <strong>WIDTH:</strong> ${width} <strong>MAX:</strong> +${maxWidth} <strong>MIN:</strong> -${minWidth}<br>
            <strong>LENGTH:</strong> ${length} <strong>MAX:</strong> +${maxLength} <strong>MIN:</strong> -${minLength}<br>
            <strong>THICKNESS:</strong> ${thickness} <strong>MAX:</strong> +${maxThickness} <strong>MIN:</strong> -${minThickness}<br>


        `;

        document.getElementById('model_summary').innerHTML = detailsMessage;*/
        document.getElementById('add_model_btn').style.display = 'none';
        document.getElementById('confirm_details').style.display = 'block';

    } else {
        document.getElementById('add_specs_btn').style.display = 'block';
        form.reportValidity();


    }

}

function cancelAdd(){

    window.location.replace("/add");

}

function confirmAdd(){


    const form2 = document.getElementById('add-specs-form');
    if (form2.checkValidity()) {

        document.getElementById("add-specs-form").submit();

    } else {
        document.getElementById('add_specs_btn').style.display = 'block';
        form2.reportValidity();


    }
   // document.getElementById("add-specs-form").submit();

}


