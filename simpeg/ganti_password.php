<h2>Ganti Password</h2>
<form name="change_password" id="change_password" action="index3.php?x=change_password.php" method="post" >
	<table cellpadding="5" class="table">
		<tr>
			<td>Password Lama</td>
			<td>:</td>
			<td><input type="password" name="password_lama"></td>
		</tr>
		<tr>
			<td>Password Baru</td>
			<td>:</td>
			<td><input type="password" name="password_baru" id="Password_baru"></td>
		</tr>
		<tr>
			<td>Konfirmasi Password Baru</td>
			<td>:</td>
			<td><input type="password" name="konfirmasi_password" id="konfirmasi_password"></td>
		</tr>
		<tr>
			<td></td>
			<td></td>
			<td><input type="submit" value="Lanjutkan" /></td>
		</tr>
	</table>
</form>
<script type="text/javascript">		$(document).ready(function(){			$("#change_password").validate({                rules: {                    password_baru: {                        required: true,                       						minlength : 4 						                    },                    konfirmasi_password: {                        required: true,                        minlength: 4                    }                  },                messages: {                    password_baru: {                        required: "Harap di isi",                       						minlength: "Kurang dari karakter minimun"												                    },                    konfirmasi_password: {                        required: "Harap di isi",                        minlength: "Kurang dari karakter minimum"                    }                }               });				});</script>