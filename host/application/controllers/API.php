<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class API extends REST_Controller{

    public function __construct() {
                parent::__construct();
                $this->load->model('API_model');
    }    
    public function data_get($id_param = NULL){
        $id = $this->input->get('id');
        if($id===NULL){
            $id = $id_param;
        }
        if ($id === NULL)
        {
            $data = $this->API_model->read($id);
            if ($data)
            {
                $this->response($data, REST_Controller::HTTP_OK); 
            }
            else
            {
                $this->response([
                    'status' => FALSE,
                    'error' => 'No books were found'
                ], REST_Controller::HTTP_NOT_FOUND); 
            }
        }
        $data = $this->API_model->read($id);
        if ($data)
        {
            $this->set_response($data, REST_Controller::HTTP_OK);   
        }
        else
        {
            $this->set_response([
                'status' => FALSE,
                'error' => 'Record could not be found'
            ], REST_Controller::HTTP_NOT_FOUND); 
        }
    }
    public function data_post(){ 
        $data = array('book_name' => $this->input->post('dname'),
                      'book_price' => $this->input->post('dprice'),                     
                      'book_author' => $this->input->post('dauthor')
        );
        $this->API_model->insert($data);
        $message = [ 
            'Book Name' => $data['book_name'],
            'Book Price' => $data['book_price'],
            'Book Author' => $data['book_author'],
            'message' => 'Added a resource'
        ];
        $this->set_response($message, REST_Controller::HTTP_CREATED); 
    }
    public function data_put(){
        $data = $this->input->input_stream();
        $this->API_model->update($data);
        $message = [
            'id' => $data['id'], 
            'Book Name' => $data['book_name'],
            'Book Price' => $data['book_price'],
            'Book Author' => $data['book_author'],
            'message' => 'Added a resource'
        ];
        $this->set_response($message, REST_Controller::HTTP_CREATED); 
    }
    public function data_delete(){
        $id = $this->uri->segment(3);
        if($id===NULL){
            $this->set_response([
                'status' => FALSE,
                'error' => 'ID cannot be empty'
            ], REST_Controller::HTTP_NOT_FOUND); 
        }
        $data = $this->API_model->delete($id);
        if ($data)
        {
            $this->set_response($data, REST_Controller::HTTP_OK);   
        }
        else
        {
            $this->set_response([
                'status' => FALSE,
                'error' => 'Record could not be found'
            ], REST_Controller::HTTP_NOT_FOUND); 
        }
    }
}