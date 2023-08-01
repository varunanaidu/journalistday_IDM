<?php if ( !defined('BASEPATH' ) )exit('No direct script access allowed');?>
<div id="content" style="padding:20px;background:#FCFCFC;">
	<center>  	
		<h2 style="font-family: sans-serif;">Selamat anda telah sukses terdaftar dalam acara Journalist Day</h2>
		
		<div class="cardWrap">
			<?php 
			if ( isset($participant) and $participant != 0 ) {
				foreach ($participant as $row) {
					?>
					<div class="card cardLeft">
						<br/><h1>JOURNALIST DAY</h1>
						<table>
							<tr>
								<td><h2><br/>Tanggal</h2></td>
								<td><h2><br/>:</h2></td>
								<td><h2><br/><?= date('d F Y H:i:s', strtotime($row->addon)) ?></h2></td>
							</tr>
							<tr>
								<td><h2>Name</h2></td>
								<td><h2>:</h2></td>
								<td><h2><?= $row->participant_name ?></h2></td>
							</tr>
							<tr>
								<td><h2>WhatsApp</h2></td>
								<td><h2>:</h2></td>
								<td><h2><?= $row->participant_wa ?></h2></td>
							</tr>
						</table>

					</div>
					<div class="card cardRight">
						<div class="logo"><br/><h1></h1></div>
					</div>

					<?php 
				}
			}
			?>
		</div>
		
	</center>
</div>