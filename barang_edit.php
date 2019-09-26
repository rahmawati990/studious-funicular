<?php
include_once "library/inc.sesadmin.php";
include_once "library/inc.library.php";

if($_GET) {
	if(isset($_POST['btnSave'])){
		# Validasi form, jika kosong sampaikan pesan error
		$message = array();
		if (trim($_POST['txtBarang'])=="") {
			$message[] = "Nama barang tidak boleh kosong !";		
		}
		if (trim($_POST['txtHargaBeli'])=="" OR ! is_numeric(trim($_POST['txtHargaBeli']))) {
			$message[] = "<b>Harga Beli</b> barang tidak boleh kosong, harus diisi angka !";		
		}
		if (trim($_POST['txtHargaJual'])=="" OR ! is_numeric(trim($_POST['txtHargaJual']))) {
			$message[] = "<b>Harga Jual</b> barang tidak boleh kosong, harus diisi angka !";		
		}
		if (trim($_POST['txtDiskon'])=="" OR ! is_numeric(trim($_POST['txtDiskon']))) {
			$message[] = "<b>Dikson (%)</b> jual tidak boleh kosong, harus diisi angka !";		
		}
		if (! is_numeric(trim($_POST['txtStok']))) {
			$message[] = "<b>Stok</b> barang harus diisi angka !";		
		}
		if (trim($_POST['cmbKategori'])=="BLANK") {
			$message[] = "<b>Kategori Barang</b> belum dipilih !";		
		}

		
		# Baca Variabel Form
		$txtLama	= $_POST['txtLama'];
		$txtBarang= $_POST['txtBarang'];
		$txtBarang= str_replace("'","&acute;",$txtBarang);
		$txtHargaBeli	= $_POST['txtHargaBeli'];
		$txtHargaBeli	= str_replace("'","&acute;",$txtHargaBeli);
		$txtHargaBeli	= str_replace(".","",$txtHargaBeli);
		$txtHargaJual	= $_POST['txtHargaJual'];
		$txtHargaJual	= str_replace("'","&acute;",$txtHargaJual);
		$txtHargaJual	= str_replace(".","",$txtHargaJual);
		$txtDiskon		= $_POST['txtDiskon'];
		$txtDiskon		= str_replace("'","&acute;",$txtDiskon);
		$txtKeterangan	= $_POST['txtKeterangan'];
		$txtKeterangan	= str_replace("'","&acute;",$txtKeterangan);
		$cmbKategori	= $_POST['cmbKategori'];
		
		# Validasi Nama barang, jika sudah ada akan ditolak
		$sqlCek="SELECT * FROM barang WHERE nm_barang='$txtBarang' AND NOT(nm_barang='$txtLama')";
		$qryCek=mysql_query($sqlCek, $koneksidb) or die ("Eror Query".mysql_error()); 
		if(mysql_num_rows($qryCek)>=1){
			$message[] = "Maaf, barang <b> $txtBarang </b> sudah ada, ganti dengan yang lain";
		}
		
		# Validasi Diskon, rugi atau laba
		if (! trim($_POST['txtHargaBeli'])=="" AND ! trim($_POST['txtHargaJual'])=="") {
			$besarDiskon = intval($txtHargaJual) * (intval($txtDiskon)/100);
			$hargaDiskon = intval($txtHargaJual) - $besarDiskon;
			if (intval($txtHargaBeli) >= $hargaDiskon ){
				$message[] = "<b>Harga Jual</b> masih salah, terhitung <b> Anda merugi </b> ! <br>
								&nbsp; Harga belum diskon : Rp. ".format_angka($txtHargaJual)." <br>
								&nbsp; Diskon ($txtDiskon %) : Rp.  ".format_angka($besarDiskon)." <br>
								&nbsp; Harga sudah diskon : Rp. ".format_angka($hargaDiskon).", 
								Sedangkan modal Anda Rp. ".format_angka($txtHargaBeli)."<br>
								&nbsp; <b>Solusi :</b> Anda harus <b>mengurangi besar % Diskon</b>, atau <b>Menaikan Harga Jual</b>.";		
			}
		}
		
		# TIDAK ADA ERROR, Jika jumlah error message tidak ada, simpan datanya
		if(count($message)==0){	
			$qryUpdate=mysql_query("UPDATE barang SET nm_barang='$txtBarang',
								  harga_beli='$txtHargaBeli', harga_jual='$txtHargaJual', diskon='$txtDiskon',
								  keterangan='$txtKeterangan', kd_kategori='$cmbKategori' WHERE kd_barang ='".$_POST['txtKode']."'") 
					   or die ("Gagal query update".mysql_error());
			if($qryUpdate){
				// Refresh
				echo "<meta http-equiv='refresh' content='0; url=?page=Data-Barang'>";
			}
			exit;
		}	
		
		# Jika ada error message ditemukan
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
	
	# TAMPILKAN DATA UNTUK DIEDIT
	$KodeEdit= isset($_GET['Kode']) ?  $_GET['Kode'] : $_POST['txtKode']; 
	$sqlShow = "SELECT * FROM barang WHERE kd_barang='$KodeEdit'";
	$qryShow = mysql_query($sqlShow, $koneksidb)  or die ("Query ambil data barang salah : ".mysql_error());
	$dataShow= mysql_fetch_array($qryShow);
	
	# MASUKKAN DATA KE VARIABEL
	$dataKode	= $dataShow['kd_barang'];
	$dataNama	= isset($dataShow['nm_barang']) ?  $dataShow['nm_barang'] : $_POST['txtBarang'];
	$dataLama	= $dataShow['nm_barang'];
	$dataHBeli 	= isset($dataShow['harga_beli']) ?  $dataShow['harga_beli'] : $_POST['txtHargaBeli'];
	$dataHJual 	= isset($dataShow['harga_jual']) ?  $dataShow['harga_jual'] : $_POST['txtHargaJual'];
	$dataDiskon	= isset($dataShow['diskon']) ?  $dataShow['diskon'] : $_POST['txtDiskon'];
	$dataStok	= isset($dataShow['stok']) ?  $dataShow['stok'] : $_POST['txtStok'];
	$dataKeterangan	= isset($dataShow['keterangan']) ?  $dataShow['keterangan'] : $_POST['txtKeterangan'];
	$dataKategori	= isset($dataShow['kd_kategori']) ?  $dataShow['kd_kategori'] : $_POST['cmbKategori'];
} // Penutup GET
?>
<form action="?page=Edit-Barang" method="post" name="frmedit">
<table class="table-list" width="100%" style="margin-top:0px;">
	<tr>
	  <th colspan="3">UBAH DATA BARANG </th>
	</tr>
	<tr>
	  <td width="15%"><b>Kode Barang</b></td>
	  <td width="1%"><b>:</b></td>
	  <td width="84%"><input name="txtLock" value="<?php echo $dataKode; ?>" size="8" maxlength="4"  readonly="readonly"/>
    <input name="txtKode" type="hidden" value="<?php echo $dataKode; ?>" /></td></tr>
	<tr>
	  <td><b>Nama Barang </b></td>
	  <td><b>:</b></td>
	  <td><input name="txtBarang" type="text" value="<?php echo $dataNama; ?>" size="80" maxlength="100" />
      <input name="txtLama" type="hidden" value="<?php echo $dataLama; ?>" /></td></tr>
	<tr>
      <td><b>Harga Beli </b></td>
	  <td><b>:</b></td>
	  <td><input name="txtHargaBeli" value="<?php echo $dataHBeli; ?>" size="20" maxlength="10" /></td>
    </tr>
	<tr>
      <td><b>Harga Jual </b></td>
	  <td><b>:</b></td>
	  <td><input name="txtHargaJual" value="<?php echo $dataHJual; ?>" size="20" maxlength="10" /></td>
    </tr>
	<tr>
      <td><b>Diskon (%) </b></td>
	  <td><b>:</b></td>
	  <td><input name="txtDiskon" value="<?php echo $dataDiskon; ?>" size="10" maxlength="30" />
	    % </td>
    </tr>
	<tr>
      <td><b>Stok</b></td>
	  <td><b>:</b></td>
	  <td><input name="txtStok" value="<?php echo $dataStok; ?>" size="10" maxlength="30" /></td>
    </tr>
	<tr>
      <td><b>Keterangan</b></td>
	  <td><b>:</b></td>
	  <td><input name="txtKeterangan" value="<?php echo $dataKeterangan; ?>" size="100" maxlength="200" /></td>
    </tr>
	<tr>
      <td><strong>Kategori Barang </strong></td>
	  <td><b>:</b></td>
	  <td><select name="cmbKategori">
          <option value="BLANK"> </option>
          <?php
	  $dataSql = "SELECT * FROM kategori ORDER BY kd_kategori";
	  $dataQry = mysql_query($dataSql, $koneksidb) or die ("Gagal Query".mysql_error());
	  while ($dataRow = mysql_fetch_array($dataQry)) {
	  	if ($dataRow['kd_kategori']== $dataKategori) {
			$cek = " selected";
		} else { $cek=""; }
	  	echo "<option value='$dataRow[kd_kategori]' $cek>$dataRow[nm_kategori]</option>";
	  }
	  $sqlData ="";
	  ?>
      </select></td>
	</tr>
	<tr><td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td><input type="submit" name="btnSave" value=" SIMPAN " style="cursor:pointer;"></td>
    </tr>
</table>
</form>

