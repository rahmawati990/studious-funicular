<?php
include_once "library/inc.sesadmin.php";
include_once "library/inc.library.php";

if($_GET) {
	if(isset($_POST['btnSave'])){
		# Validasi form, jika kosong sampaikan pesan error
		$message = array();
		if (trim($_POST['txtKategori'])=="") {
			$message[] = "Nama kategori tidak boleh kosong !";		
		}
		
		# Baca Variabel Form
		$txtKategori= $_POST['txtKategori'];
		$txtKategori= str_replace("'","&acute;",$txtKategori);
		$txtLama= $_POST['txtLama'];
		$txtLama= str_replace("'","&acute;",$txtLama);
		
		# Validasi Nama Kategori, jika sudah ada akan ditolak
		$sqlCek="SELECT * FROM kategori WHERE nm_kategori='$txtKategori' AND NOT(nm_kategori='$txtLama')";
		$qryCek=mysql_query($sqlCek, $koneksidb) or die ("Eror Query".mysql_error()); 
		if(mysql_num_rows($qryCek)>=1){
			$message[] = "Maaf, Kategori <b> $txtKategori </b> sudah ada, ganti dengan yang lain";
		}
		
		# SIMPAN PERUBAHAN DATA, Jika jumlah error message tidak ada, simpan datanya
		if(count($message)==0){	
			$qryUpdate=mysql_query("UPDATE kategori SET nm_kategori='$txtKategori'	WHERE kd_kategori ='".$_POST['txtKode']."'") 
					   or die ("Gagal query update".mysql_error());
			if($qryUpdate){
				echo "<meta http-equiv='refresh' content='0; url=?page=Data-Kategori'>";
			}
			exit;
		}	
		
		# JIKA ADA PESAN ERROR DARI VALIDASI
		// (Form Kosong, atau Duplikat ada), Ditampilkan lewat kode ini
		if (! count($message)==0 ){
            echo "<div class='mssgBox'>";
			echo "<img src='images/attention.png' class='imgBox'> <hr>";
				$Num=0;
				foreach ($message as $indeks=>$pesan_tampil) { 
				$Num++;
					echo "&nbsp;&nbsp;$Num. $pesan_tampil<br>";	
				} 
			echo "</div> <br>"; 
		}
	} // Penutup POST
	
	# TAMPILKAN DATA LOGIN UNTUK DIEDIT
	$KodeEdit= isset($_GET['Kode']) ?  $_GET['Kode'] : $_POST['txtKode']; 
	$sqlShow = "SELECT * FROM kategori WHERE kd_kategori='$KodeEdit'";
	$qryShow = mysql_query($sqlShow, $koneksidb)  or die ("Query ambil data kategori salah : ".mysql_error());
	$dataShow = mysql_fetch_array($qryShow);

	# MASUKKAN DATA KE VARIABEL
	$dataKode	= $dataShow['kd_kategori'];
	$dataNama	= isset($dataShow['nm_kategori']) ?  $dataShow['nm_kategori'] : $_POST['txtKategori'];
	$dataNamaLm	= $dataShow['nm_kategori'];
} // Penutup GET
?>
<form action="?page=Edit-Kategori" method="post" name="frmedit">
<table class="table-list" width="100%" style="margin-top:0px;">
	<tr>
	  <th colspan="3">UBAH DATA KATEGORI </th>
	</tr>
	<tr>
	  <td width="15%"><b>Kode</b></td>
	  <td width="1%"><b>:</b></td>
	  <td width="84%"><input name="txtLock" value="<?php echo $dataKode; ?>" size="8" maxlength="4"  readonly="readonly"/>
    <input name="txtKode" type="hidden" value="<?php echo $dataKode; ?>" /></td></tr>
	<tr>
	  <td><b>Nama Kategori </b></td>
	  <td><b>:</b></td>
	  <td><input name="txtKategori" type="text" value="<?php echo $dataNama; ?>" size="80" maxlength="100" />
      <input name="txtLama" type="hidden" value="<?php echo $dataNamaLm; ?>" /></td></tr>
	<tr><td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td><input type="submit" name="btnSave" value=" SIMPAN " style="cursor:pointer;"></td>
    </tr>
</table>
</form>

