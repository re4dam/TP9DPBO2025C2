<?php

/******************************************
 Asisten Pemrogaman 13 & 14
 ******************************************/

interface KontrakView
{
    function tampil();
    function formTambah();
    function formUbah($nim);
    function tambah($data);
    function ubah($nim, $data);
    function hapus($nim);
}

