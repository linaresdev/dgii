
		<div class="text-white">
			@foreach($users as $user)
			<div class="border-top p-1">
				{{$user->fullname}}
				<div>
					<form action="#">

						<div class="">
							Permisos
						</div>

						<button class="btn btn-outline-light btn-sm rounded-pill px-3 py-0">
							Agregar
						</button>
					
					</form>
				</div>
			</div>
			@endforeach
		</div>