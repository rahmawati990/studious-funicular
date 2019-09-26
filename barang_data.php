<?php
include_once "library/inc.sesadmin.php";
include_once "library/inc.library.php";

# UNTUK PAGING (PEMBAGIAN HALAMAN)
$row = 20;
$hal = isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql = "SELECT * FROM barang";
$pageQry = mysql_query($pageSql, $koneksidb) or die ("error paging: ".mysql_error());
$jml	 = mysql_num_rows($pageQry);
$max	 = ceil($jml/$row);
?>
<table width="800" border="0" cellpadding="2" cellspacing="1" class="table-border">
  <tr>
    <td colspan="2" align="right"><h1><b>DATA BARANG </b></h1></td>
  </tr>
  <tr>
    <td colspan="2"><a href="?page=Add-Barang" target="_self"><img src="images/btn_add_data2.png" height="25" border="0" /></a></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">
	<table class="table-list" width="100%" border="0" cellspacing="1" cellpadding="2">
      <tr>
        <th width="23" align="center"><b>No</b></th>
        <th width="57" align="center">Kode</th>
        <th width="333"><b>Nama Barang </b></th>
        <th width="90" align="right"><b> Beli  (Rp) </b></th>
        <th width="90" align="right"><b> Jual (Rp)</b> </th>
        <th width="72"><b>Disc (%)</b> </th>
        <td width="41" align="center" bgcolor="#CCCCCC"><b>Edit</b></td>
        <td width="47" align="center" bgcolor="#CCCCCC"><b>Delete</b></td>
      </tr>
      <?php
	$barangSql = "SELECT * FROM barang ORDER BY (SUBSTR(kd_barang,3) + 0) ASC LIMIT $hal, $row";
	$barangQry = mysql_query($barangSql, $koneksidb)  or die ("Query barang salah : ".mysql_error());
	$nomor  = 0; 
	while ($barangRow = mysql_fetch_array($barangQry)) {
	$nomor++;
	$Kode = $barangRow['kd_barang'];
	?>
      <tr>
        <td align="center"><b><?php echo $nomor; ?></b></td>
        <td align="center"><b><?php echo $barangRow['kd_barang']; ?></b></td>
        <td><?php echo $barangRow['nm_barang']; ?></td>
        <td align="right"><?php echo format_angka($barangRow['harga_beli']); ?></td>
        <td align="right"><?php echo format_angka($barangRow['harga_jual']); ?></td>
        <td align="center"><?php echo $barangRow['diskon']; ?> % </td>
        <td align="center"><a href="?page=Edit-Barang&amp;Kode=<?php echo $Kode; ?>" target="_self" alt="Edit Data"><img src="images/btn_edit.png" width="20" height="20" border="0" /></a></td>
        <td align="center"><a href="?page=Delete-Barang&amp;Kode=<?php echo $Kode; ?>" target="_self" alt="Delete Data" onclick="return confirm('ANDA YAKIN AKAN MENGHAPUS DATA PENTING INI ... ?')"><img src="images/btn_delete.png" width="20" height="20"  border="0"  alt="Delete Data" /></a></td>
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
		echo " <a href='?page=Data-Barang&hal=$list[$h]'>$h</a> ";
	}
	?>
	</td>
  </tr>
</table>
