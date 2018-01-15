<?php
if(get_settings('forum_settings','enable_adsense_ads','')!='No'){ ?>
<?php if(is_notloggedin()){ ?>
<div align="center">
	<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
	<!-- Responsive -->
	<ins class="adsbygoogle"
	style="display:block"
	data-ad-client="<?php echo (get_settings('forum_settings','adsense_pub','')!="")?get_settings('forum_settings','adsense_pub',''):"ca-pub-1851075381233863"?>"
	data-ad-slot="<?php echo (get_settings('forum_settings','adsense_adslot','')!="")?get_settings('forum_settings','adsense_adslot',''):"2058264637"?>"
	data-ad-format="auto"></ins>
	<script>
	(adsbygoogle = window.adsbygoogle || []).push({});
	</script><small class="advertisement text-grey">advertisements</small>
</div>
<?php } ?>
<?php } ?>