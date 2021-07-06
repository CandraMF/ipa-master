<?php
Class pdf extends CI_Controller{
    
    function __construct() {
        parent::__construct();
        $this->load->library('andri');
    }
    
    function index(){
        $pdf = new FPDF('l','mm','A5');
        // membuat halaman baru
        $pdf->AddPage();
        // setting jenis font yang akan digunakan
        $pdf->SetFont('Arial','B',16);
        // mencetak string 
        $pdf->Cell(190,7,'SEKOLAH MENENGAH KEJURUSAN NEEGRI 2 LANGSA',0,1,'C');
        $pdf->SetFont('Arial','B',12);
        $pdf->Cell(190,7,'DAFTAR SISWA KELAS IX JURUSAN REKAYASA PERANGKAT LUNAK',0,1,'C');
        // Memberikan space kebawah agar tidak terlalu rapat
        $pdf->Cell(10,7,'',0,1);
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(20,6,'KODE UNIT',1,0);
        $pdf->Cell(85,6,'NAMA UNIT',1,0);
        $pdf->Cell(27,6,'AKRONIM',1,0);
        $pdf->Cell(25,6,'TELPON',1,1);
        $pdf->SetFont('Arial','',10);
        $mahasiswa = $this->db->get('mskpd')->result();
        foreach ($mahasiswa as $row){
            $pdf->Cell(20,6,$row->KDUNIT,1,0);
            $pdf->Cell(85,6,$row->NMUNIT,1,0);
            $pdf->Cell(27,6,$row->AKRONIM,1,0);
            $pdf->Cell(25,6,$row->TELEPON,1,1); 
        }
        $pdf->Output();
    }
}