@extends('layouts.app')
@section('title', __('home.home'))

@section('content')
<!-- Content Header (Page header) -->
<!--<section class="content-header content-header-custom">-->
<!--    <h1>{{ __('home.welcome_message', ['name' => Session::get('user.first_name')]) }}-->
<!--    </h1>-->
<!--</section>-->
<!-- Main content -->
    
<section class="content content-custom no-print bg-body "  >
  <br>
    @if(auth()->user()->can('dashboard.data'))
    	<div class="row ">
            <div class="col-12 col-xs-12">
              @if(count($all_locations) > 1)
                {!! Form::select('dashboard_location', $all_locations, null, ['class' => 'form-control select2', 'placeholder' => __('lang_v1.select_location'), 'id' => 'dashboard_location']); !!}
              @endif
            </div>
    		<div class="col-12 col-xs-12 total-filter">
    			<div class="btn-group " data-toggle="buttons">
    				<label class="btn btn-info active">
        				<input type="radio" name="date-filter"
        				data-start="{{ date('Y-m-d') }}"
        				data-end="{{ date('Y-m-d') }}"
        				checked> {{ __('home.today') }}
      				</label>
      				<label class="btn btn-info">
        				<input type="radio" name="date-filter"
        				data-start="{{ $date_filters['this_week']['start']}}"
        				data-end="{{ $date_filters['this_week']['end']}}"
        				> {{ __('home.this_week') }}
      				</label>
      				<label class="btn btn-info">
        				<input type="radio" name="date-filter"
        				data-start="{{ $date_filters['this_month']['start']}}"
        				data-end="{{ $date_filters['this_month']['end']}}"
        				> {{ __('home.this_month') }}
      				</label>
      				<label class="btn btn-info">
        				<input type="radio" name="date-filter"
        				data-start="{{ $date_filters['this_fy']['start']}}"
        				data-end="{{ $date_filters['this_fy']['end']}}"
        				> {{ __('home.this_fy') }}
      				</label>
                </div>
    		</div>
    	</div>
    	<br>
    <div class="row ">
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 col-12">
      <div class="row row-custom filter-expance">
       
        	<div class="col-md-6 col-sm-6 col-xs-12 col-custom">
    	      <div class="info-box info-box-new-style blue">
    	       
    	        <div class="info-box-content">
    	          <span class="info-box-text">{{ __('home.total_purchase') }}</span>
    	          <span class="info-box-number total_purchase"><i class="fas fa-sync fa-spin fa-fw margin-bottom"></i></span>
    	        </div>
              <span class="info-box-icon bg-aqua"><i class="fal fa-sack-dollar"></i></span>
    	        <!-- /.info-box-content -->
    	      </div>
    	      <!-- /.info-box -->
    	    </div>
    	    <!-- /.col -->
    	    <div class="col-md-6 col-sm-6 col-xs-12 col-custom">
    	      <div class="info-box info-box-new-style green">

    	        <div class="info-box-content">
    	          <span class="info-box-text">{{ __('home.total_sell') }}</span>
    	          <span class="info-box-number total_sell"><i class="fas fa-sync fa-spin fa-fw margin-bottom"></i></span>
    	        </div>
    	        <span class="info-box-icon bg-gre"><i class="fal fa-shopping-bag"></i></span>

    	        <!-- /.info-box-content -->
    	      </div>
    	      <!-- /.info-box -->
    	    </div>
    	    <!-- /.col -->
    	    <div class="col-md-6 col-sm-6 col-xs-12 col-custom ">
    	      <div class="info-box info-box-new-style yellow">

    	        <div class="info-box-content">
    	          <span class="info-box-text">{{ __('home.purchase_due') }}</span>
    	          <span class="info-box-number purchase_due"><i class="fas fa-sync fa-spin fa-fw margin-bottom"></i></span>
    	        </div>
              <span class="info-box-icon bg-yellow ">
              <i class="fal fa-inventory"></i>
    	        </span>
    	        <!-- /.info-box-content -->
    	      </div>
    	      <!-- /.info-box -->
    	    </div>
    	    <!-- /.col -->
            <!-- expense -->
            <div class="col-md-6 col-sm-6 col-xs-12 col-custom ">
              <div class="info-box info-box-new-style red">

                <div class="info-box-content">
                  <span class="info-box-text">
                    {{ __('lang_v1.expense') }}
                  </span>
                  <span class="info-box-number total_expense"><i class="fas fa-sync fa-spin fa-fw margin-bottom"></i></span>
                </div>
                <span class="info-box-icon bg-red">
                <i class="far fa-money-check-alt"></i>
                </span>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>

    	    <!-- fix for small devices only -->
    	    <!-- <div class="clearfix visible-sm-block"></div> -->
    	    <div class="col-md-6 col-sm-6 col-xs-12 col-custom">
    	      <div class="info-box info-box-new-style orange">
    	        

    	        <div class="info-box-content">
    	          <span class="info-box-text">{{ __('home.invoice_due') }}</span>
    	          <span class="info-box-number invoice_due"><i class="fas fa-sync fa-spin fa-fw margin-bottom"></i></span>
    	        </div>
              <span class="info-box-icon bg-yellow">
              <i class="fal fa-file-invoice-dollar"></i>
    	        </span>
    	        <!-- /.info-box-content -->
    	      </div>
    	      <!-- /.info-box -->
    	    </div>

    	    <!-- /.col -->
          <div class="col-md-6 col-sm-6 col-xs-12 col-custom">
    	      <div class="info-box info-box-new-style orange">
    	        

    	        <div class="info-box-content">
    	          <span class="info-box-text">{{ __('home.invoice_due') }}</span>
    	          <span class="info-box-number invoice_due"><i class="fas fa-sync fa-spin fa-fw margin-bottom"></i></span>
    	        </div>
              <span class="info-box-icon bg-yellow">
              <i class="fal fa-file-invoice-dollar"></i>
    	        </span>
    	        <!-- /.info-box-content -->
    	      </div>
    	      <!-- /.info-box -->
    	    </div>
          
    	    <!-- /.col -->
      </div>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 right-box ">
        <div class="body-right-side">
      	<div class="row row-custom Reminder-box ">
          <div class="col-lg-2 col-xs-2">
           <span class="icon"> <i class="light-bg-red text-red far fa-alarm-clock"></i></span>
          </div>
          <div class="col-lg-7 col-xs-7">
           <div class="Heading">
             <h3>Reminder</h3>
             <p>Mr.Asim's Birthday</p>
           </div>
           </div>
          <div class="col-lg-3 col-xs-3">
            <span class="date">23 July</span>
          </div>
        </div>
        <div class="row row-custom Reminder-box border-gray">
         <div class="col-lg-2 col-xs-2">
           <span class="icon"> <i class="light-bg-green text-green far fa-suitcase-rolling"></i></span>
          </div>
          <div class="col-lg-7 col-xs-7">
           <div class="Heading">
             <h3>Upcoming Holidays</h3>
             <p>Eid-Ul-Adha </p>
           </div>
           </div>
          <div class="col-lg-3 col-xs-3">
            <span class="date">23 July</span>
          </div>
        </div>
        <div class="row row-custom Reminder-box border-gray">
          <div class="col-lg-2 col-xs-2">
           <span class="icon"><i class="light-bg-perpal text-perpal far fa-user-clock"></i> </span>
          </div>
          <div class="col-lg-7 col-xs-7">
           <div class="Heading">
             <h3>Attendance</h3>
             <p>july 2021</p>
           </div>
           </div>
          <div class="col-lg-3 col-xs-3">
            <span class="date">23 July</span>
            <span class="absent">0 Absent</span>
          </div>
        </div>
        <div class="row row-custom Reminder-box border-gray">
          <div class="col-lg-2 col-xs-2">
           <span class="icon"> <i class="text-orange light-bg-orange far fa-user-check"></i></span>
          </div>
          <div class="col-lg- col-xs-7">
           <div class="Heading">
             <h3>Leads</h3>
             <p>In the month of July</p>
           </div>
           </div>
          <div class="col-lg-3 col-xs-3">
            <span class="date">2009</span>
          </div>
        </div>
        </div>
      </div>
    </div>



<!-- Task And Activity -->


    <div class="row d-flex task-activity">
      <div class="col-lg-6 col-md-12 my-task">
          <div class="row task-icon">
                <div class="col-12">
              <i class="fas fa-tasks"></i>
                <h2>My Tasks</h2>
                  </div>
          </div>
          <div class="row task-box ">
                <div class="col-12 project-date">
                <p>16-07-2021</p>
                </div>
              <div class="col-12 project d-flex"> 
              <span class="cercial text-dark-red "><i class="fas fa-circle"></i></span>
            
                <p class="project-name">Midad Book Website Desing </p>
                <span class="status btn text-blue light-bg-blue">In Progress</span>
                </div>
              <div class="col-12 priority">
              <span class="status "><p class = "light-bg-red text-dark-red">Urgent</p></span>
              <p class="time"><span>06:00 PM</span></p>
                </div>
          </div>
          <div class="row task-box  border-gray">
                <div class="col-12 project-date">
                <p>17-07-2021</p>
                </div>
              <div class="col-12 project d-flex"> 
              <span class="cercial text-orange "><i class="fas fa-circle"></i></span>
            
                <p class="project-name">Midad Book Website Desing </p>
                <span class="status btn text-gray light-bg-gray">Not Started</span>
                </div>
              <div class="col-12 priority">
              <span class="status "><p class = "light-bg-orange  text-orange">Medium</p></span>
              <p class="time"><span>06:00 PM</span></p>
                </div>
          </div>
          <div class="row task-box  border-gray">
                <div class="col-12 project-date">
                <p>16-07-2021</p>
                </div>
              <div class="col-12 project d-flex"> 
              <span class="cercial text-blue "><i class="fas fa-circle"></i></span>
            
                <p class="project-name">Midad Book Website Desing </p>
                <span class="status btn bg-gre">Compeleted</span>
                </div>
              <div class="col-12 priority">
              <span class="status "><p class = "text-blue light-bg-blue ">Normal</p></span>
              <p class="time"><span>06:00 PM</span></p>
                </div>
          </div>
          <div class="space"></div>
          
      </div>
      <div class="col-lg-6 col-md-6 my-task myactivity">
          <div class="row task-icon">
                <div class="col-lg-6">
                <i class="fas fa-list-ul"></i>
                <h2>My Activities</h2>
               </div>
               <div class="col-lg-6">
               <form class="d-flex">
        <input class="form-control me-2" type="search" placeholder=" Search" 
        aria-label="Search">
      
      </form>
               </div>
          </div>
          <div class="row task-box ">
                <div class="col-12 project-date">
                <p>Today</p>
                </div>
              <div class="col-12 project d-flex"> 
              <span class="cercial text-orange "><i class="fas fa-circle"></i></span>
            
                <p class="project-name">Work Hour: 04:45 PM - 06:00 PM (1Hour) </p>
                <span class="time"><i class="fas fa-clock"></i>
              <span>09:26 AM</span>
              </span>
                </div>
              <div class="col-12 priority">
              <p>Added setting icon, Repot button, Rating for bouth the ad and the user </p>
              
                </div>
          </div>
          <div class="row task-box ">
                <div class="col-12 project-date">
                <p>Today</p>
                </div>
              <div class="col-12 project d-flex"> 
              <span class="cercial text-dark-red  "><i class="fas fa-circle"></i></span>
            
                <p class="project-name">Work Hour: 04:45 PM - 06:00 PM (1Hour) </p>
                <span class="time"><i class="fas fa-clock"></i>
              <span>09:26 AM</span>
              </span>
                </div>
              <div class="col-12 priority">
              <p>Added setting icon, Repot button, Rating for bouth the ad and the user </p>
              
                </div>
          </div>
          <div class="row task-box ">
                <div class="col-12 project-date">
                <p>Today</p>
                </div>
              <div class="col-12 project d-flex"> 
              <span class="cercial text-blue  "><i class="fas fa-circle"></i></span>
            
                <p class="project-name">Work Hour: 04:45 PM - 06:00 PM (1Hour) </p>
                <span class="time"><i class="fas fa-clock"></i>
              <span>09:26 AM</span>
              </span>
                </div>
              <div class="col-12 priority">
              <p>Added setting icon, Repot button, Rating for bouth the ad and the user </p>
              
                </div>
          </div>
          <div class="row task-box ">
                <div class="col-12 project-date">
                <p>Today</p>
                </div>
              <div class="col-12 project d-flex"> 
              <span class="cercial text-blue  "><i class="fas fa-circle"></i></span>
            
                <p class="project-name">Work Hour: 04:45 PM - 06:00 PM (1Hour) </p>
                <span class="time"><i class="fas fa-clock"></i>
              <span>09:26 AM</span>
              </span>
                </div>
              <div class="col-12 priority">
              <p>Added setting icon, Repot button, Rating for bouth the ad and the user </p>
              
                </div>
          </div>
          
      </div>
    </div>

<!-- ToDo-list And Sales Pyment Due  -->

    
<div class="row d-flex task-activity">
      <div class="col-lg-6 col-md-6 my-task todolist">
        
          <div class="row task-icon">
                <div class="col-12">
              <i class="fas fa-tasks"></i>
                <h2>To-do List</h2>
                  </div>
          </div>
              <div class="row task-box ">
                <div class="col-12 project-date">
                <p>19-07-2021</p>
                </div>
          <div class="d-flex">
                <div class="cercal">
                  <span class="cercial text-dark-red "><i class="fas fa-circle"></i>
                  </span>
                  <span class="side-border"><div></div></span>
               </div>
            <div class="todos">
              <div class="col-12 project d-flex"> 
            
                <p class="project-name">Midad Book Website Desing </p>
                <span class="status text-blue light-bg-blue">In Progress</span>
                </div>
                <div class="col-12 priority">
                <span class="status "><p class = "light-bg-red text-dark-red">Urgent</p></span>
                  <p class="time"><span>06:00 PM</span></p>
                </div>
              </div>
        </div>
        <div class="d-flex">
                <div class="cercal">
                  <span class="cercial text-orange  "><i class="fas fa-circle"></i>
                  </span>
                  <span class="side-border"><div></div></span>
               </div>
            <div class="todos">
              <div class="col-12 project d-flex"> 
            
                <p class="project-name">Midad Book Website Desing </p>
                <span class="status text-blue light-bg-blue">In Progress</span>
                </div>
                <div class="col-12 priority">
                <span class="status "><p class = "light-bg-orange text-orange ">Medium</p></span>
                  <p class="time"><span>06:00 PM</span></p>
                </div>
          </div>
        </div>
        <div class="d-flex">
                <div class="cercal">
                  <span class="cercial text-blue"><i class="fas fa-circle"></i>
                  </span>
                  <!-- <span class="side-border"><div></div></span> -->
               </div>
            <div class="todos">
              <div class="col-12 project d-flex"> 
            
                <p class="project-name">Midad Book Website Desing </p>
                <span class="status text-blue light-bg-blue">In Progress</span>
                </div>
                <div class="col-12 priority">
                <span class="status "><p class = "light-bg-blue text-blue">Normal</p></span>
                  <p class="time"><span>06:00 PM</span></p>
                </div>
          </div>
        </div>
      </div>
      <div class="row task-box border-gray ">
                <div class="col-12 project-date">
                <p>19-07-2021</p>
                </div>
          <div class="d-flex">
                <div class="cercal">
                  <span class="cercial text-dark-red "><i class="fas fa-circle"></i>
                  </span>
                  <!-- <span class="side-border"><div></div></span> -->
               </div>
            <div class="todos">
              <div class="col-12 project d-flex"> 
            
                <p class="project-name">Midad Book Website Desing </p>
                <span class="status text-blue light-bg-blue">In Progress</span>
                </div>
                <div class="col-12 priority">
                <span class="status "><p class = "light-bg-red text-dark-red">Urgent</p></span>
                  <p class="time"><span>06:00 PM</span></p>
                </div>
              </div>
        </div>
</div>
          
</div>
  <div class="col-lg-6 col-md-6 my-task myactivity">
          <div class="row task-icon">
                <div class="col-lg-6 col-xs-12">
                <i class="text-green fas fa-money-check-alt"></i>
                <h2>Sale Payment Due </h2>
               </div>
               <div class="col-lg-6 col-xs-12 info-pyment">
               <i class="fas fa-info-circle text-blue"></i>
               </div>
          </div>
          <div class="row">
            <div class="col-lg-8">
              <p>Export to</p>
              <div class="export-file d-flex">
                <p class="light-bg-perat "><i class="fas fa-file-csv text-perat "></i><span>CSV</span></p>
                <p class="light-bg-cgreen"><i class="fas fa-file-excel text-cgreen"></i><span>Excel</span></p>
                <p class="light-bg-red "><i class="fas fa-file-pdf text-dark-red"></i><span>PDF</span></p>
                <p class="light-bg-blue"><i class="fas fa-print text-blue"></i><span>Print</span></p>
                </div>
            </div>
            <div class="col-lg-4 filter">
              <p>Filter</p>
              <div class="filter-icon"><p class="light-bg-orange"><i class="text-orange  fas fa-columns"></i><span>Columns</span> </p></div>
            </div>
          </div>
          <div class="row product-file d-flex">
            <div class="col-lg-11 product-location d-flex">
              <span>Product</span>
              <span>Location</span>
              <span>Current Location</span>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-12 product-data">
              <p>No data available</p>
            </div>
          </div>
          <div class="row p-b-10 pb-10">
            <div class="col-lg-6 show-entries"><p>Showing 0 to 0 of 0 entries</p></div>
            <div class="col-lg-6 next-pre"> <span class="text-blue previous">Previous</span> <span class="text-blue next">Next</span></div>
          </div>
  </div>
 </div>


 <div class="row d-flex task-activity">
        <div class="col-lg-6 col-md-6 my-task todolist ">
          <div class="row task-icon">
                <div class="col-lg-8">
                <i class="text-dark-red fas fa-money-check-alt"></i>
                <h2>Purchase Payment Due </h2>
               </div>
               <div class="col-lg-4 info-pyment">
               <i class="fas fa-info-circle text-blue"></i>
               </div>
          </div>
          <div class="row">
            <div class="col-lg-8">
              <p>Export to</p>
              <div class="export-file d-flex">
                <p class="light-bg-perat "><i class="fas fa-file-csv text-perat "></i><span>CSV</span></p>
                <p class="light-bg-cgreen"><i class="fas fa-file-excel text-cgreen"></i><span>Excel</span></p>
                <p class="light-bg-red "><i class="fas fa-file-pdf text-dark-red"></i><span>PDF</span></p>
                <p class="light-bg-blue"><i class="fas fa-print text-blue"></i><span>Print</span></p>
                </div>
            </div>
            <div class="col-lg-4 filter">
              <p>Filter</p>
              <div class="filter-icon"><p class="light-bg-orange"><i class="text-orange  fas fa-columns"></i><span>Columns</span> </p></div>
            </div>
          </div>
          <div class="row product-file d-flex">
            <div class="col-lg-11 product-location d-flex">
              <span>Product</span>
              <span>Location</span>
              <span>Current Location</span>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-12 product-data">
              <p>No data available</p>
            </div>
          </div>
          <div class="row p-b-10 pb-10">
            <div class="col-lg-6 show-entries"><p>Showing 0 to 0 of 0 entries</p></div>
            <div class="col-lg-6 next-pre"> <span class="text-blue previous">Previous</span> <span class="text-blue next">Next</span></div>
          </div>
   </div>
  <div class="col-lg-6 col-md-6 my-task myactivity">
          <div class="row task-icon">
                <div class="col-lg-6">
                <i class="text-orange fas fa-boxes"></i>
               
                <h2>Product stock alert </h2>
               </div>
               <div class="col-lg-6 info-pyment">
               <i class="fas fa-info-circle text-blue"></i>
               </div>
          </div>
          <div class="row">
            <div class="col-lg-8">
              <p>Export to</p>
              <div class="export-file d-flex">
                <p class="light-bg-perat "><i class="fas fa-file-csv text-perat "></i><span>CSV</span></p>
                <p class="light-bg-cgreen"><i class="fas fa-file-excel text-cgreen"></i><span>Excel</span></p>
                <p class="light-bg-red "><i class="fas fa-file-pdf text-dark-red"></i><span>PDF</span></p>
                <p class="light-bg-blue"><i class="fas fa-print text-blue"></i><span>Print</span></p>
                </div>
            </div>
            <div class="col-lg-4 filter">
              <p>Filter</p>
              <div class="filter-icon"><p class="light-bg-orange"><i class="text-orange  fas fa-columns"></i><span>Columns</span> </p></div>
            </div>
          </div>
          <div class="row product-file d-flex">
            <div class="col-lg-11 product-location d-flex">
              <span>Product</span>
              <span>Location</span>
              <span>Current Location</span>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-12 product-data">
              <p>No data available</p>
            </div>
          </div>
          <div class="row p-b-10 pb-10">
            <div class="col-lg-6 show-entries"><p>Showing 0 to 0 of 0 entries</p></div>
            <div class="col-lg-6 next-pre"> <span class="text-blue previous">Previous</span> <span class="text-blue next">Next</span></div>
          </div>
  </div>
 </div>



 <div class="row">
 <div class="col-lg-12 col-md-12 my-task myactivity sale-order-box">
          <div class="row task-icon">
                <div class="col-lg-6">
                <i class="text-green fas fa-list-alt"></i>
                <h2>Sales Order </h2>
               </div>
               <div class="col-lg-6 info-pyment">
               <!-- <i class="fas fa-info-circle text-blue"></i> -->
               </div>
          </div>
          <div class="row">
            <div class="col-lg-8 d-flex entries">
              <p>Show</p>
              <select class="form-select" aria-label="Default select example">
                <option selected>10</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
              </select>
              <p>entries</p>
            </div>
            <div class="col-lg-4 filter">
               <form class="d-flex">
                <input class="form-control me-2" type="search" placeholder=" Search" 
                aria-label="Search">
              
              </form>
            </div>
          </div>
          <div class="row product-file d-flex">
            <div class="col-lg-12 product-location d-flex product-filter">
              <span>Date </span> <i class="fas fa-sort-alt"></i>
              <span>Order #</span>
              <span>Customer<br>Name</span> <i class="fas fa-sort-alt"></i>
              <span>Contact # </span> <i class="fas fa-sort-alt"></i>
              <span>Location </span> <i class="fas fa-sort-alt"></i>
              <span>Status </span> <i class="fas fa-sort-alt"></i>
              <span>Shiping <br> Status</span>
              <span>Quantity <br>Remaning</span>
              <span>Added <br> By </span> <i class="fas fa-sort-alt"></i>
              <span>Action</span>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-12 product-data">
              <p>No data available</p>
            </div>
          </div>
          <div class="row p-b-10 pb-10">
            <div class="col-lg-6 show-entries"><p>Showing 0 to 0 of 0 entries</p></div>
            <div class="col-lg-6 next-pre"> <span class="text-blue previous">Previous</span> <span class="text-blue next">Next</span></div>
          </div>
  </div>
 </div>
 


    
        @if(!empty($widgets['after_sale_purchase_totals']))
            @foreach($widgets['after_sale_purchase_totals'] as $widget)
                {!! $widget !!}
            @endforeach
        @endif
        @if(!empty($all_locations))
          	<!-- sales chart start -->
          	<div class="row">
          		<div class="col-sm-12">
                    @component('components.widget', ['class' => 'box-primary', 'title' => __('home.sells_last_30_days')])
                      {!! $sells_chart_1->container() !!}
                    @endcomponent
          		</div>
          	</div>
        @endif
        @if(!empty($widgets['after_sales_last_30_days']))
            @foreach($widgets['after_sales_last_30_days'] as $widget)
                {!! $widget !!}
            @endforeach
        @endif
        @if(!empty($all_locations))
          	<div class="row">
          		<div class="col-sm-12">
                    @component('components.widget', ['class' => 'box-primary', 'title' => __('home.sells_current_fy')])
                      {!! $sells_chart_2->container() !!}
                    @endcomponent
          		</div>
          	</div>
        @endif
      	<!-- sales chart end -->
        @if(!empty($widgets['after_sales_current_fy']))
            @foreach($widgets['after_sales_current_fy'] as $widget)
                {!! $widget !!}
            @endforeach
        @endif
      	<!-- products less than alert quntity -->
      	<div class="row">
            <div class="col-sm-6">
                @component('components.widget', ['class' => 'box-warning'])
                  @slot('icon')
                    <i class="fa fa-exclamation-triangle text-yellow" aria-hidden="true"></i>
                  @endslot
                  @slot('title')
                    {{ __('lang_v1.sales_payment_dues') }} @show_tooltip(__('lang_v1.tooltip_sales_payment_dues'))
                  @endslot
                  <table class="table table-bordered table-striped" id="sales_payment_dues_table">
                    <thead>
                      <tr>
                        <th>@lang( 'contact.customer' )</th>
                        <th>@lang( 'sale.invoice_no' )</th>
                        <th>@lang( 'home.due_amount' )</th>
                        <th>@lang( 'messages.action' )</th>
                      </tr>
                    </thead>
                  </table>
                @endcomponent
            </div>
            <div class="col-sm-6">
                @component('components.widget', ['class' => 'box-warning'])
                @slot('icon')
                <i class="fa fa-exclamation-triangle text-yellow" aria-hidden="true"></i>
                @endslot
                @slot('title')
                {{ __('lang_v1.purchase_payment_dues') }} @show_tooltip(__('tooltip.payment_dues'))
                @endslot
                <table class="table table-bordered table-striped" id="purchase_payment_dues_table">
                    <thead>
                      <tr>
                        <th>@lang( 'purchase.supplier' )</th>
                        <th>@lang( 'purchase.ref_no' )</th>
                        <th>@lang( 'home.due_amount' )</th>
                        <th>@lang( 'messages.action' )</th>
                      </tr>
                    </thead>
                </table>
                @endcomponent
            </div>
        </div>
        <div class="row">
            <div class="@if((session('business.enable_product_expiry') != 1) && auth()->user()->can('stock_report.view')) col-sm-12 @else col-sm-6 @endif">
                @component('components.widget', ['class' => 'box-warning'])
                  @slot('icon')
                    <i class="fa fa-exclamation-triangle text-yellow" aria-hidden="true"></i>
                  @endslot
                  @slot('title')
                    {{ __('home.product_stock_alert') }} @show_tooltip(__('tooltip.product_stock_alert'))
                  @endslot
                  <table class="table table-bordered table-striped" id="stock_alert_table" style="width: 100%;">
                    <thead>
                      <tr>
                        <th>@lang( 'sale.product' )</th>
                        <th>@lang( 'business.location' )</th>
                        <th>@lang( 'report.current_stock' )</th>
                      </tr>
                    </thead>
                  </table>
                @endcomponent
            </div>
            @can('stock_report.view')
                @if(session('business.enable_product_expiry') == 1)
                  <div class="col-sm-6">
                      @component('components.widget', ['class' => 'box-warning'])
                          @slot('icon')
                            <i class="fa fa-exclamation-triangle text-yellow" aria-hidden="true"></i>
                          @endslot
                          @slot('title')
                            {{ __('home.stock_expiry_alert') }} @show_tooltip( __('tooltip.stock_expiry_alert', [ 'days' =>session('business.stock_expiry_alert_days', 30) ]) )
                          @endslot
                          <input type="hidden" id="stock_expiry_alert_days" value="{{ \Carbon::now()->addDays(session('business.stock_expiry_alert_days', 30))->format('Y-m-d') }}">
                          <table class="table table-bordered table-striped" id="stock_expiry_alert_table">
                            <thead>
                              <tr>
                                  <th>@lang('business.product')</th>
                                  <th>@lang('business.location')</th>
                                  <th>@lang('report.stock_left')</th>
                                  <th>@lang('product.expires_in')</th>
                              </tr>
                            </thead>
                          </table>
                      @endcomponent
                  </div>
                @endif
            @endcan
      	</div>
        @if(auth()->user()->can('list_quotations'))
        <div class="row" @if(!auth()->user()->can('dashboard.data'))style="margin-top: 190px !important;"@endif>
            <div class="col-sm-12">
                @component('components.widget', ['class' => 'box-warning'])
                    @slot('icon')
                        <i class="fas fa-list-alt text-yellow fa-lg" aria-hidden="true"></i>
                    @endslot
                    @slot('title')
                        {{__('lang_v1.sales_order')}}
                    @endslot
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped ajax_view" id="sales_order_table">
                            <thead>
                                <tr>
                                    <th>@lang('messages.action')</th>
                                    <th>@lang('messages.date')</th>
                                    <th>@lang('restaurant.order_no')</th>
                                    <th>@lang('sale.customer_name')</th>
                                    <th>@lang('lang_v1.contact_no')</th>
                                    <th>@lang('sale.location')</th>
                                    <th>@lang('sale.status')</th>
                                    <th>@lang('lang_v1.shipping_status')</th>
                                    <th>@lang('lang_v1.quantity_remaining')</th>
                                    <th>@lang('lang_v1.added_by')</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                @endcomponent
            </div>
        </div>
    @endif

        @if(!empty($common_settings['enable_purchase_order']))
        <div class="row" @if(!auth()->user()->can('dashboard.data'))style="margin-top: 190px !important;"@endif>
          <div class="col-sm-12">
              @component('components.widget', ['class' => 'box-warning'])
                  @slot('icon')
                      <i class="fas fa-list-alt text-yellow fa-lg" aria-hidden="true"></i>
                  @endslot
                  @slot('title')
                      @lang('lang_v1.purchase_order')
                  @endslot
                <div class="table-responsive">
                  <table class="table table-bordered table-striped ajax_view" id="purchase_order_table" style="width: 100%;">
                      <thead>
                          <tr>
                              <th>@lang('messages.action')</th>
                              <th>@lang('messages.date')</th>
                              <th>@lang('purchase.ref_no')</th>
                              <th>@lang('purchase.location')</th>
                              <th>@lang('purchase.supplier')</th>
                              <th>@lang('sale.status')</th>
                              <th>@lang('lang_v1.quantity_remaining')</th>
                              <th>@lang('lang_v1.added_by')</th>
                          </tr>
                      </thead>
                  </table>
                  </div>
                  @endcomponent
              </div>
          </div>
        @endif
        @if(!empty($widgets['after_dashboard_reports']))
          @foreach($widgets['after_dashboard_reports'] as $widget)
            {!! $widget !!}
          @endforeach
        @endif
    @endif
</section>
<!-- /.content -->
<div class="modal fade payment_modal" tabindex="-1" role="dialog"
    aria-labelledby="gridSystemModalLabel">
</div>
<div class="modal fade edit_pso_status_modal" tabindex="-1" role="dialog"></div>
<div class="modal fade edit_payment_modal" tabindex="-1" role="dialog"
    aria-labelledby="gridSystemModalLabel">
</div>
@stop
@section('javascript')
    <script src="{{ asset('js/home.js?v=' . $asset_v) }}"></script>
    <script src="{{ asset('js/payment.js?v=' . $asset_v) }}"></script>
    @includeIf('sales_order.common_js')
    @includeIf('purchase_order.common_js')
    @if(!empty($all_locations))
        {!! $sells_chart_1->script() !!}
        {!! $sells_chart_2->script() !!}
    @endif
    <script type="text/javascript">
        sales_order_table = $('#sales_order_table').DataTable({
          processing: true,
          serverSide: true,
          scrollY: "75vh",
          scrollX:        true,
          scrollCollapse: true,
          aaSorting: [[1, 'desc']],
          "ajax": {
              "url": '/sells?sale_type=sales_order',
              "data": function ( d ) {
                  d.for_dashboard_sales_order = true;
              }
          },
          columnDefs: [ {
              "targets": 7,
              "orderable": false,
              "searchable": false
          } ],
          columns: [
              { data: 'action', name: 'action'},
              { data: 'transaction_date', name: 'transaction_date'  },
              { data: 'invoice_no', name: 'invoice_no'},
              { data: 'conatct_name', name: 'conatct_name'},
              { data: 'mobile', name: 'contacts.mobile'},
              { data: 'business_location', name: 'bl.name'},
              { data: 'status', name: 'status'},
              { data: 'shipping_status', name: 'shipping_status'},
              { data: 'so_qty_remaining', name: 'so_qty_remaining', "searchable": false},
              { data: 'added_by', name: 'u.first_name'},
          ]
      });
        @if(!empty($common_settings['enable_purchase_order']))
        $(document).ready( function(){
          //Purchase table
          purchase_order_table = $('#purchase_order_table').DataTable({
              processing: true,
              serverSide: true,
              aaSorting: [[1, 'desc']],
              scrollY: "75vh",
              scrollX:        true,
              scrollCollapse: true,
              ajax: {
                  url: '{{action("PurchaseOrderController@index")}}',
                  data: function(d) {
                      d.from_dashboard = true;
                  },
              },
              columns: [
                  { data: 'action', name: 'action', orderable: false, searchable: false },
                  { data: 'transaction_date', name: 'transaction_date' },
                  { data: 'ref_no', name: 'ref_no' },
                  { data: 'location_name', name: 'BS.name' },
                  { data: 'name', name: 'contacts.name' },
                  { data: 'status', name: 'transactions.status' },
                  { data: 'po_qty_remaining', name: 'po_qty_remaining', "searchable": false},
                  { data: 'added_by', name: 'u.first_name' }
              ]
          });
        })
        @endif
    </script>
@endsection

