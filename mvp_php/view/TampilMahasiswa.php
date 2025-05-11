<?php

/******************************************
 Asisten Pemrogaman 13 & 14
 ******************************************/

include("KontrakView.php");
include("presenter/ProsesMahasiswa.php");

class TampilMahasiswa implements KontrakView
{
    private $prosesmahasiswa; // Presenter yang dapat berinteraksi langsung dengan view
    private $tpl;

    function __construct()
    {
        //konstruktor
        $this->prosesmahasiswa = new ProsesMahasiswa();
    }

    function tampil()
    {
        $this->prosesmahasiswa->prosesDataMahasiswa();
        $data = null;

        //semua terkait tampilan adalah tanggung jawab view
        for ($i = 0; $i < $this->prosesmahasiswa->getSize(); $i++) {
            $no = $i + 1;
            $nim = $this->prosesmahasiswa->getNim($i);
            $data .= "<tr>
                <td>" . $no . "</td>
                <td>" . $nim . "</td>
                <td>" . $this->prosesmahasiswa->getNama($i) . "</td>
                <td>" . $this->prosesmahasiswa->getTempat($i) . "</td>
                <td>" . $this->prosesmahasiswa->getTl($i) . "</td>
                <td>" . $this->prosesmahasiswa->getGender($i) . "</td>
                <td>" . $this->prosesmahasiswa->getEmail($i) . "</td>
                <td>" . $this->prosesmahasiswa->getTelp($i) . "</td>
                <td>
                    <a href='index.php?action=update&id=" . $this->prosesmahasiswa->getId($i) . "' class='btn btn-warning btn-sm'>Edit</a>
                    <a href='index.php?action=delete&id=" . $this->prosesmahasiswa->getId($i) . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Apakah Anda yakin ingin menghapus data ini?\")'>Delete</a>
                </td>
            </tr>";
        }

        // Prepare buttons
        $buttons = "<div class='mb-3'><a href='index.php?action=create' class='btn btn-primary'>Tambah Mahasiswa</a></div>";

        // Check for status messages
        $alert = "";
        if (isset($_GET['status']) && isset($_GET['message'])) {
            $status = $_GET['status'];
            $message = $_GET['message'];
            $alertType = ($status === 'success') ? 'success' : 'danger';
            $alert = "<div class='alert alert-{$alertType} alert-dismissible fade show' role='alert'>
                {$message}
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>";
        }

        // Membaca template skin.html
        $this->tpl = new Template("templates/skin.html");

        // Mengganti kode Data_Tabel dengan data yang sudah diproses
        $this->tpl->replace("DATA_TABEL", $data);
        $this->tpl->replace("DATA_BUTTONS", $buttons);
        $this->tpl->replace("DATA_ALERTS", $alert);

        // Menampilkan ke layar
        $this->tpl->write();
    }

    // Display form to add a new student
    function formTambah()
    {
        // Check for status messages (for form validation errors)
        $alert = "";
        if (isset($_GET['status']) && isset($_GET['message'])) {
            $status = $_GET['status'];
            $message = $_GET['message'];
            $alertType = ($status === 'success') ? 'success' : 'danger';
            $alert = "<div class='alert alert-{$alertType} alert-dismissible fade show' role='alert'>
                {$message}
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>";
        }

        // Membaca template form
        $this->tpl = new Template("templates/form.html");

        // Replace placeholders
        $this->tpl->replace("DATA_TITLE", "Tambah Data Mahasiswa");
        $this->tpl->replace("DATA_FORM_ACTION", "index.php?action=create");
        $this->tpl->replace("DATA_NIM", isset($_GET['nim']) ? $_GET['nim'] : "");
        $this->tpl->replace("DATA_NAMA", isset($_GET['nama']) ? $_GET['nama'] : "");
        $this->tpl->replace("DATA_TEMPAT", isset($_GET['tempat']) ? $_GET['tempat'] : "");
        $this->tpl->replace("DATA_TL", isset($_GET['tl']) ? $_GET['tl'] : "");
        $this->tpl->replace("DATA_GENDER_L", isset($_GET['gender']) && $_GET['gender'] == "L" ? "checked" : "");
        $this->tpl->replace("DATA_GENDER_P", isset($_GET['gender']) && $_GET['gender'] == "P" ? "checked" : "");
        $this->tpl->replace("DATA_EMAIL", isset($_GET['email']) ? $_GET['email'] : "");
        $this->tpl->replace("DATA_TELP", isset($_GET['telp']) ? $_GET['telp'] : "");
        $this->tpl->replace("DATA_BUTTON", "Tambah");
        $this->tpl->replace("DATA_NIM_READONLY", "");
        $this->tpl->replace("DATA_ALERTS", $alert);

        // Display form
        $this->tpl->write();
    }

    // Change formUbah method to accept $id instead of $nim
    function formUbah($id)
    {
        // Check for status messages (for form validation errors)
        $alert = "";
        if (isset($_GET['status']) && isset($_GET['message'])) {
            $status = $_GET['status'];
            $message = $_GET['message'];
            $alertType = ($status === 'success') ? 'success' : 'danger';
            $alert = "<div class='alert alert-{$alertType} alert-dismissible fade show' role='alert'>
            {$message}
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                <span aria-hidden='true'>&times;</span>
            </button>
        </div>";
        }

        // Get student data
        $this->prosesmahasiswa->prosesDataMahasiswaById($id);

        if ($this->prosesmahasiswa->getSize() > 0) {
            // Student found, prepare form with data
            $this->tpl = new Template("templates/form.html");

            // Add hidden input for id
            $this->tpl->replace("DATA_ID", $id);

            // Replace placeholders with student data
            $this->tpl->replace("DATA_TITLE", "Edit Data Mahasiswa");
            $this->tpl->replace("DATA_FORM_ACTION", "index.php?action=update&id=" . $id);
            $this->tpl->replace("DATA_NIM", $this->prosesmahasiswa->getNim(0));
            $this->tpl->replace("DATA_NAMA", isset($_GET['nama']) ? $_GET['nama'] : $this->prosesmahasiswa->getNama(0));
            $this->tpl->replace("DATA_TEMPAT", isset($_GET['tempat']) ? $_GET['tempat'] : $this->prosesmahasiswa->getTempat(0));
            $this->tpl->replace("DATA_TL", isset($_GET['tl']) ? $_GET['tl'] : $this->prosesmahasiswa->getTl(0));

            // Set gender radio button
            $gender = isset($_GET['gender']) ? $_GET['gender'] : $this->prosesmahasiswa->getGender(0);
            if ($gender == "L") {
                $this->tpl->replace("DATA_GENDER_L", "checked");
                $this->tpl->replace("DATA_GENDER_P", "");
            } else {
                $this->tpl->replace("DATA_GENDER_L", "");
                $this->tpl->replace("DATA_GENDER_P", "checked");
            }

            $this->tpl->replace("DATA_EMAIL", isset($_GET['email']) ? $_GET['email'] : $this->prosesmahasiswa->getEmail(0));
            $this->tpl->replace("DATA_TELP", isset($_GET['telp']) ? $_GET['telp'] : $this->prosesmahasiswa->getTelp(0));
            $this->tpl->replace("DATA_BUTTON", "Update");
            $this->tpl->replace("DATA_NIM_READONLY", "");
            $this->tpl->replace("DATA_ALERTS", $alert);

            // Display form
            $this->tpl->write();
        } else {
            // Student not found, redirect to index
            header("Location: index.php?status=error&message=Mahasiswa tidak ditemukan");
            exit;
        }
    }

    // Process add student form
    function tambah($data)
    {
        $result = $this->prosesmahasiswa->tambahDataMahasiswa($data);

        if (!$result['status']) {
            // If failed (like duplicate NIM), redirect back to form with error message
            // and preserve form data
            $redirectParams = http_build_query([
                'status' => 'error',
                'message' => $result['message'],
                'nim' => $data['nim'],
                'nama' => $data['nama'],
                'tempat' => $data['tempat'],
                'tl' => $data['tl'],
                'gender' => $data['gender'],
                'email' => $data['email'],
                'telp' => $data['telp']
            ]);
            header("Location: index.php?action=create&" . $redirectParams);
            exit;
        }

        return $result;
    }

    // Change ubah method to use $id
    function ubah($id, $data)
    {
        $result = $this->prosesmahasiswa->ubahDataMahasiswa($id, $data);

        if (!$result['status']) {
            // If failed, redirect back to form with error message
            // and preserve form data
            $redirectParams = http_build_query([
                'status' => 'error',
                'message' => $result['message'],
                'nama' => $data['nama'],
                'tempat' => $data['tempat'],
                'tl' => $data['tl'],
                'gender' => $data['gender'],
                'email' => $data['email'],
                'telp' => $data['telp']
            ]);
            header("Location: index.php?action=update&id=" . $id . "&" . $redirectParams);
            exit;
        }

        return $result;
    }

    // Change hapus method to use $id
    function hapus($id)
    {
        return $this->prosesmahasiswa->hapusDataMahasiswa($id);
    }
}
