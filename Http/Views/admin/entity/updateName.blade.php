@extends("dgii::admin.entity.layout")
    @section("content")

    <div class="mb-3">
        
    </div>

    <article class="card border-0">
        <div class="card-body">  
            <h5 class="card-title">{{__('business.update.name')}}</h5>
            
            @if( $errors->any() )
            <div class="mb-1 ms-2 border-start border-3 border-danger ps-2 py-2 my-2">
                @foreach($errors->all() as $error)
                <p class="m-0 text-danger fs-6">{{$error}}</p>
                @endforeach
            </div>
            @endif

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