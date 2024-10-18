<!DOCTYPE html>
<html lang="en" required>
<head>
    <meta charset="UTF-8" required>
    <meta name="csrf-token" content="{{ csrf_token() }}" required>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" required>
    <meta http-equiv="X-UA-Compatible" content="ie=edge" required>
    <title>Add model</title>
</head>
<body>
    <h1>ADD MODEL : MIXING PREVENTION</h1><br>
    <div>
        <h3>MODEL DETAILS</h3>
        <form name="add-model-form" id="add-model-form" method="POST" action="{{ url('add-model-data') }}" required>
            @csrf
            <div>
                <label for="model_name" required>MODEL NAME:</label>
                <input name="model_name" id="model_name" required><br><br>
            </div>
            <h3>TOLERANCE SPECIFICATION</h3>
            <div>
                <label for="width" required>WIDTH:</label>
                <input type="number" min="0" step="0.01" id="width" name="width" required>
                <label for="max_tolerance_width" >MAX:</label>
                <input type="number" min="0" step="0.01" id="max_tolerance_width" name="max_tolerance_width" required>
                <label for="min_tolerance_width" required>MIN:</label>
                <input type="number" min="0" step="0.01" id="min_tolerance_width" name="min_tolerance_width" required>
            </div>
            <br/>
            <div>
                <label for="length" required>LENGTH:</label>
                <input type="number" min="0" step="0.01" id="length" name="length" required>
                <label for="max_tolerance_length" required>MAX:</label>
                <input type="number" min="0" step="0.01" id="max_tolerance_length" name="max_tolerance_length" required>
                <label for="min_tolerance_length" required>MIN:</label>
                <input type="number" min="0" step="0.01" id="min_tolerance_length" name="min_tolerance_length" required>
            </div>
            <br/>
            <div>
                <label for="thickness" required>TICKHNESS:</label>
                <input type="number" min="0" step="0.01" id="thickness" name="thickness" required>
                <label for="max_tolerance_thickness" required>MAX:</label>
                <input type="number" min="0" step="0.01" id="max_tolerance_thickness" name="max_tolerance_thickness" required>
                <label for="min_tolerance_thickness" required>MIN:</label>
                <input type="number" min="0" step="0.01" id="min_tolerance_thickness" name="min_tolerance_thickness" required>
            </div>
            <br><br>
            <button type="button" id="add_model_btn" name="add_model_btn" onclick="addModel()" >ADD MODEL</button>
            <div id="confirm_details" style="display: none;">
                <p>Are you sure you want to add model?</p>
                <x-submit-button type="button" onclick="confirmAdd()" style="block;">CONFIRM</x-submit-button>
            </div>
        </form>
    </div>
    <script>
        function addModel(){
            document.getElementById('add_model_btn').style.display = 'none';
            document.getElementById('confirm_details').style.display = 'block';
        }

        function confirmAdd(){

        }
    </script>
</body>
</html>
