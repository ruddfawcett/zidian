<?php
  /**
   * Generates JSON files with vocbulary from each lesson.
   */

  $lessons = json_decode(file_get_contents('dictionary_full.json'), true);

  foreach ($lessons as $lesson) {
    $book = str_replace('0', '' ,$lesson['book_number']);
    $lesson_number = $lesson['lesson_number'];
    $lesson_name_eng = $lesson['name_eng'];
    $lesson_name_zh = $lesson['name_zh'];

    $words = $lesson['words'];

    if (!file_exists('books/'.$book)) {
      mkdir('books/'.$book);
    }

    $modified_json = [
      'metadata'=> [
        'book' => (int)$book,
        'lesson' =>( int)$lesson_number,
        'name' => [
          'eng' => $lesson_name_eng,
          'zh' => $lesson_name_zh
        ]
      ],
      'vocabulary' => $words
    ];

    $modified_json = json_encode($modified_json);

    if (!file_exists('books/'.$book.'/'.$lesson_number.'.json')) {
      file_put_contents('books/'.$book.'/'.$lesson_number.'.json', $modified_json);
    }
  }

  print_r($lessons);
?>
