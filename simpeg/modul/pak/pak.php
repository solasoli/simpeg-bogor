<?



class Pak{
	
	function get_rumpun_all(){
		
		$sql = "select * from jft_rumpun";
		$query = mysql_query($sql);
		
		while($hasil = mysql_fetch_object($query)){
			$result[] = $hasil;
		}
		return $result;
	}
	
	function insert_rumpun_jft(){
		
	}
	
	function insert_riwayat_pak(){
		
	}
}