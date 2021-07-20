                    @if ($errors->any())
					    <div class="row ml-2">
		                    <div class="alert alert-danger col-sm-6">
		                    @foreach ($errors->all() as $error)
		                        <div>
			                        {{$error}}
			                    </div>
			                 @endforeach
		                    </div>
	                    </div>
	                @endif
	                @if ($message = Session::get('success'))
	                    <div class="row">
		                    <div class="alert alert-success col-sm-6">
		                        <strong> {{$message}} </strong> 
		                    </div>
	                    </div>
                    @endif 