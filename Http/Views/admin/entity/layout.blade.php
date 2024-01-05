@extends("dgii::admin.layout.master")
    @section("body")
        <article class="container-fluid mb-3">
            <section class="{{$container}}">
                <h4>{!! $icon !!} {!! $title !!}</h4>

                @yield("content", "Content")
            </section>
        </article>
    @endsection