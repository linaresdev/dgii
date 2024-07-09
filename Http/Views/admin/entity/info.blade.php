@extends("dgii::admin.entity.layout")
	
	@section("content")
		<article class="p-3 mb-3 bg-white rounded-1">
			<hgroup class="py-3">
				<h4 style="font-size: 1.3rem;" class="text-dark">
					{{$ecf->razonSocialComprador()}}
				</h4>
				<h6 style="font-size: 1rem;" class="text-secondary">
					{{$ecf->eNCF}}
				</h6>
			</hgroup>

			<table class="table table-borderless align-middle">
				<thead>
					<tr>
						<th class="bg-light text-center">Cantidad</th>
						<th class="bg-light">Nombre</th>
						<th class="bg-light">Descripcion</th>
						<th class="bg-light text-center">Precio/U</th>
						<th class="bg-light text-center">Total</th>
					</tr>
				</thead>
				<tbody>
					@foreach( $items as $item )
					<tr>
						<td class="text-center">
							{{$item->CantidadItem}}
						</td>
						<td>{{$item->NombreItem}}</td>
						<td>{{$item->DescripcionItem}}</td>
						<td class="text-center">{{$item->PrecioUnitarioItem}}</td>
						<td class="text-center">{{$item->MontoItem}}</td>
					</tr>
					@endforeach
				</tbody>
			</table>


			<div class="d-flex justify-content-end">
				<strong style="width:100px;" class="bg-light px-1 pt-2 text-end">
					Sub Total :
				</strong> 
				<span style="width:100px;" class="bg-light px-1 pt-2">
					{{$data->get("MontoGravadoTotal")}}
				</span>
			</div>
			<div class="d-flex justify-content-end">
				<strong style="width:100px;" class="bg-light px-1 text-end">
					+ Itbs :
				</strong> 
				<span style="width:100px;" class="bg-light px-1">
					{{$data->get("TotalITBIS")}}
				</span>
			</div>
			<div class="d-flex justify-content-end">
				<strong style="width:100px;" class="bg-light px-1 pb-2 text-end">
					Total :
				</strong> 
				<span style="width:100px;" class="bg-light px-1 pb-2">
					{{$data->get("MontoTotal")}}
				</span>
			</div>
			
		</article>

		<article class="p-3">
			
			<a href="{{__url('{ecf}')}}" 
				class="btn btn-outline-primary btn-sm rounded-pill px-3">
				<span class="mdi mdi-reply"></span>
				Regresar	
			</a>
			
		</article>
	@endsection