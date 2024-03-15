@extends("dgii::entities.layout")

    @section("header")

        <section class="mb-3 p-0">
            <h4 class="fx-bold fw-semibold fs-5 m-0 p-0">
                ECECF - {{__("words.acecf")}}
            </h4>
            Envio de la aprobación comercial por correo electrónico
        </section> 
    @endsection

    @section("content")
        
    @if(auth("web")->check())
        
    <article class="bg-white shadow-sm">
        <header class="bg-secondary text-white p-3 rounded-top-1">
            Sendmail
        </header>
        <section class="p-3">
            <form action="{{__url('{current}')}}" method="POST">
                <div class="form-floating mb-2">
                    <input type="text" 
                            name="email" 
                            value="{{old('email')}}"
                            id="floatMail" 
                            class="form-control"
                            placeholder="{{__('words.email')}}">

                    <label for="floatMail">{{__('words.email')}}</label>

                </div>
                <div class="form-floating mb-2">
                    <input type="text" 
                            name="subject" 
                            value="{{old('subject', $subject)}}"
                            id="floatSubject" 
                            class="form-control"
                            placeholder="{{__('words.subject')}}">
                        
                        <label for="floatSubject">{{__('words.subject')}}</label>
                </div>
                <div class="mb-2">
                    @csrf
                    <a href="{{__url('{ent}')}}" class="btn btn-sm bg-danger-subtle link-danger rounded-pill px-3">
                        <span class="mdi mdi-close mdi-20px"></span>
                        {{__('words.close')}}
                    </a>
                    <button class="btn btn-sm bg-success-subtle link-success rounded-pill px-3">
                        <span class="mdi mdi-send mdi-2-px"></span>    
                        {{__("words.send")}}
                    </button>
                </div>

            </form>
        </section>
    </article>
    @endif

    @endsection