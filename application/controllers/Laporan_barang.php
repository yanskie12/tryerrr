<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laporan_barang extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        is_role(['administrator', 'kepala toko']);

        $this->load->model('TransaksiModel', 'barang');
        $this->form_validation->set_error_delimiters('<small class="text-danger">', '</small>');
    }

    public function index()
    {
        $data['title'] = "Laporan";

        $this->form_validation->set_rules('tanggal', 'Tanggal', 'required');
        $this->form_validation->set_message('required', 'Kolom {field} harus diisi');

        if ($this->form_validation->run() == false) {
            template_view('laporan_barang/index', $data);
        } else {
            $input  = $this->input->post(null, true);
            $tgl    = explode(' - ', $input['tanggal']);
            $tgl1   = date('Y-m-d', strtotime($tgl[0]));
            $tgl2   = date('Y-m-d', strtotime(end($tgl)));

            $this->cetak_barang($tgl1, $tgl2);
        }
    }

    public function cetak_barang($tgl1, $tgl2)
    {
        $this->load->library('Dompdf_gen');
 
        $data['tanggal'] = indo_date($tgl1) . " s/d " . indo_date($tgl2);
        $data['barang'] = $this->barang->getLaporanBarang($tgl1, $tgl2);
        $data['jumlah'] = count((array) $data['barang']);         
        $data['total'] = $this->barang->getTotalBarang(null, [$tgl1, $tgl2]);
        
        $this->load->view('laporan_barang/laporan_barang', $data);

        $paper_size = 'A4'; // ukuran kertas
        $orientation = 'landscape'; //tipe format kertas potrait atau landscape
        $html = $this->output->get_output();

        $this->dompdf->set_paper($paper_size, $orientation);
        //Convert to PDF
        $this->dompdf->load_html($html);
        $this->dompdf->render();

        ob_end_clean();
        $this->dompdf->stream("laporan_barang_" . time() . ".pdf", array('Attachment' => 0));
    }
}
