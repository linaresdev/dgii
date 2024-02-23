@extends("dgii::entities.layout")

    @section("content")

        <article class="card">
            <section class="card-body">
            
                <h4 class="fx-bold fs-5 text-body-emphasis my-3">
                    <span class="mdi mdi-send mdi-20px"></span>
                    Envío de  aprobación comercial
                </h4>

                @include("dgii::entities.entity.partial.header")
                @include("dgii::entities.entity.partial.resumen")

                <!-- <div class="row">
                    <div class="col d-flex align-items-start py-3">
                        <div>
                            <h4 class="fw-bold mb-0 fs-6 text-body-emphasis">
                                {{$ecf->razonSocialEmisor()}}
                            </h4>
                            <div>Nombre o razón social del emisor</div>
                        </div>
                    </div>
                </div>
                <table class="table table-striped table-borderless mb-5">
                    
                    <tr>
                        <td><strong>eNCF</strong></td>
                        <td class="text-end">{{$ecf->eNCF}}</td>
                    </tr>
                    <tr>
                        <td><strong>RNCEmisor</strong></td>
                        <td class="text-end">{{$ecf->RNCEmisor}}</td>
                    </tr> 
                    <tr>
                        <td><strong>FechaEmision</strong></td>
                        <td class="text-end">{{$ecf->item("FechaEmision")}}</td>
                    </tr>                      
                </table> -->


                <form action="#">
                    @csrf
                    <div class="row">
                        <div class="col-10">
                            <div class="input-group">
                                <label class="input-group-text" for="Estado">Estado :</label>

                                <select name="state" id="Estado" class="form-select">
                                    <option value="1">Aprobar</option>
                                    <option value="2">Rechazar</option>
                                </select>

                                <button class="btn btn-secondary" type="button" onclick="return confirm('Are you sure?')">
                                    Enviar respuesta
                                </button>
                            </div>
                        </div>
                        <div class="col-2 text-end">
                            <a href="{{__url('{ent}')}}" class="btn btn-danger">
                                Regresar
                            </a>
                        </div>
                    </div>
                </form>
                
            </section>
        </article>
    @endsection