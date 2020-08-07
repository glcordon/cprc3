<!DOCTYPE html>
<html>
<head>
	<title>Report</title>
	<style>
		body {text-align: center;}
		.col-2{margin:10px 0;}
		.row{margin:20px 0; padding: 5px;}
	</style>
	<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<!-- Popper JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</head>
<body>
	<div class="container">
	<div class="row" style="text-align:center; border-bottom:2px solid #005b96;">
		<div class="col-4">
			<img src="https://www2.ncdps.gov/imgs/dps_logo_rgb_secondary1.25inWhtMarg-100dpi.png" alt="dps_logo">
		</div>
		<div class="col-8" style="text-align:center;">
			<h1>North Carolina Local Reentry Council</h1>
			<h2>Participation Roster</h2>
		</div>
	</div>
	<div class="row" style="padding:10px; line-height:30px">
			<div class="col-3">Intermediary Agency:</div>
			<div class="col-3" style="border:1px solid black;">CRAVEN PAMLICO</div>
			<div class="col-3">Reporting Month/Year:</div>
			<div class="col-3"> {{ $thisDate->month }}/{{ $thisDate->year }}</div>
	</div>
	
	<table class="table table-striped">
        <thead style="background-color:#800020; color:white;">
            <tr>
                <th>First Name</th>
                <th>Middle Name</th>
                <th>Last Name</th>
                <th>OPUS/ID Number</th>
                <th>Risk Level</th>
                <th>Enrollment Date</th>
                <th>Dismissal Date</th>
                <tbody>
                    @foreach($clients as $client)
                    <tr>
                        <td>{{ $client->first_name }}</td>
                        <td></td>
                        <td>{{ $client->last_name }}</td>
                        <td>{{ $client->ncdps_id }}</td>
                        <td>{{ $client->risk_level }}</td>
                        <td>{{ $client->enrollment_date }}</td>
                        <td>{{ $client->status!=='active'?$client->updated_at:'' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </tr>
        </thead>
    </table>
</body>
</html>
