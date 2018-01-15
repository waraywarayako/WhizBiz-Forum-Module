<?php '<?xml version="1.0" encoding="UTF-8" ?>' ?>

<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc><?php echo base_url();?></loc> 
        <priority>1.0</priority>
		<changefreq>always</changefreq>
    </url>
    <?php foreach($cat->result() as $caturl) { ?>
    <url>
        <loc><?php echo base_url().'threadsview/'.$caturl->slug; ?></loc>
        <priority>0.9</priority>
		<changefreq>always</changefreq>
    </url>
    <?php } ?>
	
	
	 <?php foreach($post->result() as $posturl) { ?>
    <url>
        <loc><?php echo base_url().'topic/'.$posturl->thread_slug; ?></loc>
        <priority>0.9</priority>
		<changefreq>always</changefreq>
    </url>
    <?php } ?>

</urlset>