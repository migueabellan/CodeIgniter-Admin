<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class AdminIndex extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        
        $this->load->model('admin_model');
    }

    private function _render_page($view, $data = null)
    {
        $this->viewdata = (empty($data)) ? $this->data : $data;

        $this->load->view('admin/header.php', $this->viewdata);
        $this->load->view('admin/'.$view, $this->viewdata);
        $this->load->view('admin/footer.php', $this->viewdata);
    }

    public function exist_admin()
    {
        $user = $this->input->post('user');
        $pass = $this->input->post('pass');
        return $this->admin_model->existAdmin($user, $pass) ? true : false;
    }

    public function index()
    {
        if ($this->session->userdata('is_admin_login')) 
            redirect('admin/dashboard');
        else 
            redirect('admin/login');
    }

    public function login()
    {
        if ($this->session->userdata('is_admin_login')) 
            redirect('admin/dashboard');

        $this->load->helper(array('form', 'security'));
        $this->load->library('form_validation');
        $this->form_validation->set_rules('user', 'user', 'trim|xss_clean|required|min_length[5]|max_length[45]');
        $this->form_validation->set_rules('pass', 'pass', 'trim|xss_clean|required|min_length[5]|max_length[45]|callback_exist_admin');
        
        if ($this->form_validation->run() == FALSE)
        {        
            $data = array(
                'page_title' => 'Login'
            );

            $this->_render_page('login.php', $data);
        }
        else
        {
            $data['user'] = $this->security->sanitize_filename($this->input->post('user'));
            $data['pass'] = $this->security->sanitize_filename($this->input->post('pass'));

            $sess_array = array(
                'user'=>$data['user'],
                'pass'=>$this->admin_model->genPass($data['pass'])
            );
            $this->session->set_userdata('is_admin_login', $sess_array);

            redirect('admin');
        }
    }
        
    public function logout()
    {
        $this->session->unset_userdata('is_admin_login');   
        $this->session->sess_destroy();
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
        $this->output->set_header("Pragma: no-cache");
        redirect('admin', 'refresh');
    }

    public function dashboard()
    {
        if (!$this->session->userdata('is_admin_login')) 
            redirect('admin');
        
        $data = array(
            'page_title' => 'Dashboard',
            'session' => $this->session->userdata('is_admin_login')
        );

        $this->_render_page('dashboard.php', $data);
    }
}