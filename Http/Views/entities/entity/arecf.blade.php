@extends("dgii::entities.layout")

    @section("content")
        
        @if(auth("web")->check())
        
        <article class="row mx-0">            
            @foreach($lists as $list)
            <section class="card mb-3 border-0 rounded-0 p-0 shadow-sm">
                <article class="card-body p-0">
                    <div class="d-flex align align-items-start">
                        <div class="p-3">
                            <span class="mdi mdi-file-certificate-outline" style="font-size: 3em; line-height: 100%;"></span>
                        </div>
                        <div class="p-3 border-start">
                            
                            <h4 class="fx-bold fw-semibold fs-6 text-body-emphasis m-0">
                                {{$list->pathECF->get("RazonSocialComprador")}}
                            </h4>
                            Acuse de recibo procesado el {{$list->created_at}}
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
                    Enviado por: <span class="badge text-bg-light">{{$list->pathECF->get("RNCComprador")}}</span>
                </footer>
            </section>
            @endforeach           
        </article>
      
       @endif
    @endsection