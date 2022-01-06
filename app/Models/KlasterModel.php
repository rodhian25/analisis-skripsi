<?php

namespace App\Models;

use CodeIgniter\Model;

class KlasterModel extends Model
{

  public function getProduk()
  {
    $query = $this->db->query('SELECT id_processing, item_produk, jumlah, harga FROM hasil_processing');
    $hasil =  $query->getResultObject();
    return $hasil;
  }


  //memecah array random ke array baru untuk random centroid
  public function smallify($arr, $numberOfSlices)
  {
    $sliceLength = sizeof($arr) / $numberOfSlices;
    for ($i = 1; $i <= $numberOfSlices; $i++) {

      $rt = array_chunk($arr, $sliceLength * $i);
      return $rt;
      unset($rt);
    }
  }



  //mendapatkan centroid
  public function getProdukRand($limit)
  {
    $bil = array();
    $query = $this->db->query("SELECT id_processing, item_produk, jumlah, harga FROM hasil_processing ORDER BY jumlah asc");

    foreach ($query->getResultArray() as $d) {
      $bil[] = [$d['jumlah'], $d['harga'], $d['id_processing'], $d['item_produk']];
    }

    $yy = $limit;
    $cobak = $this->smallify($bil, $yy);

    $slice = sizeof($bil) / $yy;
    $bila = $cobak;


    if (is_integer($slice)) {
      $size_klpk = sizeof($bila);
    } else {
      $size_klpk = (sizeof($bila) - 1);
    }
    for ($i = 0; $i < $size_klpk; $i++) {
      $t = range(1, $slice - 1);
      $dd = array_rand($t, 1);
      $r = $dd;
      $ttt[] = $bila[$i][$r][2];
      $rtss = $ttt;
    }


    $coba = array();
    for ($k = 0; $k < count($rtss); $k++) {
      $coba[] = $rtss[$k];
    }
    $input = $coba;
    $output = implode("','", array_map(
      function ($v, $k) {
        if (is_array($v)) {
          return $k . '[]=' . implode('&' . $k . '[]=', $v);
        } else {
          return $v;
        }
      },
      $input,
      array_keys($input)
    ));

    $querys = $this->db->query("SELECT id_processing, item_produk, jumlah, harga FROM hasil_processing where id_processing in('$output')");
    $hasil = $querys->getResultArray();
    return $hasil;
  }


  //mendapatkan centroid pilihan
  public function getProdukRandAkurasi()
  {
    $produk_rand = [
      [
        "id_processing" => "115",
        "item_produk" => "milo ice",
        "jumlah" => 701,
        "harga" => 16,
      ],
      [
        "id_processing" => "137",
        "item_produk" => "pisang bakar keju",
        "jumlah" => 126,
        "harga" => 16,
      ],
      [
        "id_processing" => "182",
        "item_produk" => "teh tarik hot",
        "jumlah" => 59,
        "harga" => 10,
      ]
    ];

    return $produk_rand;
  }

  //mendapatkan centroid pilihan
  public function getProdukRandAkurasi2()
  {
    $produk_rand2 = [
      [
        "id_processing" => "88",
        "item_produk" => "mie aceh cumi rebus",
        "jumlah" =>77,
        "harga" => 20,
      ],
      [
        "id_processing" => "115",
        "item_produk" => "milo ice",
        "jumlah" => 701,
        "harga" => 16,
      ],
      [
        "id_processing" => "123",
        "item_produk" => "nasi banjir udang",
        "jumlah" => 65,
        "harga" => 23,
      ]
    ];

    return $produk_rand2;
  }



  public function getIterasi($iterasi)
  {
    $query = $this->db->query('SELECT id, iterasi, total_medoids, total_non_medoids, selisih FROM hasil_iterasi WHERE iterasi =' . $iterasi);
    $hasil = $query->getResultObject();
    return $hasil;
  }

  public function getJumlahKlaster()
  {
    $query = $this->db->query("SELECT klaster from options");
    foreach ($query->getResultObject() as $t) {
      $hasil = $t->klaster;
    }
    return $hasil;
  }

  public function getTahapan()
  {
    $query = $this->db->query('SELECT max(tahapan) as tahapan FROM centroid');
    $hasil = $query->getResultObject();
    foreach ($hasil as $t) {
      $tahapan = $t->tahapan;
    }
    $tp = $tahapan - 1;
    return $tp;
  }

  public function getCentroidTempByIterasi()
  {
    $query = $this->db->query('SELECT max(iterasi) as it FROM centroid_temp;');
    $hasil = $query->getResultObject();
    return $hasil;
  }

  public function getHasilIterasi()
  {
    $query = $this->db->query('SELECT id, iterasi, total_medoids, total_non_medoids, selisih FROM hasil_iterasi');
    $hasil = $query->getResultObject();
    return $hasil;
  }

  public function getCentroidTempByC()
  {
    $query = $this->db->query('SELECT id, jenis, iterasi, c FROM centroid_temp GROUP BY c');
    $hasil = $hasil = $query->getResultObject();
    return $hasil;
  }

  public function getHasilKlaster()
  {
    $query = $this->db->query("SELECT hasil_klaster.c as c, hasil_processing.jumlah as jumlah, hasil_processing.harga as harga, hasil_processing.item_produk as item FROM hasil_klaster INNER JOIN hasil_processing ON hasil_klaster.fk_id_processing = hasil_processing.id_processing ORDER BY jumlah ASC");
    $hasil = $query->getResultObject();
    return $hasil;
  }


  //pengujian klaster
  public function getHasilKlasterGroup()
  {
    $query = $this->db->query('SELECT max(tahapan) as tahapan FROM centroid');
    $hasil = $query->getResultObject();
    foreach ($hasil as $t) {
      $tahapan = $t->tahapan;
    }
    $query2 = $this->db->query("SELECT c, jumlah, harga FROM centroid where tahapan = $tahapan-1");
    $hasil2 = $query2->getResultObject();
    return $hasil2;
  }


  public function getHasilPengujian()
  {
    $query = $this->db->query('SELECT id, c, si FROM hasil_pengujian');
    $hasil = $query->getResultObject();
    return $hasil;
  }


  public function getLihatNilaiSI()
  {
    $query = $this->db->query('SELECT id, si FROM hasil_pengujian');
    $hasil = $query->getResultObject();
    return $hasil;
  }
}
