<html>
	<head>
		<title>Tasks Management</title>
	</head>

	<body>
		<form action="{{ url('tasks') }}" method="post">
			{{ csrf_field() }}
			<input type="text" name="name">
			<textarea name="description"></textarea>
			<input type="submit" value="Create Task">
		</form>

		<h1>Tasks Management</h1>
		<ul>
			@foreach ($tasks as $task)
				Tugas Pertama : {{ $task->name }} <br>
				-{{ $task->description }}
				<br>
			@endforeach
		</ul>
	</body>
</html>