<?php
include_once "library/inc.sesadmin.php";
include_once "library/inc.library.php";

if($_GET) {
	# HAPUS DAFTAR barang DI TMP
	if(isset($_GET['Act'])){
		if(trim($_GET['Act'])=="Delete"){
			# Hapus Tmp jika datanya sudah dipindah
			mysql_query("DELETE FROM tmp_pembelian WHERE id='".$_GET['ID']."' AND userid='".$_SESSION['SES_LOGIN']."'", $koneksidb) 
				or die ("Gagal kosongkan tmp".mysql_error());
		}
		if(trim($_GET['Act'])=="Sucsses"){
			echo "<b>DATA BERHASIL DISIMPAN</b> <br><br>";
		}
	}
	
	if($_POST) {
	# TOMBOL PILIH (KODE barang) DIKLIK
	if(isset($_POST['btnPilih'])){
		$message = array();
		if (trim($_POST['txtKode'])=="") {
			$message[] = "<b>Kode Barang belum diisi</b>, ketik secara manual atau dari barcode reader !";		
		}
		if (trim($_POST['txtHargaBeli'])=="" OR ! is_numeric(trim($_POST['txtHargaBeli']))) {
			$message[] = "Data <b>Harga Beli belum diisi</b>, silahkan <b>isi dengan nominal uang</b> !";		
		}
		if (trim($_POST['txtJumlah'])=="" OR ! is_numeric(trim($_POST['txtJumlah']))) {
			$message[] = "Data <b>Jumlah barang (Qty) belum diisi</b>, silahkan <b>isi dengan angka</b> !";		
		}
		
		# Baca variabel
		$txtKode	= $_POST['txtKode'];
		$txtKode	= str_replace("'","&acute;",$txtKode);
		$txtHargaBeli = $_POST['txtHargaBeli'];
		$txtHargaBeli = str_replace("'","&acute;",$txtHargaBeli);
		$txtHargaBeli = str_replace(".","",$txtHargaBeli);
		$txtJumlah	= $_POST['txtJumlah'];
		$txtJumlah	= str_replace("'","&acute;",$txtJumlah);
		
		# Jika jumlah error message tidak ada
		if(count($message)==0){			
			$barangSql ="SELECT * FROM barang WHERE kd_barang='$txtKode'";
			$barangQry = mysql_query($barangSql, $koneksidb) or die ("Gagal Query Tmp".mysql_error());
			$barangRow = mysql_fetch_array($barangQry);
			$barangQty = mysql_num_rows($barangQry);
			if ($barangQty >= 1) {
				$tmpSql = "INSERT INTO tmp_pembelian SET kd_barang='$barangRow[kd_barang]', harga_beli='$txtHargaBeli', 
						   qty='$txtJumlah', userid='".$_SESSION['SES_LOGIN']."'";
				mysql_query($tmpSql, $koneksidb) or die ("Gagal Query detail barang : ".mysql_error());
				$txtKode	= "";
				$txtJumlah	= "";
				$txtHargaBeli = "";
			}
			else {
				$message[] = "Tidak ada barang dengan kode <b>$txtKode'</b>, silahkan ganti";
			}
		}

	}
	
	# JIKA TOMBOL SIMPAN DIKLIK
	if(isset($_POST['btnSave'])){
		$message = array();
		if (trim($_POST['cmbSupplier'])=="BLANK") {
			$message[] = "<b>Nama Supplier belum dipilih</b>, silahkan pilih lagi !";		
		}
		if (trim($_POST['cmbTanggal'])=="") {
			$message[] = "Tanggal transaksi belum diisi, pilih pada combo !";		
		}
		$tmpSql ="SELECT COUNT(*) As qty FROM tmp_pembelian WHERE userid='".$_SESSION['SES_LOGIN']."'";
		$tmpQry = mysql_query($tmpSql, $koneksidb) or die ("Gagal Query Tmp".mysql_error());
		$tmpRow = mysql_fetch_array($tmpQry);
		if ($tmpRow['qty'] < 1) {
			$message[] = "<b>Item Barang</b> belum ada yang dimasukan, <b>minimal 1 barang</b>.";
		}
		
		# Baca variabel
		$cmbSupplier= $_POST['cmbSupplier'];
		$cmbSupplier= str_replace("'","&acute;",$cmbSupplier);
		$txtCatatan	= $_POST['txtCatatan'];
		$txtCatatan = str_replace("'","&acute;",$txtCatatan);
		$cmbTanggal =$_POST['cmbTanggal'];
				
		# Jika jumlah error message tidak ada
		if(count($message)==0){			
			$kodeBaru	= buatKode("pembelian", "BL");
			$qrySave=mysql_query("INSERT INTO pembelian SET no_pembelian='$kodeBaru', 
								  tgl_transaksi='".InggrisTgl($_POST['cmbTanggal'])."', 
								  kd_supplier='$cmbSupplier', catatan='$txtCatatan', userid='".$_SESSION['SES_LOGIN']."'") 
								  or die ("Gagal query".mysql_error());
			if($qrySave){
				# Ambil semua data barang yang dipilih, berdasarkan kasir yg login
				$tmpSql ="SELECT * FROM tmp_pembelian WHERE userid='".$_SESSION['SES_LOGIN']."'";
				$tmpQry = mysql_query($tmpSql, $koneksidb) or die ("Gagal Query Tmp".mysql_error());
				while ($tmpRow = mysql_fetch_array($tmpQry)) {
					// Masukkan semua barang yang udah diisi ke tabel pembelian detail
					$barangSql = "INSERT INTO pembelian_item SET no_pembelian='$kodeBaru', 
								  kd_barang='$tmpRow[kd_barang]', harga_beli='$tmpRow[harga_beli]', jumlah='$tmpRow[qty]'";
		  			mysql_query($barangSql, $koneksidb) or die ("Gagal Query Simpan detail barang".mysql_error());

					// Update stok
					$barangSql = "UPDATE barang SET stok=stok + $tmpRow[qty], harga_beli='$tmpRow[harga_beli]' WHERE kd_barang='$tmpRow[kd_barang]'";
		  			mysql_query($barangSql, $koneksidb) or die ("Gagal Query Edit Stok".mysql_error());
				}
				# Kosongkan Tmp jika datanya sudah dipindah
				mysql_query("DELETE FROM tmp_pembelian WHERE userid='".$_SESSION['SES_LOGIN']."'", $koneksidb) 
						or die ("Gagal kosongkan tmp".mysql_error());
				
				// Refresh form
				echo "<meta http-equiv='refresh' content='0; url=?page=Pembelian-Barang&Act=Sucsses'>";
			}
			else{
				$message[] = "Gagal penyimpanan ke database";
			}
		}	
	} 
	// =======================================
	
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
	// ======================================
	
	} // Penutup POST
} // Penutup GET

# TAMPILKAN DATA KE FORM
$nomorTransaksi = buatKode("pembelian", "BL");
$tglTransaksi 	= isset($_POST['cmbTanggal']) ? $_POST['cmbTanggal'] : date('d-m-Y');
$dataCatatan	= isset($_POST['txtCatatan']) ? $_POST['txtCatatan'] : '';
?>
<form action="?page=Pembelian-Barang" method="post"  name="frmadd">
<table width="750" cellspacing="1" class="table-common" style="margin-top:0px;">
	<tr>
	  <td colspan="3" align="right"><h1>TRANSAKSI PEMBELIAN BARANG</h1> </td>
	</tr>
	<tr>
	  <td width="20%"><b>No Pembelian </b></td>
	  <td width="1%"><b>:</b></td>
	  <td width="79%"><input name="txtNomor" value="<?php echo $nomorTransaksi; ?>" size="9" maxlength="9" readonly="readonly"/></td></tr>
	<tr>
      <td><b>Tanggal Pembelian </b></td>
	  <td><b>:</b></td>
	  <td><?php echo form_tanggal("cmbTanggal",$tglTransaksi); ?></td>
    </tr>
	<tr>
      <td><b>Supplier Barang </b></td>
	  <td><b>:</b></td>
	  <td><select name="cmbSupplier">
        <option value="BLANK"> </option>
        <?php
	  $dataSql = "SELECT * FROM supplier ORDER BY kd_supplier";
	  $dataQry = mysql_query($dataSql, $koneksidb) or die ("Gagal Query".mysql_error());
	  while ($dataRow = mysql_fetch_array($dataQry)) {
	  	if ($dataRow['kd_supplier']== $_POST['cmbSupplier']) {
			$cek = " selected";
		} else { $cek=""; }
	  	echo "<option value='$dataRow[kd_supplier]' $cek>$dataRow[nm_supplier]</option>";
	  }
	  $sqlData ="";
	  ?>
      </select></td>
    </tr>
	<tr>
      <td><b>Catatan</b></td>
	  <td><b>:</b></td>
	  <td><input name="txtCatatan" value="<?php echo $dataCatatan; ?>" size="30" maxlength="100" /></td>
    </tr>
	<tr><td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
    </tr>
	<tr>
	  <td><b>Kode Barang/ Barcode </b></td>
	  <td><b>:</b></td>
	  <td><b>
	    <input name="txtKode" class="angkaC" size="14" maxlength="20" />
		Harga beli (Rp) : 
		<input name="txtHargaBeli" class="angkaR"  size="14" maxlength="10" /> 
		Qty :
		<input class="angkaC" name="txtJumlah" size="4" maxlength="4" value="1" 
					 onblur="if (value == '') {value = '1'}" 
					 onfocus="if (value == '1') {value =''}"/>
		<input name="btnPilih" type="submit" style="cursor:pointer;" value=" Pilih " />
      </b></td>
    </tr>
	<tr>
	  <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
	</tr>
	<tr>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td><input name="btnSave" type="submit" style="cursor:pointer;" value=" SIMPAN TRANSAKSI " /></td>
    </tr>
</table>

<table class="table-list" width="750" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <th colspan="7">DAFTAR  ITEM BARANG</th>
    </tr>
  <tr>
    <td width="26" align="center" bgcolor="#CCCCCC"><b>No</b></td>
    <td width="66" align="center" bgcolor="#CCCCCC"><b>Kode</b></td>
    <td width="335" bgcolor="#CCCCCC"><b>Nama Barang </b></td>
    <td width="97" align="right" bgcolor="#CCCCCC"><b>Harga Beli (Rp)</b></td>
    <td width="41" align="center" bgcolor="#CCCCCC"><b>Qty</b></td>
    <td width="97" align="right" bgcolor="#CCCCCC"><b>Subtotal (Rp)</b></td>
    <td width="52" align="center" bgcolor="#FFCC00"><b>Delete</b></td>
  </tr>
<?php
$tmpSql ="SELECT barang.kd_barang, barang.nm_barang, tmp_pembelian.* FROM barang, tmp_pembelian
		WHERE barang.kd_barang=tmp_pembelian.kd_barang AND tmp_pembelian.userid='".$_SESSION['SES_LOGIN']."'
		ORDER BY barang.kd_barang ";
$tmpQry = mysql_query($tmpSql, $koneksidb) or die ("Gagal Query Tmp".mysql_error());
$total = 0; $qtyBrg = 0; $nomor=0;
while($tmpRow = mysql_fetch_array($tmpQry)) {
	$ID		= $tmpRow['id'];
	$subSotal = $tmpRow['qty'] * intval($tmpRow['harga_beli']);
	$total 	= $total + $subSotal;
	$qtyBrg = $qtyBrg + $tmpRow['qty'];
	
	$nomor++;
?>
  <tr>
    <td align="center"><b><?php echo $nomor; ?></b></td>
    <td align="center"><b><?php echo $tmpRow['kd_barang']; ?></b></td>
    <td><?php echo $tmpRow['nm_barang']; ?></td>
    <td align="right"><?php echo format_angka($tmpRow['harga_beli']); ?></td>
    <td align="center"><?php echo $tmpRow['qty']; ?></td>
    <td align="right"><?php echo format_angka($subSotal); ?></td>
    <td align="center" bgcolor="#FFFFCC"><a href="?page=Pembelian-Barang&Act=Delete&ID=<?php echo $ID; ?>" target="_self"><img src="images/hapus.gif" width="16" height="16" border="0" /></a></td>
  </tr>
<?php 
}?>
  <tr>
    <td colspan="4" align="right"><b>Grand Total : </b></td>
    <td align="center"><b><?php echo $qtyBrg; ?></b></td>
    <td align="right"><b><?php echo format_angka($total); ?></b></td>
    <td align="center">&nbsp;</td>
  </tr>
</table>
</form>
