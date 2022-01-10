<?php

namespace App\Controllers;

use App\Models\DataModel;
use App\Models\KlasterModel;
use App\Models\AsosiasiModel;

class Klaster extends BaseController
{
  protected $m_data, $m_klaster, $m_asosiasi;
  //waktu proses
  public $waktu;

  public function __construct()
  {
    $this->waktu = microtime(true);
    $this->db = \Config\Database::connect();
    $this->m_data = new DataModel();
    $this->m_klaster = new KlasterModel();
    $this->m_asosiasi = new AsosiasiModel();
  }

  // pengambilan data tanggal awal dan akhir yang ingin dipakai dalam analisis
  public function index()
  {
    $var['title'] = "Analisis Data";
    $var['tanggal_awal'] =  $this->m_data->tanggal_awal_default();
    $var['tanggal_akhir'] =  $this->m_data->tanggal_akhir_default();

    return view('analisis/index', $var);
  }

  // hasil prepocessing dan penginputan jumlah klaster, support dan confidence
  public function hasilprocessing()
  {
    $var['time_start'] = $this->waktu;
    $var['title'] = "Pilih Jumlah Klaster";
    $tanggal_awal =  $this->request->getVar('tanggal_awal');
    $tanggal_akhir =  $this->request->getVar('tanggal_akhir');
    $this->db->query("TRUNCATE TABLE hasil_processing");
    $this->m_data->simpanTanggalData($tanggal_awal, $tanggal_akhir);
    $var['data'] = $this->m_data->getDataProcessing($tanggal_awal, $tanggal_akhir);
    $var['tgl_awal'] = $tanggal_awal;
    $var['tgl_akhir'] = $tanggal_akhir;
    $var['cek'] =  $this->m_data->getDataHasilProcessing();

    session()->setFlashdata('message', 'Preprocessing Data Berhasil');
    return view('analisis/klaster/klaster', $var);
  }


  // iterasi klaster
  public function iterasi_klaster()
  {
    $input = $this->validate([
      'jumlah' => 'required|max_length[2]|min_length[1]|is_natural_no_zero',
      'support' => 'required|min_length[1]|numeric',
      'confidence' => 'required|min_length[1]|numeric',
    ]);
    if (!$input) {
      echo view('analisis/klaster/klaster', [
          'validation' => $this->validator
      ]);
    }
    else {
      $var['time_start'] = $this->waktu;
      $var['title'] = "Iterasi Klaster";
      $this->db->query("TRUNCATE TABLE centroid");
      $this->db->query("TRUNCATE TABLE centroid_temp");
      $this->db->query("TRUNCATE TABLE hasil_iterasi");
      $support  =  $this->request->getVar('support');
      $confidence  =  $this->request->getVar('confidence');
      $jumlah  =  $this->request->getVar('jumlah');
      $centroid  =  $this->request->getVar('centroid');
      $data_analisis  =  $this->request->getVar('data_analisis');
      $var['produk'] = $this->m_klaster->getProduk();
      $var['sup_con'] = $this->m_asosiasi->getSupportConfidence($jumlah, $support, $confidence, $data_analisis);
      $var['jml'] = $jumlah;
      $var['data_analisis'] = $data_analisis;
      //perhitungan di skripsi
      if($centroid == 'pilih'){
        $var['produk_rand'] = $this->m_klaster->getProdukPilihan();
        $var['produk_rand2'] = $this->m_klaster->getProdukPilihan2();
      }
      else{
        $var['produk_rand'] = $this->m_klaster->getProdukRand($jumlah);
        $var['produk_rand2'] = $this->m_klaster->getProdukRand($jumlah);
      }
      $var['jumlah_klaster'] = $this->m_klaster->getJumlahKlaster();
      $var['tanggal_awal'] = $this->m_asosiasi->getTanggalAwal();
      $var['tanggal_akhir'] = $this->m_asosiasi->getTanggalAkhir();
    }
    return view('analisis/klaster/iterasi_klaster', $var);
  }


}
