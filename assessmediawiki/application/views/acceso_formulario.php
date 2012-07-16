<h1>EvalMediaWiki</h1>

<?php if($this->session->flashdata('message')) : ?>
    <p><?=$this->session->flashdata('message')?></p>
<?php endif; ?>

<?php echo form_open('acceso/index'); ?>
    <?php echo form_fieldset(); ?>

        <div class="textfield">
            <?php echo form_label('user&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', 'user_name'); ?>
			<?php echo form_error('user_name'); ?>
            <?php echo form_input('user_name'); ?>
        </div>

        <div class="textfield">
            <?php echo form_label('password', 'user_pass'); ?>
			<?php echo form_error('user_pass'); ?>
            <?php echo form_password('user_pass'); ?>
        </div>

        <div class="buttons">
            <?php echo form_submit('login', 'Login'); ?>
        </div>

    <?php echo form_fieldset_close();?>
<?php echo form_close(); ?>
