@extends("dgii::admin.layout.master")

    @section("body")  
    
        <article class="container">
            <section class="col-lg-6 offset-lg-3 col-sm-10 offset-sm-1">
                <div class="card">
                    <form class="card-body" method="POST">
                        <h5 class="card-title">Login</h5>
                        <div class="mb-2">
                            <div class="form-floating">
                                <input type="file"
                                    name="certify"
                                    value="{{old('certify')}}"
                                    id="userInput" 
                                    class="form-control"
                                    placeholder="{{__('auth.certify')}}">
                                <label for="userInput">{{__("auth.certify")}}</label>
                            </div>
                        </div>
                        <div class="mb-2">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-light rounded-pill">
                                <span class="mdi mdi-login"></span>
                                {{__("words.auth")}}
                            </button>

                            <a href="{{__url('login')}}" class="btn btn-sm btn-light rounded-pill px-3">
                                <span class="mdi mdi-login"></span>
                                {{__("form.login")}}
                            </a>
                        </div>
                    </form>
                </div>
            </section>
        </article>
    @endsection