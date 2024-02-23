
    <table class="table border">
        <thead>
            <tr>
                <th colspan=2 class="text-center">
                    RESUMEN
                </th>
            </tr>
        </thead>
        @foreach( $totales as $row )
        <tr>
            <td class="w-25 p-1">
                <strong class="d-block bg-light py-1 px-2 text-end">
                    {{$row["label"]}}
                </strong>
            </td>
            <td class="p-1">{{$ecf->item($row["value"])}}</td>
        </tr>
        @endforeach
    </table>