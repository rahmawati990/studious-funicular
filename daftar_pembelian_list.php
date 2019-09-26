<?php
include_once "library/inc.sesadmin.php";
include_once "library/inc.library.php";

# Baca variabel URL
$kodeTransaksi = $_GET['Kode'];

# Perintah untuk mendapatkan data dari tabel Pembelian
$beliSql = "SELECT pembelian.*, supplier.nm_supplier FROM pembelian, supplier 
			WHERE pembelian.kd_supplier=supplier.kd_supplier 
			AND pembelian.no_pembelian='$kodeTransaksi'";
$beliQry = mysql_query($beliSql, $koneksidb)  or die ("Query pembelian salah : ".mysql_error());
$beliRow = mysql_fetch_array($beliQry);
?>
<table width="500" border="0" cellpadding="2" cellspacing="1" class="table-list">
<tr>
  <th colspan="3"><b>TRANSAKSI PEMBELIAN </b></th>
</tr>
<tr>
  <td width="155"><b>No Pembelian </b></td>
  <td width="5"><b>:</b></td>
  <td width="326"> <?php echo $beliRow['no_pembelian']; ?> </td>
</tr>
<tr>
  <td><b>Tanggal</b></td>
  <td><b>:</b></td>
  <td><?php echo IndonesiaTgl($beliRow['tgl_transaksi']); ?></td>
</tr>
<tr>
  <td><b>Supplier</b></td>
  <td><b>:</b></td>
  <td><?php echo $beliRow['nm_supplier']; ?></td>
</tr>
<tr>
  <td><b>Petugas</b></td>
  <td><b>:</b></td>
  <td><?php echo $beliRow['userid']; ?></td>
</tr>
</table>
  
<h2> Daftar Barang</h2>
<table class="table-list" width="700" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="24" align="center" bgcolor="#CCCCCC"><b>No</b></td>
    <td width="60" align="center" bgcolor="#CCCCCC"><b>Kode</b></td>
    <td width="295" bgcolor="#CCCCCC"><b>Nama Barang </b></td>
    <td width="120" align="center" bgcolor="#CCCCCC"><b>Harga Beli  (Rp)</b></td>
    <td width="50" align="right" bgcolor="#CCCCCC"><b>Jumlah</b></td>  
    <td width="120" align="right" bgcolor="#CCCCCC"><b>Subtotal (Rp)</b></td>
  </tr>
<?php
	# Menampilkan List Item barang yang dibeli untuk Nomor Transaksi Terpilih
	$listBarangSql = "SELECT barang.nm_barang, pembelian_item.* FROM barang, pembelian_item 
					  WHERE barang.kd_barang=pembelian_item.kd_barang AND pembelian_item.no_pembelian='$kodeTransaksi'
					  ORDER BY barang.kd_barang ASC";
	$listBarangQry = mysql_query($listBarangSql, $koneksidb)  or die ("Query list barang salah : ".mysql_error());
	$nomor  = 0; $totalBelanja = 0;
	while ($listBarangRow = mysql_fetch_array($listBarangQry)) {
	$nomor++;
	# Membuat Subtotal
	$subtotal  = intval($listBarangRow['harga_beli']) * intval($listBarangRow['jumlah']);  
	
	# Menghitung Total Belanja keseluruhan
	$totalBelanja = $totalBelanja + intval($subtotal);
?>
  <tr>
    <td align="center"><?php echo $nomor; ?></td>
    <td align="center"><?php echo $listBarangRow['kd_barang']; ?></td>
    <td><?php echo $listBarangRow['nm_barang']; ?></td>
    <td align="center"><?php echo format_angka($listBarangRow['harga_beli']); ?></td>
    <td align="right"><?php echo $listBarangRow['jumlah']; ?></td>
    <td align="right"><?php echo format_angka($subtotal); ?></td>
  </tr>
  <?php } ?>
  <tr>
    <td colspan="5" align="right"><b>Grand Total Belanja (Rp) : </b></td>
    <td align="right"><b><?php echo format_angka($totalBelanja); ?></b></td>
  </tr>
</table>
