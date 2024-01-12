                
                @if( $errors->any() )
                @if(session()->has("type"))
                <div class="mb-1 ms-2 border-start border-3 border-{{session('type')}} ps-2 py-2 my-2">
                    @foreach($errors->all() as $error)
                    <p class="m-0 text-{{session('type')}} fs-6">{{$error}}</p>
                    @endforeach
                </div>
                @else
                <div class="mb-1 ms-2 border-start border-3 border-danger ps-2 py-2 my-2">
                    @foreach($errors->all() as $error)
                    <p class="m-0 text-danger fs-6">{{$error}}</p>
                    @endforeach
                </div>
                @endif
                @endif