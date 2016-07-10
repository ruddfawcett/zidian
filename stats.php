<?php

  $lessons = json_decode(file_get_contents('dictionary_full.json'), true);

  $numLessons = 0;
  $numWords = 0;

  foreach ($lessons as $lesson) {
    $numLessons++;

    foreach ($lesson['words'] as $word) {
      $numWords++;
    }
  }

  echo $numLessons.PHP_EOL.$numWords;

 ?>
