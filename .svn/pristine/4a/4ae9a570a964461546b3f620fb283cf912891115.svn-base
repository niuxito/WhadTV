<?php echo $this->element('config');?>
<?php echo $content_for_layout; ?>
<script type="text/javascript">//<![CDATA[

	/*

	########################
	### Adequació footer ###
	########################

	*/

	var zd_rs=0;

	function ftrPst() {
		var fb=jQ('#contnr').height(), fw=jQ(window).height();
		if (fb!=fw) {
			var h=jQ('#contnt').height()+(fw-fb), t=h+'px', w=jQ('#contnt .wrap'); jQ('#contnt').css({ 'min-height': t, 'height': t });
			w.height('auto'); if (w.height()<h) w.height(h);
		};
	}

	jQ(document).ready(function(){
		jQ(window).resize(function(){ if(!zd_rs){ zd_rs=1; setTimeout("ftrPst();zd_rs=0;", 100); } });
		ftrPst();
	});

//]]></script>

