<?php
$content = file_get_contents('includes/inc.php');

// Replace $data[word] with $data['word']
$content = preg_replace('/\$data\[(?!"|\')([a-zA-Z_][a-zA-Z0-9_]*?)\]/', '$data[\'$1\']', $content);

// Replace $data[$i][word] with $data[$i]['word']
$content = preg_replace('/\$data\[\$i\]\[(?!"|\')([a-zA-Z_][a-zA-Z0-9_]*?)\]/', '$data[$i][\'$1\']', $content);

// Replace )[word] or ][word] with )['word'] or ]['word']
$content = preg_replace('/(?<=\)|\])\[(?!"|\')([a-zA-Z_][a-zA-Z0-9_]*?)\]/', '[\'$1\']', $content);

file_put_contents('includes/inc.php', $content);
echo "Fixed unquoted keys in inc.php\n";
