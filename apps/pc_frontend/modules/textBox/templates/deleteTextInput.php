<?php slot('text') ?>
<ol class="text">
<?php include_partial('textBox/textRecord', array('text' => $text)) ?>
</ol>
<?php end_slot() ?>

<?php op_include_parts('yesNo', 'delete_activity', array(
  'body' => get_slot('text'),
  'yes_form' => new BaseForm(),
  'no_method' => 'get',
  'no_url' => url_for('textBox/textBox'),
  'title' => __('Do you delete this text?'),
)) ?> 