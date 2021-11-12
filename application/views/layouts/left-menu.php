<?php
   $controller = $this->router->fetch_class();
   $methods    = $this->router->fetch_method();
?>
<div id="left-panel">
    <nav class="navbar navbar-default">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
        </div>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <section id="only-one" data-accordion-group>
                <ul class="page-sidebar-menu">
                    <li data-accordion <?php if($controller=='dashboard' && $methods=='index'){ ?> class="active"
                        <?php } ?>  >
                        <a href="<?php echo base_url('dashboard');?>" title="Dashboard"><i class="fa fa-dashboard"></i>  Dashboard </a>
                    </li>
                    <li data-accordion <?php if( $controller == 'branch' || $controller == 'users'){?> class="open" <?php } ?> >
                        <a href="javascript:void(0);" title="Master Entry" data-control> <i class="fa fa-user-plus" aria-hidden="true"></i> Manage Master </a>
                        <ul class="submenu" data-content >
                            <li>
                                <a href="<?php echo base_url('branch');?>" title="Manage Branch" <?php if( $controller == 'branch' ) { ?> class="active" <?php } ?> > <i class="fa fa-arrow-right" aria-hidden="true"></i> Manage Branch </a>
                            </li>
                            <li>
                                <a href="<?php echo base_url('users');?>" title="Manage Users" <?php if( $controller == 'users' ) { ?> class="active" <?php } ?> > <i class="fa fa-arrow-right" aria-hidden="true"></i> Manage Users </a>
                            </li>
                        </ul>
                    </li>
					
					<li data-accordion <?php if( $controller == 'ScanDetailsUpload' ){?> class="open" <?php } ?> >
                        <a href="javascript:void(0);" title="Scan Items Upload" data-control> <i class="fa fa-user-plus" aria-hidden="true"></i> Scan Items Upload </a>
                        <ul class="submenu" data-content >
                            <li>
								<a href="<?php echo base_url('item-master-upload');?>" title="Item Master Upload" <?php if( $controller == 'ScanDetailsUpload' && $methods =='itemMasterUpload' ) { ?> class="active" <?php } ?> > <i class="fa fa-arrow-right" aria-hidden="true"></i> Item Master Upload </a>
								
								<a href="<?php echo base_url('delete-item-master');?>" title="Delete Item Master" <?php if( $controller == 'ScanDetailsUpload' && $methods =='deleteItemMaster' ) { ?> class="active" <?php } ?> > <i class="fa fa-arrow-right" aria-hidden="true"></i> Delete Item Master </a>
							
                                <a href="<?php echo base_url('pre-stock-upload');?>" title="Pre Stock Upload" <?php if( $controller == 'ScanDetailsUpload' && $methods =='preStockUpload' ) { ?> class="active" <?php } ?> > <i class="fa fa-arrow-right" aria-hidden="true"></i> Pre Stock Upload  </a>
								
								<a href="<?php echo base_url('location-mapping-upload');?>" title="Location Mapping Upload" <?php if( $controller == 'ScanDetailsUpload' && $methods =='locationMappingUpload' ) { ?> class="active" <?php } ?> > <i class="fa fa-arrow-right" aria-hidden="true"></i> Location Mapping Upload  </a>
								
								<a href="<?php echo base_url('scan-details-upload');?>" title="Scan Details Upload" <?php if( $controller == 'ScanDetailsUpload' && $methods =='index' ) { ?> class="active" <?php } ?> > <i class="fa fa-arrow-right" aria-hidden="true"></i> Scan Details Upload  </a>
								
								<a href="<?php echo base_url('delete-scan-details-item');?>" title="Delete Item Details" <?php if( $controller == 'ScanDetailsUpload' && $methods =='deleteScanItem' ) { ?> class="active" <?php } ?> > <i class="fa fa-arrow-right" aria-hidden="true"></i> Delete Item Details</a>
								
								<a href="<?php echo base_url('gc-upload');?>" title="GC Upload" <?php if( $controller == 'ScanDetailsUpload' && $methods =='gcUpload' ) { ?> class="active" <?php } ?> > <i class="fa fa-arrow-right" aria-hidden="true"></i> GC Upload Data </a>
								
								<a href="<?php echo base_url('user-details-upload');?>" title="GC/User Details Upload" <?php if( $controller == 'ScanDetailsUpload' && $methods =='userDetailsUpload' ) { ?> class="active" <?php } ?> > <i class="fa fa-arrow-right" aria-hidden="true"></i> User Details Upload </a>
								
								<a href="<?php echo base_url('variance-register-details-upload');?>" title="Variance Rgister (Details) Upload" <?php if( $controller == 'ScanDetailsUpload' && $methods =='varianceReportUpload' ) { ?> class="active" <?php } ?> > <i class="fa fa-arrow-right" aria-hidden="true"></i> Variance Rgister(Details) Upload  </a>
								
                            </li>
                        </ul>
                    </li>
					
					<li data-accordion <?php if( $controller == 'Reports' ){?> class="open" <?php } ?> >
                        <a href="javascript:void(0);" title="Scan Items Upload" data-control> <i class="fa fa-user-plus" aria-hidden="true"></i> Reports </a>
                        <ul class="submenu" data-content >
							<li>
                                <a href="<?php echo base_url('location-wise-user-details-report');?>" title="Location Wise User Details Report" <?php if( $controller == 'Reports' && $methods == 'locationWiseUserDetailsReport' ) { ?> class="active" <?php } ?> > <i class="fa fa-arrow-right" aria-hidden="true"></i> Location Wise User Details Report  </a>
                            </li>
						
                            <li>
                                <a href="<?php echo base_url('scan-details-upload-report');?>" title="Scan Details Upload Report" <?php if( $controller == 'Reports' && $methods == 'index' ) { ?> class="active" <?php } ?> > <i class="fa fa-arrow-right" aria-hidden="true"></i> Scan Details Upload Report  </a>
                            </li>
							
							<li>
                                <a href="<?php echo base_url('invalid-EAN-report');?>" title="Invalid EAN Report" <?php if( $controller == 'Reports' && $methods == 'invalidEANreport' ) { ?> class="active" <?php } ?> > <i class="fa fa-arrow-right" aria-hidden="true"></i> Invalid EAN Report  </a>
                            </li>
							
							<li>
                                <a href="<?php echo base_url('valid-EAN-report');?>" title="Valid EAN Report" <?php if( $controller == 'Reports' && $methods == 'validEANreport' ) { ?> class="active" <?php } ?> > <i class="fa fa-arrow-right" aria-hidden="true"></i> Valid EAN Report  </a>
                            </li>
							
							<li>
                                <a href="<?php echo base_url('Reports/missing_location');?>" title="Missing Location Report" <?php if( $controller == 'Reports' && $methods == 'missing_location' ) { ?> class="active" <?php } ?> > <i class="fa fa-arrow-right" aria-hidden="true"></i> Missing Location Report  </a>
                            </li>
							
							<li>
                                <a href="<?php echo base_url('without-barcode-report');?>" title="Without Barcode(WBC) Reports" <?php if( $controller == 'Reports' && $methods == 'withoutBarCodeReport' ) { ?> class="active" <?php } ?> > <i class="fa fa-arrow-right" aria-hidden="true"></i> Without Barcode(WBC) Reports  </a>
                            </li>
							
							<li>
                                <a href="<?php echo base_url('variance-register-report');?>" title="Variance Register(Details) Reports" <?php if( $controller == 'Reports' && $methods == 'varianceRegisterReport' ) { ?> class="active" <?php } ?> > <i class="fa fa-arrow-right" aria-hidden="true"></i> Variance Register(Details) Reports  </a>
                            </li>
							
							<li>
                                <a href="<?php echo base_url('variance-reconcilation-report');?>" title="Variance Reconcilation Reports" <?php if( $controller == 'Reports' && $methods == 'varianceReconcilationReport' ) { ?> class="active" <?php } ?> > <i class="fa fa-arrow-right" aria-hidden="true"></i> Variance Reconcilation Reports  </a>
                            </li>
							
							<li>
                                <a href="<?php echo base_url('location-wise-print');?>" title="Location Wise Print" <?php if( $controller == 'Reports' && $methods == 'locationWisePrint' ) { ?> class="active" <?php } ?> > <i class="fa fa-arrow-right" aria-hidden="true"></i> Location Wise Print </a>
                            </li>
							
							<li>
                                <a href="<?php echo base_url('location-wise-print-details');?>" title="Location Wise Print" <?php if( $controller == 'Reports' && $methods == 'locationWisePrintDetails' ) { ?> class="active" <?php } ?> > <i class="fa fa-arrow-right" aria-hidden="true"></i> Location Wise Print Details</a>
                            </li>
							
                        </ul>
                    </li>
					
					
                </ul>
            </section>
        </div>
    </nav>
</div>