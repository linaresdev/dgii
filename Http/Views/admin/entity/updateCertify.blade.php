@extends("dgii::admin.entity.layout")
    @section("content")

    <article class="card border-0">
        <div class="card-body"> 

            <h5 class="card-title">
                <span class="mdi mdi-file-certificate-outline"></span> 
                {{__('business.update.certify')}}
            </h5>
            
            {!! Alert::form("update") !!}

            <form action="{{__url('{current}')}}"
                enctype="multipart/form-data" 
                class="card border-0 mt-3" 
                method="POST">
                
                <div class="form-floating mb-3">
                    <input type="file"
                        name="certify"
                        value="{{old('certify')}}"
                        id="businessCertifi" 
                        class="form-control"
                        placeholder="{{__('business.certify')}}">
                    <label for="businessCertify">{{__('business.certify')}}</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="password"
                        name="pwd"
                        value="{{old('pwd')}}"
                        id="businessPassword" 
                        class="form-control"
                        placeholder="{{__('words.password')}}">
                    <label for="businessCertify">{{__('words.password')}}</label>
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