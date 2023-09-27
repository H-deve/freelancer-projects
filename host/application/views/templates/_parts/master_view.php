<section>
  <p>Here is where I will put the text</p>
</section>
<?php
$this->load->view('templates/_parts/master_header_view');
?>
<section>
  <?php echo $the_view_content;?>
</section>
<?php
$this->load->view('templates/_parts/master_sidebar_view');
$this->load->view('templates/_parts/master_footer_view');
?>