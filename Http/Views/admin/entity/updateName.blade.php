@extends("dgii::admin.entity.layout")
    @section("content")

    <article class="card border-0">
        <div class="card-body">  
            <h5 class="card-title">{{__('business.update.name')}}</h5>
            
            {!! Alert::form("update") !!}

            <form action="{{__url('{current}')}}" method="POST">
                <div class="form-floating mb-3">
                    <input type="text"
                            name="name"
                            value="{{old('name', $entity->name)}}"
                            id="name"
                            class="form-control"
                            placeholder="{{__('words.name')}}">
                    <label for="name">{{__('words.name')}}</label>
                </div>
                <div class="">
                    @csrf
                    <button type="submit" class="btn btn-outline-primary rounded-pill px-3">
                        <span class="mdi mdi-reload"></span>
                        {{__("words.update")}}
                    </button>

                    <a href="{{__url('admin/entities/')}}" class="btn btn-light rounded-pill px-3">
                        <span class="mdi mdi-close-thick"></span>    
                        {{__("words.close")}}
                    </a>
                </div>
            </form>
        </div>
    </article>
    @endsection