<?php
include_once "library/inc.sesadmin.php";
include_once "library/inc.library.php";

$SqlPeriode = ""; $startTgl=""; $endTgl="";

# Set Tanggal skrg
$tglStart 	= isset($_POST['cmbTglStart']) ? $_POST['cmbTglStart'] : date('d-m-Y');
$tglEnd 	= isset($_POST['cmbTglEnd']) ? $_POST['cmbTglEnd'] : date('d-m-Y');

# Jika Nomor Page (halaman) diklik
if($_GET) {
	if (isset($_POST['btnShow'])) {
		$SqlPeriode = "AND ( T2.tgl_transaksi BETWEEN '".InggrisTgl($_POST['cmbTglStart'])."' AND '".InggrisTgl($_POST['cmbTglEnd'])."')";
	}
	else {
		$startTgl 	= isset($_GET['startTgl']) ? $_GET['startTgl'] : $tglStart;
		$endTgl 	= isset($_GET['endTgl']) ? $_GET['endTgl'] : $tglEnd; 
		$SqlPeriode = " AND ( T2.tgl_transaksi BETWEEN '".InggrisTgl($startTgl)."' AND '".InggrisTgl($endTgl)."')";
	}
}

# UNTUK PAGING (PEMBAGIAN HALAMAN)
$row = 20;
$hal = isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql = "SELECT T2.tgl_transaksi, T1.*, 
			SUM(T3.jumlah) As terjual, 
			ROUND((T1.harga_jual - (T1.harga_jual * (T1.diskon / 100))) * T3.jumlah) AS subtotal
			 FROM barang As T1, 
				  penjualan As T2, 
				   penjualan_item As T3
			 WHERE T1.kd_barang = T3.kd_barang 
			 AND T2.no_penjualan 	 = T3.no_penjualan 	$SqlPeriode
			 GROUP BY T1.kd_barang, T2.tgl_transaksi";
$pageQry = mysql_query($pageSql, $koneksidb) or die ("error paging: ".mysql_error());
$jml	 = mysql_num_rows($pageQry);
$max	 = ceil($jml/$row);
?>
<h2>LAPORAN PENJUALAN PER PERIODE</h2>
<form action="?page=Lap-Penjualan-Perperiode" method="post" name="form1" target="_self" id="form1">
  <table width="500" border="0"  class="table-list">
    <tr>
      <td colspan="3" bgcolor="#CCCCCC"><strong>PERIODE TANGGAL </strong></td>
    </tr>
    <tr>
      <td width="90"><strong>Periode </strong></td>
      <td width="5"><strong>:</strong></td>
      <td width="391"><?php echo form_tanggal("cmbTglStart",$tglStart); ?> s/d <?php echo form_tanggal("cmbTglEnd",$tglEnd); ?>
      <input name="btnShow" type="submit" value=" Tampilkan " /></td>
    </tr>
  </table>
</form>
<table class="table-list" width="859" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="25" align="center" bgcolor="#CCCCCC"><b>No</b></td>
    <td width="54" align="center" bgcolor="#CCCCCC"><strong>Tanggal</strong></td>
    <td width="54" align="center" bgcolor="#CCCCCC"><b>Kode</b></td>
    <td width="298" bgcolor="#CCCCCC"><b>Nama Barang </b></td>
    <td width="118" align="right" bgcolor="#CCCCCC"><b>Harga Beli  (Rp)</b></td>  
    <td width="125" align="right" bgcolor="#CCCCCC"><b>Harga Jual (Rp)</b></td>
    <td width="64" align="center" bgcolor="#CCCCCC"><b>Disc (%)</b></td>
    <td width="80" align="center" bgcolor="#CCCCCC"><b>Qty Terjual</b></td>
  </tr>
	<?php
	# Query utama. Query ini sama dg yg dipakai Paging di atas
	$dataSql = "SELECT T2.tgl_transaksi, T1.*, 
        SUM(T3.jumlah) As terjual, 
        ROUND((T1.harga_jual - (T1.harga_jual * (T1.diskon / 100))) * T3.jumlah) AS subtotal
		 FROM barang As T1, 
			  penjualan As T2, 
			   penjualan_item As T3
		 WHERE T1.kd_barang = T3.kd_barang 
		 AND T2.no_penjualan 	 = T3.no_penjualan 	$SqlPeriode
		 GROUP BY T1.kd_barang, T2.tgl_transaksi ORDER BY T2.tgl_transaksi ASC LIMIT $hal, $row";
 
	$dataQry = mysql_query($dataSql, $koneksidb) or die ("Error Query".mysql_error());
	$nomor = 0;
	while ($dataRow = mysql_fetch_array($dataQry)) {
		$nomor++;
	?>
  <tr>
    <td align="center"><?php echo $nomor; ?></td>
    <td align="center"><?php echo IndonesiaTgl($dataRow['tgl_transaksi']); ?></td>
    <td align="center"><?php echo $dataRow['kd_barang']; ?></td>
    <td><?php echo $dataRow['nm_barang']; ?></td>
    <td align="right"><?php echo format_angka($dataRow['harga_beli']); ?></td>
    <td align="right"><?php echo format_angka($dataRow['harga_jual']); ?></td>
    <td align="center"><?php echo $dataRow['diskon']; ?></td>
    <td align="center"><?php echo $dataRow['terjual']; ?></td>
  </tr>
  <?php } ?>
  <tr>
    <td colspan="3"><b>Jumlah Data :</b> <?php echo $jml; ?> </td>
    <td>&nbsp;</td>
    <td colspan="4" align="right"><b>Halaman ke :</b>
      <?php
	for ($h = 1; $h <= $max; $h++) {
		$list[$h] = $row * $h - $row;
		echo " <a href='?page=Lap-Penjualan-Perperiode&hal=$list[$h]&startTgl='>$h</a> ";
	}
	?></td>
  </tr>
</table>
