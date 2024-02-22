@extends("dgii::admin.layout.master")

    @section("body")
        <article class="container-fluid mb-3">
            <section class="{{$container}}">
                <h4>{!! $icon !!} {!! $title !!}</h4>  
                
                {!! Alert::listen("system", "dgii::alerts.simple") !!}

                @yield("content", "Content")

                @includeIF("dgii::admin.layout.partial.footer")
            </section>
        </article>
    @endsection