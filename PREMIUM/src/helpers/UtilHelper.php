<?php
namespace app\helpers;

class UtilHelper
{
    // Génère une chaîne de caractères aléatoires pour donner un nom unique aux images
    public static function randomString($n)
    {
      $characters = '0123456789abcdefghijklnopqrstuvxywzABCDEFGHIJKLMNOPQRSTUVXYWZ';
      $str = '';

      for ($i = 0; $i < $n; $i++) {
        $index = rand(0, strlen($characters) - 1);
        $str.= $characters[$index];
      }
      return $str;
    }
}