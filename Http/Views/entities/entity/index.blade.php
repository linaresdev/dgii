@extends("dgii::entities.layout")

    @section("header")

        <section class="mb-3 p-0">
            <h4 class="fx-bold fw-semibold fs-5 m-0 p-0">
                ECF - Comprobantes Electronicos
            </h4>
            Listado de compbantes recibidos.
        </section> 
    @endsection

    @section("content")
    @if(auth("web")->check())
        <article class="row mx-0">
            
        
            @includeIF("dgii::entities.entity.partial.search")

            @foreach( $arecf as $row )
            @php 
                Dgii::addUrl([
                    '{ecf}' => "{current}/ecf/$row->id"
                ]);
            @endphp
            <section class="card border-0 rounded-0 shadow-sm mb-2 p-0">
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
                                    <Strong>Total</Strong> {{Number::format($row->montoTotal())}} $RD
                                </div>
                            </div>
                        </div>
                    </div>
                </article>
            </section>
        @endforeach
        </article>
    @endif    
    
    @endsection