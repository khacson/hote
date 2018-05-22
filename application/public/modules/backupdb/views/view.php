<style title="" type="text/css">
    table col.c1 { width: 45px; }
    table col.c2 { width: 60px; }
    table col.c3 { width: 180px; }
    table col.c4 { width: 180px; }
    table col.c5 { width: auto; }
</style>
<!-- BEGIN PORTLET-->
<form method="post" enctype="multipart/form-data">
    <div class="portlet box blue">
        <div class="portlet-title">
            <div class="caption">
                <i class="mleft5" class="fa fa-reorder"></i>
                <?= getLanguage('all', 'search') ?>
            </div>
            <div class="tools">
                <a href="javascript:;" class="collapse">
                </a>
            </div>
        </div>
        <div class="portlet-body">
            <div class="row">
               
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label col-md-4">From Date</label>
                        <div class="col-md-8 input-group date date-picker" data-date-format="dd-M-yyyy">
                            <input type="text" id="fromdate" class="form-control searchs">
                            <span class="input-group-btn ">
                                <button class="btn default btn-picker" type="button"><i class="fa fa-calendar "></i></button>
                            </span>
                        </div>

                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label col-md-4">To Date</label>
                        <div class="col-md-8 input-group date date-picker" data-date-format="dd-M-yyyy">
                            <input type="text" id="todate" class="form-control searchs">
                            <span class="input-group-btn ">
                                <button class="btn default btn-picker" type="button"><i class="fa fa-calendar "></i></button>
                            </span>
                        </div>

                    </div>
                </div>
            </div>

            <div class="row ">
				<div class="col-md-2">
					<div id="txttime"></div>
				</div> 
                <div class="col-md-10">
                    <div class="mright10" >
                        <input type="hidden" name="id" id="id" />
                        <input type="hidden" id="token" name="<?= $csrfName; ?>" value="<?= $csrfHash; ?>" />
                        
                    </div>		
                </div>
            </div>
        </div>
    </div>
</form>
<div class="portlet box blue">
    <div class="portlet-title">
        <div class="caption">
            <i class="mleft5">Found <span class='viewtotal'>0</span> results</i>
        </div>
        <div class="tools">
           <ul class="button-group pull-right" style="margin-top:-5px; margin-bottom:5px;">
                            <li id="search">
                                <button type="button" class="button">
                                    <i class="fa fa-search"></i>
                                    <?= getLanguage('all', 'search') ?>
                                </button>
                            </li>
                            <li id="refresh">
                                <button type="button" class="button">
                                    <i class="fa fa-refresh"></i>
                                    <?= getLanguage('all', 'refresh') ?>
                                </button>
                            </li>
							<li id="backup">
								<button type="button" class="button">
									<i class="fa fa-plus"></i>
									Backup
								</button>
							</li>
                        </ul>
        </div>
    </div>
    <div class="portlet-body">
        <div class="portlet-body">
            <div id="gridview" >
                <table class="resultset" id="grid"></table>
                <!--header-->
                <div id="cHeader">
                    <div id="tHeader">    	
                        <table id="tbheader" width="100%" cellspacing="0" border="1" >
                            <?php for ($i = 1; $i < 6; $i++) { ?>
                                <col class="c<?= $i; ?>">
                            <?php } ?>
                            <tr>
                                <th width="40px" class="text-center"><input type="checkbox" name="checkAll" id="checkAll" /></th>
                                <th>No.</th>
                                <th id="ord_datecreate">Date Backup</th>
                                <th id="ord_usercreate">User Backup</th>
                                <th></th>
                            </tr>
                        </table>
                    </div>
                </div>
                <!--end header-->
                <!--body-->
                <div id="data">
                    <div id="gridView">
                        <table id="tbbody"  width="100%" cellspacing="0" border="1">
                            <?php for ($i = 1; $i < 6; $i++) { ?>
                                <col class="c<?= $i; ?>">
                            <?php } ?>
                            <tbody id="grid-rows"></tbody>
                        </table>
                    </div>
                </div>
                <!--end body-->
            </div>
        </div>
        <div class="portlet-body">
            <div class="fleft" id="paging"></div>
        </div>
    </div>
</div>
<!-- END PORTLET-->
<!-- END PORTLET-->
<div class="loading" style="display: none;">
    <div class="blockUI blockOverlay" style="width: 100%;height: 100%;top:0px;left:0px;position: absolute;background-color: rgb(0,0,0);opacity: 0.1;z-index: 1000;">
    </div>
    <div class="blockUI blockMsg blockElement" style="width: 30%;position: absolute;top: 15%;left:35%;text-align: center;">
        <img src="<?= url_tmpl() ?>img/ajax_loader.gif" style="z-index: 2;position: absolute;"/>
    </div>
</div> 
<script>
    var controller = '<?= $controller; ?>/';
    var csrfHash = '<?= $csrfHash; ?>';
    var cpage = 0;
    var search;
    var schoolid = 0;
    $(function() {
        
        refresh();
        $('#refresh').click(function() {
            $(".loading").show();
            refresh();
        });
        $('#search').click(function() {
            $('.loading').show();
            searchList();
        });
        $('#backup').click(function() {
			$(".loading").show();
            backup('backup', '');
        });
    });
    function backup(func, id) {
        search = getSearch();
        var obj = $.evalJSON(search);
        var token = $('#token').val();
        var data = new FormData();
        data.append('csrf_stock_name', token);
        data.append('search', search);
        data.append('id', id);
        $.ajax({
            url: controller + func,
            type: 'POST',
            async: false,
            data: data,
            enctype: 'multipart/form-data',
            processData: false,
            contentType: false,
            success: function(datas) {
                //var obj = $.evalJSON(datas);
                $("#token").val(obj.csrfHash);
				$(".loading").hide();
				if(datas == 1){
					$.msgBox({
							title: 'Message',
							type:'info',
							content: 'Backup data thành công.',
							buttons: [{value: 'OK'}],
					 });
					 refresh();	
				}
				else{
					error('Backup data thất bại.');
				}
               
            },
            error: function() {
				error('Backup data thất bại.');
            }
        });
    }
 
    function refresh() {
        $('.loading').show();
        $('.searchs').val('');
        $('#show').html('');
        
        csrfHash = $('#token').val();
        search = getSearch();//alert(cpage);
        getList(cpage, csrfHash);
    }
    function searchList() {
        search = getSearch();//alert(cpage);exit;
        csrfHash = $('#token').val();
        getList(0, csrfHash);
    }
    function getSearch() {
        var str = '';
        $('input.searchs').each(function() {
            str += ',"' + $(this).attr('id') + '":"' + $(this).val().trim() + '"';
        })
        $('select.combos').each(function() {
            str += ',"' + $(this).attr('id') + '":"' + getCombo($(this).attr('id')) + '"';
        })
        return '{' + str.substr(1) + '}';
    }
</script> 
<script src="<?= url_tmpl(); ?>assets/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
