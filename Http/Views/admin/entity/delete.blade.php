@extends("dgii::admin.entity.layout")

    @section("content")
        <article class="card border-0 mt-3">
            <section class="card-body">
                <h5 class="card-title mt-2">
                    {{__("business.delete.title")}}
                </h5>
                <p>{{__("business.delete.info")}}</p>
                <ol>
                    @foreach(__("business.delete.driving") as $row)
                    <li>{{$row}}.</li>
                    @endforeach
                </ol>

                <form action="{{__url('{current}')}}"
                    method="POST" 
                    class="border border-danger rounded p-4">

                    @if( $errors->any() )
                    <div class="mb-1 ms-2 border-start border-3 border-danger ps-2 py-2 mb-3">
                        @foreach($errors->all() as $error)
                        <p class="m-0 text-danger fs-6">{{$error}}</p>
                        @endforeach
                    </div>
                    @endif

                    @csrf

                    <input type="text"
                            name="name" 
                            class="form-control form-control-lg mb-3 " 
                            placeholder="{{__('entity.name')}}">
                    

                    <div class="form-check mb-3">
                        <input type="checkbox" 
                            name="delegate" 
                            value="false" id="delegate" 
                            @if(!empty(old('delegate'))) checked @ese unchecked @endif
                            class="form-check-input">
                        <label for="delegate" class="form-check-label">
                            {{__("business.delete.delegate")}}.
                        </label>
                    </div>

                    <button type="submit" class="btn btn-danger">
                        <span class="mdi mdi-delete"></span>
                        {{__("words.delete")}}
                    </button>
                    <a href="{{__url('admin/entities')}}" class="btn btn-light">
                        <span class="mdi mdi-close-thick"></span>
                        {{__("words.close")}}
                    </a>
                </form>
            </section>
        </article>
    @endsection