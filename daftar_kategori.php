<?php
include_once "library/inc.sesadmin.php";
include_once "library/inc.library.php";
?>
<h2> DAFTAR KATEGORI </h2>
<table class="table-list" width="600" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="31" align="center" bgcolor="#CCCCCC"><b>No</b></td>
    <td width="366" bgcolor="#CCCCCC"><b>Nama Kategori </b></td>
    <td width="84" align="center" bgcolor="#CCCCCC"><b>Qty Barang</b> </td>  
  </tr>
  <?php
	$kategoriSql = "SELECT kategori.*, 
					(SELECT COUNT(*) FROM barang WHERE barang.kd_kategori=kategori.kd_kategori) As qty_barang
					FROM kategori ORDER BY kd_kategori ASC";
	$kategoriQry = mysql_query($kategoriSql, $koneksidb)  or die ("Query kategori salah : ".mysql_error());
	$nomor  = 0; 
	while ($kategoriRow = mysql_fetch_array($kategoriQry)) {
	$nomor++;
	$Kode = $kategoriRow['kd_kategori'];
  ?>
  <tr>
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo $kategoriRow['nm_kategori']; ?></td>
    <td align="center"><?php echo $kategoriRow['qty_barang']; ?></td>
  </tr>
  <?php } ?>
</table>