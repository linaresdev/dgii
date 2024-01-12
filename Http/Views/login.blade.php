@extends("dgii::admin.layout.master")

    @section("body")  
    
        <article class="container">
            <section class="col-lg-6 offset-lg-3 col-sm-10 offset-sm-1">
                <div class="card">
                    <form class="card-body" method="POST">
                        <h5 class="card-title mb-3">
                            <span class="mdi mdi-shield-account"></span>
                            {{__("words.identify")}}
                        </h5>
                        {!! Alert::listen("system") !!}
                        {!! Alert::form("login") !!}
                        
                        <div class="mb-2">
                            <div class="form-floating">
                                <input type="email"
                                    name="email"
                                    value="{{old('email')}}"
                                    id="userInput" 
                                    class="form-control"
                                    placeholder="{{__('words.email')}}">
                                <label for="userInput">{{__("words.email")}}</label>
                            </div>
                        </div>
                        <div class="mb-2">
                            <div class="form-floating">
                                <input type="password"
                                    name="password"
                                    value="{{old('password')}}"
                                    id="userInput" 
                                    class="form-control"
                                    placeholder="{{__('words.password')}}">
                                <label for="userInput">{{__("words.password")}}</label>
                            </div>
                        </div>
                        <div class="mb-2">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-light border rounded-pill">
                                <span class="mdi mdi-login"></span>
                                {{__("words.login")}}
                            </button>

                            <a href="{{__url('auth')}}" class="btn btn-sm btn-light rounded-pill px-3">
                                <span class="mdi mdi-shield-lock-outline"></span>
                                {{__("entity.access")}}
                            </a>
                        </div>
                    </form>
                </div>
            </section>
        </article>
    @endsection