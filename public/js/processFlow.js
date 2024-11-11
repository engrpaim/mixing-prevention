const processSpan = [];
const hiddenInput = document.getElementById('selected_processes');
const hiddenInput2 = document.getElementById('selected_processes2');
const container = document.getElementById("span-container");
const selectCurrentValue = document.getElementById("process");
const select = document.getElementById("process");
const modelName = document.getElementById("model_name2");
const currentValue = document.getElementById("model_name");
let count =0;
const color = ["green","violet","red","blue","yellow","pink"];
//handle the visibility and validity of the first form using
function addSpecs(){
    document.getElementById('add_specs_btn').style.display ='none';
    const form = document.getElementById('add-model-form');
    if (form.checkValidity()) {
        document.getElementById('add_specs_btn').style.display = 'block';
        const modelName = document.getElementById('model_name').value;
        const process0 = document.getElementById('process_0').textContent;

        document.getElementById('specs-model-form').submit();



    } else {
        document.getElementById('add_specs_btn').style.display = 'block';
        form.reportValidity();


    }

}
currentValue.addEventListener("input",function(event){
    const passedValue = event.target.value;
    modelName.value = passedValue;
    console.log(modelName);
})

select.addEventListener("change", () => {


    if(processSpan.length < 7){
        count++;
        const selectedValue = select.value;


        if (selectedValue && !processSpan.includes(selectedValue)) {

            processSpan.push(selectedValue);
            console.log(processSpan);

            renderSpans();
            updateHiddenInput();
        }
    }
});

//Create span in process flow

function renderSpans() {
    console.log(processSpan.length);
    container.innerHTML = '';
    if(processSpan.length  == 0){
        console.log('hello');
        selectCurrentValue.value ="";

        const span2 = document.createElement("span");
        span2.classList.add("process_0", "justify-center", 'cursor-pointer', "p-3", "bg-red-200", "m-24","rounded", "mx-3","min-w-fit","text-xs", "bg-red-700","text-gray-50");
        span2.id = "process_0";
        span2.style.display = "flex";
        span2.style.alignItems = "center";
        span2.textContent = "No exisiting process flow";

        container.appendChild(span2);

    }else{




    processSpan.forEach((processValue, index) => {

        const span = document.createElement("span");
        span.classList.add("process_"+index, 'cursor-pointer', "p-3", "bg-"+color[index]+"-200", "rounded", "my-1","min-w-fit","text-xs", "hover:bg-"+color[index]+"-700","hover:text-gray-50" ,"hover:font-bold");
        span.id = "process_" + index;
        span.style.display = "flex";
        span.style.alignItems = "center";
        span.style.justifyContent = "space-between";
        span.textContent = processValue;


        const removeButton = document.createElement("button");
        removeButton.textContent = "X";
        removeButton.type = "button";
        removeButton.classList.add("ml-1", "p-2", "bg-red-400", "text-white", "rounded", "hover:bg-red-600");


        removeButton.addEventListener("click", () => {

            processSpan.splice(index, 1);
            renderSpans();
            updateHiddenInput();
        });

        span.appendChild(removeButton);


        container.appendChild(span);

    });
}
}

//update the value to be passed in 2 forms hiddeninput2 is for add specs

function updateHiddenInput() {

    console.log(hiddenInput2);

    hiddenInput.value = processSpan.join(';');
    hiddenInput2.value = processSpan.join(';');

}
//updates the view of the process flow
renderSpans();