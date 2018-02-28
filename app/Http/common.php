<?php

function returnError($message) {
  header('HTTP/1.1 500 Internal Server Booboo');
  header('Content-type: application/json; charset=UTF-8');
  die(json_encode(array('message' => $message, 'code' => 'custom')));
}
