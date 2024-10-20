<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}" required>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Prevention: Section</title>
</head>
<body>
    <div>
        <x-home-button/>
        <h2>PROCESS UPDATE</h2>

        <x-form formName="add_process_form"  formId="add_process_form" method="POST" action="add-process-data"  name="add_process" show="PROCESS:"  placeholder="add process here" inputeId="add_process" inputName="add_process"
        buttonType="submit" buttonOnclick="processAdd()" style="block;" btnName="btnProcess" btnId="btnProcess" btnLabel="ADD PROCESS"/>

        <h2>MATERIAL UPDATE</h2>

        <x-form formName="before_material_form"  formId="before_material_form" method="POST" action="before-material-data"  name="before_material" show="MATERIAL(BEFORE):"  placeholder="add before material here" inputeId="before_material" inputName="before_material"
        buttonType="submit" buttonOnclick="home()" style="block;" btnName="btnBefore" btnId="btnBefore" btnLabel="ADD BEFORE MATERIAL"/>

        <x-form formName="after_material_form"  formId="after_material_form" method="POST" action="after-material-data"  name="after_material" show="MATERIAL(AFTER):"  placeholder="add after material here" inputeId="after_material" inputName="after_material"
        buttonType="submit" buttonOnclick="home()" style="block;" btnName="btnAfter" btnId="btnAfter" btnLabel="ADD AFTER MATERIAL"/>
    </div>
    <script>
        function processAdd(){
            document.getElementById("add_process_form").submit();

        }
    </script>

</body>
</html>
