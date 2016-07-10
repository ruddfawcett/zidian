<?php

  /**
   * Exports the dictionary.json file.
   */

  $books = json_decode(file_get_contents('dictionary.json'), true);

  $dictionary = [];

  foreach ($books as $lessons) {
    $words = [];
    $root = $lessons['LearningUnit'][0]['SubCategory'];

    foreach ($root as $category) {
      $list = $category['Sentence'];

      foreach ($list as $word) {
        $formatted_word = ['zh' => $word['MajorText'], 'pinyin' => $word['Pinyin'], 'eng' => $word['Def'], 'type' => $word['Parts']];

        $words[] = $formatted_word;
      }
    }

    $lesson = ['book_number' => $lessons['BookSeqNo'],
               'lesson_number' => str_replace('Lesson ', '', $lessons['PrefixName']),
               'name_eng' => $lessons['Name'],
               'name_zh' => $lessons['MajorName'],
               'words' => $words];

    $dictionary[] = $lesson;
  }

  echo json_encode($dictionary);
?>
