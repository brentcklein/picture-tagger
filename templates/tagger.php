<!DOCTYPE html>
<html>
  <head>
    <title>RaceFace Tagger</title>
    <link rel="stylesheet" href="css/normalise.css" type="text/css">
    <link rel="stylesheet" href="css/bootstrap.css" type="text/css">
    <link rel="stylesheet" href="css/styles.css" type="text/css">
    <link rel="stylesheet" href="lib/owl-carousel/css/owl.carousel.css">
    <link rel="stylesheet" href="lib/owl-carousel/css/owl.theme.css">
    <script src="js/jquery-1.9.1.min.js"></script>
    <script src="lib/owl-carousel/owl.carousel.js"></script>
  </head>
  <body>
    <div class="container" id="utilityContainer">
      <form method="post" action=<?php echo $DOC_ROOT; ?>>
        <div class="row">
          <div class="col-md-3">
            <input type="text" name="tagSearch" id="tagSearch" <?php if (isset($_POST['tagSearch']) AND $_POST['tagSearch']) {echo "placeholder='" . $_POST['tagSearch'] . "'";} else {echo 'placeholder="Tag Search"';} ?>>
          </div>
          <div class="col-md-3">
            <input type="number" name="posSearch" id="posSearch" placeholder=<?php if (!$imagePos) {echo "'Photo # Search'";} else {echo $imagePos+1; } ?>> <!-- placeholder="Photo # Search" -->
          </div>
          <div class="col-md-2">
            <button type="submit" class="btn btn-primary">Search</button>
          </div>
          <div class="col-md-4">
            <select id="eventSearch" name="eventSearch">
              <?php echo $events; ?>
            </select>
            <br>
            <select id="albumSearch" name="albumSearch">
              <option>Album</option>
            </select>
          </div>
        </div>
        <div id="tagRow">
          <div class="col-md-8">
            <div id="tagList">
                <p class="result"></p>
            </div>
          </div>
          <div class="col-md-4">
            <label class="checkbox">
              <input type="checkbox" name="untagged[]" id="untagged" value="untagged" <?php if ($_SERVER["REQUEST_METHOD"] == "POST" AND isset($_POST['untagged'])) {echo "checked";} ?>>
              Untagged Only
            </label>
            <label class="checkbox">
              <input type="checkbox" name="all[]" id="all" value="all" <?php if ($_SERVER["REQUEST_METHOD"] == "POST" AND isset($_POST['all'])) {echo "checked";} ?>>
              Show Full List
            </label>
          </div>
        </div>
      </form>
        <div class="row">
          <div class="col-md-8">
            <div id="imageContainer" class="owl-carousel">
              <?php echo $carouselData; ?>
            </div>
          </div>
      <form method="post" action="lib/updateTags.php" id="updateForm">
          <div class="col-md-4">
            <input type="text" name="tag1" id="tag1" placeholder="Tag 1"/>
            <br>
            <input type="text" name="tag2" id="tag2" placeholder="Tag 2"/>
            <br>
            <input type="text" name="tag3" id="tag3" placeholder="Tag 3"/>
            <br>
            <input type="text" name="tag4" id="tag4" placeholder="Tag 4"/>
            <br>
            <input type="text" name="tag5" id="tag5" placeholder="Tag 5"/>
            <br>
            <button type="submit" class="btn btn-primary" id="updateButton">Update</button>
          </div>
        </div>
        <input type="hidden" id="imagePosInput" name="imagePosInput" value=<?php if (!$imagePos) {echo "0";} else {echo $imagePos;} ?>>
        <input type="hidden" id="imageIdInput" name="imageIdInput" value="">
        <!-- <input type="hidden" name="_METHOD" value="PUT"/> -->
      </form>
        <div class="row" id="statusRow">
          <div class="col-md-2">
            <div class="photoNum">
                <p class="result text-center"></p>
            </div>
          </div>
          <div class="col-md-2 col-md-offset-4">
            <div class="photoPos">
                <p class="result text-center"></p>
            </div>
          </div>
        </div>
    </div>
    <div id="currentAlbum" style="display:none;"><?php if (isset($currentAlbum)) {echo $currentAlbum;} else {echo "";} ?></div>
    <?php echo $tableData; ?>
  </body>
  <script>
      
    function updateAlbums(){
        $("#albumSearch").empty();

        $.ajax( {
          type: "POST",
          url: "lib/getAlbums.php",
          data: 'event=' + $("#eventSearch").val(),
          dataType: "json",
          success: function( results ) {

            $("#albumSearch").append("<option value='none'>None</option>");

            for (var i = 0; i < results.length; ++i) {
              var album = results[i]["album_tag"];
              var option = "<option value='" + album + "'";
              if (currentAlbum == album) {option = option + " selected";}
              option = option + ">" + album + "</option>";
              $("#albumSearch").append(option);
              console.log(option);
            }
          },
          error: function(jqxhr, type, error){
            console.log(type + ": " + error);
          }
        });
      }

    $(document).ready(function() {

      var statusRow = $("#statusRow"),
          updateForm = $("#updateForm"),
          imagePosInput = $("#imagePosInput"),
          tagList = $("#tagList"),
          data = $("#data"),
          imagePos = parseInt(imagePosInput.val()),
          currentAlbum = $("#currentAlbum").html();

      $("#imageContainer").owlCarousel({
        items : 1,
        lazyLoad : true,
        navigation : true,
        pagination : false,
        rewindNav : false,
        mouseDraggable: false,
        afterInit : afterInit,
        // afterMove : afterMove
        afterAction: afterAction
      });

      owl = $("#imageContainer").data('owlCarousel');

      // Update tags and refresh tag list
      var form = $('#updateForm');
      form.submit(function (e) {
        e.preventDefault();
        console.log("update form submitted");
        $.ajax( {
          type: "POST",
          url: form.attr( 'action' ),
          data: form.serialize(),
          success: function( response ) {
            var current = owl.owl.currentItem;
            data.find("." + current).find(".tags").append(response);
            tagList.find(".result").append(response);
            updateDisplay(owl);
            console.log( response );
          }
        } ); 
        console.log("Ajax completed");
      });

      $("#eventSearch").change(function(){
        updateAlbums();        
      })

      function updateAlbums(){
        $("#albumSearch").empty();

        $.ajax( {
          type: "POST",
          url: "lib/getAlbums.php",
          data: 'event=' + $("#eventSearch").val(),
          dataType: "json",
          success: function( results ) {

            $("#albumSearch").append("<option value='none'>None</option>");

            for (var i = 0; i < results.length; ++i) {
              var album = results[i]["album_tag"];
              var option = "<option value='" + album + "'";
              if (currentAlbum == album) {option = option + " selected";}
              option = option + ">" + album + "</option>";
              $("#albumSearch").append(option);
              console.log(option);
            }
          },
          error: function(jqxhr, type, error){
            console.log(type + ": " + error);
          }
        });
      }

      $('.item').on('click', function(event){

        // console.log("item clickied");

        $.ajax( {
          type: "POST",
          url: "lib/getUrls.php",
          data: 'id=' + data.find("." + owl.owl.currentItem).find(".id").html(),
          dataType: "json",
          success: function( results ) {
            // console.log("ajax successful");

            var newWindow = window.open("","","width=1000,height=1000");

            var sizes = new Array("Small", "Medium", "Large", "X-Large", "XX-Large");
            var str = "<p>";

            for (var i = sizes.length - 1; i >= 0; i--) {
              var size = sizes[i], url = results[0][sizes[i]];
              if (url) {
                str = str + size + ": <a href='" + url + "'>" + url + "</a><br>";
              } else {
                str = str + size + ": Unavailable<br>";
              }
            };
            
            str = str + "</p>";
            newWindow.document.write(str);
            // console.log(str);
          },
          error: function(jqxhr, type, error){
            console.log(type + ": " + error);
          }
        });

      });
      

      function updateResult(div,pos,value){
        div.find(pos).find(".result").text(value);
      }

      function updateDisplay(that){
        var current = parseInt(that.owl.currentItem);

        var num = data.find("." + current).find(".num").html(),
            id = data.find("." + current).find(".id").html(),
            pos = (current + 1),
            tags = data.find("." + current).find(".tags").html();

        //update position
        var value = pos + " of " + that.owl.owlItems.length;
        statusRow.find(".photoPos").find(".result").text(value);
        // update number
        value = "Photo # " + (parseInt(num)+1);
        statusRow.find(".photoNum").find(".result").text(value);
        // update tags
        tagList.find(".result").text(tags);

        // update hidden form inputs
        imagePosInput.val(pos);
        console.log("imagePosInput updated to: " + pos);
        imageIdInput.value=id;
        console.log("imageIdInput updated to: " + id);

        console.log("display updated");

      }


      function afterInit(){
        this.jumpTo(imagePos);
        updateAlbums();
      }

      function afterAction(){
        var that = this;
        updateDisplay(that);
      }
      

    });
  </script>
</html>