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
					<div class="form-row category-form">
						<h2>Search</h2>
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
										<label for="name"> Stock Take No </label>
										<input type="text" name="stock_take_no" value="<?php echo $this->input->get('stock_take_no');?>" class="form-control" placeholder="Enter stock take no" />
									</div>
								</div>
							
								<div class="col-md-3 col-sm-3">
									<div class="form-group form-left">
										<label for="name"> Store Code </label>
										<input type="text" name="store_code" value="<?php echo $this->input->get('store_code');?>" class="form-control" placeholder="Enter store code" />
									</div>
								</div>

								<div class="col-md-3 col-sm-3">
									<div class="form-group form-left">
										<label for="name"> From Date </label>
										<input type="text" name="from_date" value="<?php echo $this->input->get('from_date');?>" class="form-control datepicker" placeholder="Select from date" readonly />
									</div>
								</div>

								<div class="col-md-3 col-sm-3">
									<div class="form-group form-left">
										<label for="name"> To Date </label>
										<input type="text" name="to_date" value="<?php echo $this->input->get('to_date');?>" class="form-control datepicker" placeholder="Select to date" readonly />
									</div>
								</div>
								
								<div class="col-md-3 col-sm-3">
									<div class="form-group form-left">
										<div style="float: right; padding-right: 38px; padding-top: 25px;">
											<input type="submit" class="btn btn-success" value="Search">
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
	
	<div class="search-result">
		<div class="container-fluid">
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
			<div class="row">
				<div class="col-md-12">
					<div class="table-responsive">
						<div class="search-result-table">
			
			<table class="table table-bordered table-striped table-datatable-export">
				<thead class="thead-inverse">
					<tr>
						<th>Date</th>
						<th>Stock Take No</th>
						<th>Store Code</th>
						<th>Location No</th>
						<th>valid Qty</th>
						<th>Select</th>
					</tr>
				</thead>
				<tbody>
				<?php
				if(isset($locationWisePrint) && !empty($locationWisePrint))
				{
					foreach ($locationWisePrint as $value)
					{
						//echo "<pre>";print_r($value);
				?>
					<tr>
						<td><?php echo isset($value['date'])?date('d-m-Y',strtotime($value['date'])):'';?></td>
						<td><?php echo isset($value['stock_take_no'])?$value['stock_take_no']:'';?></td>
						<td><?php echo isset($value['store_code'])?$value['store_code']:'';?></td>
						<td><?php echo isset($value['location'])?$value['location']:'';?></td>
						<td><?php echo isset($value['valid_scan'])?$value['valid_scan']:'';?></td>
						<td></td>
					</tr>
				<?php
					}
				}else{
					?>
					<tr>
						<td colspan="16" align="center" valign="middle" class="blue-block">No Records Found</td>
					</tr>
				<?php } ?>
				</tbody>
			</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php $this->load->view('layouts/includeJS.php'); ?>