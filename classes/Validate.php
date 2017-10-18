<?php 

class Validate
{

	private $_passed = false;
	private $_errors = array();
	private $_db = null;

	public function __construct()
	{
		$this->_db = DB::getInstance();
	}

	public function check($source, $items = array())
	{
		foreach($items as $item => $rules)
		{
			foreach($rules as $rule => $rule_value)
			{
				$user = new User();

				$value = $user->checkInput($source[$item]);

				if($rule === 'required' && empty($value)) {
					$this->addError("{$item} is required");
				} 

				else if(!empty($value)) {

					switch($rule)
					{
						case 'min':
							if(strlen($value) < $rule_value) {
								$this->addError("{$item} must be a minimum of {$rule_value} characters");
							}
						break;

						case 'max':
							if(strlen($value) > $rule_value) {
								$this->addError("{$item} must be a maximum of {$rule_value} characters");
							}
						break;

						case 'email-unique':
							if($user->checkEmail($value) === true) {
								$this->addError("{$item} already exists");
							}
						break;

						case 'matches':
							if($value != $source[$rule_value]) {
								$this->addError("{$rule_value} must match with password before");
							}
						break;
					}
				}
			}
		}

		if(empty($this->_errors)) {
			$this->_passed = true;
		}

		return $this;
		
	}

	private function addError($error)
	{
		$this->_errors[] = $error;
	}

	public function errors()
	{
		return $this->_errors;
	}

	public function passed()
	{
		return $this->_passed;
	}

}

?>