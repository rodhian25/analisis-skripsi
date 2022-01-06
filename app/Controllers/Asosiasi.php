<?php

namespace App\Controllers;

use App\Models\DataModel;
use App\Models\AsosiasiModel;

class Asosiasi extends BaseController
{
  protected $m_data, $m_asosiasi;
  //data transaksi
  public $data;
  //data transaksi setelah di convert
  public $datas;
  //data transaksi sebelum di per-transaksi
  public $datass;
  //total data transaksi
  public $total_data;
  //item/category yang ada dalam data transaksi
  public $categories;
  //minimal jumlah data (berdasarkan min_support)
  protected $min_count;
  //minimal Support dalam persen
  protected $min_support;
  //minimal confident dalam persen
  protected $min_confidence;
  //frequest itemset dari data transaksi
  public $frequent_itemset;
  //support dari kumpulan data
  public $support;
  //itemset yang sudah terurut dari support terbesar
  public $ordered_itemset;
  //fp tree
  public $fp_tree;
  //item data beserta total transaksi
  public $item;
  //conditional patern base
  public $cpb;
  //conditional fp tree
  public $cfpt;
  //aturan asosiasi
  public $ass;
  //waktu proses
  public $waktu;

  public function __construct()
  {
    $this->m_data = new DataModel();
    $this->m_asosiasi = new AsosiasiModel();
    $this->db = \Config\Database::connect();
    $data = $this->m_asosiasi->getDataHasilKlaster();
    $this->data = $data;
    $this->datas = $this->m_asosiasi->convert($data);
    $this->datass = $this->m_asosiasi->converts($data);
    $this->total_data = count($this->datas);

    //menghitung jumlah item berdasarkan support yang diinputkan
    $min_support = doubleval($this->m_asosiasi->support_minimum());
    $min_confidence = doubleval($this->m_asosiasi->confidence_minimum());
    $this->min_support = $min_support;
    $this->min_count = $min_support / 100 * $this->total_data;
    $this->min_confidence = $min_confidence;
    $this->waktu = microtime(true);

    //memanggil fungsi2
    $this->frequent_itemset();
    $this->ordered_itemset();
    $this->fp_tree();
    $this->item();
    $this->cpb();
    $this->cfpt();
    $this->fpg();
    $this->association();
  }


  // FUNGSI UNTUK ANALISIS FP-GROWTH -----------------------------------------------------------------
  /**
   * menampilkan quantity setiap item berapa kali muncul di transaksi
   */
  function frequent_itemset()
  {
    foreach ($this->datass as $key => $val) {
      foreach (array_unique($val) as $k => $v) {
        if (!isset($this->frequent_itemset[$v]))
          $this->frequent_itemset[$v] = 1;
        else
          $this->frequent_itemset[$v]++;
      }
    }
    foreach ($this->frequent_itemset as $key => $val) {
      $this->categories[] = $key;
      if ($val < $this->min_count) {
        unset($this->frequent_itemset[$key]);
      } else {
        $this->support[$key] = $val / $this->total_data;
      }
    }
    arsort($this->frequent_itemset);
    // echo "<pre>";
    // print_r($this->frequent_itemset);
    // echo "</pre>";
  }


  /**
   * menghitung ordered itemset (item dari support terbesar)
   */
  function ordered_itemset()
  {
    foreach ($this->datas as $data) {
      $arr = array();
      foreach ($this->frequent_itemset as $category => $count) {
        if (in_array($category, $data))
          $arr[] = $category;
      }
      if ($arr)
        $this->ordered_itemset[] = $arr;
    }
  }


  /**
   * membangun fp tree
   */
  function fp_tree()
  {
    $this->fp_tree = array(
      'Root' => array(
        'value' => 'Root',
        'count' => 0,
        'next' => array(),
      ),
    );
    $this->build_tree($this->fp_tree['Root']['next'], $this->ordered_itemset);
  }


  /**
   * fungsi recursive untuk membangun fp tree dari setiap cabang
   * @param array $parent_node node induk
   * @param array $ordered_itemset data ordered itemset
   * @return array @node cabang dari tree
   */
  function build_tree(&$parent_node, $ordered_itemset = array())
  {
    $ordered_itemset = array_values($ordered_itemset);
    if (!$ordered_itemset)
      return;
    $ordered_itemset[0] = array_values($ordered_itemset[0]);
    $itemset = current($ordered_itemset);
    $item = current($itemset);

    unset($ordered_itemset[0][0]);
    if (!$itemset) {
      unset($ordered_itemset[0]);
      $this->build_tree($this->fp_tree['Root']['next'], $ordered_itemset);
    } else if (in_array($item, array_keys($parent_node))) {
      $parent_node[$item]['count']++;
      $this->build_tree($parent_node[$item]['next'], $ordered_itemset);
    } else {
      $parent_node[$item]['value'] = $item;
      $parent_node[$item]['count'] = 1;
      $parent_node[$item]['next'] = array();
      $this->build_tree($parent_node[$item]['next'], $ordered_itemset);
    }
  }



  /**
   * menampilkan fp tree dalam bentuk pohon
   */
  public function display()
  {
    echo "<ul class='fp_tree'><li><b class='btn btn-sm btn-warning'>Root</b>";
    $this->_display($this->fp_tree['Root']);
    echo "</li></ul>";
  }




  /**
   * fungsi redursive menampilkan cabang-cabang dari pohon
   */
  public function _display($tree)
  {
    echo "<ul>";
    foreach ($tree['next'] as $key => $val) {
      echo "<li> <b class='btn btn-sm btn-ty'>$key : <span class='text-primary'>( $val[count] )</span></b>";
      $this->_display($val);
      echo '</li>';
    }
    echo "</ul>";
  }




  /**
   * conditional patern base untuk node tertentu
   * @param array $items kombinasi itemset
   * @param string $value node yang ingin dicari
   * @param array $tree pohon fp-tree
   * @return array hasil cpb
   */
  function _cpb($items, $value, $tree)
  {
    if ($tree['value'] != 'Root') {
      $items[] = $tree['value'];
      $this->cpb[] = array(
        'value' => $tree['value'],
        'items' => $items,
        'count' => $tree['count'],
      );
    }
    foreach ($tree['next'] as $key => $val) {
      $this->_cpb($items, $key, $val);
    }
  }




  /**
   * menghitung conditional patern base
   */
  function cpb()
  {
    $this->_cpb(array(),  'Root', $this->fp_tree['Root']);
    //echo '<pre>' . print_r($this->cpb, 1) . '</pre>';
    $arr = array();
    foreach ($this->cpb as $key => $val) {
      if (count($val['items']) > 1) {
        $key = $val['items'][count($val['items']) - 1];
        array_pop($val['items']);
        $arr[$key][] = $val;
      }
    }
    $this->cpb = $arr;
    // echo "<pre>";
    // print_r($arr);
    // echo "</pre>";
  }





  /**
   * membalik urutan dalam array frequent itemset
   */
  function item()
  {
    $this->item = array_reverse($this->frequent_itemset, true);
    // echo "<pre>";
    // print_r($this->item);
    // echo "</pre>";
  }



  /**
   * mencari berapa data transaksi yang terdapat item tertentu
   * @param array $needed kombinasi item
   * @return int jumlah transaksi
   */
  function get_match($needed)
  {
    $matches = 0;
    foreach ($this->datas as $k => $v) {
      $arr = array();
      foreach ($v as $a => $b) {
        if (in_array($b, $needed)) {
          $arr[] = $b;
        }
      }
      if (count($arr) == count($needed)) {
        $matches++;
      }
    }
    return $matches;
  }



  /**
   * conditional fp tree semua data berdasarkan conditional patern base
   */
  public function cfpt()
  {
    foreach ($this->item as $key => $val) {
      if (isset($this->cpb[$key])) {
        $this->cfpt[$key] = $this->_cfpt($this->cpb[$key]);
      }
    }
  }


  /**
   * cfpt data tertentu
   */
  private function _cfpt($datas)
  {
    $arr = array();
    $key = array();
    $max = 0;

    foreach ($datas as $val) {
      if (count($val['items']) > $max)
        $max = count($val['items']);

      $arr[] = $val['items'];
      foreach ($val['items'] as $k => $v) {
        $key[$v] = 1;
      }
    }
    $key = array_keys($key);
    $itemset = $max;
    $arr3 = array();
    while ($itemset >= 1) {
      $com = array();
      $com = $this->getCombinations($key, $itemset);

      foreach ($com as $k => $v) {
        $result = $this->get_result($v, $datas);
        if ($result['count'] >= $this->min_count)
          $arr3[] = $result;
      }
      $itemset--;
    }
    return $arr3;
  }




  /**
   * hasil cfpt berdasarkan kombinasi itemset
   * @param array $com kombinasi itemset
   * @param array $datas data transaksi
   * @return array hasil cfpt kombinasi
   */
  function get_result($com, $datas)
  {
    $total = 0;
    foreach ($datas as $key => $val) {
      if ($this->match($com, $val['items']))
        $total += $val['count'];
    }
    return array(
      'items' => $com,
      'count' => $total,
    );
  }


  /**
   * menentukan apakah satu array1 ada di array2
   * @param array $needed array pertama
   * @param array $datas array kedua
   * @return bool match atau tidak
   */
  function match($needed, $datas)
  {
    foreach ($needed as $key => $val) {
      if (!in_array($val, $datas))
        return false;
    }
    return true;
  }



  function getCombinations(array $base, $n)
  {
    $baselen = count($base);
    if ($baselen == 0) {
      return;
    }
    if ($n == 1) {
      $return = array();
      foreach ($base as $b) {
        $return[] = array($b);
      }
      return $return;
    } else {
      $oneLevelLower = $this->getCombinations($base, $n - 1);
      $newCombs = array();
      foreach ((array) $oneLevelLower as $oll) {
        $lastEl = $oll[$n - 2];
        $found = false;
        foreach ($base as  $key => $b) {
          if ($b == $lastEl) {
            $found = true;
            continue;
          }
          if ($found == true) {
            if ($key < $baselen) {
              $tmp = $oll;
              $newCombination = array_slice($tmp, 0);
              $newCombination[] = $b;
              $newCombs[] = array_slice($newCombination, 0);
            }
          }
        }
      }
    }
    return $newCombs;
  }


  /**
   * mencari fp growth berdasarkan conditional fp tree
   */
  function fpg()
  {
    $arr = array();
    foreach ($this->cfpt as $key => $val) {
      foreach ($val as $k => $v) {
        $items = $v['items'];
        $items[] = $key;
        $count = count($items);
        $arr[$key][] = array(
          'items' => $items,
          'count' => $v['count'],
        );
      }
    }
    $this->fpg = $arr;
    // echo "<pre>";
    // print_r($arr);
    // echo"</pre>";
  }



  /**
   * mencari aturan asosiasi berdasarkan hasil fpg
   */
  function association()
  {
    $no = 0;
    $arr2 = array();
    foreach ($this->fpg as $k => $v) {
      foreach ($v as $item_key => $item_val) {
        $items = $item_val['items'];
        $arr = array();
        for ($a = 0; $a < count($items) - 1; $a++) {
          $arr = array_merge($this->getCombinations($items, $a + 1), $arr);
        }
        foreach ($arr as $key => $val) {
          $keys = array(
            'left' => array(),
            'right' => array(),
          );
          foreach ($items as $k => $v) {
            if (in_array($v, $val))
              $keys['left'][] = $v;
            else
              $keys['right'][] = $v;
          }
          $arr2[$no] = $keys;
          $arr2[$no]['b'] = $this->get_match($arr2[$no]['left']);
          $arr2[$no]['a'] = $item_val['count'];
          $arr2[$no]['total'] = $this->total_data;
          $arr2[$no]['sup'] = $arr2[$no]['a'] / $arr2[$no]['total'];
          $arr2[$no]['conf'] = @($arr2[$no]['a'] / $arr2[$no]['b']);
          $s_head = $this->get_match($arr2[$no]['right']) / $this->total_data;
          $arr2[$no]['lr'] = @($arr2[$no]['conf'] / $s_head);
          $no++;
        }
      }
    }
    $this->ass = $arr2;
    // echo "<pre>";
    // print_r($arr2);
    // echo "</pre>";
  }


  // END FUNGSI UNTUK ANALISIS FP-GROWTH -----------------------------------------------------------------
  // asosiasi fp-growth
  public function asosiasi()
  {
    $var['time_start'] = $this->waktu;
    $var['title'] = "Algoritma FP-Growth";
    //mendapatkan nilai support dan confidence
    $var['sup'] = $this->min_support;
    $var['con'] = $this->min_confidence;
    //data transaksi hasil klaster
    $var['data'] = $this->datas;
    $var['data_'] = $this->data;
    $var['frequent_itemset'] = $this->frequent_itemset;
    $var['ordered_itemset'] = $this->ordered_itemset;
    $var['item'] = $this->item;
    $var['cpb'] = $this->cpb;
    $var['cfpt'] = $this->cfpt;
    $var['fpg'] = $this->fpg;
    $var['ass'] = $this->ass;

    return view('analisis/fp_growth/index', $var);
  }

  //menampilkan fp-tree
  public function display_fptree()
  {
    $var['title'] = "FP-TREE";
    $var['display'] = $this->display();
    return view('analisis/fp_growth/fp_tree', $var);
  }

  //downloas fp-tree
  public function display_fptree2()
  {
    $var['title'] = "FP-TREE";
    $var['display'] = $this->display();
    return view('hasil/download_fptree', $var);
  }



  // asosiasi fp-growth mengubah support dan confidence
  public function ubah_sup_conf()
  {
    $support  =  $this->request->getVar('support');
    $confidence  =  $this->request->getVar('confidence');
    $this->m_asosiasi->updateSupportConfidence($support, $confidence);
    return redirect()->back();
  }
}
