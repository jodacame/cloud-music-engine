<div class="col-lg-8">

  <form class="box box-warning" id="translations" method="POST">
    <div class="box-header">
      <h3 class="box-title">Translations
        
      </h3>   
       <?php if($lang != 'en'){ ?>
      <button type="button" data-sl="en" data-tl="<?php echo $lang; ?>" class="btn-auto-translate btn btn-info btn-xs pull-right"><i class="fa fa-refresh"></i> Try Auto Translate</button>      
      <?php } ?>
    </div><!-- /.box-header -->
    <div class="box-body" >
      <table class="table table-hover">
      <thead>        
        <tr>
            <th>Code</th>
            <th>Translation</th>            
        </tr>
      </thead>
      <tbody>
        <?php foreach ($translation as $key => $value) {          

          ?>
          <tr>
            
            <td><?php echo $value['code']; ?></td>
            <td>
                   
                      <input type="text" style="border:0;width:100%" name="<?php echo $value['code']; ?>" placeholder="<?php echo $value['helper']; ?>" required class="form-control t-me" value="<?php echo $value['translation']; ?>">
             
              </td>            
          </tr>
          <?php
        }
        ?>
        </tbody>
      </table>
    </div><!-- /.box-body -->
    <div class="box-footer">          
             <button type="submit"  class="btn btn-success ">Save</button>
        </div>
  </form><!-- /.box -->
</div>
<div class="col-md-4">  

    <div class="box box-info">
      <div class="box-header with-border">
        <h3 class="box-title">Languages</h3>
      </div><!-- /.box-header -->
      <!-- form start -->
      <form role="form" method="get" >
        <div class="box-body">
          <div class="form-group">            
           <div class="form-group">
            <label>Select Language to translate</label>
            <select required name="lang" class="select2 form-control">
              <?php foreach ($languages as $key => $value) {
                ?>
                <option <?php if($lang == $value['code']){ echo 'selected'; } ?> value="<?php echo $value['code']; ?>"><?php echo $value['name']; ?></option>
                <?php
              }
              ?>
            </select>
          </div>
           <div class="progress">
                <div class="progress-bar progress-bar-primary" id="t2" role="progressbar" aria-valuenow="<?php echo $porc; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $porc; ?>%">
                  <span><?php echo $porc; ?>% Complete</span>
                </div>
              </div>
        
        <div class="box-footer">          
            <button type="submit"  class="btn btn-primary pull-right">Change</button>
             </form>
             <?php if($lang != 'en'){ ?>
             <form method="POST">
             <input type="hidden" value="1" name="r">
              <button type="submit"  class="btn btn-danger ">Remove</button>
            </form>
            <?php } ?>
            <br>
            <br>
            <a href="http://translate.yandex.com/">Auto Translation: Powered By Yandex</a>
            <div class="out"></div>

        </div>
     
    </div>
 

</div>
<script>

$(function () {
  var total = $(".t-me").length;
  var current = 0;
  var yandex_key = '<?php echo config_item("yandex_key"); ?>';
  $(document).on('click', '.btn-auto-translate', function(event) {    
    event.preventDefault();
     $(".out").empty();
    if(yandex_key == '')
    {
      alert("Yandex KEY is Required");
      return false;
    }
    $("#t2").width("0%");
    $(this).attr("disabled","disabled");
    $("i",$(this)).addClass('fa-spin');
    var sl = $(this).attr("data-sl");
    var tl = $(this).attr("data-tl");

    $.each($(".t-me"), function(index, val) {
       var text = $(this).attr("placeholder");
       var _this = $(this);
       if(text == '')
        text = $(this).val();

      
      



      $(this).val("Translating...");
       $.getJSON('https://translate.yandex.net/api/v1.5/tr.json/translate?key='+yandex_key+'&text='+encodeURI(text)+'&lang='+sl+'-'+tl,false, function(json, textStatus) {
          if(json.code == '200')
          {
           //var translatedText = json[0][0][0];
           $("#t2").width(parseInt((current*100/total))+"%");
           $("#t2 span").text(parseInt((current*100/total))+"% Complete");
             console.log(json.text[0]);         
          _this.val(json.text[0]);

            

              current++;

          if(current >= total)
              $("#translations").submit();
          }
          else
          {
            alert(json.message);
          }

       }).error(function(e) { 
        var json = JSON.parse(e.responseText)
          $(".out").html("<br><br><div class='alert alert-danger'>"+json.message+"</div>");
         });
       
    });

     $(this).removeAttr("disabled");
    $("i",$(this)).removeClass('fa-spin');


  });
});

</script>