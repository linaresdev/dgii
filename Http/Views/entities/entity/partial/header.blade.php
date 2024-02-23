
    <table class="table table-borderless" style="font-size: .9em;">
        <tbody>
            <tr>
                <td class="p-0">
                    <strong class="fw-normal text-body-emphasis">FACTURA NO.:</strong>
                    {{$ecf->item("NumeroFacturaInterna")}}
                </td>
                <td class="text-end p-0">
                    <strong class="fw-normal text-body-emphasis">DE FECHA :</strong>
                    {{$ecf->item("FechaEmision")}}
                </td>
                <td class="text-end p-0">
                    <strong class="fw-normal text-body-emphasis">VALIDO HASTA :</strong>
                    <strong class="fs-7">N/A</strong>
                </td>                
            </tr>
        </tbody>
    </table>

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
            <!-- <tr>
                <td colspan="4" class="p-0">
                    <table class="table table-borderless m-0">
                        <tr>
                            <td width="120" class="bg-light text-end py-1">
                                <strong>
                                    CUENTA :
                                </strong>
                            </td>
                            <td class="py-1"></td>

                            <td width="120" class="bg-light text-end py-1 ">
                                <strong>
                                    # ORDEN
                                </strong>
                            </td>
                            <td class="py-1"></td>

                            <td width="120" class="bg-light text-end py-1">
                                <strong>
                                    SUC :
                                </strong>
                            </td>
                            <td class="py-1"></td>

                            <td width="120" class="bg-light text-end py-1">
                                <strong>
                                    DEVOLUCION :
                                </strong>
                            </td>
                            <td class="py-1"></td>
                        </tr>
                    </table>
                </td>
            </tr> -->
        </tbody>
    </table>