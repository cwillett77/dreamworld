<?php
class Validate {
 
  // ---------------------------------------------------------------------------
  //  paramaters
  // ---------------------------------------------------------------------------
 
  /**
  * Array to hold the errors
  *
  * @access public
  * @var array
  */
  public $errors = array();
 
  // ---------------------------------------------------------------------------
  //  validation methods
  // ---------------------------------------------------------------------------
 
  /**
  * Validates a string
  *
  * @access public
  * @param $postVal - the value of the $_POST request
  * @param $postName - the name of the form element being validated
  * @param $min - minimum string length
  * @param $max - maximum string length
  * @return void
  */
  public function validateStr($postVal, $postName, $min = 5, $max = 500) {
    if(strlen($postVal) < intval($min)) {
      $this->setError($postName, ucfirst($postName)." must be at least {$min} characters long.");
    } else if(strlen($postVal) > intval($max)) {
      $this->setError($postName, ucfirst($postName)." must be less than {$max} characters long.");
    }
  }// end validateStr
 
  /**
  * Validates an email address
  *
  * @access public
  * @param $emailVal - the value of the $_POST request
  * @param $emailName - the name of the email form element being validated
  * @return void
  */
  public function validateEmail($emailVal, $emailName) {
    if(strlen($emailVal) <= 0) {
      $this->setError($emailName, "Please enter an Email Address");
    } else if (!preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $emailVal)) {
      $this->setError($emailName, "Please enter a Valid Email Address");
        }
  }// end validateEmail
 
  // ---------------------------------------------------------------------------
  //  error handling methods
  // ---------------------------------------------------------------------------
 
  /**
  * sets an error message for a form element
  *
  * @access private
  * @param string $element - name of the form element
  * @param string $message - error message to be displayed
  * @return void
  */
  private function setError($element, $message) {
    $this->errors[$element] = $message;
  }// end logError
 
  /**
  * returns the error of a single form element
  *
  * @access public
  * @param string $elementName - name of the form element
  * @return string
  */
  public function getError($elementName) {
    if($this->errors[$elementName]) {
      return $this->errors[$elementName];
    } else {
      return false;
    }
  }// end getError
 
  /**
  * displays the errors as an html un-ordered list
  *
  * @access public
  * @return string: A html list of the forms errors
  */
  public function displayErrors() {
    $errorsList = "<ul class=\"errors\">\n";
    foreach($this->errors as $value) {
      $errorsList .= "<li>". $value . "</li>\n";
    }
    $errorsList .= "</ul>\n";
    return $errorsList;
  }// end displayErrors
 
  /**
  * returns whether the form has errors
  *
  * @access public
  * @return boolean
  */
  public function hasErrors() {
    if(count($this->errors) > 0) {
      return true;
    } else {
      return false;
    }
  }// end hasErrors
 
  /**
  * returns a string stating how many errors there were
  *
  * @access public
  * @return void
  */
  public function errorNumMessage() {
    if(count($this->errors) > 1) {
            $message = "There were " . count($this->errors) . " errors sending your message!\n";
        } else {
            $message = "There was an error sending your message!\n";
        }
    return $message;
  }// end hasErrors
 
}// end class