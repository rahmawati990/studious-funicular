<?php
include_once "library/inc.sesadmin.php";
include_once "library/inc.library.php";

if($_GET) {
	# HAPUS DAFTAR barang DI TMP
	if(isset($_GET['Act'])){
		if(trim($_GET['Act'])=="Delete"){
			# Hapus Tmp jika datanya sudah dipindah
			mysql_query("DELETE FROM tmp_penjualan WHERE id='".$_GET['ID']."' AND userid='".$_SESSION['SES_LOGIN']."'", $koneksidb) 
				or die ("Gagal kosongkan tmp".mysql_error());
		}
		if(trim($_GET['Act'])=="Sucsses"){
			echo "<b>DATA BERHASIL DISIMPAN</b> <br><br>";
		}
	}
	// =========================================================================
	
	if($_POST) {
	# TOMBOL PILIH (KODE barang) DIKLIK
	if(isset($_POST['btnPilih'])){
		$message = array();
		if (trim($_POST['txtKode'])=="") {
			$message[] = "<b>Kode Barang belum diisi</b>, ketik secara manual atau dari barcode reader !";		
		}
		if (trim($_POST['txtJumlah'])=="" OR ! is_numeric(trim($_POST['txtJumlah']))) {
			$message[] = "Data <b>Jumlah barang (Qty) belum diisi</b>, silahkan <b>isi dengan angka</b> !";		
		}
		
		# Baca variabel
		$txtKode	= $_POST['txtKode'];
		$txtKode	= str_replace("'","&acute;",$txtKode);
		$txtJumlah	= $_POST['txtJumlah'];
		$txtJumlah	= str_replace("'","&acute;",$txtJumlah);
		
		# Jika jumlah error message tidak ada
		if(count($message)==0){			
			$barangSql ="SELECT * FROM barang WHERE kd_barang='$txtKode'";
			$barangQry = mysql_query($barangSql, $koneksidb) or die ("Gagal Query Tmp".mysql_error());
			$barangRow = mysql_fetch_array($barangQry);
			$barangQty = mysql_num_rows($barangQry);
			if ($barangQty >= 1) {
				# Hitung Diskon, dan Harga setelah diskon
				$besarDiskon = intval($barangRow['harga_jual']) * (intval($barangRow['diskon'])/100);
				$hargaDiskon = intval($barangRow['harga_jual']) - $besarDiskon;

				$tmpSql = "INSERT INTO tmp_penjualan SET kd_barang='$barangRow[kd_barang]', harga_jual='$hargaDiskon', 
						   qty='$txtJumlah', userid='".$_SESSION['SES_LOGIN']."'";
				mysql_query($tmpSql, $koneksidb) or die ("Gagal Query detail barang : ".mysql_error());
				$txtKode= "";
				$txtJumlah	= "";
			}
			else {
				$message[] = "Tidak ada barang dengan kode <b>$txtKode'</b>, silahkan ganti";
			}
		}

	}
	// ============================================================================
	
	# JIKA TOMBOL SIMPAN DIKLIK
	if(isset($_POST['btnSave'])){
		$message = array();
		if (trim($_POST['cmbTanggal'])=="") {
			$message[] = "Tanggal transaksi belum diisi, pilih pada combo !";		
		}
		$tmpSql ="SELECT COUNT(*) As qty FROM tmp_penjualan WHERE userid='".$_SESSION['SES_LOGIN']."'";
		$tmpQry = mysql_query($tmpSql, $koneksidb) or die ("Gagal Query Tmp".mysql_error());
		$tmpRow = mysql_fetch_array($tmpQry);
		if ($tmpRow['qty'] < 1) {
			$message[] = "<b>Item Barang</b> belum ada yang dimasukan, <b>minimal 1 barang</b>.";
		}
		
		# Baca variabel
		$txtPelanggan= $_POST['txtPelanggan'];
		$txtPelanggan= str_replace("'","&acute;",$txtPelanggan);
		$txtCatatan	= $_POST['txtCatatan'];
		$txtCatatan = str_replace("'","&acute;",$txtCatatan);
		$cmbTanggal =$_POST['cmbTanggal'];
				
		# Jika jumlah error message tidak ada
		if(count($message)==0){			
			$kodeBaru	= buatKode("penjualan", "JL");
			$qrySave=mysql_query("INSERT INTO penjualan SET no_penjualan='$kodeBaru', tgl_transaksi='".InggrisTgl($_POST['cmbTanggal'])."', 
								  pelanggan='$txtPelanggan', catatan='$txtCatatan', userid='".$_SESSION['SES_LOGIN']."'") or die ("Gagal query".mysql_error());
			if($qrySave){
				# Ambil semua data barang yang dipilih, berdasarkan kasir yg login
				$tmpSql ="SELECT * FROM tmp_penjualan WHERE userid='".$_SESSION['SES_LOGIN']."'";
				$tmpQry = mysql_query($tmpSql, $koneksidb) or die ("Gagal Query Tmp".mysql_error());
				while ($tmpRow = mysql_fetch_array($tmpQry)) {
					// Masukkan semua barang yang udah diisi ke tabel penjualan detail
					$itemSql = "INSERT INTO penjualan_item SET no_penjualan='$kodeBaru', kd_barang='$tmpRow[kd_barang]', 
								harga_jual='$tmpRow[harga_jual]', jumlah='$tmpRow[qty]'";
		  			mysql_query($itemSql, $koneksidb) or die ("Gagal Query Simpan detail barang".mysql_error());
					
					// Update stok
					$barangSql = "UPDATE barang SET stok=stok - $tmpRow[qty] WHERE kd_barang='$tmpRow[kd_barang]'";
		  			mysql_query($barangSql, $koneksidb) or die ("Gagal Query Edit Stok".mysql_error());
				}
				# Kosongkan Tmp jika datanya sudah dipindah
				mysql_query("DELETE FROM tmp_penjualan WHERE userid='".$_SESSION['SES_LOGIN']."'", $koneksidb) or die ("Gagal kosongkan tmp".mysql_error());
				
				// Refresh form
				echo "<meta http-equiv='refresh' content='0; url=nota_penjualan.php?noNota=$kodeBaru'>";
			}
			else{
				$message[] = "Gagal penyimpanan ke database";
			}
		}	
	}  
	// ============================================================================

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
	// ============================================================================

	} // Penutup POST
} // Penutup GET

# TAMPILKAN DATA KE FORM
$nomorTransaksi = buatKode("penjualan", "JL");
$tglTransaksi 	= isset($_POST['cmbTanggal']) ? $_POST['cmbTanggal'] : date('d-m-Y');
$dataPelanggan	= isset($_POST['txtPelanggan']) ? $_POST['txtPelanggan'] : 'Umum';
$dataCatatan	= isset($_POST['txtCatatan']) ? $_POST['txtCatatan'] : '';
?>
<form action="?page=Penjualan-Barang" method="post"  name="frmadd">
<table width="750" cellspacing="1" class="table-common" style="margin-top:0px;">
	<tr>
	  <td colspan="3" align="right"><h1>TRANSAKSI PENJUALAN BARANG</h1> </td>
	</tr>
	<tr>
	  <td width="20%"><b>No Penjualan </b></td>
	  <td width="1%"><b>:</b></td>
	  <td width="79%"><input name="txtNomor" value="<?php echo $nomorTransaksi; ?>" size="9" maxlength="9" readonly="readonly"/></td></tr>
	<tr>
      <td><b>Tanggal Penjualan </b></td>
	  <td><b>:</b></td>
	  <td><?php echo form_tanggal("cmbTanggal",$tglTransaksi); ?></td>
    </tr>
	<tr>
      <td><b>Pelanggan</b></td>
	  <td><b>:</b></td>
	  <td><input name="txtPelanggan" value="<?php echo $dataPelanggan; ?>" size="30" maxlength="30" 
	  			 onBlur="if (value == '') {value = 'Umum'}" 
      		 	 onfocus="if (value == 'Umum') {value =''}"/> 
      * Diisi nama pelanggan</td>
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
Qty :
<input class="angkaC" name="txtJumlah" size="2" maxlength="4" value="1" 
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
    <th colspan="9">DAFTAR  ITEM BARANG</th>
    </tr>
  <tr>
    <td width="20" align="center" bgcolor="#CCCCCC"><b>No</b></td>
    <td width="52" align="center" bgcolor="#CCCCCC"><b>Kode</b></td>
    <td width="268" bgcolor="#CCCCCC"><b>Nama Barang </b></td>
    <td width="80" align="right" bgcolor="#CCCCCC"><b>Harga</b></td>
    <td width="64" align="center" bgcolor="#CCCCCC"><strong>Disc (%)</strong> </td>
    <td width="75" align="right" bgcolor="#CCCCCC"><strong>Harga Disc</strong> </td>
    <td width="29" align="center" bgcolor="#CCCCCC"><b>Qty</b></td>
    <td width="71" align="right" bgcolor="#CCCCCC"><b>Subtotal</b></td>
    <td width="45" align="center" bgcolor="#FFCC00"><b>Delete</b></td>
  </tr>
<?php
$tmpSql ="SELECT barang.*, tmp_penjualan.id, tmp_penjualan.harga_jual As harga_jdisc, tmp_penjualan.qty 
		FROM barang, tmp_penjualan
		WHERE barang.kd_barang=tmp_penjualan.kd_barang AND tmp_penjualan.userid='".$_SESSION['SES_LOGIN']."'
		ORDER BY barang.kd_barang ";
$tmpQry = mysql_query($tmpSql, $koneksidb) or die ("Gagal Query Tmp".mysql_error());
$total = 0; $qtyBrg = 0; $nomor=0;
while($tmpRow = mysql_fetch_array($tmpQry)) {
	$ID		= $tmpRow['id'];
	$subSotal = $tmpRow['qty'] * $tmpRow['harga_jdisc'];
	$total 	= $total + ($tmpRow['qty'] * $tmpRow['harga_jdisc']);
	$qtyBrg = $qtyBrg + $tmpRow['qty'];
	
	$nomor++;
?>
  <tr>
    <td align="center"><b><?php echo $nomor; ?></b></td>
    <td align="center"><b><?php echo $tmpRow['kd_barang']; ?></b></td>
    <td><?php echo $tmpRow['nm_barang']; ?></td>
    <td align="right"><?php echo format_angka($tmpRow['harga_jual']); ?></td>
    <td align="center"><?php echo $tmpRow['diskon']; ?></td>
    <td align="right"><?php echo format_angka($tmpRow['harga_jdisc']); ?></td>
    <td align="center"><?php echo $tmpRow['qty']; ?></td>
    <td align="right"><?php echo format_angka($subSotal); ?></td>
    <td align="center" bgcolor="#FFFFCC"><a href="?page=Penjualan-Barang&Act=Delete&ID=<?php echo $ID; ?>" target="_self"><img src="images/hapus.gif" width="16" height="16" border="0" /></a></td>
  </tr>
<?php 
}?>
  <tr>
    <td colspan="6" align="right"><b>Grand Total : </b></td>
    <td align="center"><b><?php echo $qtyBrg; ?></b></td>
    <td align="right"><b><?php echo format_angka($total); ?></b></td>
    <td align="center">&nbsp;</td>
  </tr>
</table>
</form>
