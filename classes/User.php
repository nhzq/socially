<?php  

class User
{

	private $_db = null;
	public $_errors;

	public function __construct()
	{
		$db = DB::getInstance();
		$this->_db = $db->getConnection();
	}
	
	//Check post or get
	public static function has($item = null) 
	{
		if(isset($_POST[$item])) {
			return $_POST[$item];
		} else if(isset($_GET[$item])) {
			return $_GET[$item];
		}
	}

	//Escape input form
	public function checkInput($var)
    {
        $var = htmlspecialchars($var);
        $var = trim($var);
        $var = stripcslashes($var);

        return $var;
    }

    //Check email exist
    public function checkEmail($email)
    {
    	$query = "SELECT email FROM users WHERE email = :email";

    	$stmt = $this->_db->prepare($query);
    	$stmt->bindValue(':email', $email, PDO::PARAM_STR);
    	$stmt->execute();

    	$count = $stmt->rowCount();

    	if($count > 0) {
            return true;
        } else {
            return false;
        }
    }

    //Check username exist
    public function checkUsername($username)
    {
        $query = "SELECT username FROM users WHERE username = '$username'";

        $stmt = $this->_db->prepare($query);
        $stmt->bindValue('$username', $username, PDO::PARAM_STR);
        $stmt->execute();

        $count = $stmt->rowCount();

        if($count > 0) {
            return true;
        } else {
            return false;
        }
    }

    //Random avatar
    public function avatar()
    {
        $rand = rand(1, 2);

        switch($rand)
        {
            case 1:
                $avatar = "assets/images/avatar/user_1.png";
            break;

            case 2:
                $avatar = "assets/images/avatar/user_2.png";
            break;
        }

        return $avatar;
    }

    //Register user
    public function register($firstName, $lastName, $email, $password, $username, $avatar, $date)
    {
        $query = "INSERT INTO users (first_name, last_name, email, password, username, profile_pic, signup_date, num_posts, num_likes, user_closed, friend_array) VALUES (:first_name, :last_name, :email, :password, '$username', '$avatar', '$date', '0', '0', 'no', ',')";

        $stmt = $this->_db->prepare($query);

        $stmt->bindValue(':first_name', $firstName, PDO::PARAM_STR);
        $stmt->bindValue(':last_name', $lastName, PDO::PARAM_STR);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->bindValue(':password', md5($password), PDO::PARAM_STR);

        $stmt->execute();
    }

}

?>