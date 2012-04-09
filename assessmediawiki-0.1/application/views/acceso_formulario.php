<h1>AssessMediaWiki</h1>

<?php if($this->session->flashdata('message')) : ?>
    <p><?=$this->session->flashdata('message')?></p>
<?php endif; ?>

<?php echo form_open('acceso/index'); ?>
    <?php echo form_fieldset('Acceso'); ?>

        <div class="textfield">
            <h3>Introduzca sus datos de acceso a WikiASO:</h3>
        </div>

        <div class="textfield">
            <?php echo form_label('usuario&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', 'user_name'); ?>
			<?php echo form_error('user_name'); ?>
            <?php echo form_input('user_name'); ?>
        </div>

        <div class="textfield">
            <?php echo form_label('contraseña', 'user_pass'); ?>
			<?php echo form_error('user_pass'); ?>
            <?php echo form_password('user_pass'); ?>
        </div>

        <div class="buttons">
            <?php echo form_submit('login', 'Login'); ?>
        </div>

    <?php echo form_fieldset_close();?>
<?php echo form_close(); ?>
