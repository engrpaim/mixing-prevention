<div class="flex items-end justify-end w-screen mt-10">
    <div class="flex flex-col">
    <x-handler process="{{ session('process') }}" compare="Model" compareErr="model already exist"/>

    <x-submit-button type="button" onclick="addModel()" style="block;" name="add" id="add_model_btn">Add model</x-submit-button>
    </div>
    <div id="confirm_details" style="display: none;" >

        <p>Are you sure you want to add model?</p>
        <div  id="model_summary"></div>

        <x-submit-button type="button" onclick="confirmAdd()" style="block;" name="confirm" id="confirm">CONFIRM</x-submit-button>

        <x-submit-button type="button" onclick="cancelAdd()" style="block;" name="cancel" id="cancel">CANCEL</x-submit-button>

    </div>
</div>
