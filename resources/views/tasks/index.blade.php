@extends('layouts.app')

@section('content')
	<h1 class="page-header text-center">Tasks Management</h1>
	<div class="py-4">
		<div class="row">
		    <div class="col-md-4 col-md-offset-2">
		        <h2>Tasks</h2>
		        <ul class="list-group">
		            @foreach ($tasks as $task)
		                <li class="list-group-item">
		                	<form action="{{ url('tasks/'.$task->id) }}" method="post" onsubmit="return confirm('Are You sure to delete this task?')">
		                		{{ csrf_field() }}
		                		{{ method_field('DELETE') }}
		                		<input type="submit" value="X" id="delete_task_{{ $task->id }}" class="btn btn-secondary float-right">
		                	</form>
		                	<a href="{{ url('tasks') }}?action=edit&id={{ $task->id }}"
		                		id="edit_task_{{ $task->id }}" class="btn btn-primary float-right" style="margin-right: 10px">Edit</a>
		                    {{ $task->name }} <br>
		                    {{ $task->description }}
		                </li>
		            @endforeach
		        </ul>
		    </div>
		    <div class="col-md-4">
		        @if (count($errors) > 0)
		            <div class="alert alert-danger">
		                <ul class="list-unstyled">
		                    @foreach ($errors->all() as $error)
		                        <li>{{ $error }}</li>
		                    @endforeach
		                </ul>
		            </div>
		        @endif

		        @if (! is_null($editableTask) && request('action') == 'edit')
		        	<h2>Edit Task</h2>
		    		<form id="edit_task_1" action="{{ url('tasks/1') }}" method="post">
						{{ csrf_field() }} {{ method_field('PATCH') }}
						<div class="form-group">
							<label for="name" class="control-label">Name</label>
							<input type="text" name="name" id="name" class="form-control">
						</div>

						<div class="form-group">
							<label for="description" class="control-label">Description</label>
							<textarea id="description" name="description" class="form-control"></textarea>
						</div>
		    			<input type="submit" value="Update Task" class="btn btn-primary">
		    			<a href="{{ url('tasks') }}" class="float-right btn btn-primary">Cancel</a>
		    		</form>
				@else
					<h2>New Task</h2>
					<form action="{{ url('tasks') }}" method="post">
		            {{ csrf_field() }}
		            <div class="form-group">
		                <label for="name" class="control-label">Name</label>
		                <input id="name" name="name" class="form-control" type="text">
		            </div>
		            <div class="form-group">
		                <label for="description" class="control-label">Description</label>
		                <textarea id="description" name="description" class="form-control"></textarea>
		            </div>
		            <input type="submit" value="Create Task" class="btn btn-primary">
		        </form>
		    	@endif
		    </div>
		</div>
	</div>
@endsection