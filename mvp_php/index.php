<?php

/******************************************
 Asisten Pemrogaman 13 & 14
 ******************************************/

include("view/TampilMahasiswa.php");

$action = isset($_GET['action']) ? $_GET['action'] : 'read';

$tp = new TampilMahasiswa();

switch ($action) {
    case 'create':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $result = $tp->tambah($_POST);
            header("Location: index.php?status=" . ($result ? "success" : "error") . "&message=" . ($result ? "Data berhasil ditambahkan" : "Gagal menambahkan data"));
            exit;
        } else {
            $tp->formTambah();
        }
        break;

    case 'update':
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            // Show edit form if no POST data, otherwise process the form
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $result = $tp->ubah($id, $_POST);
                // Redirect to index page after operation
                header("Location: index.php?status=" . ($result ? "success" : "error") . "&message=" . ($result ? "Data berhasil diubah" : "Gagal mengubah data"));
                exit;
            } else {
                $tp->formUbah($id);
            }
        } else {
            // ID not provided, redirect to index
            header("Location: index.php");
            exit;
        }
        break;

    case 'delete':
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $result = $tp->hapus($id);
            // Redirect to index page after operation
            header("Location: index.php?status=" . ($result ? "success" : "error") . "&message=" . ($result ? "Data berhasil dihapus" : "Gagal menghapus data"));
            exit;
        } else {
            // ID not provided, redirect to index
            header("Location: index.php");
            exit;
        }
        break;

    case 'read':
    default:
        // Show student list (default action)
        $tp->tampil();
        break;
}
