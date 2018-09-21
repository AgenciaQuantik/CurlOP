<?php 

namespace Quantik\CurlOP;

/**
*  A sample class
*
*  This class is a response for Quantik's needs on Curl operations, that aims for simplicity
*  and complete support for authorization, posting, etc. You won't have to manually add the
*  authentication to the header.
*
*  @author Rafael Correa
*/
class CurlOP {

   /**  @var CurlObject $_CurlObject class that keeps information about the Curl connection */
   protected $_CurlObject;

   /**  @var string     $_Method way that curl will talk to the target url */
   protected $_Method;

   /**  @var array      $_Header header that will be sent with the request */
   protected $_Header = [];

   /**  @var array      $_PostVars Post variables that will be sent with the request */
   protected $_PostVars = [];

   /**  @var string     $_AuthType Auth type that is going to be used */
   protected $_AuthType = [];

   /**  @var string     $_AuthType Auth type that is going to be used */
   protected $_AuthInfo = ["Token"=>"","Login"=>"","Password"=>""];

   /**  @var array      $_Response Response given by the request */
   protected $_Response = [];

  /*
   |---------------------------------------------------------------------------------------------
   | Main methods
   |---------------------------------------------------------------------------------------------
   */
 
  /**
  * Constructor
  *
  * The default constructor for the class
  *
  * @param string $url The target URL that curl will target
  *
  * @return object
  */
   public function __construct ($url = "") {
      //Start the Curl Connection
      $this->_CurlObject = curl_init();

      //Only set target URL if the argument require so
      if ($url != "")
        curl_setopt($this->_CurlObject, CURLOPT_URL, $url);

      //Always return object, allowing concatenation of methods
			return $this;
   }
 
  /**
  * run
  *
  * The default constructor for the class
  *
  * @param bool $url The target URL that curl will target
  *
  * @return object
  */
   public function run ($dumpmode = false) {
      //Get the Curl Connection
      $curl = $this->_CurlObject;

      //Setup authentication
      switch ($this->_AuthType) {
        case 1:
          $this->_Header[] = "Bearer ".$this->_AuthInfo["Token"];
        break;
        case 2:
          curl_setopt($curl, CURLOPT_USERPWD, $this->_AuthInfo["Login"] . ":" . $this->_AuthInfo["Password"]); 
        break;
        case 3:
          //NYI
        break;
        case 4:
          //NYI
        break;
        case 5:
          $this->_Header[] = "Bearer ".$this->_AuthInfo["Token"];
        break;
        case 6:
          //NYI
        break;
      }

      //Setup general info about the request
      curl_setopt($curl, CURLOPT_HTTPHEADER     , $this->_Header);
      curl_setopt($curl, CURLOPT_RETURNTRANSFER , $dumpmode);

      //Setup method control
      curl_setopt($curl, CURLOPT_POST           , count($this->_PostVars));
      curl_setopt($curl, CURLOPT_POSTFIELDS     , json_encode($this->_PostVars));

      //Custom method control
      if ($this->_Method != "GET" && $this->_Method != "POST")
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $this->_Method); 

      //Run curl
      $this->_Response = curl_exec($curl);

      //Close curl
      curl_close($curl);

      //An exception to the concatenation, this will return the result
      return $this->_Response;
   }

  /*
   |---------------------------------------------------------------------------------------------
   | Header methods
   |---------------------------------------------------------------------------------------------
   */

  /**
  * setHeader
  *
  * Set a single header for the request, can be compost or simple,
  * compost requests are glued together. 
  *
  * @param string      $arg1 If only arg1 is passed, enables simple header (passed as a string)
  * @param string|null $arg2 If arg2 is passed, enables compost header (glued together and passed as a string)
  *
  * @return object
  */
   public function setHeader ($arg1, $arg2 = null) {
      //Only set target URL if the argument require so
      if (is_null($arg2))
        $this->_Header[] = $arg1;
      else
        $this->_Header[] = $arg1.": ".$arg2;

      //Always return object, allowing concatenation of methods
      return $this;
   }

  /**
  * setHeaders
  *
  * Overwrite the actual header with the new one, if no argument is passed,
  * it will simply clear the header
  *
  * @param array $newHeader New header that will be used in the request
  *
  * @return object
  */
   public function setHeaders ($newHeader = []) {
      //Only set target URL if the argument require so
      $this->_Header = $newHeader;

      //Always return object, allowing concatenation of methods
      return $this;
   }

  /*
   |---------------------------------------------------------------------------------------------
   | Body variables methods
   |---------------------------------------------------------------------------------------------
   */

  /**
  * setPost
  *
  * Set a single body variable for the request, can be compost or simple,
  * compost requests are glued together. 
  *
  * @param string      $arg1 If only arg1 is passed, enables simple variable (passed as a numeric)
  * @param string|null $arg2 If arg2 is passed, enables compost header (glued together and passed as a associative)
  *
  * @return object
  */
   public function setPost ($arg1, $arg2 = null) {
      //Only set target URL if the argument require so
      if (is_null($arg2))
        $this->_PostVars[]      = $arg1;
      else
        $this->_PostVars[$arg1] = $arg2;

      //Always return object, allowing concatenation of methods
      return $this;
   }

  /**
  * setPosts
  *
  * Overwrite the actual post variables with the new one, if no argument is passed,
  * it will simply clear the array
  *
  * @param array $newPost New post array that will be used in the request
  *
  * @return object
  */
   public function setPosts ($newPost = []) {
      //Only set target URL if the argument require so
      $this->_PostVars = $newPost;

      //Always return object, allowing concatenation of methods
      return $this;
   }

  /*
   |---------------------------------------------------------------------------------------------
   | Authentication methods
   |---------------------------------------------------------------------------------------------
   */

  /**
  * token
  *
  * Set a token value in case that the authentication requires it
  *
  * @param string $token Token that will be used in authentication
  *
  * @return object
  */
   public function token ($token) {
      $this->_AuthInfo["Token"] = $token;

      //Always return object, allowing concatenation of methods
      return $this;
   }

  /**
  * login
  *
  * Login info in case they use basic login
  *
  * @param string $login Field used as login in authentication
  * @param string $password Field used as password in authentication
  *
  * @return object
  */
   public function login ($login, $password = "") {
      $this->_AuthInfo["Login"] = $login;

      if ($password != "")
        $this->_AuthInfo["Password"] = $password;

      //Always return object, allowing concatenation of methods
      return $this;
   }


  /**
  * auth
  *
  * Set the type of authorization to be sent in the request header
  *
  * @param string|int $authType Type that is going to be used in the auth
  *
  * @return object
  */
   public function auth ($authType = 0) {
      //Make avaible all methods through ints or strings, this follows POSTMAN method order
      switch ($authType) {
        default:
        case 0:
        case 'None':
          $this->_AuthType = 0;
        break;

        //NYI
        case 1:
        case 'Bearer':
          $this->_AuthType = 1;
        break;
        
        //NYI
        case 2:
        case 'Basic':
          $this->_AuthType = 2;
        break;
        
        //NYI
        case 3:
        case 'Digest':
          $this->_AuthType = 3;
        break;
        
        //NYI
        case 4:
        case 'OAuth1':
          $this->_AuthType = 4;
        break;
        
        //NYI
        case 5:
        case 'OAuth2':
          $this->_AuthType = 5;
        break;
        
        //NYI
        case 6:
        case 'Hawk':
          $this->_AuthType = 6;
        break;
        
        //NYI
        case 7:
        case 'AWS':
          $this->_AuthType = 7;
        break;
      }

      //Always return object, allowing concatenation of methods
      return $this;
   }

  /*
   |---------------------------------------------------------------------------------------------
   | General methods
   |---------------------------------------------------------------------------------------------
   */

  /**
  * Method
  *
  * Decide which way curl will talk to the URL
  *
  * @param string|int $method The target URL that curl will target
  *
  * @return object
  */
   public function method ($method) {
      //Make avaible all methods through ints or strings, this follows POSTMAN method order
      switch ($method) {
        //Get method
        default:
        case 0:
        case 'GET':
          $this->_Method = "GET";
        break;

        //Post method
        case 1:
        case 'POST':
          $this->_Method = "POST";
        break;

        //Put method
        case 2:
        case 'PUT':
          $this->_Method = "PUT";
        break;

        //Patch method
        case 3:
        case 'PATCH':
          $this->_Method = "PATCH";
        break;

        //Delete method
        case 4:
        case 'DELETE':
          $this->_Method = "DELETE";
        break;

        //Copy method
        case 5:
        case 'COPY':
          $this->_Method = "COPY";
        break;

        //Head method
        case 6:
        case 'HEAD':
          $this->_Method = "HEAD";
        break;

        //Options method
        case 7:
        case 'OPTIONS':
          $this->_Method = "OPTIONS";
        break;

        //Link method
        case 8:
        case 'LINK':
          $this->_Method = "LINK";
        break;

        //Unlink method
        case 9:
        case 'UNLINK':
          $this->_Method = "UNLINK";
        break;

        //Purge method
        case 10:
        case 'PURGE':
          $this->_Method = "PURGE";
        break;

        //Lock method
        case 11:
        case 'LOCK':
          $this->_Method = "LOCK";
        break;

        //Unlock method
        case 12:
        case 'UNLOCK':
          $this->_Method = "UNLOCK";
        break;

        //Propfind method
        case 13:
        case 'PROPFIND':
          $this->_Method = "PROPFIND";
        break;

        //View method
        case 14:
        case 'VIEW':
          $this->_Method = "VIEW";
        break;
      }

      //Always return object, allowing concatenation of methods
      return $this;
   }
}