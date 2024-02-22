@extends("dgii::entities.layout")

    @section("content")
    
    <article class="card">
        <section class="card-body">
            <table class="table table-striped table-borderless">
                <thead>
                    <tr>
                        <th class="text-center" width="50">#</th>
                        <th>eNCF</th>
                        <th>RNCEmisor</th>
                        <th>Razon Social Emisor</th>
                        <th>Monto Total</th>
                        <th class="text-end py-0">Aciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach( $arecf as $row )
                    <tr>
                        <td class="text-center" width="50">-</td>
                        <td>{{$row->eNCF}}</td>
                        <td>{{$row->RNCEmisor}}</td>
                        <td>{{$row->razonSocialEmisor()}}</td>
                        <td>{{$row->montoTotal()}}</td>
                        <td class="text-end py-0 pt-1">
                            <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
                                Acion
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </section>
    </article>
    @endsection