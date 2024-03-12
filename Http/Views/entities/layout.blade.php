@extends("dgii::admin.layout.master")

    @section("body")
        <article class="container-fluid mb-3">
            
            <header class="row mb-5 border-bottom bg-banner-moon">
                <article class="{{$container}}">
                    <h4 class="mb-4">
                        {!! $icon !!} {!! $title !!}
                    </h4>                                

                    @yield("header", "Header")                    
                </article>
            </header>

            <section class="{{$container}}">
                {!! Alert::listen("system", "dgii::alerts.simple") !!}
                
                @yield("content", "Content")

                @includeIF("dgii::admin.layout.partial.footer")
            </section>
        </article>
    @endsection