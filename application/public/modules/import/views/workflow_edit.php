<!-- Start danh cho admin Code ----------> 


<style>

    #main{width:776px; height:700px;position:relative;}
    .workflow { 
        width:70px;
        height:70px;
        text-align:center;
        z-index:20; 
        position:absolute;
        color:black;
        font-family:helvetica;padding:0.5em;
        font-size:0.9em;}
    .active {
        /*border:1px dotted green;*/
        background: #00f;
    }
    .hover {
        /*border:1px dotted red;*/
        background: #f00;
    }


    ._jsPlumb_connector { z-index:4; }
    ._jsPlumb_endpoint, .endpointTargetLabel, .endpointSourceLabel{ z-index:21;cursor:pointer; }
    .hl { border:3px solid red; }
    #debug { position:absolute; background-color:black; color:red; z-index:5000 }

    ._jsPlumb_dragging { z-index:4000; }

    .aLabel {
        display: none;
        background-color:white; 
        padding:0.4em; 
        font:12px sans-serif; 
        color:#444;
        z-index:21;
        border:1px dotted gray;
        opacity:0.8;
        filter:alpha(opacity=80);
    }

</style>


<script>

    var $arraypositon = new Array();
    var $arrayforcedrouting = new Array();
    $(function() {
        
        
        
        
    jsPlumb.importDefaults({
				// default drag options
				DragOptions : { cursor: 'pointer', zIndex:2000 },
				// default to blue at one end and green at the other
				EndpointStyles : [{ fillStyle:'#225588' }, { fillStyle:'#558822' }],
				// blue endpoints 7 px; green endpoints 11.
				Endpoints : [ [ "Dot", {radius:7} ], [ "Dot", { radius:11 } ]],
				// the overlays to decorate each connection with.  note that the label overlay uses a function to generate the label text; in this
				// case it returns the 'labelText' member that we set on each connection in the 'init' method below.
				ConnectionOverlays : [
					[ "Arrow", { location:-5 } ],
					[ "Label", { 
						location:0.1,
						id:"label",
						cssClass:"aLabel"
					}]
				]
			});				


        /////////////////////////////// danh co admin co quyen chinh sua work flow===========================================
        //add endpoint
<?php
foreach ($process as $item) {
    ?>
            _addEndpoints("ID<?= $item->processid; ?>", [], ["Vitri1",
                "Vitri2",
                "Vitri3",
                "Vitri4",
                "Vitri5",
                "Vitri6",
                "Vitri7",
                "Vitri8",
                "Vitri9",
                "Vitri10",
                "Vitri11",
                "Vitri12", ]);

<?php } ?>

        //add start poit cho tất cả icon
<?php
foreach ($process as $item) {
    ?>
            _addEndpoints("ID<?= $item->processid; ?>", ["Vitri1",
                "Vitri2",
                "Vitri3",
                "Vitri4",
                "Vitri5",
                "Vitri6",
                "Vitri7",
                "Vitri8",
                "Vitri9",
                "Vitri10",
                "Vitri11",
                "Vitri12", ], []);

<?php } ?>


<?php foreach ($forcedrouting as $item) { ?>
            jsPlumb.connect({uuids: ["ID<?= $item->processnode; ?><?= $item->forcestar; ?>", "ID<?= $item->nextprocessid; ?><?= $item->forceend; ?>"], editable: false});
<?php } ?>

        jsPlumb.draggable(jsPlumb.getSelector(".workflow"), {grid: [1, 1], containment: "#main",
            stop: function() {
                var position = $(this).attr('style');
                var processid = $(this).attr('idprocess');

                var myposition = new Array();
                myposition["processid"] = processid;
                myposition["position"] = position;
                $arraypositon.push(myposition);
            }});


        jsPlumb.bind("click", function(conn) {

            //kiem tra xem co click su kien gi chua
//        var length = $arrayforcedrouting.length;
//        var length1 = $arraypositon.length;
//        
//        if(length > 0 || length1 >0){
//            $.msgBox({
//                    title: "Message",
//                      type:"error",
//                    content: "You have changed, please save first",
//                });
//                return;
//        }
            var $star = $('#' + conn.sourceId);
            var $idstar = $star.attr('idprocess');
            var $end = $('#' + conn.targetId);
            var $idend = $end.attr('idprocess');
            
            var $starpoint = conn.endpoints[0].anchor.type;
            var $endpoint = conn.endpoints[1].anchor.type;
            
           
            var length = $arrayforcedrouting.length;
            if (length > 0) {
                //kiem tra xem co trung voi trong list
                for ($i = 0; $i < length; $i++) {
                    if ($arrayforcedrouting[$i]["idstar"] == $idstar && $arrayforcedrouting[$i]["idend"] == $idend
                    && $arrayforcedrouting[$i]["pointstar"] == $starpoint && $arrayforcedrouting[$i]["pointend"] == $endpoint ){                        
                        $arrayforcedrouting.splice($i, 1);
                        //console.log($arrayforcedrouting);
                    }
                }
            }

            $.msgBox({
                title: "Warning",
                content: "Are you sure you want to delete this?",
                type: "confirm",
                buttons: [{value: "Yes"}, {value: "No"}],
                success: function(result) {
                    if (result == "Yes") {
                        $.post(url + control + '/deleforcedrouting' + suffix, {
                            idstar: $idstar,
                            idend: $idend,
                            starpoint:$starpoint,
                            endpoint:$endpoint,
                        }, function(data) {
                            jsPlumb.detach(conn);
                        });
                    }
                }
            });
        });
        jsPlumb.bind("jsPlumbConnection", function(CurrentConnection) {
            var $star = $('#' + CurrentConnection.sourceId);
            var $idstar = $star.attr('idprocess');
            var $end = $('#' + CurrentConnection.targetId);
            var $idend = $end.attr('idprocess');
            var $pointstar = CurrentConnection.sourceEndpoint.anchor.type;
            var $pointend = CurrentConnection.targetEndpoint.anchor.type;
            if ($idend) {
                var myconect = new Array();
                myconect["idstar"] = $idstar;
                myconect["pointstar"] = $pointstar;
                myconect["idend"] = $idend;
                myconect["pointend"] = $pointend;
                $arrayforcedrouting.push(myconect);
            }

        });

        $('#closeeditworkflow').click(function() {
            $('#main123').html('<center>Please Wait</center>');
        });

        $('#saveworkflow').click(function() {
           
            var length = $arrayforcedrouting.length;
            if (length > 0) {              
                $arrayforcedrouting.forEach(function(entry) {
                    $.post(url + control + '/addforcedrouting' + suffix, {
                        idstar: entry["idstar"],
                        idend: entry["idend"],
                        pointstar: entry["pointstar"],
                        pointend: entry["pointend"],
                    }, function(data) {
                    });
                });
            }


            //update list position
            var length1 = $arraypositon.length;
            if (length1 > 0) {             
                $arraypositon.forEach(function(entry1) {
                    $.post(url + control + '/updateProcess' + suffix, {
                        processid: entry1['processid'],
                        position: entry1['position'],
                    }, function(data) {
                    });
                });
            }

            //clear array
            $arrayforcedrouting = [];
            $arraypositon = [];


            
                $.msgBox({
                    title: "Message",
                    content: "The process is saved successfully",
                    buttons: [{value: 'OK'}],
                });
           
            
        });
    });
</script>

<!----------------------------------------------------------ket thuc admin-------------------------->


<style>	
<?php
foreach ($process as $item) {
    ?>
        #ID<?= $item->processid; ?> {<?= $item->positionicon; ?>}		    
<?php } ?>



    .workflowsl {
        line-height: 27px;
        height: 27px;
        padding: 0 0 0 5px;
        position: relative;
        overflow: hidden;
        width: 80px !important; }   
    </style>
    <div id="main">	

    <?php
    foreach ($process as $item) {
        ?>
        <div  class="workflow" id="ID<?= $item->processid; ?>" idprocess="<?= $item->processid; ?>">           
            <img style="max-width: 50px; max-height: 50px" src="<?= base_url() ?>/files/Image/<?= $item->image; ?>"><br/><?= $item->processname; ?>

        </div>
    <?php } ?>


    <div class="f-right">        
        <a href="<?= base_url() ?>home.html" title="Close" class="btn-delete" id="closeeditworkflow">Close</a>
        <a href="#" title="Save" class="btn-save" id="saveworkflow">Close</a>
    </div>

</div>
