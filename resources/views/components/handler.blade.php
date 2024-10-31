
    @if ($process  == $compare )
            <br />
            <x-sucess/>
            <br />
            
    @elseif ($process  == $compareErr )
            <br/>
            <x-error/>
            <br/>
    @endif


