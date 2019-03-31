<div class="page-head">
   <div class="container">
        <div class="page-title">
			<h1>Calendar <small> for Holidays, Leaves &amp; Shifts</small></h1>
		</div>  
    </div>
</div>
<div class="page-content">
    <div class="container">
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <a href="<?php echo URL_VIEW;?>"><i class="fa fa-home"></i>&nbsp;Home</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <a href="<?php echo URL_VIEW.'calendar/showCalendar';?>">Calendar</a>
            </li>
        </ul>
        <div class="row margin-top-10">
            <div class="col-md-3 col-sm-12">
                <div class="portlet light">
                    <div class="portlet-title">
                        <div class="caption caption-md">
                            <i class="icon-bar-chart theme-font hide"></i>
                            <span class="caption-subject theme-font bold uppercase">Labels</span>
                            <!-- <span class="caption-helper hide">weekly stats...</span> -->
                        </div>
                    </div>
                    <div class="portlet-body">
                        <ul class="feeds">
                            <li>
                                <div class="col1">
                                    <div class="cont">
                                        <div class="cont-col1">
                                            <div class="label label-sm label-success" style="height: 20px;width: 20px;background-color:black;">
                                            </div>
                                        </div>
                                        <div class="cont-col2">
                                            <div class="desc">
                                                Public Holidays
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                        <hr>
                        <div>Per Organization</div>
                        <br>
                        <ul class="feeds">

                            <?php 
                                   $count=0;
                                   if(isset($loginUserRelationToOther->userOrganization) && !empty($loginUserRelationToOther->userOrganization)){
                                       foreach($loginUserRelationToOther->userOrganization as $k=>$v){
                                            $color = dechex(hexdec('100099') + hexdec($count));

                                            if($color >= 'eeeeee'){ 
                                                $count = dechex($k*132);
                                            }
                                            foreach($v as $k1=>$v1){
                                                echo "<input type='hidden' id='orgColor_".$k."' value='#".$color."'/>";
                                            }

                                            echo    '<li>
                                                        <div class="col1">
                                                            <div class="cont">
                                                                <div class="cont-col1">
                                                                    <div class="label label-sm label-success" style="height: 20px;width: 20px;background-color:#'.$color.';">
                                                                    </div>
                                                                </div>
                                                                <div class="cont-col2">
                                                                    <div class="desc">'.$k1.'
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>';
                                            $count=dechex(hexdec($count)+111166);
                                       }
                                   }
                                ?> 
                            
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="portlet light">
                    <div class="portlet-title">
                        <div class="caption caption-md">
                            <i class="icon-bar-chart theme-font hide"></i>
                            <span class="caption-subject theme-font bold uppercase">Calendar</span>
                            <!-- <span class="caption-helper hide">weekly stats...</span> -->
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="row">
                            <div class="col-md-12">
                                <img src="<?=URL_IMAGE;?>loading-x.gif" id="loadingimage" alt="loading, Please wait..."/>
                                <style>
                                    #loadingimage{
                                        display: block;
                                        margin-left: auto;
                                        margin-right: auto
                                    }
                                </style>
                                <div id="calendar12" class="has-toolbar">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {  
        
    toastr.options = {
      "closeButton": false,
      "debug": false,
      "newestOnTop": false,
      "progressBar": true,
      "positionClass": "toast-top-right",
      "preventDuplicates": false,
      "onclick": null,
      "showDuration": "300",
      "hideDuration": "200",
      "timeOut": "9000",
      "extendedTimeOut": "12000",
      "showEasing": "swing",
      "hideEasing": "linear",
      "showMethod": "fadeIn",
      "hideMethod": "fadeOut"
    }
        function loadCalender(){
        $.ajax({
            url:'<?php echo URL."Users/wholeCalendar/".$user_id.".json";?>',
            dataType:'jsonp',
            beforeSend: function(){
                $('#loadingimage').show();
            },
            complete: function(){
                $('#loadingimage').hide();
            },
            success:function(data){
                if(data.result != null){
                var data3=$.map(data.result,function(k,v){
                    return {
                        title:k.title,
                        start:k.start,
                        end:k.end,
                        backgroundColor:$('#orgColor_'+k.org.id).val(),
                        description:k.description,
                        stat:k.status,
                        branchId:k.branch_name
                    }
               });
                } else{
                    var data3={};
                }
            var data1=[];
          $.ajax({
                    url:'http://data.gov.au/api/action/datastore_search?resource_id=0f94ad45-c1b4-49de-bada-478ccd3805f0',
                    // dataType:"jsonp",
                    async:false,
                    success:function(data){
                        if(data.result.records != null){
                            var data2=$.map(data.result.records,function(v,k){
                                if(v.ACT == "TRUE"){
                                    stY=v.DTSTART.substring(0,4);
                                    stM=v.DTSTART.substring(4,6);
                                    stD=v.DTSTART.substring(6,8);
                                    enY=v.DTEND.substring(0,4);
                                    enM=v.DTEND.substring(4,6);
                                    enD=v.DTEND.substring(6,8);
                                    return{
                                    title:v.Summary,
                                    start:stY+"-"+stM+"-"+stD,
                                    end:enY+"-"+enM+"-"+enD,
                                    borderColor:'black',
                                    backgroundColor:'black',
                                    textColor:'white',
                                    description:v.Description
                                    }
                                }
                            });
                        }else{
                            var data2={};
                        }
                        data1 = $.merge(data3, data2);
                    }
                });
               $('#calendar12').fullCalendar({
        			header: {
        				left: 'prev,next today',
        				center: 'title',
        				right: 'month,agendaWeek,agendaDay'
        			},
        			defaultDate: new Date(),
        			//editable: true,
                    //droppable: true,
                    displayEventEnd:true,
        			eventLimit: true,
        			events: data1,
                    eventRender: function (event, element, view) {  
                        //to all event add sth event.prepend()
                        if(event.title=='Shift'){
                            if(event.stat == 0){
                                var status = "Open shift";
                            }else if(event.stat == 1){
                                var status = "Pending";
                            }else if(event.stat == 2){
                                var status = "Waiting";
                            }else if(event.stat == 3){
                                var status = "Confirmed";
                            }
                        }else if(event.title == "Function"){
                            if(event.stat == 0){
                                var status = "Organization Holiday";
                            }else if(event.stat == 1){
                                var status = "event";
                            }
                        }else if(event.title == "Leave"){
                            if(event.stat == 0){
                                var status = "pending";
                            }else if(event.stat == 1){
                                var status = "Rejected";
                            }else if(event.stat == 2){
                                var status = "Accepted";
                            }
                        }
                        
                        var branch1="";
                         if(event.branchId){
                            branch1+="<hr/><p><b><small>Branch Lists</small></b><p>";
                            $.each(event.branchId,function(key1,value1){
                                branch1 += "<small>" + value1 + "</small><br/>";
                            });
                         }
                        
                        element.find('.fc-content').addClass('popovers');
                        element.find('.fc-content').attr('style',"cursor:pointer;");
                        element.find('.fc-content').attr('data-container',"body");
                        element.find('.fc-content').attr('data-trigger',"hover");
                        element.find('.fc-content').attr('data-html',"true");
                        element.find('.fc-content').attr('data-original-title',status);
                        element.find('.fc-content').attr('data-placement',"left");
                        element.find('.fc-content').attr('data-content',"<p><i>"+event.description+branch1+"</i></p>");
                    },
        			drop: function(date) { 
                        //when external events are dropped
        			},
                    eventDrop: function(event, delta, revertFunc ) {
                        //when events are moved to another date
                    },
                    loading: function(bool) {
        				//when calendar loads
        			},
                    eventClick: function(calEvent, jsEvent, view) {
                        //when an event is clicked 
                    },
                    eventMouseover:function( event, jsEvent, view ) { 
                        popoverActivete();                                                        
                        //toastr.info("<p>"+event.description +"</p><strong>"+ status+"</strong>","<strong><em>"+event.title+"</em></strong>");
                    },
                    eventMouseout:function( event, jsEvent, view ) { 
                      // toastr.clear();
                    }
                });
            }
       });   
       }
       loadCalender();
       popoverActivete();

    	   function popoverActivete(){
    			$('.popovers').popover();
    		}
       });
</script>