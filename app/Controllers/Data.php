<?php

namespace App\Controllers;

use Irsyadulibad\DataTables\DataTables;
use App\Models\DataModel;

class Data extends BaseController
{
  protected $m_data;

  public function __construct()
  {
    $this->m_data = new DataModel();
    $this->db = \Config\Database::connect();
  }

  // menampilkan detail data transaksi
  public function index()
  {
    $var['title']  = "Data Detail Transaksi";
    $var['tanggal_awal'] =  $this->m_data->tanggal_awal_default();
    $var['tanggal_akhir'] =  $this->m_data->tanggal_akhir_default();

    return view('data/index', $var);
  }

  // menampilkan tabel detail data transaksi
  public function ajaxLoadData()
  {
		  return DataTables::use('data')->select('id, receipt_number,staff,tanggal,pukul,item_produk,jumlah,harga, (harga/jumlah) as perharga')
			->make(true);
  }

  // menampilkan data transaksi
  public function tampil_data_transaksi()
  {
    $var['title']  = "Data Transaksi";
    $var['data'] = $this->m_data->tampil_data();
    return view('data/transaksi', $var);
  }


  public function hapus_data()
  {
    $tanggal_awal =  $this->request->getVar('tanggal_awal');
    $tanggal_akhir =  $this->request->getVar('tanggal_akhir');
    $this->m_data->hapus_data($tanggal_awal, $tanggal_akhir);
    $this->db->query("ALTER TABLE data DROP id");
    $this->db->query("ALTER TABLE data ADD id INT NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST");

    return redirect()->back();
  }


  // menampilkan data produk
  public function tampil_produk()
  {
    $var['title']  = "Data Produk";
    $var['produk'] = $this->m_data->tampil_produk();
    return view('data/produk', $var);
  }

  public function ubah_jenis_produk()
  {
    $jenis  =  $this->request->getVar('jenis');
    $id =  $this->request->getVar('produk');
    $this->m_data->ubah_jenis_produk($jenis, $id);
    return redirect()->back();
  }




  //import file csv untuk dilakukan proses simpan ke database
  public function upload_data()
  {
    $input = $this->validate([
      'file' => 'uploaded[file]|max_size[file,2048]|ext_in[file,csv],'
    ]);

    if (!$input) {
      $var['title'] = "Data Transaksi";
      $var['data']  = $this->m_data->tampil_data();
      $var['tanggal_awal'] =  $this->m_data->tanggal_awal_default();
      $var['tanggal_akhir'] =  $this->m_data->tanggal_akhir_default();
      session()->setFlashdata('message', 'CSV file coud not be imported.');
      session()->setFlashdata('alert-class', 'alert-danger');
      return view('/data/index', $var);
    } else {

      if ($file = $this->request->getFile('file')) {

        $file_name = $file->getTempName();
        $datas = array();
        $csv_data = array_map('str_getcsv', file($file_name));

        if (count($csv_data) > 0) {
          $index = 0;
          foreach ($csv_data as $data) {
            if ($index > 0) {
              $date = date_create($data[3], timezone_open("Europe/Oslo"));
              $datas[] = array(
                "receipt_number"  => $data[1],
                "staff"           => $data[2],
                "tanggal"         => date_format($date, "Y-m-d"),
                "pukul"           => $data[4],
                "item_produk"     => $data[5],
                "jumlah"          => $data[6],
                "harga"           => $data[7],
              );
            }
            $index++;
          }

          $builder = $this->db->table('data');
          $builder->insertBatch($datas);

          $this->db->query('TRUNCATE TABLE data_produk');
          $this->m_data->buat_tampil_produk();

          session()->setFlashdata('message', $index . ' rows successfully added.');
          session()->setFlashdata('alert-class', 'alert-success');

          return redirect()->to(base_url('/data'));
        }
      }
      session()->setFlashdata('message', 'CSV file coud not be imported.');
      session()->setFlashdata('alert-class', 'alert-danger');
      return view("/data");
    }
  }

}
