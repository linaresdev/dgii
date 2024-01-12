@extends("dgii::admin.entity.layout")

    @section("content")
        <div class="py-2 mb-3">
            <a href="{{__url('{entity}/register')}}" 
                class="btn btn-sm btn-outline-primary rounded-pill px-3">
                <span class="mdi mdi-plus-thick"></span> Nuevo
            </a>
        </div>   

        {!! Alert::listen("system", "dgii::alerts.simple") !!}

        <div class="card border-0">
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-lg-4 offset-lg-8">
                        <input type="text" 
                            class="form-control"
                            placeholder="{{__('words.search')}}...">
                    </div>
                </div>
                
                <div class="table-responsive-md">
                    <table class="table table-striped table-borderless table-hover align-middle">
                        <thead>
                            <tr>
                                <th>{!! __("business.name") !!}</th>
                                <th class="text-center">{{__("words.state")}}</th>
                                <th class="text-end">{{__("words.actions")}}</th>
                            </tr>
                        </thead>
                        <tbody> 
                            @foreach($entities as $entity)
                            <tr>
                                <td>{{$entity->name}}</td>
                                <td class="text-center"> 
                                    <div class="dropdown">
                                        <a href="#" class="btn btn-light rounded-pill btn-sm btn-dropdown dropdown-toggle px-3" 
                                            data-bs-toggle="dropdown"
                                            area-expanded="false">
                                            {{trans_choice("state.$entity->activated", 1)}}
                                        </a>
                                        <div class="dropdown-menu">
                                            @for( $i=0; $i <= 4; $i++)
                                            @if( $entity->activated == $i)
                                            <span class="dropdown-item active">
                                                <span class="mdi mdi-checkbox-outline"></span>
                                                {{trans_choice("state.$i", 1)}}
                                            </span>
                                            @else
                                            <a href="{{__url('{entity}/'.$entity->id.'/set-state/'.$i)}}" 
                                                class="dropdown-item">
                                                <span class="mdi mdi-checkbox-blank-outline"></span>
                                                {{trans_choice("state.$i", 2)}}
                                            </a>
                                            @endif
                                            @endfor
                                        </div>
                                    </div>
                                </td>
                                <td class="text-end py-0">
                                    
                                    <div class="dropdown dropstart">
                                        <a href="#" class="btn btn-dropdown dropdown-toggle p-0" 
                                            data-bs-toggle="dropdown"
                                            area-expanded="false">
                                            <span class="mdi mdi-progress-wrench"></span>
                                        </a>
                                        <div class="dropdown-menu">
                                            <h6 class="dropdown-header">Mantenimiento</h6>
                                            <a href="{{__url('{entity}/'.$entity->id.'/update')}}" 
                                                class="dropdown-item">
                                                {{__("business.update.name")}}
                                            </a>

                                            <a href="{{__url('{entity}/'.$entity->id.'/delete')}}" 
                                                class="dropdown-item">
                                                {{__("business.delete.title")}}
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>   
                </div>
            </div>
        </div>
    @endsection