<!DOCTYPE html>
<html lang="en" >
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}" >
    <meta name="viewport" content="width=device-width, initial-scale=1.0" >
    <meta http-equiv="X-UA-Compatible" content="ie=edge" >
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Mixing: Add</title>
</head>
<body>
    <div class="flex items-center justify-end h-24 max-w-full bg-gray-100 outline outline-1 outline-gray-300 md:min-w-full sm:me-48 sm:px-64" >
        <x-nav title="Add model" route="add" isLast="" tooltip="Insert new model"/>
        <x-nav title="Update details" route="sections" isLast="" tooltip="Update material and processes"/>
        <x-nav title="Check mixing" route="check" isLast="" tooltip="show or check mixing models"/>
        <x-home-button/>
    </div>
    <h1>ADD MODEL : MIXING PREVENTION</h1><br>
    <div>
        <h3>MODEL DETAILS</h3>
        <form name="add-model-form" id="add-model-form" method="POST" action="{{ url('add-model-data') }}" >
            @csrf
            <div>
                <label for="model_name" required>MODEL NAME:</label>
                <input name="model_name" id="model_name" required><br><br>
            </div>
            <div>

            </div>
            <?php for($i = 0; $i < 1 ;$i++){?>
            <h3>TOLERANCE SPECIFICATION</h3>
            <div>
                <label for="width" required>WIDTH:</label>
                <input type="number"  step="0.001" id="width" name="width" required>
                <label for="max_tolerance_width" >MAX:</label>
                <input type="number"  step="0.001" id="max_tolerance_width" name="max_tolerance_width" required>
                <label for="min_tolerance_width" required>MIN:</label>
                <input type="number" step="0.001" id="min_tolerance_width" name="min_tolerance_width" required>
            </div>
            <br/>
            <div>
                <label for="length" required>LENGTH:</label>
                <input type="number"  step="0.001" id="length" name="length" required>
                <label for="max_tolerance_length" required>MAX:</label>
                <input type="number"  step="0.001" id="max_tolerance_length" name="max_tolerance_length" required>
                <label for="min_tolerance_length" required>MIN:</label>
                <input type="number"  step="0.001" id="min_tolerance_length" name="min_tolerance_length" required>
            </div>
            <br/>
            <div>
                <label for="thickness" required>THICKNESS:</label>
                <input type="number"  step="0.001" id="thickness" name="thickness" required>
                <label for="max_tolerance_thickness" required>MAX:</label>
                <input type="number"  step="0.001" id="max_tolerance_thickness" name="max_tolerance_thickness" required>
                <label for="min_tolerance_thickness" required>MIN:</label>
                <input type="number"  step="0.001" id="min_tolerance_thickness" name="min_tolerance_thickness" required>
            </div>
            <?php } ?>
            <br>
            <x-error/>
            <x-sucess/>
            <br><br>

            <x-submit-button type="button" onclick="addModel()" style="block;" name="add" id="add_model_btn">Add model</x-submit-button>
            <div id="confirm_details" style="display: none;">
                <p>Are you sure you want to add model?</p>
                <div  id="model_summary"></div>
                <x-submit-button type="button" onclick="confirmAdd()" style="block;" name="confirm" id="confirm">CONFIRM</x-submit-button>
                <x-submit-button type="button" onclick="cancelAdd()" style="block;" name="cancel" id="cancel">CANCEL</x-submit-button>
            </div>

        </form>
    </div>

    <script type="text/javascript" src="{{ asset('js/add.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/allCaps.js') }}"></script>

</body>
</html>
