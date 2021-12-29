<?php

namespace App\Controllers;

class Info extends BaseController
{

  public function index()
  {
    $var['title'] = 'Info Sistem Aplikasi';
    return view('info/index', $var);
  }
}
