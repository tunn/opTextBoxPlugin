<li class="text">
<div class="memberImage">
<?php echo link_to(image_tag_sf_image($text->getMember()->getImageFileName(), array('size' => '48x48')), '@obj_member_profile?id='.$text->getMemberId()) ?>
</div>
<div class="body">
<?php echo link_to($text->getMember()->getName(), '@obj_member_profile?id='.$text->getMemberId()) ?>&nbsp;
<?php echo op_auto_link_text($text->getContent()) ?>
<div class="info">
<span class="time"><?php echo op_format_activity_time(strtotime($text->getCreatedAt())) ?>
</span>
</div>
<!--
<div class="operation">
<?php if ($text->getMemberId() == $sf_user->getMemberId()): ?>
<?php echo link_to(__('Delete'), 'textBox/deleteText?id='.$text->getId()) ?>
<?php endif; ?>
</div> -->
</div>
</li>
