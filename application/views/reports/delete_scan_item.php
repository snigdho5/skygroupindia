<div class="page-content">
   <div class="breadcrumb-section">
      <ul class="breadcrumb">
         <li class="breadcrumb-item"><a href="<?php echo base_url('dashboard');?>"> <i class="fa fa-home" aria-hidden="true"></i> Dashboard</a></li>
         <li class="breadcrumb-item"><?php echo isset($meta_title)?$meta_title:'';?></li>
      </ul>
      <div class="clearfix"></div>
   </div>

	<div class="form_section">
		<div class="container-fluid">
			<div class="row">
				<div class="form-content">
				
				<?php if ($this->session->flashdata('error')!='') { ?>
					<div class="alert alert-danger">
					<?php echo $this->session->flashdata('error'); ?>
					</div>
				<?php } ?>
				<?php if ($this->session->flashdata('success')!='') { ?>
					<div class="alert alert-success">
					<?php echo $this->session->flashdata('success'); ?>
					</div>
				<?php } ?>
				
					<div class="form-row category-form">
						<h2>Delete Item Details</h2>
						<form action="" method="get">
							<?php
								$csrf = array(
									'name' => $this->security->get_csrf_token_name(),
									'hash' => $this->security->get_csrf_hash()
								);
							?>
						   <input type="hidden" name="<?php echo $csrf['name'];?>" value="<?php echo $csrf['hash'];?>" />
						   
							<div class="form-content-inner">
								<div class="col-md-3 col-sm-3">
									<div class="form-group form-left">
										<label for="name"> Store Code </label>
										<input type="text" name="store_code" value="<?php echo $this->input->get('store_code');?>" class="form-control" placeholder="Enter store code" data-validation="required"/>
									</div>
								</div>

								<div class="col-md-3 col-sm-3">
									<div class="form-group form-left">
										<label for="name">From Date </label>
										<input type="text" name="from_date" value="<?php echo $this->input->get('from_date');?>" class="form-control datepicker" placeholder="Select from date" readonly data-validation="required"/>
									</div>
								</div>

								<div class="col-md-3 col-sm-3">
									<div class="form-group form-left">
										<label for="name"> To Date </label>
										<input type="text" name="to_date" value="<?php echo $this->input->get('to_date');?>" class="form-control datepicker" placeholder="Select to date" readonly  data-validation="required" />
									</div>
								</div>
								
								<div class="col-md-3 col-sm-3">
									<div class="form-group form-left">
										<div style="float: right; padding-right: 38px; padding-top: 25px;">
											<input type="submit" class="btn btn-success" onclick="return confirm('This action can delete all GC_DETAILS , SCAN_DETAILS , USER_DETAILS , PRE_STOCK and LOCATION_MAPPING data permanently from the system. Are you sure you want to proceed ?');" value="Delete">
											<button type="button" onclick="clearAll();" class="btn btn-danger">Clear</button>
										</div>
									</div>
								</div>
								<div class="clearfix"></div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>	
</div>
<?php $this->load->view('layouts/includeJS.php'); ?>