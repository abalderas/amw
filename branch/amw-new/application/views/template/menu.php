<div class="row">
    <div class="span12">
        <div class="navbar">
            <div class="navbar-inner">
                <ul class="nav">
                    <?php if ($this->session->userdata('evaluar_access')) { ?>
                	   <li><?php echo anchor(site_url("evaluar"), "Assess"); ?></li>
                       <li class="divider-vertical"></li>
                    <?php } ?>
                    <?php if ($this->session->userdata('feedback_access')) { ?>
					   <li><?php echo anchor(site_url("feedback"), "My assessments"); ?></li>
					   <li class="divider-vertical"></li>
                    <?php } ?>
                    <?php if ($this->session->userdata('metaevaluar_access')) { ?>
                        <li><?php echo anchor(site_url("metaevaluar"), "Metaevaluations"); ?></li>
                        <li class="divider-vertical"></li>
                    <?php } ?>
                    <?php if ($this->session->userdata('metaevaluar_lista_access')) { ?>
                       <li><?php echo anchor(site_url("metaevaluar/lista"), "All Metaevaluations"); ?></li>
                       <li class="divider-vertical"></li>
                    <?php } ?>
                    <?php if ($this->session->userdata('alumnos_access')) { ?>
					   <li><?php echo anchor(site_url("alumnos"), "Students"); ?></li>
                       <li class="divider-vertical"></li>
                    <?php } ?>
                    <?php if ($this->session->userdata('parametros_access')) { ?>
					   <li><?php echo anchor(site_url("parametros"), "Parameters"); ?></li>
					   <li class="divider-vertical"></li>
                    <?php } ?>
                    <?php if ($this->config->item('modo_desarrollo') == TRUE) { ?>
                       <li><?php echo anchor(site_url("test"), "Debug Room"); ?></li>
                       <li class="divider-vertical"></li>
                    <?php } ?>
                    				
					<li class="pull-right"><?php echo anchor(site_url("acceso/salir"), "Logout"); ?></li>
                </ul>
            </div>
        </div>
    </div>
</div> <!-- .row -->