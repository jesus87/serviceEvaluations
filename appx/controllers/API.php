<?php

require(APPPATH.'/libraries/REST_Controller.php');
 
class Api extends REST_Controller{
    
    public function __construct()
    {
        parent::__construct();

        //$this->load->model('book_model');
		$this->load->model('user_model');
    }

    //API - client sends user and on valid user information is sent back
    function userById_get(){

        $user  = $this->get('huella');
        
        if(!$user){

            $this->response("No User specified", 400);

            exit;
        }

        $result = $this->user_model->BuscaById( $user );

        if($result){

            $this->response($result, 200); 

            exit;
        } 
        else{

             $this->response("User Has no Huella", 404);

            exit;
        }
    } 

    //API -  Fetch All users
    function users_get(){

		$users = $this->user_model->Busca();

		if($users)
		{
			$this->response($users, 200);
		}

		else
		{
			$this->response(NULL, 404);
		}
    }
    function usersSinNull_get(){

		$users = $this->user_model->BuscaSinNull();

		if($users)
		{
			$this->response($users, 200);
		}

		else
		{
			$this->response(NULL, 404);
		}
    }
    //API - create a new token item in database.
    function generateToken_post(){
             
             $huella  = $this->post('huella');
      
      
             if(!$huella)  {
                $this->response("Enter complete user information to get token", 400);
             }
             $name = $this->user_model->BuscaById($huella);
             if($name !== "notfound"){
                 $token = bin2hex(openssl_random_pseudo_bytes(32));
                         $data = array(
    			'usuario' => $name,
    			'token' => $token
    		    );
                $result = $this->user_model->AgregaToken($data);
                if($result === 0){
    
                    $this->response("Token could not be saved. Try again.", 500);
    
                }else{
                    $this->response($token, 200);  
                }
             }
             $this->response("notfound", 404);
             
             
                
            
         

    }
     
    //API - create a new user item in database.
    function addUser_post(){

         $name      = $this->post('user');

         $huella     = $this->post('huella');

         
         if(!$name){

                $this->response("Enter complete user information to save", 400);

         }else{

            $data = array(
			'usuario' => $name,
			'huella' => $huella
		    );
            $result = $this->user_model->Agrega($data);
            
            if($result === 0){

                $this->response("User information could not be saved. Try again.", 500);

            }else{

                $this->response("success", 200);  
           
            }

        }

    }

    
   


}
