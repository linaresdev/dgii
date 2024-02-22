@extends("dgii::entities.layout")

    @section("content")
        <hr class="divider">
        @if(auth("web")->check())
        
        <article class="row mx-1">            
            @foreach( $user->entities() as $entity )
            <div class="col d-flex align align-items-start p-3 border bg-white">
                <span class="mdi mdi-bank" style="font-size: 3em;line-height: 90%;"></span>
                <div class="">
                    <h4 class="fx-bold fs-6 text-body-emphasis mb-0">{{$entity->name}}</h4>
                    <a href="{{__url('entity/'.$entity->slug)}}" class="btn btn-light btn-sm rounded-pill px-3 py-1">
                        Administrar
                    </a>
                </div>
            </div>
            @endforeach          
            
        </article>
      
       @endif
    @endsection