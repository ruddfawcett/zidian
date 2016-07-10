<?php

  /**
   * Inefficiently uploads all of the lesson vocabulary to quizlet.
   */

  $token = '';

  for ($i = 1; $i <= 48; $i++) {
    $lesson = json_decode(file_get_contents('books/all/'.$i.'.json'), true);

    $terms = [];
    $defs = [];
    $lang_terms = 'zh-CN';
    $lang_definitions = 'en';
    $subjects = ['chinese'];
    $allow_discussion = true;
    $visibility = 'public';
    $editable = 'only_me';
    $whitespace = true;

    // For sets that that were uploaded with pinyin and English, not Chinese/English with pinyin.
    //
    // $title = 'Lesson '.$lesson['metadata']['lesson'].' Vocabulary (Pinyin/English)';
    //
    // foreach ($lesson['vocabulary'] as $word) {
    //   $terms[] = $word['pinyin'];
    //   $defs[] = $word['eng'];
    // }

    $title = 'Lesson '.$lesson['metadata']['lesson'].' Vocabulary';

    foreach ($lesson['vocabulary'] as $word) {
      $terms[] = $word['zh'];
      $defs[] = $word['eng'].' '.$word['pinyin'];
    }

    $lesson_modified = [
      'whitespace' => $whitespace,
      'title' => $title,
      'terms' => $terms,
      'definitions' => $defs,
      'lang_terms' => $lang_terms,
      'lang_definitions' => $lang_definitions,
      'subjects' => $subjects,
      'allow_discussion' => $allow_discussion,
      'editable' => $editable,
      'visibility' => $visibility
    ];

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL,"https://api.quizlet.com/2.0/sets");
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: Bearer '.$token]);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($lesson_modified));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);
    curl_setopt($ch, CURLOPT_TIMEOUT, 20);

    $response = curl_exec($ch);
    print $response;

    curl_close ($ch);
  }
?>
