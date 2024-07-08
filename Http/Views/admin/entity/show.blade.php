@extends("dgii::admin.entity.layout")

@section("content")

    <article class="py-2 mb-3">

        <ul class="nav nav-tabs nav-tabs-simple">
            <li class="nav-item">
                <a href="{{__url('{entity}/show/'.$entity->id)}}" class="nav-link active">
                    <span class="mdi mdi-home"></span> {{__("words.home")}}
                </a>
            </li>
            <li class="nav-item">
                <a href="{{__url('{entity}/show/'.$entity->id."/ecf")}}" class="nav-link">ECF</a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">ARECF</a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">RFCE</a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">ACECF</a>
            </li>
        </ul>
    </article>   

    

    
    <article class="card border-0">
        <div class="card-body">
            <h5 class="card-title">
                Ambiente de trabajo
            </h5>

            {!! Alert::listen("env", "dgii::alerts.simple") !!}

            <div>
                <form action="{{__url('{entity}/show/'.$entity->id.'/set-env')}}"
                    method="POST">
                    @csrf

                    <div class="input-group">
                        <label class="input-group-text" for="env">
                            <span class="badge text-bg-light">
                                {{env("DGII_ENV")}} - {{__("entity.".env("DGII_ENV"))}}
                            </span>
                        </label>
                        <select name="env" id="env" class="form-control">
                            <option value="testecf">{{__("entity.testecf")}}</option>
                            <option value="certecf">{{__("entity.certecf")}}</option>
                            <option value="ecf">{{__("entity.ecf")}}</option>
                        </select>
                        <button class="btn btn-outline-secondary" type="submit">
                           <span class="mdi mdi-reload"></span> 
                           {{__("words.update")}}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </article>
        
    </article>
    
    
@endsection