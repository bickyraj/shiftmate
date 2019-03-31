<?php
$loginUserRelationToOther = loginUserRelationToOther($user_id);
?>
<div class="page-head">
    <div class="container">
        <div class="page-title">
            <h1>Today's Shifts</h1>
        </div>
    </div>
</div>
<div class="page-content">
    <div class="container">
        <ul class="page-breadcrumb breadcrumb">
            <li>
    			<i class="fa fa-home"></i>
    			<a href="http://localhost/shiftmate_view/">Home</a>
    			<i class="fa fa-circle"></i>
    		</li>
    		<li>
    			<a href="javascript:;">Today's Shifts</a>
    		</li>
        </ul>

		<div class="row">
			<div class="col-md-12 col-sm-12">
                <div class="portlet light">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="icon-bar-chart font-green-sharp hide"></i>
                            <span class="caption-subject font-green-sharp bold uppercase">Today's shift</span>
                        </div>
                        <div class="actions" style="display:none;">
                            <select class="orgn">
                                <option value="0">All Organizations</option>
                                <?php if(isset($loginUserRelationToOther->userOrganization) && !empty($loginUserRelationToOther->userOrganization)){
                                    foreach($loginUserRelationToOther->userOrganization as $ordnid=>$orgndet){
                                        foreach($orgndet as $key=>$value){
                                            echo "<option value='".$ordnid."'>".$key."</option>";
                                        }
                                    }
                                } ?>
                            </select>
                            <select class="brnch">
                                <option value="0">All Branches</option>
                            </select>
                            <select class="brd">
                                <option value="0">All Depatrment</option>
                            </select>
                        </div>

                        <div class="actions">
            				<div class="btn-group btn-group-devided" data-toggle="buttons">
            					<label class="btn btn-transparent grey-salsa btn-circle btn-sm active">
            					<input type="radio" name="options" class="toggle" id="option1">Today</label>
            				</div>
            			</div>
                    </div>

                    <script>
                        $(document).ready(function(){    
                            var userRelation = <?php echo json_encode($loginUserRelationToOther);?>;
                            $(".orgn").change(function(){
                                var e=$(this);
                                loadBrdNBrnch(e); 
                                loadBoardUser12(e.val(),$(".brd").val()); 
                            });
                            
                            function loadBrdNBrnch(e){
                                if(e.val() != 0){
                                    $.ajax({
                                    url:"<?php echo URL;?>"+"Boards/listBoards/"+e.val()+".json",
                                    datatype:"jsonp",
                                    success:function(data){
                                        data1="<option value='0'>All Departments</option>";
                                        //console.log(userRelation);
                                        $.each(userRelation['board'],function(k4,v4){
                                            $.each(data['boards'],function(k,v){
                                                if(k4==v['Board']['id']){
                                                    data1+="<option value='"+v['Board']['id']+"'>"+v['Board']['title']+"</option>";
                                                }
                                            });
                                        });
                                        $(".brd").html(data1);
                                    }
                                });
                                $.ajax({
                                    url:"<?php echo URL;?>"+"Branches/BranchesList/"+e.val()+".json",
                                    datatype:"jsonp",
                                    success:function(data){
                                        data2="<option value='0'>All Branches</option>";
                                        $.each(userRelation['userOrganization'],function(k1,v1){
                                            $.each(v1,function(k2,v2){
                                                $.each(v2,function(k3,v3){
                                                    $.each(data['branches'],function(k,v){
                                                        if(k3 == k){
                                                            data2+="<option value='"+k+"'>"+v+"</option>";
                                                        } 
                                                    });
                                                });
                                            });
                                        });
                                        $(".brnch").html(data2);
                                    }
                                });
                                }else{
                                    $(".brd").html("<option value='0'>All Departments</option>");
                                    $(".brnch").html("<option value='0'>All Branches</option>");
                                }
                            }

                             $(".brnch").change(function(){
                                var f=$(this);
                                if(f.val() != 0){
                                    $.ajax({
                                        url:"<?php echo URL;?>"+"Boards/getBoardListOfBranch/"+f.val()+".json",
                                        datatype:"jsonp",
                                        success:function(data){
                                            //console.log(data);
                                            data3="<option value='0'>All Departments</option>";
                                            $.each(userRelation['board'],function(k5,v5){
                                                $.each(data['boardList'],function(k6,v6){
                                                    if(k5==v6['Board']['id']){
                                                        data3+="<option value='"+v6['Board']['id']+"'>"+v6['Board']['title']+"</option>";
                                                    }
                                                });
                                            });
                                            $(".brd").html(data3);
                                            loadBoardUser12($(".orgn").val(),$(".brd").val()); 
                                        }
                                    });
                                }else{
                                    loadBrdNBrnch($(".orgn").val());
                                    loadBoardUser12($(".orgn").val(),$(".brd").val()); 
                                }
                             }); 
                                
                             $(".brd").change(function(){
                                var g=$(this);
                                loadBoardUser12($(".orgn").val(),g.val());    
                             });
                             
                         loadBoardUser12($(".orgn").val(),$(".brd").val());  
                            function loadBoardUser12(orgn,brd){
                            	// alert(orgn+' '+brd);
                                var shiftboard=[];
                                if(orgn == "0"){
                                    if(userRelation['userOrganization'] && userRelation['userOrganization'] != null){
                                        $.each(userRelation['userOrganization'],function(k,v){
                                            $.ajax({
                                                url:"<?php echo URL."ShiftBoards/openShifts/";?>"+k+".json",
                                                datatype:"jsonp",
                                                async:false,
                                                success:function(data){
                                                    if(data['openShifts'] != null){
                                                       shiftboard.push(data['openShifts']); 
                                                    }
                                                }
                                            });
                                            if(userRelation['board'] && userRelation['board'] != null)
                                            $.each(userRelation['board'],function(k1,v1){
                                                $.ajax({
                                                   url:"<?php echo URL."ShiftBoards/closedShifts/".$user_id."/";?>"+k+"/"+k1+".json",
                                                   datatype:"jsonp",
                                                   async:false,
                                                   success:function(data){
                                                        if(data['closedShifts'] != null){
                                                           shiftboard.push(data['closedShifts']); 
                                                        }
                                                   } 
                                                });
                                            });
                                        });
                                        //console.log(shiftboard.shift());
                                    }
                                }else{
                                    if(brd == "0"){
                                        $.ajax({
                                            url:"<?php echo URL."ShiftBoards/openShifts/";?>"+orgn+".json",
                                            datatype:"jsonp",
                                            async:false,
                                            success:function(data){
                                                if(data['openShifts'] != null){
                                                    shiftboard.push(data['openShifts']);
                                                }
                                            }
                                        });
                                        $.each(userRelation['board'],function(k1,v1){
                                            $.ajax({
                                                   url:"<?php echo URL."ShiftBoards/closedShifts/".$user_id."/";?>"+orgn+"/"+k1+".json",
                                                   datatype:"jsonp",
                                                   async:false,
                                                   success:function(data){
                                                    if(data['closedShifts'] != null){
                                                        shiftboard.push(data['closedShifts']);
                                                    }
                                                   } 
                                                });
                                        });
                                    }else{
                                         $.ajax({
                                            url:"<?php echo URL."ShiftBoards/openShifts/";?>"+orgn+".json",
                                            datatype:"jsonp",
                                            async:false,
                                            success:function(data){
                                                if(data['openShifts'] != null){
                                                    shiftboard.push(data['openShifts']);
                                                }
                                            }
                                        });
                                        $.ajax({
                                           url:"<?php echo URL."ShiftBoards/closedShifts/".$user_id."/";?>"+orgn+"/"+brd+".json",
                                           datatype:"jsonp",
                                           async:false,
                                           success:function(data){
                                                if(data['closedShifts'] != null){
                                                    shiftboard.push(data['closedShifts']);
                                                }
                                           } 
                                        });
                                    }
                                }
                            datax="<blockquote><small>There are no shifts scheduled for today till now.</small></blockquote>";            datay="";
                                        $.each(shiftboard,function(ky,vy){
                                        	//console.log(shiftboard);
                                            if(vy.length !=0 ){
                                                datax="<thead><tr class='uppercase'><th>Shift</th><th>Organization</th><th>Time</th><th>No.of Employee</th><th>Option</th></tr></thead><tbody>";
                                                $.each(vy,function(kx,vx){
                                                    dataz="";
                                                    var count=0;
                                                    
                                                    

                                                    if(vx["Shift"]["ShiftUser"].length != 0){
                                                    $.each(vx["Shift"]["ShiftUser"],function(k1,v1){

                                                       if(v1.User.imagepath != '') {
                                                            src = v1.User.imagepath;
                                                        } else if(v1.User.image != ''){
                                                        var src = '<?php echo URL; ?>webroot/files/user/image/'+v1['User']['image_dir']+'/'+v1['User']['image'];
                                                        }

                                                         else if(v1.User.gender == 0){
                                                            src = '<?php echo URL; ?>webroot/files/user_image/defaultuser.png';
                                                        } else {
                                                            src = '<?php echo URL ?>webroot/files/user_image/femaleadmin.png';
                                                        }

                                                        dataz += "<div class='row'><div class='col-md-2 col-sm-2 col-xs-3'><img class='img-responsive' style='height:50px;width:100px;' src='"+src+"'/></div><div class='col-md-4 col-sm-4 col-xs-4'><strong>"+v1['User']['fname']+" "+v1['User']['lname']+"</strong></div></div><hr/>";
                                                        count++;
                                                    });
                                                    }
                                                    
                                                var t1 = ''+vx["Shift"]["starttime"]+'';
                                                var t2 = ''+vx["Shift"]["endtime"]+'';
                                                var s1 = t1.split(':');
                                                var s2 = t2.split(':');
                                                if(s1[0] < 12){
                                                    time3 = parseInt(s1[0])+":"+s1[1]+" AM";
                                                } else if(s1[0] == 12) {
                                                    time3 = parseInt(s1[0])+":"+s1[1]+" PM";
                                                } else {
                                                    time3 = (parseInt(s1[0]) - 12)+":"+s1[1]+" PM";
                                                }

                                                if(s2[0] < 12){
                                                    time4 = parseInt(s2[0])+":"+s2[1]+" AM";
                                                } else if(s2[0] == 12) {
                                                    time4 = parseInt(s2[0])+":"+s2[1]+" PM";
                                                } else {
                                                    time4 = (parseInt(s2[0]) - 12)+":"+s2[1]+" PM"; 
                                                }
                                                    // var time1 = new Date("2015-05-31T"+vx["Shift"]["starttime"]);
                                                    // var time2 = new Date("2015-05-31T"+vx["Shift"]["endtime"]);
                                                    // if(time1.getHours() < 12){
                                                    //     time3 = time1.getHours()+":"+time1.getMinutes()+" AM";
                                                    // }else{
                                                    //     time3 = (time1.getHours() - 12)+":"+time1.getMinutes()+" PM";
                                                    // }   
                                                    // if(time2.getHours() < 12){
                                                    //     time4 = time2.getHours()+":"+time2.getMinutes()+" AM";
                                                    // }else{
                                                    //     time4 = (time2.getHours() - 12)+":"+time2.getMinutes()+" PM";
                                                    // }
                                                    
                                                    datax += "<tr><td>"+vx["Shift"]["title"]+"</td><td>"+vx["Board"]["Organization"]["title"]+"</td><td>"+time3+" - to - "+time4+"</td><td>"+count+"</td><td>"+'<button type="button" data-toggle="modal" class="btn btn-sm btn-default" data-target="#employer_'+vx["ShiftBoard"]["id"]+'">View</button>'+"</td>";                 
                                                    datay+='<div class="modal fade" id="employer_'+vx["ShiftBoard"]["id"]+'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">'+
                                                                    '<div class="modal-dialog" role="document">'+
                                                                       '<div class="modal-content">'+
                                                                        '<div class="modal-header">'+
                                                                        '<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                                                                        '<h4 class="modal-title" id="myModalLabel">Shift Users</h4>'+
                                                                      '</div>'+
                                                                      '<div class="modal-body">'+dataz+
                                                                    '</div>'+
                                                                    '<div class="modal-footer">'+
                                                                    '<button type="button" class="btn btn-default" data-dismiss="modal">Ok</button>'+
                                                                  '</div>'+
                                                                    '</div>'+
                                                                  '</div>'+
                                                                '</div>';
                                                });
                                            }
                                        });
                                        datax += "</body>";
                                        $("#sample_today_shift").html(datax);
                                        $("#modals_of_today_shift").html(datay);
                                     }
                                    });
                    </script>

                    <div class="portlet-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-light" id="sample_today_shift">
                            
                            </table>
                        </div>
                        <div id="modals_of_today_shift"></div>
                    </div>
                </div>
            </div>
		</div>
	</div>
</div>