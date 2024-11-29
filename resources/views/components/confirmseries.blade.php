<div class="flex items-end justify-end w-screen mt-10 ">
    <div class="flex flex-col">
    <x-handler process="{{ session('process') }}" compare="Model" compareErr="model already exist"/>

    <x-submit-button type="button" onclick="addModel()" style="block;" name="add" id="add_model_btn">Add model</x-submit-button>
    </div>
    <div id="confirm_details" style="display: none;" class="absolute inset-0 z-50 justify-center">
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
            <div class="flex flex-col items-center justify-center p-6 rounded-lg outline outline-1 outline-slate-200 bg-slate-200 w-96">
                <div class="flex flex-col">
                    <p>Are you sure you want to add model?</p>
                </div>
                <div class="flex flex-col">
                    <div class="flex flex-row gap-4">
                        <div id="model_summary"></div>

                        <x-submit-button type="button" onclick="confirmAdd()" style="block;" name="confirm" id="confirm">CONFIRM</x-submit-button>

                        <x-submit-button type="button" onclick="cancelAdd()" style="block;" name="cancel" id="cancel">CANCEL</x-submit-button>
                    </div>
                </div>
                <script type="text/javascript" src="{{ asset('js/add.js') }}"></script>
            </div>
        </div>
    </div>
</div>
