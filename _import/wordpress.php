<?php
	include 'markdownify_extra.php';
	$leap = MDFY_LINKS_EACH_PARAGRAPH;
	$keephtml = MDFY_KEEPHTML;
	$md = new Markdownify_Extra($leap, MDFY_BODYWIDTH, $keephtml);

	$outputroot = realpath($_SERVER['argv'][1]).'/';

	$db = mysql_connect('localhost', 'root', 'epsilon9032') or die("Connect failed\n");
	mysql_select_db('stut', $db) or die("Select failed\n");

	$query1 = mysql_query('select * from wp_posts where post_type = "post" and post_status = "publish"');

	$sql = 'SELECT t.taxonomy, term.name, term.slug FROM wp_term_relationships AS tr INNER JOIN wp_term_taxonomy AS t ON t.term_taxonomy_id = tr.term_taxonomy_id INNER JOIN wp_terms AS term ON term.term_id = t.term_id WHERE tr.object_id = %%ID%% ORDER BY tr.term_order';

	while ($row = mysql_fetch_assoc($query1))
	{
		$title = $row['post_title'];
		$slug = $row['post_name'];
		$date = $row['post_date'];
		$content = $row['post_content'];
		$output_filename = $outputroot.array_shift(explode(' ', $row['post_date'])).'-'.$slug.'.markdown';
		$cats = array();
		$tags = array();

		$query2 = mysql_query(str_replace('%%ID%%', $row['ID'], $sql));
		while ($row2 = mysql_fetch_assoc($query2))
		{
			if ($row2['taxonomy'] == 'category')
			{
				$cats[] = $row2['slug'];
			}
			elseif ($row2['taxonomy'] == 'post_tag')
			{
				$tags[] = $row2['slug'];
			}
			else
			{
				var_dump($row2);
				break;
			}
		}

		$fp = fopen($output_filename, 'wt');

		fwrite($fp, "---\n");
		fwrite($fp, "layout: \"post\"\n");
		fwrite($fp, "title: \"".str_replace('"', '\\"', $title)."\"\n");
		fwrite($fp, "time: ".date('H:i:s', strtotime($date))."\n");
		if (count($cats) > 0)
		{
			fwrite($fp, "categories: \n");
			foreach ($cats as $cat)
			{
				fwrite($fp, "- ".$cat."\n");
			}
		}
		if (count($tags) > 0)
		{
			fwrite($fp, "tags: \n");
			foreach ($tags as $tag)
			{
				fwrite($fp, "- ".$tag."\n");
			}
		}
		fwrite($fp, "---\n");
		fwrite($fp, $content);
		fclose($fp);
	}
