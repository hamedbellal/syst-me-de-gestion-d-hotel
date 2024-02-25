<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
      <i class="fa fa-book" aria-hidden="true"></i> Gestion des réservations
        <small>Créer / Modifier une réservation</small>
      </h1>
    </section>
    
    <section class="content">
	<div class="row">
            <!-- left column -->
            <div class="col-md-8">
              <!-- general form elements -->
                
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Entrez les détails de la réservation : </h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    
                    <form role="form" id="" action="<?php echo base_url() ?>addedNewBooking" method="post" role="form">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="startDate">Date début</label>
                                        <div class="input-group">
                                            <input type="text" id="startDate" name="startDate" value="" class="form-control" placeholder="yyyy-mm-dd" autocomplete="off"/>
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="endDate">Date fin</label>
                                        <div class="input-group">
                                            <input type="text" id="endDate" name="endDate" value="" class="form-control" placeholder="yyyy-mm-dd" autocomplete="off"/>
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
								<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="floorId">Étage</label>
                                        <select class="form-control" id="floorId" name="floorId">
                                            <option value="">Sélectionnez l'étage</option>
                                            <?php
                                            if(!empty($floors))
                                            {
                                                foreach ($floors as $frs)
                                                {
                                                    ?>
                                                    <option value="<?php echo $frs->floorId ?>"><?php echo $frs->floorCode." - ".$frs->floorName ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>                                      
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="sizeId">Taille de la chambre</label>
                                        <select class="form-control" id="sizeId" name="sizeId">
                                            <option value="">Select taille</option>
                                            <?php
                                            if(!empty($roomSizes))
                                            {
                                                foreach ($roomSizes as $rs)
                                                {
                                                    ?>
                                                    <option value="<?php echo $rs->sizeId ?>"><?php echo $rs->sizeTitle ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
							    <div class="col-md-12 text-right">                                
                                    <button type="button" class="btn btn-primary btn-md" id='checkAvailableBtn'>Verifier la Disponibilité</button>
                                    <!-- <button type="button" class="btn btn-default  btn-md">Reset</button> -->
                                </div>
                            </div>
                            <hr>
                            <div class="row">
							    <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="roomId">Numéro du chambre</label>
                                        <select class="form-control" id="roomId" name="roomId" >
                                            <option value="">Select chambre</option>
                                            <?php
                                            if(!empty($rooms))
                                            {
                                                foreach ($rooms as $rm)
                                                {
                                                    ?>
                                                    <option value="<?php echo $rm->roomId ?>"><?php echo $rm->roomNumber ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>                                      
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="customerId">Client (Cliquer sur <i class="fa fa-search"></i> pour chercher)</label>
                                        <div class="input-group">
                                            <input type="text" value="" class="form-control" id="customerName" name="customerName" placeholder="Type name and click on magnifier" autocomplete="off" />
                                            <div class="input-group-addon">
                                                <i class="fa fa-search" id="searchCustomer"></i>
                                            </div>
                                        </div>
                                        <select class="form-control" id="customerId" name="customerId">
                                            <option value="">Select Client</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="comments">commentaires</label>
                                        <textarea name='comments' id="comments"></textarea>
                                    </div>
                                </div>
                            </div>
                            
                        </div><!-- /.box-body -->
    
                        <div class="box-footer">
                            <input type="submit" class="btn btn-lg btn-primary" value="Enregistrer" />
                            <input type="reset" class="btn btn-default pull-right" value="Annuler" />
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-4">
                <div id="validationDiv" style='display:none'><div class="box box-primary"><div class="box-body"><div class="row"><div class="col-md-12"><div class="callout callout-danger"><h4>Unable to check!</h4><p id='dateValidationMsg'></p></div></div></div></div></div></div>
                <div id='availableRoomDiv'></div>

                <?php
                    $this->load->helper('form');
                    $error = $this->session->flashdata('error');
                    if($error)
                    {
                ?>
                <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $this->session->flashdata('error'); ?>                    
                </div>
                <?php } ?>
                <?php  
                    $success = $this->session->flashdata('success');
                    if($success)
                    {
                ?>
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $this->session->flashdata('success'); ?>
                </div>
                <?php } ?>
                
                <div class="row">
                    <div class="col-md-12">
                        <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bookings.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/tinymce/tinymce.min.js"></script>
<script type="text/javascript">
tinymce.init({
    selector: "textarea",
    plugins: [
        "advlist autolink lists link image charmap print preview anchor",
        "searchreplace visualblocks code fullscreen",
        "insertdatetime media table contextmenu paste"
    ],
    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
});
</script>
