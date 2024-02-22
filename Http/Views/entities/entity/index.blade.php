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
                            <div class="dropdown dropstart nopointer">
                                <button class="btn btn-sm btn-secondary rounded-pill px-3 dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Acion
                                </button>
                                <ul class="dropdown-menu">
                                    <h6 class="dropdown-header">{{$row->razonSocialEmisor()}}</h6>
                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <span class="mdi mdi-link mdi-20px"></span>
                                            Envíar Aprobación Comercial
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <span class="mdi mdi-link mdi-20px"></span> Another action
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <span class="mdi mdi-link mdi-20px"></span> Something else here
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </section>
    </article>
    @endsection