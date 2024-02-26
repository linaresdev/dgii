

    <article class="col-3 offset-9">
        <table class="table table-borderless rounded">
            <tr>
                <td class="text-end py-0">
                    FACTURA NO.:
                </td>
                <td class="text-end py-0">
                    {{$ecf->item("NumeroFacturaInterna")}}
                </td>
            </tr>
            <tr>
                <td class="text-end py-0">
                    DE FECHA :
                </td>
                <td class="text-end py-0">
                    {{$ecf->item("FechaEmision")}}
                </td>
            </tr>
        </table>
    </article>

    <table class="table border" style="font-size: .9em;">
        <tbody>
        
            @foreach( $headerFields as $headers )
            <tr>
                @foreach($headers as $head)                
                <td class="bg-light text-end py-1 w-25">
                    <strong>
                        {{$head["label"]}}
                    </strong>
                </td>
                <td class="py-1">
                    {{$ecf->item($head["value"])}}
                </td>
                @endforeach
            </tr>
            @endforeach
        </tbody>
    </table>