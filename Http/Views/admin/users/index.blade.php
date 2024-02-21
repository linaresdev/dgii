@extends("dgii::admin.users.layout")
    
    @section("content")
    <article class="card border-0">
        <section class="card-body">
            <h5 class="fs-4 mt-3">
                <span class="mdi mdi-account"></span>
                {{__('words.users')}}
            </h5>

            <article class="row my-3">
                <div class="col-7">
                    <a href="{{__url('{users}/new')}}" class="btn btn-outline-primary btn-sm rounded-pill px-3">
                        <span class="mdi mdi-plus-thick"></span>
                        {{__('words.new')}}
                    </a>
                </div>
                <div class="col-5">
                    <input type="text"
                        name="src"
                        value="{{old('src')}}"
                        class="form-control"
                        placeholder="{{__('words.filters')}}...">
                </div>
            </article>

            <article class="table-responsive-md">
                <table class="table table-striped table-borderless table-hover align-middle">
                    <thead>
                        <tr>
                            <th>{{__("words.name")}}</th>
                            <th class="text-center">{{__("account.type")}}</th>
                            <th class="text-center">{{__("words.state")}}</th>
                            <th class="text-end">{{__("words.actions")}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td class="py-1">{{$user->fullname}}</td>
                            <td class="text-center py-1">
                                {{ucwords($user->type)}}
                            </td>
                            <td class="text-center py-1">
                                <div class="dropdown">
                                    <a href="#" class="btn btn-light rounded-pill btn-sm btn-dropdown dropdown-toggle px-3" 
                                        data-bs-toggle="dropdown"
                                        area-expanded="false">
                                        {{trans_choice("state.$user->activated", 1)}}
                                    </a>
                                    <div class="dropdown-menu">
                                        @for( $i=0; $i <= 4; $i++)
                                        @if( $user->activated == $i)
                                        <span class="dropdown-item active">
                                            <span class="mdi mdi-checkbox-outline"></span>
                                            {{trans_choice("state.$i", 1)}}
                                        </span>
                                        @else
                                        <a href="#" 
                                            class="dropdown-item">
                                            <span class="mdi mdi-checkbox-blank-outline"></span>
                                            {{trans_choice("state.$i", 2)}}
                                        </a>
                                        @endif
                                        @endfor
                                    </div>
                                </div>
                            </td>
                            <td class="text-end py-1">
                                <div class="dropdown dropstart">
                                    <a href="#" class="btn btn-dropdown dropdown-toggle p-0" 
                                        data-bs-toggle="dropdown"
                                        area-expanded="false">
                                        <span class="mdi mdi-progress-wrench"></span>
                                    </a>
                                    <div class="dropdown-menu">
                                        <h6 class="dropdown-header">{{$user->fullname}}</h6>
                                        <a href="#" 
                                            class="dropdown-item ms-3">
                                            {{__("update.credentials")}}
                                        </a>

                                        <a href="#" 
                                            class="dropdown-item ms-3">
                                            {{__("update.password")}}
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </article>
        </section>
    </article>
    @endsection