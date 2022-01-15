<?php

namespace App\Models;

use CodeIgniter\Model;

class DataModel extends Model
{
  protected $table      = 'data';
  protected $primaryKey = 'id';

  protected $returnType     = 'object';
  protected $useSoftDeletes = true;

  protected $allowedFields = ['no', 'tahun', 'receipt_number', 'staff', 'tanggal', 'pukul', 'item_produk', 'jumlah', 'harga', 'created_at', 'updated_at', 'deleted_at'];

  protected $useTimestamps = true;
  protected $createdField  = 'created_at';
  protected $updatedField  = 'updated_at';
  protected $deletedField  = 'deleted_at';


  public function tanggal_awal_default()
  {
    //mengambil tanggal awal dari tb_data sebagai tanggal awal default
    $tanggal_awal = $this->db->query("SELECT MIN(tanggal) as tgl FROM data");
    $hasil = $tanggal_awal->getResultObject();
    foreach ($hasil as $t) {
      $tgl_awal = $t->tgl;
    }
    return $tgl_awal;
  }

  public function tanggal_akhir_default()
  {
    //mengambil tanggal akhir dari tb_data sebagai tanggal akhir default
    $tanggal_akhir = $this->db->query("SELECT MAX(tanggal) as tgl FROM data");
    $hasil = $tanggal_akhir->getResultObject();
    foreach ($hasil as $t) {
      $tgl_akhir = $t->tgl;
    }
    return $tgl_akhir;
  }


  public function hapus_data($tanggal_awal, $tanggal_akhir)
  {
    //mengambil data dari data berdasarkan tanggal inputan
    return $this->db->query("DELETE from data WHERE tanggal>='$tanggal_awal' AND tanggal<='$tanggal_akhir'");
  }


  public function getDataProcessing($tanggal_awal, $tanggal_akhir)
  {
    //mengambil data dari data berdasarkan tanggal inputan
    $query   = $this->db->query("SELECT sum(jumlah) as item, jumlah, item_produk, harga from data WHERE tanggal>='$tanggal_awal' AND tanggal<='$tanggal_akhir' GROUP BY item_produk");
    $hasil = $query->getResultObject();
    $sql = "INSERT INTO hasil_processing(item_produk, jumlah, harga) VALUES ";
    foreach ($hasil as $key) {
      $harga = intval(($key->harga) / $key->jumlah) / 1000;
      $sql .= "('" . $key->item_produk . "'," . intval($key->item) . "," . $harga . "), ";
    }
    $sql = rtrim($sql, ', ');
    $this->db->query($sql);
  }


  public function simpanTanggalData($tanggal_awal, $tanggal_akhir)
  {
    $query = "UPDATE options SET tgl_awal ='" . $tanggal_awal . "', tgl_akhir = '" . $tanggal_akhir . "' WHERE
    id=1";
    $this->db->query($query);
  }


  function getDataHasilProcessing()
  {
    $query = $this->db->query('SELECT id_processing, item_produk, jumlah, harga FROM hasil_processing');
    $hasil = $hasil = $query->getResultObject();
    return $hasil;
  }


  function tampil_data()
  {
    $query   = $this->db->query('SELECT id, receipt_number, staff, tanggal, pukul, item_produk, jumlah, harga FROM data');
    $hasil = $query->getResultArray();
    return $hasil;
  }


  function jumlah_transaksi()
  {
    $query   = $this->db->query('SELECT COUNT(receipt_number) FROM data GROUP BY receipt_number');
    $hasil = $query->getResultArray();
    return $hasil;
  }

  function jumlah_menu()
  {
    $query   = $this->db->query('SELECT COUNT(item_produk) FROM data GROUP BY item_produk');
    $hasil = $query->getResultObject();
    return $hasil;
  }

  function jumlah_paket()
  {
    $query   = $this->db->query('SELECT id_hasil FROM hasil_asosiasi');
    $hasil = $query->getResultObject();
    return $hasil;
  }

  function produk_peritem()
  {
    return $this->db->query("SELECT item, item_produk, harga from data_produk GROUP BY item_produk")->getResultObject();
  }

  function produk_peritem_urut()
  {
    return $this->db->query("SELECT sum(jumlah) as item, item_produk, harga, jumlah from data GROUP BY item_produk order by item desc")->getResultObject();
  }

  function produk_laris()
  {
    return $this->db->query("SELECT sum(jumlah) as item, item_produk from data GROUP BY item_produk ORDER BY item DESC limit 5")->getResultObject();
  }

  function produk_kurang_laris()
  {
    return $this->db->query("SELECT sum(jumlah) as item, item_produk from data GROUP BY item_produk ORDER BY item ASC limit 5")->getResultObject();
  }

  function produk_jenis()
  {
    return $this->db->query("SELECT sum(item) as jumlahs, count(jenis) as jumlah, jenis from data_produk group by jenis")->getResultObject();
  }



  function tampil_produk()
  {
    return $this->db->query("SELECT id, item, item_produk, harga, jenis from data_produk")->getResultObject();
  }

  function buat_tampil_produk()
  {
    $query = $this->db->query("SELECT sum(jumlah) as item, item_produk, (harga/jumlah) as price, jenis from data GROUP BY item_produk");
    $sql = "INSERT INTO data_produk(item, item_produk, harga) VALUES ";
    foreach ($query->getResultObject() as $key) {
      $sql .= "(" . $key->item . ",'" . $key->item_produk . "','" . $key->price . "'), ";
    }
    $sql = rtrim($sql, ', ');
    $this->db->query($sql);
  }

  function ubah_jenis_produk($jenis, $id)
  {
    $jumlah_dipilih = count($id);
    for ($x = 0; $x < $jumlah_dipilih; $x++) {
      $query = "UPDATE data_produk SET jenis ='" . $jenis . "' WHERE id='$id[$x]'";
      $this->db->query($query);
    }
  }



  function tampil_hasil_jumlah_data_klaster()
  {
    return $this->db->query("SELECT id from data_klaster")->getResultObject();
  }

  function tampil_hasil_jumlah_klaster()
  {
    $query = $this->db->query("SELECT klaster from options");
    foreach ($query->getResultObject() as $t) {
      $hasil = $t->klaster;
    }
    return $hasil;
  }

  function tampil_hasil_jumlah_data($tanggal_awal, $tanggal_akhir)
  {
    return $this->db->query("SELECT id from data where tanggal>='$tanggal_awal' AND tanggal<='$tanggal_akhir'")->getResultObject();
  }

  function tampil_hasil_jumlah_data_transaksi($tanggal_awal, $tanggal_akhir)
  {
    return $this->db->query("SELECT id from data where tanggal>='$tanggal_awal' AND tanggal<='$tanggal_akhir' group by receipt_number")->getResultObject();
  }

  function tampil_hasil_jumlah_data_transaksi_klaster()
  {
    return $this->db->query("SELECT id from data_klaster group by receipt_number")->getResultObject();
  }
}
