
<div class="col-md-12">
  <h1 class="pull-left"><i class="zmdi zmdi-google-pages text-success"></i> <?php echo $title; ?></h1>
   
</div>
<div class="clearfix"></div>

<div id="pages-list">

<?php
foreach ($pages as $key => $value) {
	?>
	<a class="page" href="<?php echo base_url(); ?><?php echo config_item("slug_pages"); ?>/<?php echo urlencode($value["title"]); ?>-<?php echo intval($value["idpage"]); ?>">
		<div class="date">
		<?php
		$year = date("Y",strtotime($value['updated']));
		$month = date("m",strtotime($value['updated']));
		$day = date("d",strtotime($value['updated']));			
		?>
			<div class="day"><?php echo $day; ?></div>
			<div class="month"><?php echo $month; ?>-<?php echo $year; ?></div>

		</div>
		<div class="data">
			<h2><?php echo $value['title']; ?></h2>
			<?php echo more($value["text"],250); ?>
		</div>
	</a>
	<?php
}
?>
</div>