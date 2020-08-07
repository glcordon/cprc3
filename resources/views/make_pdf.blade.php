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
			<h2>Monthly Progress Report</h2>
			<h3>Due by 15th of each Month</h3>
		</div>
	</div>
	<div class="row" style="padding:10px; line-height:30px">
			<div class="col-3">Intermediary Agency:</div>
			<div class="col-3" style="border:1px solid black;">CRAVEN PAMLICO</div>
			<div class="col-3">Reporting Month/Year:</div>
			<div class="col-3"> {{ $thisDate->month }}/{{ $thisDate->year }}</div>
	</div>
	
	<div class="row" style="background-color:#005b96; color:white; marign:0">
		<div class="col-12">Activity Summary</div>
	
	<div class="col-12" style="background-color:#b3cde0;margin:0; color:black">
		Please enter the number of reentry clients for each category during the reporting period.
	</div>
	</div>
	<div class="row">
		<div class="col-4">
				Number of reentry clients:
		</div>
		<div class="col-8">

		</div>
	</div>
		<div class="row" style="background-color:#b3cde0; color:black">
			<div class="col-3">Enrolled:</div>
			<div  style="border:1px solid black;" class="col-3">{{ count($all) }}</div>
			<div class="col-3">Active</div>
			<div style="border:1px solid black" class="col-3">{{ $totalActive }}</div>
		</div>
		
			<div class="row">
				<div class="col-4">
						Number of clients that received supportive services:
				</div>
				<div class="col-8">
		
				</div>
			</div>
					@foreach($service->sortBy('service_name')->chunk(3) as $chunk)
						<div class="row" style="background-color:#b3cde0;">
						@foreach($chunk as $serv)
							<div class="col-2" style="text-align:right">{{ $serv->service_name }}</div>
							<div style="border:1px solid black"  class="col-2">{{ $serviceCount[$serv->service_name] ?? '0' }}</div>
						@endforeach
						</div>
					@endforeach
					<div class="row">
						<div class="col-4">
								Supportive Services Detail:
						</div>
						<div class="col-8">
				
						</div>
					</div>
					<div class="row">
						<div class="col-4">
								Employment: Hourly Wage Ranges
						</div>
						<div class="col-8">
				
						</div>
					</div>
					<div class="row" style="background-color:#b3cde0; color:black">
						<div class="col-2" style="text-align:right">
							Min Wage
						</div>
						<div class="col-1" style="border:1px solid black;padding-top:9px">
							{{ $jobCount['min'] ?? 0 }}
						</div>
						<div class="col-2" style="text-align:right">
							Min Wage - $8.00
						</div>
						<div class="col-1" style="border:1px solid black;padding-top:9px">
							{{ $jobCount['minTo8'] ?? 0 }}
						</div>
						<div class="col-2" style="text-align:right">
							$9.01 - $10.00 
						</div>
						<div class="col-1" style="border:1px solid black;padding-top:9px">
							{{ $jobCount['minTo10'] ?? 0 }}
						</div>
						<div class="col-2" style="text-align:right">
							$10.00+
						</div>
						<div class="col-1" style="border:1px solid black;padding-top:9px">
							{{ $jobCount['over10'] ?? 0 }}
						</div>
					</div>
					<div class="row">
						Housing: Type
					</div>
					<div class="row" style="background-color:#b3cde0; color:black">

						@foreach($service->sortBy('service_name') as $serv)
							@if(strpos($serv->service_name,'Housing') === 0)
								<div class="col-2" style="text-align:right">{{ $serv->service_name }}</div>
								<div style="border:1px solid black"  class="col-2">{{ $serv->client()->count() }}</div>
							@endif
						
					@endforeach
					</div>
					<div class="row">
						Number of Client Dismissals:
					</div>
					<div class="row">
						<div class="col-3 text-right">Successfully Completed</div><div class="col-1" style="border:1px solid black">
							{{ $inactiveCount['Successfully Completed'] ?? '0' }}
						</div>
						<div class="col-3 text-right">Non-compliant</div><div class="col-1" style="border:1px solid black">
								{{ $inactiveCount['Non-compliant'] ?? '0' }}
						</div>
						<div class="col-3 text-right">Moved Away</div><div class="col-1" style="border:1px solid black">
								{{ $inactiveCount['Moved Away'] ?? '0' }}
						</div>
					</div>
					<div class="row">
						
						<div class="col-3 text-right">Dropped Out (Quit)</div><div class="col-1" style="border:1px solid black">
								{{ $inactiveCount['Quit'] ?? '0' }}
						</div>
						<div class="col-3 text-right">Re-Arrest</div><div class="col-1" style="border:1px solid black">
								{{ $inactiveCount['Re-Arrest'] ?? '0' }}
						</div>
						<div class="col-3 text-right">Deceased</div><div class="col-1" style="border:1px solid black">
							{{ $inactiveCount['Deceased'] ?? '0' }}
						</div>
					</div>
					<div class="row">
						<div class="col-3 text-right">No Contact</div><div class="col-1" style="border:1px solid black">
							{{ $inactiveCount['No Contact'] ?? '0' }}
						</div>
						<div class="col-3 text-right">Transferred</div><div class="col-1" style="border:1px solid black">
							{{ $inactiveCount['Transferred'] ?? '0' }}
						</div>
						<div class="col-3 text-right">Complete</div><div class="col-1" style="border:1px solid black">
							{{ $inactiveCount['complete'] ?? '0' }}
						</div>
					</div>
					</div>
					

								
			</div>
		</div>
		
					
</body>
</html>
