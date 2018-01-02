<body>
	<p>Course has been booked:</p><br /><br />
	<p>Course Details:</p>
	<p>Course Name: {{ $course->name }}</p><br /><br />
	<p>User Details:</p><br />
	<p>Name: {{ $name }}</p>
	<p>Email: {{ $email }}</p>
	<p>Phone: {{ $phone }}</p>
	<br />
	<p>Preferrend Contact: {{ ucfirst($phone) }}</p>
	<p>Years Driving for Uber: {{ $drivinguber }}</p>
	<p>Current Rating for Uber: {{ $drivingrating }}</p>
</body>