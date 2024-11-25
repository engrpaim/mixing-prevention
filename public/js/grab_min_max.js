
document.addEventListener('DOMContentLoaded', function () {

    const minInputs = document.querySelectorAll('input[id$="_min"]');
    const maxInputs = document.querySelectorAll('input[id$="_max"]');
    const valInputs = document.querySelectorAll('input[id$="_val"]');


    minInputs.forEach(input => {
        input.addEventListener('input', function () {
        var generateinput = document.createElement('input');
            generateinput.type = 'hidden';
            generateinput.id = input.id;
            generateinput.name = input.id;
            generateinput.value = input.value;

        var findform = document.getElementById('add-specs-form');
        if (findform) {
            findform.appendChild(generateinput);
        } else {
            console.error("Form with id 'myForm' not found.");
        }
        });
    });

    valInputs.forEach(input => {
        input.addEventListener('input', function () {
        var generateinput = document.createElement('input');
            generateinput.type = 'hidden';
            generateinput.id = input.id;
            generateinput.name = input.id;
            generateinput.value = input.value;

        var findform = document.getElementById('add-specs-form');
        if (findform) {
            findform.appendChild(generateinput);
        } else {
            console.error("Form with id 'myForm' not found.");
        }
        });
    });


    maxInputs.forEach(input => {
        input.addEventListener('input', function () {
        var generateinput = document.createElement('input');
            generateinput.type = 'hidden';
            generateinput.id = input.id;
            generateinput.name = input.id;
            generateinput.value = input.value;

        var findform = document.getElementById('add-specs-form');
        if (findform) {
            findform.appendChild(generateinput);
        } else {
            console.error("Form with id 'myForm' not found.");
        }
        });
    });



    });

