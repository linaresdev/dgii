@extends("dgii::entities.layout")

    @section("content")
        
        @if(auth("web")->check())
        
        <article class="row mx-0">            
            @foreach($lists as $list)
            <section class="card mb-3 border-0 rounded-0 p-0 shadow-sm">
                <article class="card-body p-0">
                    <div class="d-flex align align-items-start">
                        <div class="text-center p-3 @if($list->Estado == '1') text-success @else text-danger @endif">
                            <span class="mdi mdi-file-certificate-outline" style="font-size: 3em; line-height: 100%;"></span>
                            <div class="">
                                @if($list->Estado == "1")
                                <span class="badge text-bg-success">Acetado</span>
                                @elseif($list->Estado == 2)
                                <span class="badge text-bg-danger">Rechazada</span>
                                @endif
                            </div>
                        </div>
                        <div class="px-3 py-3 border-start">
                            <h4 class="fx-bold fw-semibold fs-6 text-body-emphasis m-0">
                                {{$list->ecf->get("RazonSocialComprador")}}
                            </h4>
                            Aprobación comercial enviada el  {{$list->created_at}}
                            @if($list->Estado == "2")
                            <div class="text-warning-emphasis">
                                <strong>Razon :</strong> {{$list->DetalleMotivoRechazo}}
                            </div>
                            @endif
                            <div>
                                <a href="#" class="link-primary">
                                    <spn class="mdi mdi-link mdi-20px"></spn>
                                    Información
                                </a>
                            </div>
                        </div>
                    </div>                                      
                </article>
                <footer class="border-top px-3 py-1 bg-light">
                    Recibido: <span class="badge text-bg-light">{{$list->created_at->diffForHumans()}}</span> | 
                    Enviado por: <span class="badge text-bg-light">{{$list->ecf->get("RNCComprador")}}</span>
                </footer>
            </section>
            @endforeach           
        </article>
      
       @endif
    @endsection