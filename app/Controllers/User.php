<?php

namespace App\Controllers;

use Myth\Auth\Models\UserModel;
use App\Models\DataModel;
use Myth\Auth\Password;

class User extends BaseController
{
  protected $m_users, $m_data;

  public function __construct()
  {
    $this->m_users = new UserModel;
    $this->m_data = new DataModel;
  }

  // menampilkan halaman utama user
  public function index()
  {
    $var['title'] = "Selamat Datang";
    $var['data']   = $this->m_data->tampil_data();
    $var['j_data'] = $this->m_data->jumlah_transaksi();
    $var['j_menu'] = $this->m_data->jumlah_menu();
    $var['j_paket'] = $this->m_data->jumlah_paket();
    $var['produk_jenis'] = $this->m_data->produk_jenis();
    $var['produk_item'] = $this->m_data->produk_peritem();
    $var['produk_item_urut'] = $this->m_data->produk_peritem_urut();
    $var['produk_laris'] = $this->m_data->produk_laris();
    $var['produk_kurang_laris'] = $this->m_data->produk_kurang_laris();

    return view('index', $var);
  }

  // menampilkan data user hanya untuk akses admin
  public function datauser()
  {
    $var['title'] = "Data User";
    $var['data'] = $this->m_users->tampil_datauser();
    return view('admin/data_user', $var);
  }

  // menghapus data user hanya untuk akses admin
  public function hapus_akun($id)
  {
    $this->m_users->update($id, ['active' => $this->request->getVar('active')]);
    $this->m_users->delete($id);
    session()->setFlashdata('message', 'Hapus Akun Berhasil');
    return redirect()->to('/admin/data-user');
  }

  // menampilkan menu profile untuk semua akses
  public function profile()
  {
    $var['title'] = "Profile";
    $var['data'] = $this->m_users->profile();
    return view('profile/profile', $var);
  }

  // mengubah profile data untuk semua akses
  public function update_profile()
  {
    if (!$this->validate([

      'email' => [
        'rules' => 'required',
        'errors' => [
          'required' => '{field} Harus diisi'
        ]
      ],
      'alamat' => [
        'rules' => 'required',
        'errors' => [
          'required' => '{field} Harus diisi'
        ]
      ],
      'no_hp' => [
        'rules' => 'required',
        'errors' => [
          'required' => '{field} Harus diisi'
        ]
      ],

    ])) {
      session()->setFlashdata('error', $this->validator->listErrors());
      return redirect()->back()->withInput();
    }
    $id =  $this->request->getVar('id');
    $data = array(
      'alamat'      => $this->request->getVar('alamat'),
      'no_hp'       => $this->request->getVar('no_hp'),
    );
    $this->m_users->update_profil($data, $id);

    session()->setFlashdata('message', 'Update Data Profil Berhasil');
    return redirect()->to('/profile');
  }


  // mengubah password untuk semua akses
  public function update_password()
  {
    if (!$this->validate([

      'password_baru' => [
        'rules' => 'required|min_length[8]|matches[ulangi_password]',
        'errors' => [
          'required' => '{field} Harus diisi'
        ]
      ],
      'ulangi_password' => [
        'rules' => 'required|min_length[8]|matches[password_baru]',
        'errors' => [
          'required' => '{field} Harus diisi'
        ]
      ],

    ])) {
      session()->setFlashdata('error', $this->validator->listErrors());
      return redirect()->back()->withInput();
    }

    $id =  $this->request->getVar('id');
    $password_baru = $this->request->getVar('password_baru');
    $password_hash = Password::hash($password_baru);
    $data = array(
      'password_hash' => $password_hash,
    );
    $this->m_users->update_password($data, $id);

    session()->setFlashdata('message', 'Update Data Password Berhasil');
    return redirect()->to('/logout');
  }

}
