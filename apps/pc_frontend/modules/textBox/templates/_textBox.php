<?php use_helper('Javascript') ?>
<?php use_stylesheet('/opTextBoxPlugin/css/textBox.css') ?> 
<?php $id = 'textBox'; ?>
<?php $id .= isset($gadget) ? '_'.$gadget->getId() : '' ?>
<div class="textBox">
<div class="parts">
<div class="partsHeading"><h3><?php echo __("Text Box") ?></h3></div>
<div class="body">
<?php if (isset($form)): ?>
<form id="<?php echo $id ?>_form">
<div id="<?php echo $id ?>_count" class="count" style="float:right;margin:0 auto;">140</div>
<?php echo $form['type'] ?>
<?php echo $form['content']->render(array('id' => $id.'_text_box_content')) ?>
<?php echo $form->renderHiddenFields() ?>
<br />
<?php if (!$sf_user->hasAttribute('sfTwitterAuth_oauth_access_token') || !$sf_user->hasAttribute('sfTwitterAuth_oauth_access_token_secret')): ?>
<a class="twitter" href="<?php echo url_for('/sfTwitterAuth/login')?>">
 <img src="/opTextBoxPlugin/images/twitter_button_1_hi.gif" />
</a>
<?php endif; ?>
<input id="<?php echo $id ?>_submit" type="submit" value="<?php echo __('Submit') ?>" class="submit" />
</form>
<script type="text/javascript">
$('<?php echo $id ?>_form').observe('submit', function(e) {
  e.stop();
  if (this.<?php echo $id ?>_text_box_content.value) {
    request = new Ajax.Request('<?php echo url_for('textBox/updateText') ?>',
      {method: 'post', parameters: this.serialize(), onSuccess: function(obj){
        tl_obj = $('<?php echo $id ?>_timeline');
        tl_obj.innerHTML = obj.responseText + tl_obj.innerHTML;
      }}
    );
    this.reset();
    $('<?php echo $id ?>_text_box_content').onkeyup();
  }
});
$('<?php echo $id ?>_text_box_content').onkeyup = function() {
  submit_obj = $('<?php echo $id ?>_submit');
  count = this.value.length;
  if (count > 140 || count == 0) {
    submit_obj.disable();
  } else {
    submit_obj.enable();
  }
  $('<?php echo $id ?>_count').innerHTML = 140 - count;
};
$('<?php echo $id ?>_text_box_content').onkeyup();
</script>
<?php endif; ?>

<ol id="<?php echo $id ?>_timeline" class="textList">
<?php foreach ($textList as $text): ?>
<?php include_partial('textBox/textRecord', array('text' => $text)); ?>
<?php endforeach; ?>
</ol>
</div>
</div>
</div>
