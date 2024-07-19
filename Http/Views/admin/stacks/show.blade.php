@extends("dgii::admin.stacks.layout")

	@section("content")



		<article class="card border-0 mb-3">
			<div class="card-body">
				<h5 class="card-title py-1">
					{{strtoupper($stack->header)}}
				</h5>

				<div class="responsive-table">
					<table class="table table-bordered aling-middle rounded-top">
						<thead>
							<tr>
								<th class="text-center">ID</th>
								<th class="text-center">IP</th>
								<th class="text-center">Header</th>
								<th class="text-center">PATH</th>
								<th class="text-center">DATE</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td class="text-center">
									{{$stack->id}}
								</td>
								<td class="text-center">
									{{$stack->host}}
								</td>
								<td class="text-center">
									{{$stack->header}}
								</td>			
								<td class="text-center">
									{{$stack->path}}
								</td>
								<td class="text-center">
									{{$stack->created_at}}
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</article>

		<article class="card border-0 mb-3">
			<div class="card-body">

				<h5 class="card-title">META DATA</h5>

				<div class="responsive-table">
					<table class="table table-bordered aling-middle">
						<tbody>
							@foreach($stack->meta as $key => $value)
								<tr>
									<td width="100" class="text-end py-1">
										<strong>
											{{ucwords($key)}}
										</strong>
									</td>
									<td class="py-1">
										{{$value}}
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>

				<div class="py-3">
					<a href="{{__url("admin/stacks")}}" class="btn btn-primary">
						Regresar
					</a>
				</div>
			</div>
		</article>
	@endsection