 <?php
//langkah6 di server untuk mengembalikan ke hosting simpeg.sql
$file = "C:\\xampp\htdocs\simpeg\backupsimpegdariserver\kel.txt" ;//source atau asal
$remote_file = '/public_html/kel.txt';//destinition atau tujuan

// set up basic connection
$ftp_server = "simpeg.org";//serverip
$conn_id = ftp_connect($ftp_server);
$ftp_user_name='k0230277';
$ftp_user_pass='51mp36';

// login with username and password
$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);
echo $login_result;

// upload a file
if (ftp_put($conn_id, $remote_file, $file, FTP_ASCII)) {
														echo "successfully uploaded $file\n";
													   } else {
															  echo "There was a problem while uploading $file\n";
															  }

// close the connection
ftp_close($conn_id);
?>

