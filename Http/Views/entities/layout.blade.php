@extends("dgii::admin.layout.master")

    @section("body")
        <article class="container-fluid mb-3">
            <section class="{{$container}}">
                <h4 class="mb-4">
                    {!! $icon !!} {!! $title !!}
                </h4>  
                
                {!! Alert::listen("system", "dgii::alerts.simple") !!}

                <nav class="navbar navbar-entity navbar-expand-lg px-1 py-0 mb-3">
                    <a class="navbar-brand px-3 @if(request()->path() == 'entity') active @endif" 
                        href="{{__url('entity')}}">
                        <span class="mdi mdi-home"></span>
                        {{__("words.home")}}
                    </a>

                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        {!! Nav::route(12) !!}
                    </div>
                </nav>
                

                @yield("content", "Content")

                @includeIF("dgii::admin.layout.partial.footer")
            </section>
        </article>
    @endsection