<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}" required>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Mixing: Section</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
<div >
    <div class="flex items-center justify-end h-24 max-w-full bg-gray-100 outline outline-1 outline-gray-300 md:min-w-full sm:me-48 sm:px-64" >
        <x-nav title="Add model" route="add" isLast="" tooltip="Insert new model"/>
        <x-nav title="Update details" route="sections" isLast="" tooltip="Update material and processes"/>
        <x-nav title="Check mixing" route="check" isLast="" tooltip="show or check mixing models"/>
        <x-home-button/>
    </div>
    <div class="flex justify-center p-5">
        <div class="mt-8">
            <h2 class="font-bold">PROCESS UPDATE</h2>

            <x-form formName="add_process_form"  formId="add_process_form" method="POST" action="add-process-data"  name="add_process" show="PROCESS:"  placeholder="add process here" inputeId="add_process" inputName="add_process"
            buttonType="submit" buttonOnclick="processAdd()" style="block;" btnName="btnProcess" btnId="btnProcess" btnLabel="process"/>
            <x-handler process="{{ session('process') }}" compare="Process" compareErr="process already exist"/>
            <h2 class="font-bold">MATERIAL UPDATE</h2>

            <x-form formName="before_material_form"  formId="before_material_form" method="POST" action="before-material-data"  name="before_material" show="MATERIAL(BEFORE):"  placeholder="add before material here" inputeId="before_material" inputName="before_material"
            buttonType="submit" buttonOnclick="" style="block;" btnName="btnBefore" btnId="btnBefore" btnLabel="before material"/>
            <x-handler process="{{ session('process') }}" compare="Before Material" compareErr="material(before) already exist"/>

            <x-form formName="after_material_form"  formId="after_material_form" method="POST" action="after-material-data"  name="after_material" show="MATERIAL(AFTER):"  placeholder="add after material here" inputeId="after_material" inputName="after_material"
            buttonType="submit" buttonOnclick="" style="block;" btnName="btnAfter" btnId="btnAfter" btnLabel="after material"/>
            <x-handler process="{{ session('process') }}" compare="After Material" compareErr="after(material) already exist"/>
        </div>
        {{-- SIDE FORMS PROCESS UPDATE/MATERIAL UPDATE  --}}
        <div class="flex updateTables">
            <x-table title="PROCESS" :array="$allProcess" column="process" compare="Process" />
            <x-table title="BEFORE-MATERIAL" :array="$allBeforeMaterial" column="before_material"  compare="Before"/>
            <x-table title="AFTER-MATERIAL" :array="$allAfterMaterial" column="after_material"  compare="After"/>
        </div>
    </div>

</div>





<script type="text/javascript" src="{{ asset('js/allCaps.js') }}"></script>

</body>
</html>
