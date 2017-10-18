<?php  

	require_once 'core/init.php';

	//Define variable
	$error = "";

	// Instantiate object
	$user = new User();

	// Registration
	if(User::has('register-submit')) {

		$validate = new Validate();

		$validation = $validate->check($_POST, array(
			'first_name' => array(
				'required' => true,
				'min' => 2,
				'max' => 20
			),
			'last_name' => array(
				'required' =>true,
				'min' => 2,
				'max' => 20
			),
			'email' => array(
				'required' => true,
				'email-unique' => 'email'
			),
			'password' => array(
                'required' => true,
                'min' => 6
            ),
            'confirm_password' => array(
                'required' => true,
                'matches' => 'password'
            ),
		));

        if($validation->passed()) {

        	$firstName = $user->checkInput($_POST['first_name']);
        	$lastName  = $user->checkInput($_POST['last_name']);
        	$email     = $user->checkInput($_POST['email']);
        	$password  = $user->checkInput($_POST['password']);
        	$date	   = date("Y-m-d");

        	//Create username
        	$username  = strtolower($firstName . "_" . $lastName);
        	$i = 1;

        	while($user->checkUsername($username) != 0)
        	{
        		$username = $username . "_" . $i;

        		$i++;
        	}

        	//Create avatar
        	$avatar = $user->avatar();

        	//Register user
        	$user->register($firstName, $lastName, $email, $password, $username, $avatar, $date);

        } else {
            foreach($validation->errors() as $error) {
                echo "{$error} <br>";
            }
        }
	}

?>