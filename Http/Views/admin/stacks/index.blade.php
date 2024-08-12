@extends("dgii::admin.stacks.layout")

	@section("content")

	<article class="card border-0">
		<div class="card-body">
			<h5 class="card-title">Card title</h5>

			<div class="responsive-table">
				<table class="table align-middle">
					<thead>
						<tr>
							<th>ID</th>
							<th>Fecha</th>
							<th>Type</th>
							<th>Host</th>
							<th>Descripcion</th>
							<th>Ruta</th>
							<th class="text-end">Acciones</th>
						</tr>
					</thead>
					<tbody>
						@foreach( $stacks as $stack )
						<tr>
							<td class="py-1">{{$stack->id}}</td>
							<td width="180" class="py-1">
								{{$stack->created_at->diffForHumans()}}
							</td>
							<td width="180" class="py-1">
								{{$stack->type}}
							</td>
							<td class="py-1">{{$stack->host}}</td>
							<td class="py-1">{{$stack->header}}</td>
							<td class="py-1">{{$stack->path}}</td>
							<td class="py-0 text-end">
								<div class="dropdown dropstart">
                                        <a href="#" class="btn btn-dropdown dropdown-toggle p-0" 
                                            data-bs-toggle="dropdown"
                                            area-expanded="false">
                                            <span class="mdi mdi-progress-wrench"></span>
                                        </a>
                                        <div class="dropdown-menu">
                                            <h6 class="dropdown-header">
                                            	{{$stack->header}}
                                            </h6>

                                            <a href="{{__url('admin/stacks/show/'.$stack->id)}}" class="dropdown-item">
                                               <span class="mdi mdi-connection mdi-20px"></span>
                                               Ver meta data
                                            </a>
                                        </div>
                                    </div>
							</td>
						</tr>
						@endforeach
					</tbody>

				</table>
			</div>

			{{$stacks->links()}}
		</div>
	</article>
	@endsection