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
    @include('components.all-nav')
  

    <div class="shadow-gray-300 shadow-md shadow-cyan-500/50 rounded-lg w-auto m-2 m-24 min-w-fit">
      <div class="flex justify-center bg-blue-200 py-4">
        <h1 class="font-bold">ADD: MODEL DETAILS</h1>
      </div>
      <div class="p-5 font-semibold text">
        <form name="add-model-form" id="add-model-form" method="POST" action="{{ url('add-model-data') }}" >
            @csrf
            <label for="model_name" required>MODEL NAME:</label>
            <input class="m-2 p-3 shadow-lg outline outline-1 outline-gray-300 rounded-lg hover:bg-blue-100 hover:outline-blue-500 hover:outline-2" name="model_name" id="model_name" placeholder="add model here" required><br><br>
          
            <x-error/>
            <x-sucess/>

            <x-submit-button type="button" onclick="addModel()" style="block;" name="add" id="add_model_btn">Add model</x-submit-button>
            <div id="confirm_details" style="display: none;">
                <p>Are you sure you want to add model?</p>
                <div  id="model_summary"></div>
                <x-submit-button type="button" onclick="confirmAdd()" style="block;" name="confirm" id="confirm">CONFIRM</x-submit-button>
                <x-submit-button type="button" onclick="cancelAdd()" style="block;" name="cancel" id="cancel">CANCEL</x-submit-button>
            </div>
            <script type="text/javascript" src="{{ asset('js/add.js') }}"></script>
            <script type="text/javascript" src="{{ asset('js/allCaps.js') }}"></script>
        </form>
      </div>
    </div>
    

   

        
        
           
            <?php for($i = 0; $i < 1 ;$i++){?>
            <!--h3>TOLERANCE SPECIFICATION</h3>
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
            </div>!-->
            <?php } ?>
           
        
 

    

</body>
</html>
