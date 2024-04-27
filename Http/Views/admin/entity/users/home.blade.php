@extends("dgii::admin.entity.layout")

    @section("content")          

        <article class="d-flex">
        	<nav class="bg-secondary p-3 rounded-start-2" style="min-width: 300px;">
        		<h4 class="text-white mb-3"> 
        			<span class="mdi mdi-account"></span>
        			{{__("words.users")}}
        		</h4>

        		<div class="form-floating mb-3">
        			<input type="text" 
        				name="src"
        				onkeyup="sourceUser(this)" 
        				id="src"
        				placeholder="{{__('users.search')}}" 
        				class="form-control">
        			<label for="src">{{__("users.search")}}</label>
        		</div>

        		<div class="resultado">
        			
        		</div>

        	</nav>
        	<section class="bg-white flex-fill py-3 rounded-end-2">

        		<h4 class="px-3">
        			<mdi class="mdi mdi-account-group"></mdi>
        			{{__("users.group")}}
        		</h4>
        		
        		<table class="table align-middle table-hover">
        			<thead>
        				<tr>
        					<th class="px-2">Nombre</th>
        					<th class="px-2 text-end">Acciones</th>
        				</tr>
        			</thead>
        			<tbody>
        				@foreach($term->users as $user )
        				<tr>
        					<td class="p-1 px-2">{{$user->name}}</td>
        					<td class="p-1 px-2 text-end">
        						<a href="#" class="btn btn-light btn-sm rounded-pill px-3">
        							Remover
        						</a>
        					</td>
        				</tr>
        				@endforeach
        			</tbody>
        		</table>
        	</section>
        </article>
    @endsection

    @section("js")
    	@parent <script type="text/javascript">
    		
    		function sourceUser(src) {
    			let value 	= src.value,
    				uri 	= "{{$urlAjax}}/"+value;
    				
    			if( value.length > 2 ) {    				
    				jQuery.get(uri, function(data){
    					jQuery(".resultado").html(data);
    				});
    			}
    			else {
    				if(value.length == 0 )
    				{
    					jQuery(".resultado").html("");
    				}
    				else{
    					jQuery(".resultado").html("Buscando resultados");
    				}
    			}
    		}
    	</script>
    @endsection