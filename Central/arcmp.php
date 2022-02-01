<?php

$a=[
    'L'=>22,
    'S'=>33,
    'XL'=>11
];

$b=[
    'S'=>0,
    'M'=>0,
    'L'=>0,
    'XL'=>0,
    '2XL'=>0,
    '3XL'=>0,
    '4XL'=>0
];


print_r($a);
echo '<hr>';
print_r($b);
echo '<hr>';

print_r(array_intersect_key($a,$b));
echo '<hr>';
print_r(array_intersect_key($b,$a));
?>