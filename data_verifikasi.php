<?php

class Data_verifikasi extends CI_Controller
{
    public function index()
    {
            $this->load->view('templates_admin/header');
            $this->load->view('templates_admin/sidebar');
            $this->load->view('admin/data_verifikasi');
            $this->load->view('templates_admin/footer');
    }

    public function cetak(){
        ob_start();
        $data['c_tanggapan'] = $this->model_verifikasi->count_tanggapan();
        $data['tanggapan'] = $this->model_verifikasi->get_tanggapan();
        $this->load->view('admin/preview_tanggapan',$data);
        $html = ob_get_contents();
                ob_end_clean();
        require './assets/html2pdf/autoload.php';

        $pdf = new Spipu\Html2Pdf\Html2Pdf('P','A4','en');
        $pdf->WriteHTML($html);
        $pdf->Output('Data_Tanggapan_'.date('d-m-Y'). '.pdf', 'D');
    }

    public function multimedia(){
        $this->load->view('base');
    }

    public function cetak_xls(){
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Data Tangggapan.xls"');
        header('Cache-Control: max-age=0');
        $data['c_tanggapan'] = $this->model_verifikasi->count_tanggapan();
        $data['tanggapan'] = $this->model_verifikasi->get_tanggapan();
        $this->load->view('admin/preview_tanggapan', $data);
    }

    public function ambilData()
    {
        $dataTanggapan = $this->model_verifikasi->ambilData('tanggapan')->result();
        echo json_encode($dataTanggapan);
    }

    public function tambahdata()
    {
        $id_pengaduan=$this->input->post('id_pengaduan');
        $tgl_tanggapan=$this->input->post('tgl_tanggapan');
        $tanggapan=$this->input->post('tanggapan');
        $id_petugas=$this->input->post('id_petugas');

        if($id_pengaduan==''){
            $result['pesan']= "Id Pengaduan Harus Diisi";
        } else if($tgl_tanggapan == '') {
            $result['pesan'] = "Tanggal Harus Diisi";
        } else if($tanggapan == '') {
            $result['pesan'] = "Harus Diisi";
        } else if($id_petugas == ''){
            $result['pesan'] = "Harus Diisi";
        } else  {
            $result['pesan'] = "";

        $data = array(
            'id_pengaduan' => $id_pengaduan,
            'tgl_tanggapan' => $tgl_tanggapan,
            'tanggapan' => $tanggapan,
            'id_petugas' => $id_petugas
        );

            $this->model_verifikasi->tambahdata($data,'tanggapan');
           
        }
        echo json_encode($result);
       
    }
    public function ubahdata()
    {
        $id_tanggapan=$this->input->post('id_tanggapan');
        $id_pengaduan=$this->input->post('id_pengaduan');
        $tgl_tanggapan=$this->input->post('tgl_tanggapan');
        $tanggapan=$this->input->post('tanggapan');
        $id_petugas=$this->input->post('id_petugas');

        if($id_pengaduan==''){
            $result['pesan']= "Id Pengaduan Harus Diisi";
        } else if($tgl_tanggapan == '') {
            $result['pesan'] = "Tanggal Harus Diisi";
        } else if($tanggapan == '') {
            $result['pesan'] = "Harus Diisi";
        } else if($id_petugas == ''){
            $result['pesan'] = "Harus Diisi";
        } else  {
            $result['pesan'] = "";

            $where = array('id_tanggapan'=>$id_tanggapan);
            
            $data = array(
            'id_pengaduan' => $id_pengaduan,
            'tgl_tanggapan' => $tgl_tanggapan,
            'tanggapan' => $tanggapan,
            'id_petugas' => $id_petugas
        );

            $this->model_verifikasi->updatedata($where, $data,'tanggapan');
           
        }
        echo json_encode($result);
       
    }

    public function ambilId()
    {
        $id_tanggapan = $this->input->post('id_tanggapan');
        $where=array('id_tanggapan'=>$id_tanggapan);
        $datatanggapan = $this->model_verifikasi->ambilId('tanggapan', $where)->result();

        echo json_encode($datatanggapan);
    }

    public function hapusdata()
    {
        $id_tanggapan = $this->input->post('id_tanggapan');
        $where = array('id_tanggapan'=>$id_tanggapan);
        $this->model_verifikasi->hapusdata($where,'tanggapan');
    }
}