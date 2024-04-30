
		<div class="text-white">
			@foreach($users as $user)
			<div class="border-top p-1">
				{{$user->fullname}}
				<div>
					<form action="{{__url($uri)}}" method="POST">
						
						<div class="d-flex" style="font-size:.8em">
							<div class="form-check me-2">
								<input class="form-check-input" 
							  		type="checkbox" 
							  		name="view" 
							  		value="1" 
							  		id="view">
								<label class="form-check-label" for="view">
									{{__("words.view")}}
								</label>
							</div>

							<div class="form-check me-2">
								<input class="form-check-input" 
							  		type="checkbox"
							  		name="insert" 
							  		value="1" 
							  		id="insert">
								<label class="form-check-label" for="insert">
									{{__("words.insert")}}
								</label>
							</div>

							<div class="form-check me-2">
								<input class="form-check-input" 
							  		type="checkbox"
							  		name="update" 
							  		value="1" 
							  		id="edit">
								<label class="form-check-label" for="edit">
									{{__("words.edit")}}
								</label>
							</div>

							<div class="form-check">
								<input class="form-check-input" 
							  		type="checkbox"
							  		name="delete" 
							  		value="1" 
							  		id="delete">
								<label class="form-check-label" for="delete">
									{{__("words.delete")}}
								</label>
							</div>
						</div>

						<div class="">
							<input type="hidden" name="termID" value="{{$termID}}">
							<input type="hidden" name="ID" value="{{$user->id}}">
							@csrf
							<button type="submit" class="btn btn-outline-light btn-sm rounded-pill px-3 py-0">
								Agregar
							</button>
						</div>
					
					</form>
				</div>
			</div>
			@endforeach
		</div>