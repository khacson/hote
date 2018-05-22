<script src="<?= url_tmpl() ?>js/jquery.json.js"></script>

<script type="text/javascript">
    var url = '<?= base_url() ?>';
    var suffix = '';
    var control = 'testcode';
    var get = 'loadWorkFlow';
    var resoles = "123";

    $(function() {
        $(document).tooltip({
            track: true
        });
    });

    $(function() {

        //load worflow truoc 
        $.post(url + control + '/' + get + suffix, {page: 1}, function($data) {
            $obj = $.evalJSON($data);
            $('#main123').html($obj.content);
            //load statistic			
            $.post(url + 'loadstatic/LoadStatic', function(data) {	
		
                var ojb = $.evalJSON(data);
                $('#viewstatic').html(ojb.html);

                if (ojb.totaltime > 0) {
                    $(ojb.csstime).appendTo("head");
                    for (var i = 0; i < ojb.totaltime; i++) {
                        $('#ID' + ojb.listprocesstime[i]).addClass("warningtime" + ojb.listprocesstime[i]);
                        $('#ID' + ojb.listprocesstime[i]).attr("title", ojb.listprocesstimeover[i]);
                    }
                }

                if (ojb.total > 0) {
                    $(ojb.css).appendTo("head");
                    for (var i = 0; i < ojb.total; i++) {
                        $('#ID' + ojb.listprocess[i]).addClass("warning" + ojb.listprocess[i]);
                        $('#ID' + ojb.listprocess[i]).attr("title", ojb.listprocessover[i]);
                    }
                }
            });
        });

        $('.btn-refresh').click(function() {
            $('#main123').html('<center><img src="<?= url_tmpl() ?>img/icon_loading.gif"></center>');
            $('#viewstatic').html('<center><img src="<?= url_tmpl() ?>img/icon_loading.gif"></center>');
            //load worflow truoc 
            $.post(url + control + '/' + get + suffix, {page: 1}, function($data) {
                $obj = $.evalJSON($data);
                $('#main123').html($obj.content);
                //load statistic
                $.post(url + 'loadstatic/LoadStatic', function(data) {
                    var ojb = $.evalJSON(data);
                    $('#viewstatic').html(ojb.html);

                    if (ojb.totaltime > 0) {
                        $(ojb.csstime).appendTo("head");
                        for (var i = 0; i < ojb.totaltime; i++) {
                            $('#ID' + ojb.listprocesstime[i]).addClass("warningtime" + ojb.listprocesstime[i]);
                            $('#ID' + ojb.listprocesstime[i]).attr("title", ojb.listprocesstimeover[i]);
                        }
                    }

                    if (ojb.total > 0) {
                        $(ojb.css).appendTo("head");
                        for (var i = 0; i < ojb.total; i++) {
                            $('#ID' + ojb.listprocess[i]).addClass("warning" + ojb.listprocess[i]);
                            $('#ID' + ojb.listprocess[i]).attr("title", ojb.listprocessover[i]);
                        }
                    }
                });
            });
        });

        /////////////////////////////////////////    



        //========================================


    });




</script>

<aside class="box-wrapper">
    <div class="box fixie">
        <div class="title fixie">Statistics <span class="ico"></span></div>
        <div class="content">            
            <dl class="job-counter clearfix" id="viewstatic">  
                <center><img src="<?= url_tmpl() ?>img/icon_loading.gif"></center>
            </dl>
            <p class="clearfix"><a href="#" class="btn-refresh" title="refresh">Refresh</a></p>
        </div>
    </div>
</aside><!-- // aside -->
<div class="main-content box-wrapper fixie">
    <div class="box">
        <div class="title fixie">Work Flow <span class="ico"></span></div>
        <div id="main123">
            <center><img src="<?= url_tmpl() ?>img/icon_loading.gif"></center>
        </div>    
    </div>
</div>

