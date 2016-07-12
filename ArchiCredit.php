<?php
class ArchiCredit
{ 
  protected $server_ip;
  protected $server_port;

  public function setServerIp($server_ip) {
     $this->server_ip = $server_ip;
  }
  public function setServerPort($server_port) {
    $this->server_port = $server_port;
  }

  /**
   * 
   */
  public function getClients(){
    $postDataGetClients = array(
      'command' => 'getclients',
      'value'   => array('rpid' => '1'),
      'check'   => '2fd06c4c24be4f760143a5346409794e',
    );
    $clientsArray = $this->curlResponse($postDataGetClients);
    return $clientsArray;
  }

  /**
   * 
   */
  public function getClientInfo($id){
    //$id = (string)$id;
  	$check = md5('getclientinfo' . $id);
    $postDataClientInfo = array(
    'command' => 'getclientinfo',
    'value'   => array('clientid' => $id),
    'check'   => $check,
    );
    $clientsInfoArray = $this->curlResponse($postDataClientInfo);
    return $clientsInfoArray;
  }
  
  public function getDictonaryUsers() {
  	$check = md5('getdictionaryUSERS');
  	$postData = array(
      'command' => "getdictionary",
      'value' => array('name' => 'USERS'),
      'check' => $check
  		);
  	$dictonaryUsers = $this->curlResponse($postData);
    return $dictonaryUsers;
  }

  public function getorders($clientname){
    $check = md5('getorders' . $clientname . '1,23');
    $postData = array(
      'command' => "getorders",
      'value' => array('clientname' => $clientname, 'rpid' => '1,23'),
      'check' => $check
      );
    $orders = $this->curlResponse($postData);
    return $orders;
  }

  public function getorderstatus($orderNumber){
    $check = md5('getorderstatus' . $orderNumber);
    $postData = array(
      'command' => "getorderstatus",
      'value' => array('ordernumber' => $orderNumber),
      'check' => $check
      );
    $status = $this->curlResponse($postData);
    return $status;
  }

  public function authorization ($username, $password){
    $check = md5('authorization' . $username . $password);
    $postData = array(
      'command' => "authorization",
      'value' => array('username' => $username, 'password' => $password),
      'check' => $check
      );
    $auth = $this->curlResponse($postData);
    return $auth;
  }
  
  /**
   * Post a request to the server.
   * @param  [type] $_data [description]
   * @return [type]        [description]
   */
  private function curlResponse($_data)
  {
    $ch = curl_init($this->server_ip);
    curl_setopt_array($ch, array(
      CURLOPT_POST           => true,
      CURLOPT_PORT           => $this->server_port,
      CURLOPT_POSTFIELDS     => json_encode($_data),
      CURLOPT_RETURNTRANSFER => true,
    ));

// Send the request
    $response = curl_exec($ch);

// Check for errors
    if ($response === false) {
      die(curl_error($ch));
    }

// Decode the response
    $responseData = json_decode($response, true);

    return $responseData;
  }

}
?>