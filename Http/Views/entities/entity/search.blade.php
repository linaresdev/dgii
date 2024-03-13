
    <article class="mb-3 d-flex aling-items-center p-0">
        Busqueda por {{config("ecf.filter.by")}}
    </article>
    @if($results->count() > 0)
    @foreach( $results as $row )
    @php 
        Dgii::addUrl([
            '{ecf}' => "entity/$rnc/ecf/$row->id"
        ]);
    @endphp
    <article class="card border-0 rounded-0 shadow-sm mb-2 p-0">
        <article class="d-flex align-items-stretch">
            
            @if($row->arecf()->get("Estado") == "0")
            <a href="{{__url('{ecf}/arecf')}}" class="link-success link-underline-opacity-0 text-center px-3 py-4">
                <span class="mdi mdi-file-sign" style="font-size: 2.2rem;line-height: 100%;"></span>
                <div>ARECF</div>
            </a>
            @else
            <a href="{{__url('{ecf}/arecf')}}" class="link-danger link-underline-opacity-0 text-center px-3 py-4">
                <span class="mdi mdi-file-cancel-outline" style="font-size: 2.2rem;line-height: 100%;"></span>
                <div>ARECF</div>
            </a>
            @endif                    
            @if(empty(($acecf = $row->acecf)))
            <a href="{{__url('{ecf}/acecf/send')}}" class="link-warning link-underline-opacity-0 text-center px-3 py-4 border-start">
                <span class="mdi mdi-file-document-arrow-right-outline" style="font-size: 2.2rem;line-height: 100%;"></span>
                <div>ACECF</div>
            </a>
            @else
                @if($acecf->Estado == 1)
                <a href="{{__url('{ecf}/acecf')}}" class="link-success link-underline-opacity-0 text-center px-3 py-4 border-start">
                    <span class="mdi mdi-file-document-check-outline" style="font-size: 2.2rem;line-height: 100%;"></span>
                    <div>ACECF</div>
                </a>
                @else
                <a href="{{__url('{ecf}/acecf')}}" class="link-danger link-underline-opacity-0 text-center px-3 py-4 border-start">
                    <span class="mdi mdi-file-document-alert-outline" style="font-size: 2.2rem;line-height: 100%;"></span>
                    <div>ACECF</div>
                </a>
                @endif
            @endif
            <div class="p-3 border-start">
                <h4 class="fx-bold fw-semibold fs-6 text-body-emphasis m-0 mb-1">
                {{$row->eNCF}}
                </h4>
                <div>
                    <h4 class="fs-7">{{$row->razonSocialEmisor()}}</h4>
                    <div class="d-flex">
                        <div class="me-3">
                            <Strong>Fecha Emision</Strong> {{$row->fechaEmision()}}
                        </div>
                        <div>
                            <Strong>Total</Strong> $RD {{Number::format($row->montoTotal())}} 
                        </div>                                
                    </div>
                </div>
                <a href="{{__url('{ecf}/download')}}" class="btn btn-sm bg-primary-subtle link-primary rounded-pill px-3">
                    <span class="mdi mdi-download mdi-20px"></span>
                    {{__("words.download")}}
                </a>
            </div>
        </article>
    </article>
    @endforeach

    @else
    <article class="bg-white shadow-sm d-flex align-items-center p-0">
        <section class="p-3">
            <span class="mdi mdi-file-hidden opacity-25" style="font-size: 2.2rem;line-height: 100%;"></span>
        </section>
        <section class="p-3 border-start">
            <span class="mdi mdi-file-hidden opacity-25" style="font-size: 2.2rem;line-height: 100%;"></span>
        </section>
        <section class="p-3 border-start">
            <h4 class="fs-7">
                Busqueda sin contenido para mostrar.
            </h4>
            <a href="{{__url('entity/'.$rnc)}}" class="btn bg-primary-subtle btn-sm rounded-pill px-3">
                <span class="mdi mdi-reply mdi-20px"></span>
                {{__("words.close")}}
            </a>
        </section>
    </article>
    @endif