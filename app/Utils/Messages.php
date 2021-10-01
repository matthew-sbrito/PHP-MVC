<?php

namespace App\Utils;

class Messages
{

  public static function setError($msg)
  {
    $_SESSION['message'] = ['error' => $msg];
  }

  public static function setSuccess($msg)
  {
    $_SESSION['message'] = ['success' => $msg];
  }
  public static function setWarning($msg)
  {
    $_SESSION['message'] = ['warning' => $msg];
  }

  public static function getMessage()
  {

    $msg = $_SESSION['message'];
    unset($_SESSION['message']);

    if (isset($msg)) {
      $keyMsg = array_keys($msg);
      $message = $msg[$keyMsg[0]];

      $content = self::getToastr($keyMsg[0], $message);
    }
  
    return $content ? $content : '';
  }

  private static function getToastr($status, $msg)
  {
    if ($status == 'error') {
      $cor = 'background-color: rgba(240, 14, 14, 0.8);';
      $icon = 'fas fa-ban';
    } elseif ($status == 'success') {
      $cor = 'background-color: rgba(34, 167, 34, 0.8);';
      $icon = 'far fa-check-circle';
    } elseif ($status == 'warning') {
      $cor = 'background-color: rgba(249, 200, 78, 0.8);';
      $icon = 'fas fa-exclamation-triangle';
    }
    return View::render('components/toastr', [
      'cor' => $cor,
      'text' => $msg,
      'icon' => $icon,
    ]);
  }
}
