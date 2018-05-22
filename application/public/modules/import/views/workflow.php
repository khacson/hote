<!-------------------danh cho uer------------------------------->  
<script>
    $(function() {




        jsPlumb.importDefaults({
            // default drag options
            DragOptions: {cursor: 'pointer', zIndex: 2000},
            EndpointStyles: [{fillStyle: '#225588'}, {fillStyle: '#558822'}],
            Endpoints: [["Dot", {radius: 7}], ["Dot", {radius: 11}]],
            ConnectionOverlays: [
                ["Arrow", {location: -1,
                        width: 7,
                        length: 7,
                        foldback: 1
                    }],
                ["Label", {
                        location: 0.1,
                        id: "label",
                        cssClass: "aLabel"
                    }]
            ]
        });
//        //========================= danh cho user chi co quyen view========================>
//

<?php foreach ($forcedrouting as $item) { ?>
            _addEndpoints("ID<?= $item->processnode; ?>", ["<?= $item->forcestar; ?>_v"], []);
            _addEndpoints("ID<?= $item->nextprocessid; ?>", [], ["<?= $item->forceend; ?>_v"]);
            jsPlumb.connect({uuids: ["ID<?= $item->processnode; ?><?= $item->forcestar; ?>_v", "ID<?= $item->nextprocessid; ?><?= $item->forceend; ?>_v"], editable: false});
<?php } ?>


        $('#editworkflow').click(function() {
            $('#main123').html('<center>Please Wait</center>');
            $.post(url + control + '/loadWorkFlowEdit' + suffix, {page: 1}, function($data) {
                $obj = $.evalJSON($data);
                $('#main123').html($obj.content);
            });
        });


        $('.workflow').mouseenter(function() {
            // alert("manh") ;
            var focus = $('.' + $(this).attr("id"));
            focus.addClass("classfocus");
        });

        $('.workflow').mouseleave(function() {
            var focus = $('.' + $(this).attr("id"));
            focus.removeClass("classfocus");
        });

    });
</script>

<style>
    #main{width:776px; height:700px;position:relative;}


    img.desaturate{ filter: grayscale(100%);
                    -webkit-filter: grayscale(100%);
                    -moz-filter: grayscale(100%);
                    -ms-filter: grayscale(100%); 
                    -o-filter: grayscale(100%);
                    filter: url(<?= url_tmpl() ?>Workflow/desaturate.svg#greyscale); 
                    filter: gray; 
                    -webkit-filter: grayscale(1); }


    .workflow { 
        width:70px;
        height:70px;
        text-align:center;
        z-index:20; 
        position:absolute;
        color:black;
        font-family:helvetica;padding:0.5em;
        font-size:0.9em;             
    }   

    ._jsPlumb_connector { z-index:4; }  

    ._jsPlumb_endpoint, .endpointTargetLabel, .endpointSourceLabel{ z-index:-1;}


    .hl { border:3px solid red; }
    #debug { position:absolute; background-color:black; color:red; z-index:5000 }

    ._jsPlumb_dragging { z-index:4000; }


</style>


<!------------------------------------------------ket thuc user--------------------------------------->





<style>	
<?php
foreach ($process as $item) {
    ?>
        #ID<?= $item->processid; ?> {<?= $item->positionicon; ?>}		    
<?php } ?>    
</style>
<div id="main">	
    <?php 
    foreach ($process as $item)
	{
//		if(isset($arr_processid[$item->processid]))
//		{
//			$minutes = $arr_processid[$item->processid];
//		}
//		else
//		{
//			$minutes = 0;
//		}
        ?>
        <div class="workflow" id="ID<?= $item->processid; ?>">

            <?php if ($item->checkpermistion) { ?>

                <?php if ($item->controller != "") { ?>
                    <a href="<?= base_url() ?><?= $item->controller; ?>.html" class="link-1">

                    <?php } else { ?>
                        <a href="<?= base_url() ?>process/<?= $item->processid; ?>.html" class="link-1">                
                        <?php } ?>

                        <img style="max-width: 50px; max-height: 50px" src="<?= base_url() ?>/files/Image/<?= $item->image; ?>"><br/><?= $item->processname; ?>
                    </a>
                <?php } else { ?>
                    <img style="max-width: 50px; max-height: 50px" class="desaturate" src="<?= base_url() ?>/files/Image/<?= $item->image; ?>"><br/><?= $item->processname; ?>          
                <?php } ?>
				<br>
<!--				<span style="position:appsolute; font-size:10px; color:#296ec2;" ><?=$minutes;?> uh</span>-->
        </div>
		
    <?php } ?>


    <?php if ($isadmin == 1) { ?>
        <div class="f-right">
            <a href="#" title="Edit" class="btn-edit" id="editworkflow">Edit</a>
        </div>
    <?php } ?>

</div>
