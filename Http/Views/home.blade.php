@extends("dgii::admin.layout.master")

@section("body")
    <article class="col-xl-8 offset-xl-2 col-lg-10 offset-lg-1">
        <h4>{{$title}}</h4>

        <section class="container-fluid">
            <article class="row">

                <div class="col d-flex align align-items-start border p-2 bg-white">
                    <span class="mdi mdi-progress-wrench" style="font-size: 3em;"></span>
                    <div>
                        <h4 class="fx-bold fs-5 text-body-emphasis mb-0">Taller</h4>
                        El mejor trato te lo dan en casa: Cotización, mantenimiento y reparación.
                        +INFO 809-620-3000
                    </div>
                </div>

                <div class="col d-flex align align-items-start border  p-2  bg-white">
                    <span class="mdi mdi-car-child-seat mdi-flip-h" style="font-size: 3em;"></span>
                    <div>
                        <h4 class="fx-bold fs-5 text-body-emphasis mb-0">
                            Queda mucho por recorrer
                        </h4>
                        Nuestros expertos recomiendan un servicio cada 5,000 KM o 3 meses.
                    </div>
                </div>

            </article>
        </section>
    </article>

    
    <article class="conatiner p-3 mt-3">
        <article class="col-xl-8 offset-xl-2 col-lg-10 offset-lg-1">
            <section class="row">
                <div class="col p-0"> <hr class="divide"> </div>
                <div class="col-auto">
                    <img src="{{__url('{cdn}/images/delta.png')}}"
                        style="margin:0 0 10px 0; width:48px;"
                        alt="@">
                </div>
                <div class="col p-0"> <hr class="divide"> </div>
            </section>
            <section class="pb-3 text-center" style="color:#996;font-size:13px;">
                <strong class="text-danger fs-5"
                    style="">&COPY;</strong>
                |Delta Comercial, S.A. | Santo Domingo República Dominicana
            </section>
        </article>
    </article>
@endsection