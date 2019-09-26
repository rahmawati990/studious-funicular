<?php
include_once "library/inc.sesadmin.php";
include_once "library/inc.library.php";
?>
<h2> DAFTAR TRANSAKSI PENJUALAN </h2>
<table class="table-list" width="600" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="23" align="center" bgcolor="#CCCCCC"><b>No</b></td>
    <td width="66" bgcolor="#CCCCCC"><b>Tanggal</b></td>
    <td width="94" bgcolor="#CCCCCC"><b>Nomor Jual </b> </td>  
    <td width="180" bgcolor="#CCCCCC"><b>Pelanggan </b></td>
    <td width="88" bgcolor="#CCCCCC"><b>Petugas</b></td>
    <td width="38" align="center" bgcolor="#CCCCCC"><b>View</b></td>
  </tr>
<?php
	# Perintah untuk menampilkan Semua Daftar Transaksi Penjualan
	$jualSql = "SELECT * FROM penjualan ORDER BY no_penjualan ASC";
	$jualQry = mysql_query($jualSql, $koneksidb)  or die ("Query penjualan salah : ".mysql_error());
	$nomor  = 0; 
	while ($jualRow = mysql_fetch_array($jualQry)) {
	$nomor++;
	
	# Membaca Kode Penjualan/ Nomor transaksi
	$Kode = $jualRow['no_penjualan'];
?>
  <tr>
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo IndonesiaTgl($jualRow['tgl_transaksi']); ?></td>
    <td><?php echo $jualRow['no_penjualan']; ?></td>
    <td><?php echo $jualRow['pelanggan']; ?></td>
    <td><?php echo $jualRow['userid']; ?></td>
    <td align="center"><a href="?page=Daftar-Penjualan-List&amp;Kode=<?php echo $Kode; ?>" target="_self" alt="Daftar Penjualan"><img src="images/btn_view.png" width="20" height="20" border="0" /></a></td>
  </tr>
  <?php } ?>
</table>