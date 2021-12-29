<?php

namespace App\Models;

use CodeIgniter\Model;

class AsosiasiModel extends Model
{
  public function getTanggalAwal()
  {
    $ta = $this->db->query("SELECT tgl_awal FROM options limit 1")->getResultObject();
    foreach($ta as $taw)
    {
      $hasil = $taw->tgl_awal;
    }
    return $hasil;
  }


  public function getTanggalAkhir()
  {
    $tk = $this->db->query("SELECT tgl_akhir FROM options limit 1")->getResultObject();
    foreach($tk as $tak)
    {
      $hasil = $tak->tgl_akhir;
    }
    return $hasil;
  }


  public function getDataHasilKlaster()
  {
    $query =  "SELECT id, receipt_number, tanggal, item_produk FROM data_klaster order by id";
    return $this->db->query($query)->getResultObject();
  }


  public function getSupportConfidence($jumlah, $support, $confidence, $data_analisis)
  {
    $query = "UPDATE options SET klaster ='".$jumlah."', support ='".$support."', confidence = '".$confidence. "',data_analisis ='" . $data_analisis . "' WHERE
    id=1";
    $this->db->query($query);
  }



  public function updateSupportConfidence($support, $confidence)
  {
    $query = "UPDATE options SET support ='".$support."', confidence = '".$confidence."' WHERE
    id=1";
    $this->db->query($query);
  }


  public function tampilSupportConfidence()
  {
    $query   = $this->db->query("SELECT support, confidence from options");
    $hasil = $query->getResultObject();
    return $hasil;
  }


  public function support_minimum()
  {
    $query   = $this->db->query("SELECT support from options");

    foreach ($query->getResultObject() as $q1) {
      $supp = $q1->support;
    }
    return $supp;
  }


  public function confidence_minimum()
  {
    $query   = $this->db->query("SELECT confidence from options");
    foreach ($query->getResultObject() as $q2) {
      $conf = $q2->confidence;
    }
    return $conf;
  }

  public function data_analisis()
  {
    $query   = $this->db->query("SELECT data_analisis from options");
    foreach ($query->getResultObject() as $q2) {
      $data_analisis = $q2->data_analisis;
    }
    return $data_analisis;
  }


  public function tampilHasil()
  {
    $query   = $this->db->query("SELECT left_item, right_item, supp, conf, lift from hasil_asosiasi");
    $hasil = $query->getResultObject();
    return $hasil;
  }



  public function converts($data)
  {
    $arr = array();
    foreach ($data as $row) {
      $v = trim(strtolower($row->item_produk));
      $arr[$row->id][$v] = $v;
    }
    return $arr;
  }

  public function convert($data)
  {
    $arr = array();
    foreach ($data as $row) {
      $v = trim(strtolower($row->item_produk));
      $arr[$row->receipt_number][$v] = $v;
    }
    return $arr;
  }

}

?>