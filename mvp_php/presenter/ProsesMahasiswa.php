<?php

include("KontrakPresenter.php");

/******************************************
 Asisten Pemrogaman 13 & 14
 ******************************************/

class ProsesMahasiswa implements KontrakPresenter
{
    private $tabelmahasiswa;
    private $data = [];

    function __construct()
    {
        // Konstruktor
        try {
            $db_host = "localhost"; // host 
            $db_user = "root"; // user
            $db_password = ""; // password
            $db_name = "db_mvp"; // nama basis data
            $this->tabelmahasiswa = new TabelMahasiswa($db_host, $db_user, $db_password, $db_name); // instansi TabelMahasiswa
            $this->data = array(); // instansi list untuk data Mahasiswa
        } catch (Exception $e) {
            echo "yah error" . $e->getMessage();
        }
    }

    function prosesDataMahasiswa()
    {
        try {
            // mengambil data di tabel Mahasiswa
            $this->tabelmahasiswa->open();
            $this->tabelmahasiswa->getMahasiswa();

            while ($row = $this->tabelmahasiswa->getResult()) {
                // ambil hasil query
                $mahasiswa = new Mahasiswa(); // instansiasi objek mahasiswa untuk setiap data mahasiswa
                $mahasiswa->setId($row['id']); // mengisi id
                $mahasiswa->setNim($row['nim']); // mengisi nim
                $mahasiswa->setNama($row['nama']); // mengisi nama
                $mahasiswa->setTempat($row['tempat']); // mengisi tempat
                $mahasiswa->setTl($row['tl']); // mengisi tl
                $mahasiswa->setGender($row['gender']); // mengisi gender
                $mahasiswa->setEmail($row['email']); // mengisi email
                $mahasiswa->setTelp($row['telp']); // mengisi telp

                $this->data[] = $mahasiswa; // tambahkan data mahasiswa ke dalam list
            }
            // Tutup koneksi
            $this->tabelmahasiswa->close();
        } catch (Exception $e) {
            // memproses error
            echo "yah error part 2" . $e->getMessage();
        }
    }

    public function prosesDataMahasiswaById($id)
    {
        try {
            $this->data = [];
            $this->tabelmahasiswa->open();
            $this->tabelmahasiswa->getMahasiswaById($id);

            while ($row = $this->tabelmahasiswa->getResult()) {
                // ambil hasil query
                $mahasiswa = new Mahasiswa();
                $mahasiswa->setId($row['id']);
                $mahasiswa->setNim($row['nim']);
                $mahasiswa->setNama($row['nama']);
                $mahasiswa->setTempat($row['tempat']);
                $mahasiswa->setTl($row['tl']);
                $mahasiswa->setGender($row['gender']);
                $mahasiswa->setEmail($row['email']);
                $mahasiswa->setTelp($row['telp']);

                $this->data[] = $mahasiswa;
            }

            $this->tabelmahasiswa->close();
        } catch (Exception $e) {
            echo "Process Data By ID Error: " . $e->getMessage();
        }
    }

    public function tambahDataMahasiswa($data)
    {
        try {
            $nim = $data['nim'];
            $nama = $data['nama'];
            $tempat = $data['tempat'];
            $tl = $data['tl'];
            $gender = $data['gender'];
            $email = $data['email'];
            $telp = $data['telp'];

            $this->tabelmahasiswa->open();
            $result = $this->tabelmahasiswa->insertMahasiswa($nim, $nama, $tempat, $tl, $gender, $email, $telp);
            $this->tabelmahasiswa->close();

            if ($result) {
                return [
                    'status' => true,
                    'message' => 'Data mahasiswa berhasil ditambahkan'
                ];
            } else {
                return [
                    'status' => false,
                    'message' => 'Gagal menambahkan data mahasiswa'
                ];
            }
        } catch (Exception $e) {
            return [
                'status' => false,
                'message' => 'Error: ' . $e->getMessage()
            ];
        }
    }

    public function ubahDataMahasiswa($id, $data)
    {
        try {
            $nim = $data['nim'];
            $nama = $data['nama'];
            $tempat = $data['tempat'];
            $tl = $data['tl'];
            $gender = $data['gender'];
            $email = $data['email'];
            $telp = $data['telp'];

            $this->tabelmahasiswa->open();
            $result = $this->tabelmahasiswa->updateMahasiswa($id, $nim, $nama, $tempat, $tl, $gender, $email, $telp);
            $this->tabelmahasiswa->close();

            if ($result) {
                return [
                    'status' => true,
                    'message' => 'Data mahasiswa berhasil diperbarui'
                ];
            } else {
                return [
                    'status' => false,
                    'message' => 'Gagal memperbarui data mahasiswa'
                ];
            }
        } catch (Exception $e) {
            return [
                'status' => false,
                'message' => 'Error: ' . $e->getMessage()
            ];
        }
    }

    public function hapusDataMahasiswa($id)
    {
        try {
            $this->tabelmahasiswa->open();
            $result = $this->tabelmahasiswa->deleteMahasiswa($id);
            $this->tabelmahasiswa->close();

            if ($result) {
                return [
                    'status' => true,
                    'message' => 'Data mahasiswa berhasil dihapus'
                ];
            } else {
                return [
                    'status' => false,
                    'message' => 'Gagal menghapus data mahasiswa'
                ];
            }
        } catch (Exception $e) {
            return [
                'status' => false,
                'message' => 'Error: ' . $e->getMessage()
            ];
        }
    }

    function getId($i)
    {
        // mengembalikan id mahasiswa dengan indeks ke i
        return $this->data[$i]->id;
    }
    function getNim($i)
    {
        // mengembalikan nim mahasiswa dengan indeks ke i
        return $this->data[$i]->nim;
    }
    function getNama($i)
    {
        // mengembalikan nama mahasiswa dengan indeks ke i
        return $this->data[$i]->nama;
    }
    function getTempat($i)
    {
        // mengembalikan tempat mahasiswa dengan indeks ke i
        return $this->data[$i]->tempat;
    }
    function getTl($i)
    {
        // mengembalikan tanggal lahir(TL) mahasiswa dengan indeks ke i
        return $this->data[$i]->tl;
    }
    function getGender($i)
    {
        // mengembalikan gender mahasiswa dengan indeks ke i
        return $this->data[$i]->gender;
    }
    function getEmail($i)
    {
        // mengembalikan email mahasiswa dengan indes ke i
        return $this->data[$i]->email;
    }
    function getTelp($i)
    {
        return $this->data[$i]->telp;
    }
    function getSize()
    {
        return sizeof($this->data);
    }
}
