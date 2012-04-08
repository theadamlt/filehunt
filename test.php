<?php
echo 0x0+2;
echo "<br />";
echo 0x0+3.5;
echo "<br />";
echo 0x0+2e1;
echo "<br />";
echo "<br />";


$x = "!";
$y = 0;
echo "Increments: <br />";
while ($y < 4) {
	$x++;
	$y++;
	echo $x."<br />";
}

echo "Decrements: <br />";
while ($y > 0) {
	$x--;
	$y--;
	echo $x."<br />";
}


echo "That last fella' <br />";
$x = "y";

echo (int)($x < "yy"), "<br />";
$x++;
echo (int)($x < "yy"), "<br />";
$x++;
echo (int)($x < "yy"), "<br />";

echo true+1;

?>