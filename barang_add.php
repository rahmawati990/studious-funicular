<?php
include_once "library/inc.sesadmin.php";
include_once "library/inc.library.php";

if($_GET) {
	if(isset($_POST['btnSave'])){
		# Validasi form, jika kosong sampaikan pesan error
		$message = array();
		if (trim($_POST['txtBarang'])=="") {
			$message[] = "<b>Nama barang</b> tidak boleh kosong !";		
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
		$txtBarang	= $_POST['txtBarang'];
		$txtBarang	= str_replace("'","&acute;",$txtBarang);
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
		$sqlCek="SELECT * FROM barang WHERE nm_barang='$txtBarang'";
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
		# SIMPAN DATA KE DATABASE
		if(count($message)==0){			
			$kodeBaru	= buatKode("barang", "B");
			$qrySave=mysql_query("INSERT INTO barang SET kd_barang='$kodeBaru', nm_barang='$txtBarang',
								  harga_beli='$txtHargaBeli', harga_jual='$txtHargaJual', diskon='$txtDiskon',
								  keterangan='$txtKeterangan', kd_kategori='$cmbKategori'") or die ("Gagal query".mysql_error());
			if($qrySave){
				echo "<meta http-equiv='refresh' content='0; url=?page=Data-Barang'>";
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
		
	# MASUKKAN DATA KE VARIABEL
	$dataKode	= buatKode("barang", "B");
	$dataNama	= isset($_POST['txtBarang']) ? $_POST['txtBarang'] : '';
	$dataHBeli 	= isset($_POST['txtHargaBeli']) ? $_POST['txtHargaBeli'] : '';
	$dataHJual 	= isset($_POST['txtHargaJual']) ? $_POST['txtHargaJual'] : '';
	$dataDiskon	= isset($_POST['txtDiskon']) ? $_POST['txtDiskon'] : '';
	$dataStok	= isset($_POST['txtStok']) ? $_POST['txtStok'] : '0';
	$dataKeterangan	= isset($_POST['txtKeterangan']) ? $_POST['txtKeterangan'] : '';
	$dataKategori	= isset($_POST['cmbKategori']) ? $_POST['cmbKategori'] : '';
} // Penutup GET
?>
<form action="?page=Add-Barang" method="post" name="frmadd" target="_self">
<table width="100%" cellpadding="2" cellspacing="1" class="table-list" style="margin-top:0px;">
	<tr>
	  <th colspan="3">TAMBAH DATA BARANG </th>
	   <th colspan="3">TAMBAH DATA BARANG </th>
	    <th colspan="3">TAMBAH DATA BARANG </th>
	</tr>
	<tr>
	  <td width="15%"><b>Kode Barang</b></td>
	  <td width="1%"><b>:</b></td>
	  <td width="84%"><input name="txtKode" value="<?php echo $dataKode; ?>" size="10" maxlength="4" readonly="readonly"/></td></tr>
	<tr>
	  <td><b>Nama Barang </b></td>
	  <td><b>:</b></td>
	  <td><input name="txtBarang" value="<?php echo $dataNama; ?>" size="80" maxlength="100" /></td>
	</tr>
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
      <td><b>Stok </b></td>
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
	  	if ($dataRow['kd_kategori']== $_POST['cmbKategori']) {
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
