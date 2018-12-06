<?php

   function random_num($size) {
      $alpha_key = '';
      $keys = range('A', 'Z');

      for ($i = 0; $i < 5; $i++) {
         $alpha_key .= $keys[array_rand($keys)];
      }

      $length = $size - 4;

      $key = '';
      $keys = range(0, 9);

      for ($i = 0; $i < $length; $i++) {
         $key .= $keys[array_rand($keys)];
      }

      // $special_key = '';
      // $special_keys = ["", "$"];

      // for ($i = 0; $i < 2; $i++) {
      //    $special_key .= $special_keys[array_rand($special_keys)];
      // }

      // return str_shuffle($alpha_key . $key . $special_key);
      
      return ucfirst(str_shuffle(strtolower($alpha_key . $key)));

   }

   echo json_encode(random_num(rand(12, 12)));