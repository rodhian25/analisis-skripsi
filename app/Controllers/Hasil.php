<?php

namespace App\Controllers;

use App\Models\DataModel;
use App\Models\KlasterModel;
use App\Models\AsosiasiModel;

class Hasil extends BaseController
{
  protected $m_data, $m_klaster, $m_asosiasi;

  public function __construct()
  {
    $this->m_data = new DataModel();
    $this->m_klaster = new KlasterModel();
    $this->m_asosiasi = new AsosiasiModel();
    $this->db = \Config\Database::connect();
  }

  public function index()
  {
    $var['title'] = 'Hasil Algoritma K-Medoids dan FP-Growth';
    $var['hasil'] = $this->m_asosiasi->tampilHasil();
    $tanggal_awal = $this->m_asosiasi->getTanggalAwal();
    $tanggal_akhir = $this->m_asosiasi->getTanggalAkhir();
    $var['data_klaster'] = $this->m_data->tampil_hasil_jumlah_data_klaster();
    $var['supp'] = $this->m_asosiasi->support_minimum();
    $var['conf'] = $this->m_asosiasi->confidence_minimum();
    $var['data_analisis'] = $this->m_asosiasi->data_analisis();
    $var['klaster'] = $this->m_data->tampil_hasil_jumlah_klaster();
    $var['data'] = $this->m_data->tampil_hasil_jumlah_data($tanggal_awal, $tanggal_akhir);
    $var['data_transaksi'] = $this->m_data->tampil_hasil_jumlah_data_transaksi($tanggal_awal, $tanggal_akhir);
    $var['data_transaksi_klaster'] = $this->m_data->tampil_hasil_jumlah_data_transaksi_klaster();

    return view('hasil/index', $var);
  }


  public function download()
  {
    $var['title'] = 'Download Hasil';
    //mendapatkan status user sebagai apa
    $id = user()->id;
    $this->builder = $this->db->table('users');
    $this->builder->select('users.id as userid, username, email, no_hp, created_at, name');
    $this->builder->join('auth_groups_users', 'auth_groups_users.user_id = users.id');
    $this->builder->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id');
    $this->builder->where('users.id', $id);
    $query = $this->builder->get();
    $var['datas'] = $query->getRow();
    $var['datasss'] = $this->m_asosiasi->getDataHasilKlaster();
    $var['tgl'] = $this->db->query('SELECT tgl_awal, tgl_akhir FROM options LIMIT 1')->getRow();
    $var['options'] = $this->db->query('SELECT klaster, support, confidence, data_analisis FROM options LIMIT 1')->getRow();
    $var['hasil_klaster'] = $this->db->query("SELECT hasil_klaster.c as c, hasil_processing.item_produk as item, hasil_processing.jumlah as jumlah, hasil_processing.harga as harga FROM hasil_klaster INNER JOIN hasil_processing ON hasil_klaster.fk_id_processing = hasil_processing.id_processing ORDER BY c asc, jumlah desc")->getResultObject();
    $tanggal_awal = $this->m_asosiasi->getTanggalAwal();
    $tanggal_akhir = $this->m_asosiasi->getTanggalAkhir();
    $var['data'] = $this->m_data->tampil_hasil_jumlah_data($tanggal_awal, $tanggal_akhir);
    $var['data_klaster'] = $this->m_data->tampil_hasil_jumlah_data_klaster();
    $var['data_transaksi'] = $this->m_data->tampil_hasil_jumlah_data_transaksi($tanggal_awal, $tanggal_akhir);
    $var['data_transaksi_klaster'] = $this->m_data->tampil_hasil_jumlah_data_transaksi_klaster();
    $var['hasils'] = $this->m_asosiasi->tampilHasil();
    $data_analisis = $this->m_asosiasi->data_analisis();

    if($data_analisis == 'banyak'){
      //mendapatkan klaster yang tinggi nilainya
      $var['cari_klaster'] = $this->db->query("SELECT hasil_klaster.c as c, hasil_processing.jumlah as jumlah FROM hasil_klaster INNER JOIN hasil_processing ON hasil_klaster.fk_id_processing = hasil_processing.id_processing order by jumlah desc limit 1")->getRow();
    }
    else{
      //mendapatkan klaster yang terendah nilainya
      $var['cari_klaster'] = $this->db->query("SELECT hasil_klaster.c as c, hasil_processing.jumlah as jumlah FROM hasil_klaster INNER JOIN hasil_processing ON hasil_klaster.fk_id_processing = hasil_processing.id_processing order by jumlah asc limit 1")->getRow();
    }

    return view('hasil/download', $var);
  }
}
