
            <section class="mb-3 shadow-sm bg-white rounded-1 p-0">
                <article class="d-flex align-items-center border border-light-subtle rounded-1">
                    <div class="py-1 px-3">
                    <div class="dropdown dropend  nopointer">
                            <button class="btn link-dark dropdown-toggle p-0" 
                                type="button" 
                                data-bs-toggle="dropdown" 
                                aria-expanded="false">
                                <span class="mdi mdi-view-comfy mdi-20px"></span>
                            </button>
                            <div class="dropdown-menu bg-light-subtle border-secondary">
                               <h6 class="dropdown-header">
                                    {{__("ecf.lists")}}:
                               </h6>
                            </div>
                        </div>                        
                    </div>

                    <div class="flex-grow-1 py-0 px-0 border-start border-end">
                        <input type="text" 
                            name="src" 
                            class="form-control form-control-lg border-0 rounded-0"
                            placeholder="{{__('words.search')}}...">
                    </div>

                    <div class="py-1 px-3">
                        <div class="dropdown dropstart nopointer">
                            <button class="btn link-dark dropdown-toggle p-0" 
                                type="button" 
                                data-bs-toggle="dropdown" 
                                aria-expanded="false">
                                <span class="mdi mdi-filter mdi-20px"></span>
                            </button>
                            <div class="dropdown-menu bg-light-subtle border-secondary">
                                <h6 class="dropdown-header">
                                    {{__("ecf.filters.by")}}:
                               </h6>
                                <a href="{{__url('{current}/config/set/ecf-filter-by/RNC')}}" class="dropdown-item">
                                    @if( $isFilter("RNC") )
                                    <i class="mdi mdi-checkbox-intermediate mdi-20px"></i>
                                    @else
                                    <i class="mdi mdi-checkbox-blank-outline mdi-20px"></i>
                                    @endif
                                    RNC
                                </a>
                                <a href="{{__url('{current}/config/set/ecf-filter-by/eNCF')}}" class="dropdown-item">
                                    @if( $isFilter("eNCF") )
                                    <i class="mdi mdi-checkbox-intermediate mdi-20px"></i>
                                    @else
                                    <i class="mdi mdi-checkbox-blank-outline mdi-20px"></i>
                                    @endif
                                    eNCF
                                </a>
                                <a href="{{__url('{current}/config/set/ecf-filter-by/date')}}" class="dropdown-item">
                                    @if( $isFilter("date") )
                                    <i class="mdi mdi-checkbox-intermediate mdi-20px"></i>
                                    @else
                                    <i class="mdi mdi-checkbox-blank-outline mdi-20px"></i>
                                    @endif
                                    {{__("words.date")}}
                                </a>
                            </div>
                        </div>
                    </div>
                </article>
                
            </section>

            <section class="mb-3 d-flex aling-items-center p-0">           

                <div class="me-3">
                    {{__("words.to-lists")}}: 
                    <span class="badge text-secondary">{{__("words.".$getConfig("ecf.lists.by"))}}</span>
                </div>
                <div class="me-3">
                    {{__("ecf.filters.by")}}: 
                    <span class="badge text-secondary">{{__("words.".$getConfig("ecf.filter.by"))}}</span>
                </div>

                <div>
                    # {{__("words.registers")}}: <span class="badge text-secondary"> 0 </span>
                </div>
                
            </section>