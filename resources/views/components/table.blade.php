<div>
    <table>
        <thead>
            <tr>
                <th>{{ $title }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($array  as $data)
                <tr>
                    <td>{{ $data->{$column} }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
