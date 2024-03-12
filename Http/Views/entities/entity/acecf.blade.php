@extends("dgii::entities.layout")

    @section("header")

        <section class="mb-3 p-0">
            <h4 class="fx-bold fw-semibold fs-5 m-0 p-0">
                ACECF - {{__("words.acecf")}}
            </h4>
            Información de la aprobación comercial.
        </section> 
    @endsection

    @section("content")
        
    @if(auth("web")->check())
        
        <article class=" bg-secondary text-white text-end p-3 rounded-top-1">            
            <hgroup>
                <h4 class="fx-bold fw-semibold fs-6 m-0 mb-1">
                    {{$ecf->eNCF}}
                </h4>
                <h4 class="fs-7">
                    {{$ecf->RazonSocialComprador()}}
                </h4>
            </hgroup>          
        </article>
        <article class="bg-white d-flex justify-content-center shadow-sm p-3">
            <ul class="m-0 p-0" style="list-style:none;">
                <h4 class="fx-bold fw-semibold fs-6 mx-0 mb-3">
                    DETALLE APROBACIÓN COMERCIAL
                </h4>
                @foreach($acecf->info() as $key => $value )
                <li>
                    <strong style="width: 300px; display: inline-block;">
                        {{$key}}
                    </strong>
                    
                    {{$value}}
                </li>
                @endforeach
                <li class="py-3">
                    <a href="{{__url('{ent}')}}" class="btn btn-sm bg-danger-subtle link-danger rounded-pill px-3">
                        <span class="mdi mdi-close mdi-20px"></span>
                        {{__('words.close')}}
                    </a>
                    <a href="{{__url('{current}/download')}}" class="btn btn-sm bg-primary-subtle link-primary rounded-pill px-3">
                        <span class="mdi mdi-download mdi-20px"></span>
                        {{__('download.xml')}}
                    </a>
                    <a href="{{__url('{current}/send/mail')}}" class="btn btn-sm bg-success-subtle link-success rounded-pill px-3">
                        <span class="mdi mdi-email-arrow-right-outline mdi-20px"></span>
                        {{__('send.xml')}}
                    </a>
                </li>
            </ul>
        </article>
      
    @endif
    @endsection