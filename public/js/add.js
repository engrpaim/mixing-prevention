function addModel(){
    const form = document.getElementById('add-model-form');
    if (form.checkValidity()) {

        const modelName = document.getElementById('model_name').value;
        const width = document.getElementById('width').value;
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

        document.getElementById('model_summary').innerHTML = detailsMessage;
        document.getElementById('add_model_btn').style.display = 'none';
        document.getElementById('confirm_details').style.display = 'block';

    } else {

        form.reportValidity();

    }
}

function cancelAdd(){

    window.location.replace("/add");

}

function confirmAdd(){

    document.getElementById("add-model-form").submit();

}
