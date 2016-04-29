<h1>Recent Posts</h1>
<hr />

<ul>
<?php
$stmt = $db->query('SELECT title, slug FROM blog_posts ORDER BY id DESC LIMIT 5');
while($row = $stmt->fetch()){
	echo '<li><a href="'.$row['slug'].'">'.$row['title'].'</a></li>';
}
?>
</ul>

<h1>Catgories</h1>
<hr />

<ul>
<?php
$stmt = $db->query('SELECT catTitle, catSlug FROM blog_cats ORDER BY catID DESC');
while($row = $stmt->fetch()){
	echo '<li><a href="c-'.$row['catSlug'].'">'.$row['catTitle'].'</a></li>';
}
?>
</ul>

<h1>Archives</h1>
<hr />

<ul>
<?php
$stmt = $db->query("SELECT Month(created) as Month, Year(created) as Year FROM blog_posts GROUP BY Month(created), Year(created) ORDER BY created DESC");
while($row = $stmt->fetch()){
	$monthName = date("F", mktime(0, 0, 0, $row['Month'], 10));
	$slug = 'a-'.$row['Month'].'-'.$row['Year'];
	echo "<li><a href='$slug'>$monthName</a></li>";
}
?>
</ul>