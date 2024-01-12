@extends("dgii::admin.entity.layout")
    @section("content")
    
        <form action="{{__url('{current}')}}"
            enctype="multipart/form-data" 
            class="card border-0 mt-3" 
            method="POST">
            
            <div class="card-body pt-4">                   

                <h5 class="card-title">
                    {{__("business.register")}}
                </h5>  
                
                {!! Alert::form("register") !!}

                <div class="mb-3 ms-2">
                    <div class="form-floating">
                        <input type="text"
                            name="name"
                            value="{{old('name')}}"
                            id="name" 
                            class="form-control"
                            placeholder="{{__('business.name')}}">
                        <label for="name">{{__('business.name')}}</label>
                    </div>
                </div>

                <div class="mb-3 ms-2">
                    <div class="form-floating">
                        <input type="file"
                            name="certify"
                            value="{{old('certify')}}"
                            id="businessCertifi" 
                            class="form-control"
                            placeholder="{{__('business.certify')}}">
                        <label for="businessCertify">{{__('business.certify')}}</label>
                    </div>
                </div>

                <div class="mb-3 ms-2">
                    <div class="form-floating">
                        <input type="password"
                            name="pwd"
                            value="{{old('pwd')}}"
                            id="businessPassword" 
                            class="form-control"
                            placeholder="{{__('words.password')}}">
                        <label for="businessCertify">{{__('words.password')}}</label>
                    </div>
                </div>

                <div class="bm-3">
                    @csrf 
                    <button type="submit" class="btn btn-sm btn-primary">
                        <span class="mdi mdi-content-save"></span> Registrar
                    </button>
                    <a href="{{__url('admin/entities')}}" class="btn btn-outline-danger btn-sm">
                        <span class="mdi mdi-close"></span> {{__("words.close")}}
                    </a>
                </div>
            </div>
        </form>
    @endsection