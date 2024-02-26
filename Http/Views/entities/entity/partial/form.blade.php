
        <article class="card border-dark">
            <div class="card-body">
                
                <form action="{{__url('{current}')}}" method="POST">

                    @csrf
                    <input type="hidden" name="rnc" value="{{$ecf->item('RNCComprador')}}">
                    <div class="row">
                        <div class="col-2 text-end">                            
                            <a href="{{__url('{ent}')}}" class="btn btn-danger">
                                <span class="mdi mdi-close"></span>
                                {{__("words.close")}}
                            </a>
                        </div>
                        <div class="col-9">
                            <div class="input-group">
                                <label class="input-group-text" for="Estado">Estado :</label>

                                <select name="state" id="Estado" class="form-select">
                                    <option value="1">Aprobar</option>
                                    <option value="2">Rechazar</option>
                                </select>                                

                                <button class="btn btn-secondary" type="submit" onclick="return confirm('Are you sure?')">
                                    Enviar respuesta
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </article>