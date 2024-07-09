@extends("dgii::admin.entity.layout")
	
	@section("content")

		<article class="p-3 mb-3 bg-white rounded-1">

			<h4 class="fs-5 pt-3">{{__("words.recf")}}</h4>
			<article>
				# de registros: {{$arecf->total()}}
			</article>

			<div class="responsive-table">
				<table class="table table-hover align-middle">
					<thead>
						<tr>
							<th>eNCF</th>
							<th>{{__("trade.name")}}</th>
							<th class="text-center">{{__("date.isue")}}</th>
							<th class="text-end">{{__("words.actions")}}</th>
						</tr>
					</thead>
					<tbody>
						@foreach($arecf as $row)
						<tr>
							<td class="">{{$row->eNCF}}</td>
							<td>{{$row->razonSocialComprador()}}</td>
							<td class="text-center">
								{{$row->fechaEmision()}}
							</td>
							<td class="text-end py-0"> 
								<div class="dropdown dropstart">
									<button class="btn dropdown-toggle p-0" 
										data-bs-toggle="dropdown"
										aria-expanded="false">
										<span class="mdi mdi-progress-wrench"></span>
									</button>
									<div class="dropdown-menu">
										<a href="{{__url('{ecf}/info/'.$row->id)}}" class="dropdown-item">
											<span class="mdi mdi-text-short mdi-20px"></span>
											{{__("words.information")}}
										</a>
										<a href="{{__url('{ecf}/download/'.$row->id)}}" class="dropdown-item">
											<span class="mdi mdi-download mdi-20px"></span>
											{{__("download.xml")}}
										</a>
									</div>
								</div>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>

			<div class="">
				{{$arecf->links()}}
			</div>

		</article>
	@endsection