
        <article class="card pt-4 border-0 rounded-1 shadow-1">
            <div class="card-body">

                @if($errors->any())
                <div class="mb-1 ms-2 border-start border-3 border-danger ps-2 py-2 my-2">
                    @foreach($errors->all() as $error)
                    <p class="m-0 text-danger fs-6">{{$error}}</p>
                    @endforeach
                </div>
                @endif

                {!! Alert::listen("acecf", "dgii::alerts.basic") !!}

                <form action="{{__url('{current}')}}" method="POST">

                    @csrf
                    <input type="hidden" name="rnc" value="{{$ecf->item('RNCComprador')}}">

                    <div class="mb-2">
                        <label for="Estado">Estado</label>
                        <select name="Estado" id="Estado" class="form-select">
                            <option value="1">Aprobar</option>
                            <option value="2">Rechazar</option>
                        </select> 
                    </div>
                    <div class="mb-2">                                
                        <label for="DetalleMotivoRechazo">
                            En caso no ser aprobado, especifique porque.
                        </label>
                        <textarea class="form-control" id="DetalleMotivoRechazo" name="DetalleMotivoRechazo"></textarea>
                    </div>
                    <div class="">
                        <a href="{{__url('{ent}')}}" class="btn btn-danger">
                            <span class="mdi mdi-close"></span>
                            {{__("words.close")}}
                        </a>
                        <button class="btn btn-secondary" type="submit" onclick="return confirm('Are you sure?')">
                            Enviar respuesta
                        </button>
                    </div>
                </form>
            </div>
        </article>