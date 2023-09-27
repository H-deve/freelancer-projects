<?php

class Client extends CI_Controller
{
    function __construct() {
        parent::__construct();        
        $this->load->library('rest', array('server' => 'http://localhost:82/cc',
                        'api_key'         => 'REST API',
                        'api_name'        => 'X-API-KEY',
                        'http_user'       => 'admin',
                        'http_pass'       => '1234',
                        'http_auth'       => 'basic',
                       ));       
    }
    function put($id=0){          
        if($id==0){
            $this->load->view('read');
        }
        $id = $this->uri->segment(3);
        $this->rest->format('application/json');
        $params = array(
            'id' => $id,
            'book_name' => $this->input->post('dname'),
            'book_price' => $this->input->post('dprice'),                     
            'book_author' => $this->input->post('dauthor')
        );
        $user = $this->rest->put('index.php/api/data/'.$id, $params,'');
        $this->rest->debug();
    }
    function post($id=0){
        if($id==0){
            $this->load->view('read');
        }
        $this->rest->format('application/json');
        $params = $this->input->post(NULL,TRUE);
        $user = $this->rest->post('index.php/api/data', $params,'');
        $this->rest->debug();
    }
    function get($id=0){
        if($id==0){
            $this->load->view('read');
        }
        $id = $this->uri->segment(3);
        $this->rest->format('application/json');
        $params = $this->input->get('id');
        $user = $this->rest->get('index.php/api/data/'.$id, $params,'');
       // $this->rest->debug();
    }
    function delete($id=0){
        if($id==0){
            $this->load->view('read');
       }
        $id = $this->uri->segment(3);
       $this->rest->format('application/json');
       $user = $this->rest->delete('index.php/api/data/'.$id,'','');
       $this->rest->debug();
    }
}