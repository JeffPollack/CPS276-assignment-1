<?php

session_start();

function secure_my_page(){
    if(isset($_SESSION['userid']) && $_SESSION['userid']!=null){
        // this is a valid user
       
    }else{
        $loggedIn=false;
        $message='';
        if(isset($_POST['username']) && isset($_POST['password'])){
            // check username and password
            $hash = hash('sha256', $_POST['password']);
            $passed=true;
            $id=5;
            
            if($passed){
                $loggedIn=true;
                $_SESSION['userid']=$id;
            }else{
                $message='username or password is wrong';
            }
        }
        // not logged in
        // show the login form
        if(!$loggedIn){
            ?>
            <form method='post'>
                    Username: <input type='text' name='username'/>
                    </br>
                    Password: <input type='text' name='password'/>
                    </br>
                    <input type='submit' value='Log In'/>
            </form>
            <?php
            exit;
        }
    }
}
