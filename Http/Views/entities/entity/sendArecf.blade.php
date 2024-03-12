@extends("dgii::entities.layout")

    @section("header")

        <section class="mb-3 p-0">
            <h4 class="fx-bold fw-semibold fs-5 m-0 p-0">
                ACECF - {{__("words.acecf")}}
            </h4>
            Envío de  aprobación comercial
        </section> 
    @endsection

    @section("content")

        <article class="row mb-3">

            <section class="col-lg-4 col-md-4 col-sm-12">
                @include("dgii::entities.entity.partial.form")  
            </section>  

            <section class="col-lg-8 col-md-8 col-sm-12">
               <div class="card border-0 rounded-0 rounded-top-1 d-flex bg-secondary text-white">
                    <div class="p-3 text-end">
                        <h4 class="fx-bold fw-semibold fs-6 m-0 mb-1">
                           {{$ecf->eNCF}}
                        </h4>
                        <h4 class="fs-7">{{$ecf->RazonSocialComprador()}}</h4>
                    </div>
               </div>
               <div class="card border-0 rounded-0 d-flex align-items-center">
                    <ul class="p-3 m-0" style="list-style:none;">
                        <li>
                            <strong style="width: 300px; display: inline-block;">FECHA DE EMISION</strong>
                            {{$ecf->fechaEmision()}}
                        </li>
                        <li>
                            <strong style="width: 300px; display: inline-block;">RNC</strong>
                            {{$ecf->item('RNCComprador')}}
                        </li>
                        <li>
                            <strong style="width: 300px; display: inline-block;">VALOR GRAVADO RD$</strong>
                            @if( ($MontoGravadoTotal = $ecf->item('MontoGravadoTotal')) != null)
                            RD$ {{Number::format($MontoGravadoTotal)}}
                            @endif                            
                        </li>
                        <li>
                            <strong style="width: 300px; display: inline-block;">INDICADOR VALOR GRAVADO</strong>
                            @if( ($IndicadorMontoGravado = $ecf->item('IndicadorMontoGravado')) != null)
                            RD$ {{Number::format($IndicadorMontoGravado)}}
                            @endif
                        </li>
                        <li>
                            <strong style="width: 300px; display: inline-block;">TOTAL ITBIS</strong>
                            RD$ {{Number::format($ecf->item('TotalITBIS'))}}
                        </li>
                        <li>
                            <strong style="width: 300px; display: inline-block;">MONTO TOTAL</strong>
                            @if( ($MontoTotal = $ecf->item('MontoTotal')) != null )
                            RD$ {{Number::format($MontoTotal)}} 
                            @endif
                        </li>
                    </ul>
               </div>
            </section> 
        </article>
        
    @endsection