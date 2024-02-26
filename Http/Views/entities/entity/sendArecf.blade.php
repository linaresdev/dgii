@extends("dgii::entities.layout")

    @section("content")

        <h4 class="fx-bold fs-5 text-body-emphasis mb-4">
            Envío de  aprobación comercial
        </h4>

        <article class="card pt-4 mb-3">
            <section class="card-body">               

                @include("dgii::entities.entity.partial.header")
                @include("dgii::entities.entity.partial.resumen")               
                
            </section>
        </article>

        @include("dgii::entities.entity.partial.form")
    @endsection