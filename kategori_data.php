<?php
include_once "library/inc.sesadmin.php";
include_once "library/inc.library.php";

# UNTUK PAGING (PEMBAGIAN HALAMAN)
$row = 20;
$hal = isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql = "SELECT * FROM kategori";
$pageQry = mysql_query($pageSql, $koneksidb) or die ("error paging: ".mysql_error());
$jml	 = mysql_num_rows($pageQry);
$max	 = ceil($jml/$row);
?>
<table width="700" border="0" cellpadding="2" cellspacing="1" class="table-border">
  <tr>
    <td colspan="2" align="right"><h1><b>DATA KATEGORI</b></h1></td>
  </tr>
  <tr>
    <td colspan="2"><a href="?page=Add-Kategori" target="_self"><img src="images/btn_add_data2.png" height="25" border="0" /></a></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><table class="table-list" width="100%" border="0" cellspacing="1" cellpadding="2">
      <tr>
        <th width="32" align="center"><b>No</b></th>
        <th width="444"><b>Nama Kategori </b></th>
        <th width="93" align="center"><b>Qty Barang</b> </th>
        <td width="47" align="center" bgcolor="#CCCCCC"><b>Edit</b></td>
        <td width="52" align="center" bgcolor="#CCCCCC"><b>Delete</b></td>
      </tr>
      <?php
	$kategoriSql = "SELECT kategori.*, (SELECT COUNT(*) FROM barang WHERE barang.kd_kategori=kategori.kd_kategori) As qty_barang
					FROM kategori ORDER BY kd_kategori ASC LIMIT $hal, $row";
	$kategoriQry = mysql_query($kategoriSql, $koneksidb)  or die ("Query kategori salah : ".mysql_error());
	$nomor  = 0; 
	while ($kategoriRow = mysql_fetch_array($kategoriQry)) {
	$nomor++;
	$Kode = $kategoriRow['kd_kategori'];
	?>
      <tr>
        <td align="center"><b><?php echo $nomor; ?></b></td>
        <td><?php echo $kategoriRow['nm_kategori']; ?></td>
        <td align="center"><?php echo $kategoriRow['qty_barang']; ?></td>
        <td align="center"><a href="?page=Edit-Kategori&amp;Kode=<?php echo $Kode; ?>" target="_self" alt="Edit Data"><img src="images/btn_edit.png" width="20" height="20" border="0" /></a></td>
        <td align="center"><a href="?page=Delete-Kategori&amp;Kode=<?php echo $Kode; ?>" target="_self" alt="Delete Data" onclick="return confirm('ANDA YAKIN AKAN MENGHAPUS DATA PENTING INI ... ?')"><img src="images/btn_delete.png" width="20" height="20"  border="0"  alt="Delete Data" /></a></td>
      </tr>
      <?php } ?>
    </table></td>
  </tr>
  <tr>
    <td><b>Jumlah Data :</b> <?php echo $jml; ?> </td>
    <td align="right"><b>Halaman ke :</b> 
	<?php
	for ($h = 1; $h <= $max; $h++) {
		$list[$h] = $row * $h - $row;
		echo " <a href='?page=Data-Kategori&hal=$list[$h]'>$h</a> ";
	}
	?>
	</td>
  </tr>
</table>
