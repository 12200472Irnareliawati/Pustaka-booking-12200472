<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Pengguna;

class PenggunaController extends BaseController
{
    public function index()
    {
        return view('halaman/pengguna/table', [
            'xx'                => (new Pengguna()) -> get()->getResult(),
            'error'             => $this->session->getFlashdata('error')
        ]);
    }
    public function form($data = []){
        return view('halaman/pengguna/form', [
            'vd'                => $this->session->getFlashdata('validator'),
            'error'             => $this->session->getFlashdata('error'),
            'data'              => $data
        ]);
    }

    private function validasi(){
        return $this->validate(
            [
                'nama'          => 'required',
                'password'      => 'required|min_length[6]',
                'password2'     => 'required[min_length[6]|matches[password]'
            ],
            [
                'nama'          => ['required' => 'Nama pengguna harus diisikan'],
                'password'      =>[
                    'required'  => 'Kata sandi harus diisikan',
                    'min_length'=> 'Minimal karakter 6 huruf',
                   
                ],
                'password2'     =>[
                    'required'  => 'Ulangi kata sandi harus diisikan',
                    'min_length'=> 'Minimal karakter 6 huruf',
                    'matches'   => 'Sandi tidak cocok'
                ]

            ]
                );
    }

    public function simpan(){
        $data = [
            'nama'              => $this->request->getPost('nama'),
            'password'          => $this->request->getPost('password')
        ];
        if($this->validasi()){
            $r = (new Pengguna())->insert($data);
            if($r == false){
                    return redirect()->to('/pengguna')->with('error', ' Data Pengguna gagal disimpan');
            }else{
                return redirect()->to('/pengguna-list');
            }
        }else{
            return redirect()->to('/pengguna')->with('validator', $this->validator);
        }
    }
    public function edit($id){
        $data = (new Pengguna())->where('id', $id)->first();
        if($data == null){
            return redirect()->to('/pengguna-list')->with('error', 'Pengguna tidak ditemukan');
            
        }else{
            return $this->form($data);
        }
    }

    private function validasiPatch(){
        return $this->validate(
            [
                'nama'          => 'required',
             
            ],
            [
                'nama'          => ['required' => 'Nama pengguna harus diisikan'],
            

            ]
         );
    }

    public function patch (){

        $id = $this->request->getPost('id');
        $data = [
            'nama' => $this->request->getPost('nama'),
        ];

        if ($this->request->getPost('password') != ''){
            $data['password'] = md5($this->request->getPost('password'));
        }

        if( $this->validasiPatch() ){
           $r = (new Pengguna())->update($id, $data);
           if($r == true){
               return redirect()->to('/pengguna-list');
           }else{
               return redirect()->to('/pengguna' , $id)->with('errror', 'Data gagal di update');
           }

        }else{
            return redirect()->to('/pengguna/', $id)->with('validator', $this->validator);
        }
    }

    public function delete(){
        $id = $this->request->getPost('id');
        $r = (new Pengguna())->delete('$id');

        
        $rd = redirect()->to('/pengguna-list');
        if($r == false){
            $rd->with('error', 'Gagal untuk dihapus');
        }
        return $rd;
    }
}