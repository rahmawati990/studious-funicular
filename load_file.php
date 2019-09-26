<?php
if($_GET) {
	switch ($_GET['page']){				
		case '' :				
			if(!file_exists ("main.php")) die ("Empty Main Page!"); 
			include "main.php";						
		break;
		case 'HalamanUtama' :				
			if(!file_exists ("main.php")) die ("Sorry Empty Page!"); 
			include "main.php";						
		break;			
		case 'Login' :				
			if(!file_exists ("login.php")) die ("Sorry Empty Page!"); 
			include "login.php";						
		break;
		case 'Login-Validasi' :				
			if(!file_exists ("login_validasi.php")) die ("Sorry Empty Page!"); 
			include "login_validasi.php";						
		break;
		case 'Logout' :				
			if(!file_exists ("login_out.php")) die ("Sorry Empty Page!"); 
			include "login_out.php";						
		break;		

		# USER LOGIN
		case 'Data-User' :				
			if(!file_exists ("user_data.php")) die ("Sorry Empty Page!"); 
			include "user_data.php";	 break;		
		case 'Add-User' :				
			if(!file_exists ("user_add.php")) die ("Sorry Empty Page!"); 
			include "user_add.php";	 break;		
		case 'Delete-User' :				
			if(!file_exists ("user_delete.php")) die ("Sorry Empty Page!"); 
			include "user_delete.php"; break;		
		case 'Edit-User' :				
			if(!file_exists ("user_edit.php")) die ("Sorry Empty Page!"); 
			include "user_edit.php"; break;	

		# USER SUPPLIER / PEMASOK
		case 'Data-Supplier' :				
			if(!file_exists ("supplier_data.php")) die ("Sorry Empty Page!"); 
			include "supplier_data.php";	 break;		
		case 'Add-Supplier' :				
			if(!file_exists ("supplier_add.php")) die ("Sorry Empty Page!"); 
			include "supplier_add.php";	 break;		
		case 'Delete-Supplier' :				
			if(!file_exists ("supplier_delete.php")) die ("Sorry Empty Page!"); 
			include "supplier_delete.php"; break;		
		case 'Edit-Supplier' :				
			if(!file_exists ("supplier_edit.php")) die ("Sorry Empty Page!"); 
			include "supplier_edit.php"; break;	
			
		# DATA KATEGORI
		case 'Data-Kategori' :				
			if(!file_exists ("kategori_data.php")) die ("Sorry Empty Page!"); 
			include "kategori_data.php"; break;		
		case 'Add-Kategori' :				
			if(!file_exists ("kategori_add.php")) die ("Sorry Empty Page!"); 
			include "kategori_add.php"; break;		
		case 'Delete-Kategori' :				
			if(!file_exists ("kategori_delete.php")) die ("Sorry Empty Page!"); 
			include "kategori_delete.php"; break;		
		case 'Edit-Kategori' :				
			if(!file_exists ("kategori_edit.php")) die ("Sorry Empty Page!"); 
			include "kategori_edit.php"; break;		
		
		# DATA BARANG
		case 'Data-Barang' :				
			if(!file_exists ("barang_data.php")) die ("Sorry Empty Page!"); 
			include "barang_data.php"; break;		
		case 'Add-Barang' :				
			if(!file_exists ("barang_add.php")) die ("Sorry Empty Page!"); 
			include "barang_add.php"; break;		
		case 'Delete-Barang' :				
			if(!file_exists ("barang_delete.php")) die ("Sorry Empty Page!"); 
			include "barang_delete.php"; break;		
		case 'Edit-Barang' :				
			if(!file_exists ("barang_edit.php")) die ("Sorry Empty Page!"); 
			include "barang_edit.php"; break;		
		
		# DATA PEMBELIAN BARANG (BARANG MASUK)	
		case 'Pembelian-Barang' :				
			if(!file_exists ("transaksi_pembelian.php")) die ("Sorry Empty Page!"); 
			include "transaksi_pembelian.php"; break;		
			
		# DATA PENJUALAN BARANG (BARANG MASUK)	
		case 'Penjualan-Barang' :				
			if(!file_exists ("transaksi_penjualan.php")) die ("Sorry Empty Page!"); 
			include "transaksi_penjualan.php"; break;		

		# MASTER DATA
		case 'Laporan-Data' :				
				echo "<ul><li><a href='?page=Daftar-Supplier' title='Daftar Supplier'>Laporan Daftar Supplier</a></li>";
				echo "<li><a href='?page=Daftar-Kategori' title='Daftar Kategori'>Laporan Daftar Kategori</a></li>";
				echo "<li><a href='?page=Daftar-Barang' title='Daftar Barang'>Laporan Daftar Barang</a></li>";
				echo "<li><a href='?page=Daftar-Barang-Kategori' title='Daftar Barang'>Laporan Daftar Barang Per Kategori</a></li>";
				echo "<li><a href='?page=Daftar-Pembelian' title='Daftar Pembelian'>Laporan Transaksi Pembelian</a></li>";
				echo "<li><a href='?page=Daftar-Penjualan' title='Daftar Penjualan'>Laporan Transaksi Penjualan</a></li>";
				echo "<li><a href='?page=Lap-Penjualan-Perperiode' title='Daftar Penjualan Periode'>Laporan Transaksi Penjualan Periode</a></li>";
				echo "<li><a href='?page=Daftar-Petugas' title='Daftar Petugas'>Daftar Petugas</a></li></ul>";
		break;		
		
		# INFORMASI DAN LAPORAN
		case 'Daftar-Supplier' :				
			if(!file_exists ("daftar_supplier.php")) die ("Sorry Empty Page!"); 
			include "daftar_supplier.php"; break;		
		case 'Daftar-Kategori' :				
			if(!file_exists ("daftar_kategori.php")) die ("Sorry Empty Page!"); 
			include "daftar_kategori.php"; break;		
		case 'Daftar-Barang' :				
			if(!file_exists ("daftar_barang.php")) die ("Sorry Empty Page!"); 
			include "daftar_barang.php"; break;		
		case 'Daftar-Barang-Kategori' :				
			if(!file_exists ("daftar_barang_kategori.php")) die ("Sorry Empty Page!"); 
			include "daftar_barang_kategori.php"; break;		
		case 'Daftar-Barang-Kategori-Show' :				
			if(!file_exists ("daftar_barang_kategori_show.php")) die ("Sorry Empty Page!"); 
			include "daftar_barang_kategori_show.php"; break;		
		case 'Daftar-Petugas' :				
			if(!file_exists ("daftar_petugas.php")) die ("Sorry Empty Page!"); 
			include "daftar_petugas.php"; break;		
		case 'Daftar-Pembelian' :				
			if(!file_exists ("daftar_pembelian.php")) die ("Sorry Empty Page!"); 
			include "daftar_pembelian.php"; break;		
		case 'Daftar-Pembelian-List' :				
			if(!file_exists ("daftar_pembelian_list.php")) die ("Sorry Empty Page!"); 
			include "daftar_pembelian_list.php"; break;		
		case 'Daftar-Penjualan' :				
			if(!file_exists ("daftar_penjualan.php")) die ("Sorry Empty Page!"); 
			include "daftar_penjualan.php"; break;		
		case 'Daftar-Penjualan-List' :				
			if(!file_exists ("daftar_penjualan_list.php")) die ("Sorry Empty Page!"); 
			include "daftar_penjualan_list.php"; break;				
		case 'Lap-Penjualan-Perperiode' :				
			if(!file_exists ("daftar_penjualan_per_periode.php")) die ("Sorry Empty Page!"); 
			include "daftar_penjualan_per_periode.php"; break;		
						
		default:
			if(!file_exists ("main.php")) die ("Empty Main Page!"); 
			include "main.php";						
		break;
	}
}
?>