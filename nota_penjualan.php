<?php
include_once "library/inc.connection.php";
include_once "library/inc.library.php";

# Baca variabel URL
$kodeTransaksi = $_GET['noNota'];

# Perintah untuk mendapatkan data dari tabel penjualan
$jualSql = "SELECT penjualan.*, user_login.nama FROM penjualan, user_login 
			WHERE penjualan.userid=user_login.userid AND no_penjualan='$kodeTransaksi'";
$jualQry = mysql_query($jualSql, $koneksidb)  or die ("Query penjualan salah : ".mysql_error());
$jualRow = mysql_fetch_array($jualQry);
?>
<html>
<head>
<title> :: Nota Penjualan - Butik Indah Way jepara</title>
<link href="styles/style.css" rel="stylesheet" type="text/css">
</head>
<body>
<table width="500" border="0" cellspacing="1" cellpadding="4" class="table-print">
  <tr>
    <td width="59" rowspan="2" align="center"><img src="images/logo_ib.png" width="104" height="86" /></td>
    <td width="208"><strong>
      <h3> BUTIK INDAH</h3>
    </strong></td>
    <td width="217"><strong>Way Jepara,</strong> <?php echo IndonesiaTgl($jualRow['tgl_transaksi']); ?></td>
  </tr>
  <tr>
    <td>Jl. Suhada, No 31, Labuhan Ratu Baru, Way Jepara, Lampung Timur <br> Telpon : 07241111111 </td>
    <td valign="top"><strong>Kepada Yth.</strong> <?php echo $jualRow['pelanggan']; ?> .. ..... ... .. ... ... .... . .... ... ... .. .... ..... ....... ....... .... ... ... ... ... .... .... ....</td>
  </tr>
</table>
<table class="table-list" width="500" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td colspan="5"><strong>No Nota : <?php echo $jualRow['no_penjualan']; ?></strong></td>
  </tr>
  <tr>
    <td width="32" align="center" bgcolor="#CCCCCC"><b>Qty</b></td>
    <td width="262" bgcolor="#CCCCCC"><b>Nama Barang </b></td>
    <td width="70" align="center" bgcolor="#CCCCCC"><b>Harga</b></td>
    <td width="40" align="right" bgcolor="#CCCCCC"><b>Disc</b></td>  
    <td width="70" align="right" bgcolor="#CCCCCC"><b>Subtotal</b></td>
  </tr>
	<?php
		# Menampilkan List Item barang yang dibeli untuk Nomor Transaksi Terpilih
		$notaSql = "SELECT barang.nm_barang, barang.diskon, penjualan_item.* FROM barang, penjualan_item
						  WHERE barang.kd_barang=penjualan_item.kd_barang AND penjualan_item.no_penjualan='$kodeTransaksi'
						  ORDER BY barang.kd_barang ASC";
		$notaQry = mysql_query($notaSql, $koneksidb)  or die ("Query list barang salah : ".mysql_error());
		$nomor  = 0;  $totalBelanja = 0;
		while ($notaRow = mysql_fetch_array($notaQry)) {
		$nomor++;
		# Hitung Diskon, dan Harga setelah diskon
		$besarDiskon = intval($notaRow['harga_jual']) * (intval($notaRow['diskon'])/100);
		$hargaDiskon = intval($notaRow['harga_jual']) - $besarDiskon;
		
		# Membuat Subtotal
		$subtotal  = $hargaDiskon * intval($notaRow['jumlah']); 
		# Menghitung Total Belanja keseluruhan
		$totalBelanja = $totalBelanja + intval($subtotal);
	?>
  <tr>
    <td align="center"><?php echo $notaRow['jumlah']; ?></td>
    <td><?php echo $notaRow['kd_barang'].": ".$notaRow['nm_barang']; ?></td>
    <td align="center"><?php echo format_angka($notaRow['harga_jual']); ?></td>
    <td align="right"><?php echo $notaRow['diskon']." %"; ?></td>
    <td align="right"><?php echo format_angka($subtotal); ?></td>
  </tr>
  <?php } ?>
  <tr>
    <td colspan="4" align="right"><b> Total Belanja (Rp) : </b></td>
    <td align="right" bgcolor="#CCFFFF"><b><?php echo format_angka($totalBelanja); ?></b></td>
  </tr>
</table>
<br/>
<table class="table-print" width="500" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="140" align="center">Tanda terima,<br /><br /><br /> 
    ( ............................ ) </td>
    <td width="204">&nbsp;</td>
    <td width="140" align="center">Hoarmat kami,<br /><br /><br /> 
	(  <?php echo $jualRow['nama']; ?> ) </td>
  </tr>
</table>
</body>
