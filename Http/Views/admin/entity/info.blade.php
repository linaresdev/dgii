@extends("dgii::admin.entity.layout")
	
	@section("content")
		<article class="p-3 mb-2 mt-4 bg-white rounded-1">
			<hgroup class="py-3">
				<h4 style="font-size: 1.3rem;" class="text-dark">
					{{$ecf->razonSocialEmisor()}}
				</h4>
				<h6 style="font-size: 1rem;" class="text-secondary">
					{{$ecf->eNCF}}
				</h6>
			</hgroup>

			<section class="">
				<hgroup class="mb-3">
					<h4 style="font-size: .9rem;">
						Sr (s): {{$ecf->razonSocialComprador()}}
					</h4>
				</hgroup>
			</section>

			<section>

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
					<strong style="width:200px;" class="bg-light px-1 pt-2 text-end">
						Sub Total :
					</strong> 
					<span style="width:100px;" class="bg-light px-1 pt-2">
						{{$data->get("MontoGravadoTotal")}}
					</span>
				</div>
				<div class="d-flex justify-content-end">
					<strong style="width:200px;" class="bg-light px-1 text-end">
						+ Itbs :
					</strong> 
					<span style="width:100px;" class="bg-light px-1">
						{{$data->get("TotalITBIS")}}
					</span>
				</div>
				<div class="d-flex justify-content-end">
					<strong style="width:200px;" class="bg-light px-1 text-end">
						Inpuesto adicional :
					</strong> 
					<span style="width:100px;" class="bg-light px-1">
						{{$data->get("MontoImpuestoAdicional")}}
					</span>
				</div>
				<div class="d-flex justify-content-end">
					<strong style="width:200px;" class="bg-light px-1 pb-2 text-end">
						Total :
					</strong> 
					<span style="width:100px;" class="bg-light px-1 pb-2">
						{{$data->get("MontoTotal")}}
					</span>
				</div>
			</section>
			
		</article>

		<article class="p-3">
			
			<a href="{{__url('{ecf}')}}" 
				class="btn btn-primary btn-sm rounded-pill px-3">
				<span class="mdi mdi-reply"></span>
				Regresar	
			</a>
			
			<a href="{{__url('{ecf}/download/'.$ecf->id)}}" 
				class="btn btn-success btn-sm rounded-pill px-3">
				<span class="mdi mdi-download mdi-20px"></span>
				{{__("download.xml")}}
			</a>
		</article>
	@endsection