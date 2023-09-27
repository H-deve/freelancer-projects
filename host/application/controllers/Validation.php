<?php
class Validation Extends CI_Controller{




	 public function __construct()
    {
        parent::__construct();
        /*
        load you helper library
        */
        /*
        load you model
        */

        $this->load->library('form_validation');
    }

    function register_get()
    {
        /* What you have done that i don't know */
        /*
        $json = array('status' => false );
        if($this->input->post()==null){
            $this -> response($json, 200);
        }
        */

        /* This is Form Validation */
        $this->form_validation->set_rules('first_name', 'FirstName', 'valid_email|required');
        $this->form_validation->set_rules('last_name', 'LastName', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        /* Here you mistake $this->post('post var')*/
        $firstname = $this->input->post("first_name");
        $lastname = $this->input->post("last_name");
        $password = $this->input->post("password");

        /** YOUR PROCESS for REGISTER **/
        /*
        LIKE
        */
        if ($this->form_validation->run() == TRUE)
        {
            if(/* REGISTRATION SUCCESSFUL */)
            {
                $data = array('result' => 'success', 'msg' => 'Registered Successfully...');
            }
            else
            {
                $data = array('result' => 'error', 'msg' => 'Email Already Used or Invalid - Unable to Create Account' );
            }
        }
        else
        {
            $data = array('result' => 'error','msg' => preg_replace("/[\n\r]/",".",strip_tags(validation_errors())));
        }

        echo json_encode($data);

        /*
        if(!$firstname || !$lastname || !$password){
            $json['status'] = "wrong insert";
            $this -> response($json, 200);
        }

        $this->load->model('Data_model');
        $result = $this->Data_model->search($firstname, $lastname);

        if($result)
        {
            $this->Data_model->insert($firstname,$lastname,$password);
            $json['status'] = true;

        }
        // here if false..
        $this -> response($json, 200);
        */
    }
}
?>