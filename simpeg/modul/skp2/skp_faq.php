<h2>
	FREQUENTLY ASK QUESTION
	<br>
	<small>Tanya Jawab e-PPK PNS</small>
</h2>

<table class="table">
	<?php
		
		$x = 1;
		foreach($skp->get_faq() as $faq) {
			
			
	?>
	<tr>
		<td width="3%" rowspan="2"><?php echo $x++ ?></td>
		<td width="7%">
			<p><strong>Tanya : </strong></p>
		</td>
		<td>
			<p>
				<?php echo $faq->question ?>
			</p>
		</td>
	</tr>
	<tr>		
		<td width="7%">
			<p><strong>Jawab : </strong></p>
		</td>
		<td>
			<p>
				<?php echo $faq->answer ?>
			</p>
		</td>
	</tr>
	<?php
	
		}
	?>
</table>

