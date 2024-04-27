@extends("dgii::admin.users.layout")
    
    @section("content")

    <article class="card border-0">
        <section class="card-body">
            <h4 class="fs-4 my-3">
                {{ $user->fullname }}
            </h4>

            <article class="">

                <form action="{{__url('{current}')}}" method="POST">

                    @if( $errors->any() )
                    <div class="mb-3 px-4 py-3 bg-light rounded-1">
                        @foreach($errors->all() as $error )
                        <p class="m-0 text-danger">{{$error}}</p>
                        @endforeach
                    </div>
                    @endif

                    @csrf
                    <div class="form-floating mb-2">
                        <input type="password"
                            name="password"
                            value="{{old('password')}}"
                            id="password" 
                            class="form-control"
                            placeholder="{{__('words.password')}}">
                        <label for="firstname">{{__('words.password')}}</label>
                    </div>

                    <div class="py-3">
                        <a href="{{__url('admin/users')}}" 
                            class="btn btn-light btn-sm rounded-pill px-3">
                            <span class="mdi mdi-close"></span>
                            {{__("words.close")}}
                        </a>

                        <button type="submit" 
                            class="btn btn-outline-primary btn-sm rounded-pill px-3">
                            
                            <mdi class="mdi mdi-content-save"></mdi>
                            {{__("words.save")}}
                        </button>
                    </div>
                </form>
            </article>
        </section>
    </article>
    @endsection