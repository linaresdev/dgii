@extends("dgii::admin.layout.master")
    @section("body")
        <article class="container-fluid mb-3">
            <section class="{{$container}}">
                <h4>{!! $icon !!} {!! $title !!}</h4>
                
                <article class="py-2 mb-3">
                    <a href="{{__url('admin/users')}}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                        <span class="mdi mdi-account-circle mdi-20px"></span>
                        {{__("words.users")}}
                    </a>
                    <a href="{{__url('admin/users/groups')}}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                        <span class="mdi mdi-account-supervisor-circle mdi-20px"></span>
                        {{__("words.groups")}}
                    </a>
                </article>

                @yield("content", "Content")
            </section>
        </article>
    @endsection