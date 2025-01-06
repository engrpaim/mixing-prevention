<footer>
        <div class="flex flex-col bg-slate-800 h-66">
            <div class="flex flex-row justify-end mr-96 bg-slate-800 h-66">
                <div class="">
                    <img src="{{ asset('icons/AE.png') }}" style="width:250px; height:250px;"/>
                </div>
                <div class="mx-10 ml-5">
                    <img src="{{ asset('icons/shinetsu.png') }}" style="width:250px; height:150px; margin-top: 40px;"/>
                </div>
                <div class="flex flex-col p-5 text-white">
                    <div class="pb-2">
                        <h1 class="text-xl font-bold">AUTOMATION ENGINEERING</h1>
                    </div>


                            @php
                            $allContacts = [
                                "" => "Local 619",
                                "automation@smp.com.ph" => "automation@smp.com.ph",
                                "ae@smp.com.ph" => "ae@smp.com.ph",

                            ];
                            @endphp

                            @foreach (  $allContacts  as $key => $value)
                                <div class="py-1 ml-2 text-sm hover:font-bold">
                                    <a href="mailto:{{ $key  }}">{{ $value }}</a><br>
                                </div>
                            @endforeach

                </div>
                <div class="flex flex-col p-5 ml-10 text-white ">
                        <div class="pb-2">
                            <h1 class="text-xl font-bold">OTHER SITES</h1>
                        </div>
                        @php
                            $allSites = [
                                "http://172.17.2.236/p7temp/" => "P7 Temperature Monitoring",
                                "https://172.17.2.235/inventory/" => "Inventory System",
                                "https://172.17.2.236/ms/" => "MS Database Server",
                                "https://172.17.1.130/gatepass/" => "Gate Pass System",
                                "https://172.17.8.60/idl/datalogger.php" => "IDL Datalogger",
                                "https://172.17.8.60/training" => "Training Management"
                            ];
                        @endphp

                        @foreach (  $allSites  as $key => $value)
                            <div class="py-1 ml-2 text-sm hover:font-bold">
                                <a href="{{ $key  }}">{{ $value }}</a><br>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
            <div class="flex flex-row justify-center py-2 pb-5 text-gray-400 bg-slate-800">
                <p>2025 &copy; Automation Engineering Department</p>
            </div>
        </div>
    </footer>
