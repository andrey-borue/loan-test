<?php
/**
 * Затраченное время около 30 минут.
 * Сначала хотел сделать посимвольное чтение из файла, но с utf-8 получилось не особо быстро.
 * В итоге сделал предположение, что если текст и очень большой, то он хотя бы разбит на строки.
 */
const MAX_LENGTH = 9999;
const DELIMITER = ' ';
$input = fopen(__DIR__ . '/task01-input.txt', 'rb');
$output = fopen(__DIR__ . '/task01-output.txt', 'wb');

$i = 1;
while (!feof($input)) {
    $str = fgets($input);
    if (!preg_match_all('/(\w+)([\W\s]+)/u', $str, $words)) {
        fwrite($output, $str);
        continue;
    }
    foreach ($words[1] as $j => $word) {
        if ($i % 15 === 0) {
            $word = '-FIFTEEN-';
        } elseif ($i % 3 === 0) {
            $word = '-THREE-';
        } elseif ($i % 5 === 0) {
            $word = '-FIVE-';
        }
        fwrite($output, $word . $words[2][$j] ?? '');
        $i++;
    }
}

