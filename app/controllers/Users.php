<?php
  class Users extends Controller{
    public function __construct(){
      $this->userModel = $this->model('User');
    }

    // public function index(){
    //   redirect('welcome');
    // }

    public function register(){
     
    }

    public function login(){
    
  
    }

    // Logout & Destroy Session
    public function logout(){
      unset($_SESSION['user_id']);
      unset($_SESSION['user_email']);
      unset($_SESSION['user_name']);
      session_destroy();
      redirect('users/login');
    }

    // Check Logged In
    // public function isLoggedIn(){
    //   if(isset($_SESSION['user_id'])){
    //     return true;
    //   } else {
    //     return false;
    //   }
    // }
  }