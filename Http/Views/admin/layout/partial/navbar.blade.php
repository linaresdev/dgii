
<nav class="navbar navbar-lighter navbar-expand-md fixed-top">
        <a href="{{__url('mainURL')}}" class="navbar-brand px-3">
            Delta Domercial
        </a>
        <button class="navbar-toggler" 
                type="button" 
                data-bs-toggle="collapse" 
                data-bs-target="#mainBar" 
                aria-controls="mainBar" 
                aria-expanded="false" 
                aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div id="mainBar" class="collapse navbar-collapse">
            
            @if( auth("web")->check() && is_object(($nav = anonymous(__path("{http}/Support/Menu.php"))))) 
            @if( !empty(($items = $nav->items())))
            <ul class="nav">
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="mdi mdi-cog"></span> Administrar
                    </a>
                    <div class="dropdown-menu">
                        @foreach($items as $item)
                        <a href="{{$item['url']}}" class="dropdown-item">
                            <span class="mdi mdi-{{$item['icon']}}"></span>
                            {{$item["label"]}}
                        </a>
                        @endforeach
                    </div>
                </li>
            </ul>
            @endif
            @endif
            <ul class="nav ms-auto">
                @if(auth("web")->check())                
                <li class="nav-item">
                    <a href="{{__url('logout')}}" 
                        class="nav-link py-1 px-3 bg-success-subtle text-success rounded-pill">
                        <span class="mdi mdi-logout"></span>
                        {{__("words.logout")}}
                    </a>
                </li>
                @else
                <li class="nav-item">
                    <a href="{{__url('login')}}" 
                        class="nav-link bg-light rounded-pill px-3 py-1">
                        <span class="mdi mdi-login"></span>
                        {{__("words.login")}}
                    </a>
                </li>
                @endif
            </ul>
        </div>
    </nav>