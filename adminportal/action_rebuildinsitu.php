<?php
session_start();
include_once('../connections/tractordbcon.php');
include_once('include/veriparms.php');


$userid = $_GET['id'];
$idcampaign = $_SESSION['idcampaign'];



    // Query Campaign based on id
      $sqluser = "SELECT * FROM tractorusers INNER JOIN tractorcampaigns ON tractorusers.idcampaign = tractorcampaigns.id WHERE tractorusers.id = '$userid' AND tractorusers.idcampaign = '$idcampaign' ORDER BY tractorusers.id DESC LIMIT 1";

if($resultuser = mysqli_query($link, $sqluser)){

    if(mysqli_num_rows($resultuser) > 0){
    while($rowuser = mysqli_fetch_array($resultuser)){
      $iduser = $rowuser['id'];
      $idcampaign = $rowuser['idcampaign'];
      $name = $rowuser['name'];
      $email = $rowuser['email'];
      $location = $rowuser['location'];
      $idlocation = $rowuser['idlocation'];
      $idbillboard = $rowuser['idbillboard'];
      $billboardmessage = $rowuser['billboardmessage'];
      $fromname = $rowuser['fromname'];
      $toname = $rowuser['toname'];
      $idtemplate = $rowuser['idtemplate'];
      $compositfilename = $rowuser['compositfilename'];
      $insitufilename = $rowuser['insitufilename'];
      $displayfilename = $rowuser['displayfilename'];
      $uniquesession = $rowuser['uniquesession'];
      $billboard_logo = $rowuser['billboard_logo'];
      $billboard_sticker1 = $rowuser['billboard_sticker1'];
      $idcopyline = $rowuser['idcopyline'];
      $instructions = $rowuser['instructions'];
      $toggle_logo = $rowuser['billboard_logo_toggle'];
      $toggle_sticker = $rowuser['billboard_sticker1_toggle'];
      $toggle_copyline = $rowuser['copyline_toggle'];
    }
    $userfilename = $uniquesession;

    // Query Campaigns table for canvas bg color
    $sqlcampaigns = "SELECT id, campaign_backgroundcolor, modrewritename FROM tractorcampaigns WHERE id = '$idcampaign'";

    if($resultcampaigns = mysqli_query($link, $sqlcampaigns)) {

        if(mysqli_num_rows($resultcampaigns) > 0) {
           while ($rowcampaigns = mysqli_fetch_array($resultcampaigns)){
          $bgcolor = $rowcampaigns['campaign_backgroundcolor'];
          $campaignbasename = $rowcampaigns['modrewritename'];
        }
            // Free result set
            mysqli_free_result($resultcampaigns);
        }
    }


    //$canvastext = '#'.$name;
    //echo "<br/> idbillboard :: ". $idbillboard . "<br/>";

    // Query Billboard based on id
    $sqlbillboard = "SELECT * FROM billboards WHERE idbillboard = '$idbillboard'";
    if($resultbillboard = mysqli_query($link, $sqlbillboard)){
        if(mysqli_num_rows($resultbillboard) > 0){
        while($rowbillboard = mysqli_fetch_array($resultbillboard)){
            $billboard_width  = $rowbillboard['billboard_width'];
            $billboard_height = $rowbillboard['billboard_height'];
            $canvas_width = $rowbillboard['canvas_width'];
            $canvas_height  = $rowbillboard['canvas_height'];
            $canvasPreview_pos_x = $rowbillboard['canvas_pos_x'];
            $canvasPreview_pos_y = $rowbillboard['canvas_pos_y'];
            $physicallocation = $rowbillboard['physicallocation'];
            $billboard_insitu_png = $rowbillboard['billboard_insitu_png']; 
            $billboard_insitu_png_width = $rowbillboard['billboard_insitu_png_width']; 
            $billboard_insitu_png_height = $rowbillboard['billboard_insitu_png_height']; 
            $insitu_pos_y = $rowbillboard['insitu_pos_y']; 
            $insitu_pos_x = $rowbillboard['insitu_pos_x']; 
            $insitu_height = $rowbillboard['insitu_height']; 
            $insitu_width = $rowbillboard['insitu_width']; 
            $billboard_template = $rowbillboard['billboard_template']; //images/billboards/templates
            $bezel_filename = $rowbillboard['bezel_filename'];
            $fromtextX = $rowbillboard['fromtextX'];
            $fromtextY = $rowbillboard['fromtextY'];
            $fromtextsize = $rowbillboard['fromtextsize'];
            $totextX = $rowbillboard['totextX'];
            $totextY = $rowbillboard['totextY'];
            $totextsize = $rowbillboard['totextsize'];
            $messageX = $rowbillboard['messageX'];
            $messageY = $rowbillboard['messageY'];
            $messagesize = $rowbillboard['messagesize'];
            $messagewidth =  $rowbillboard['messagewidth'];
            $fromtextwidth =  $rowbillboard['fromtextwidth'];
            $totextwidth =  $rowbillboard['totextwidth'];
            $billboardcode1  = $rowbillboard['billboardcode1'];
         }



          if($compositfilename == ''){ 
            $compositfilename = $billboardcode1 . '-brutal-'. preg_replace('/\\.[^.\\s]{3,4}$/', '', $userfilename) . '-composit.jpg';
          }
          if($insitufilename == ''){ 
            $insitufilename = $billboardcode1 . '-brutal-'. preg_replace('/\\.[^.\\s]{3,4}$/', '', $userfilename) . '-insitu.png';
          }
          if($displayfilename == ''){ 
            $displayfilename = $billboardcode1 . '-brutal-'. preg_replace('/\\.[^.\\s]{3,4}$/', '', $userfilename) . '-billboard.jpg'; 
          }

            // Free result set
            mysqli_free_result($resultbillboard);
        }
    }
  }
}

$fontname = 'CocogoosePro Reg';
$fontnameLight = 'CocogoosePro Light';
$fontnameUltraLight = 'CocogoosePro UltraLight';
$fontnameSemiLight = 'CocogoosePro SemiLight';

?>
<html style="height: 100%">
<link rel="stylesheet" href="../css/style.css">
<script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="https://unpkg.com/konva@7.0.6/konva.min.js"></script>
    <body style="height: 100%">


    <div id="canvaswrap" style="margin-left: auto;margin-right: auto">
      <div id="container"></div>
    </div>
    <div id="canvaswrapInsitu" style="display: none;">
      <div id="containerInsitu"></div>
    </div>
    <div style="position: absolute; background-color: white; text-align: center; width: 100%; height: 100%; top: 0">processing...<br/><img src="images/Barline-Loading-Images-1.gif" /></div>
  </body>
  </html>
<script>
var thecanvaswidth = <?php echo $canvas_width; ?>;

var width = <?php echo $canvas_width; ?>;
var height = <?php echo $canvas_height; ?>;
$('#container').css('width', width);


var stage = new Konva.Stage({
    container: 'container',
    width: width,
    height: height
});

var layer = new Konva.Layer();
      stage.add(layer);

// main image:
var imageObj = new Image();
imageObj.onload = function () {
  var yoda = new Konva.Image({
    x: 0,
    y: 0,
    image: imageObj,
    width: width,
    height: height,
  });

  // add the shape to the layer
  layer.add(yoda);
  layer.draw();
};
imageObj.src = '../images/billboards/templates/<?php echo $bezel_filename; ?>';


function scaledFontsize( text,fontface,desiredWidth ){
    desiredWidth = desiredWidth - 20;
    var c=document.createElement('canvas');
    var cctx=c.getContext('2d');
    var testFontsize=18;
    cctx.font=testFontsize+'px '+fontface;
    var textWidth=cctx.measureText(text).width;
    return((testFontsize*desiredWidth/textWidth));
}
var scaledSizeTo = scaledFontsize( '<?php echo $toname; ?>' ,'<?php echo $fontnameUltraLight; ?>', '<?php echo $totextwidth; ?>' );
var scaledSizeFrom = scaledFontsize( '<?php echo $fromname; ?>' ,'<?php echo $fontnameUltraLight; ?>', '<?php echo $fromtextwidth; ?>' );
var messageheight = 70;

//var maxToTextSIze = '<?php echo $totextsize;?>';
//if (scaledSize >= maxToTextSIze) {  scaledSize = maxToTextSIze; }

//sliding max font size for different bb sizes
//for very large bb;
if (thecanvaswidth >= 1200){
  if(scaledSizeTo >= 91){ scaledSizeTo = 91; }
  if(scaledSizeFrom >= 51){ scaledSizeFrom = 51; }
  messageheight = 140;
}else{
  if(scaledSizeTo >= 51){ scaledSizeTo = 51; }
  if(scaledSizeFrom >= 24){ scaledSizeFrom = 24; }
}


//Billboardmessage
var layertext = new Konva.Layer();
stage.add(layertext);


const textHolder = new Konva.Text({
    x: <?php echo $messageX;?>,
    y: <?php echo $messageY;?>,
    text: "<?php echo $billboardmessage;?>",
    fontSize: <?php echo $messagesize;?>,
    fontFamily: '<?php echo $fontnameUltraLight; ?>',
    fontWeight: 'Normal',
    letterSpacing: 1,
    lineHeight: 1.1,
    fill: 'white',
    keepRatio:false,
    width: <?php echo $messagewidth; ?>,
    align: 'center',
    name: 'nameTx',
    id: 'nameTx',
    height: messageheight,
    verticalAlign: 'middle'
});



//Fromtext
var layertextFrom = new Konva.Layer();
stage.add(layertextFrom);
const textHolderFrom = new Konva.Text({
    x: <?php echo $fromtextX;?>,
    y: <?php echo $fromtextY;?>,
    text: "<?php echo $fromname;?>",
//    fontSize: <?php echo $fromtextsize;?>,
    fontSize: scaledSizeFrom,
    fontFamily: '<?php echo $fontnameUltraLight; ?>',
    fontWeight: 'Normal',
    fill: '#c16566',
    keepRatio:false,
    width: <?php echo $fromtextwidth; ?>,
    align: 'center',
    name: 'nameTx',
    id: 'nameTx',
    height: 50,
    verticalAlign: 'top'
});


//Totext
var layertextTo = new Konva.Layer();
stage.add(layertextTo);
const textHolderTo = new Konva.Text({
    x: <?php echo $totextX;?>,
    y: <?php echo $totextY;?>,
    text: "<?php echo $toname;?>",
////    fontSize: <?php echo $totextsize;?>,
    fontSize: scaledSizeTo,
    fontFamily: '<?php echo $fontnameUltraLight; ?>',
    fontWeight: 'Normal',
    fill: 'white',
    keepRatio:false,
    width: <?php echo $totextwidth; ?>,
    align: 'center',
    name: 'nameTx',
    id: 'nameTx',
    height: 50,
    verticalAlign: 'bottom'
});



const groupWithText = new Konva.Group();
setTimeout( function(){
  groupWithText.add(textHolder);
  groupWithText.add(textHolderTo);
  groupWithText.add(textHolderFrom);
  //activate Text
  layertext.add(groupWithText);
  layertext.draw();
  layertext.draw();
  layertext.moveToTop();
},1000)


setTimeout(function(){
        makeBillboard();
  },4000
)
function makeBillboard(){

          console.log('get approval');
          var dataURL = stage.toDataURL({ pixelRatio: 1 });
          $.ajax({
            url: "../savefile.php",
            type: "post",
            data: {"data":dataURL, "compositfilename":'<?php echo $compositfilename; ?>', "idbillboard":'<?php  echo $idbillboard  ?>', "iduser":'<?php  echo $iduser  ?>', "idcampaign":'<?php  echo $idcampaign  ?>', "uniquesession":'<?php  echo $uniquesession  ?>' } ,
            success: function (response) {
              console.log(response);
              //$("#submitstep4").css('display', 'block');
              //$("#save").css('display', 'block');
            },
            error: function(jqXHR, textStatus, errorThrown) {
              console.log(textStatus, errorThrown);
            },
            async: false
          });
          //create insitu image
          setTimeout(function(){
                  makeInsitu();
            },4000
          )

}

//makeInsitu();

function makeInsitu(){
  widthinsitu = <?php echo $billboard_insitu_png_width; ?>;
  heightinsitu= <?php echo $billboard_insitu_png_height; ?>;
  insitu_width= <?php echo $insitu_width; ?>;
  insitu_height= <?php echo $insitu_height; ?>;
  insitu_pos_x= <?php echo $insitu_pos_x; ?>;
  insitu_pos_y= <?php echo $insitu_pos_y; ?>;

  var stageInsitu = new Konva.Stage({
      container: 'containerInsitu',
      width: widthinsitu,
      height: heightinsitu
  });

  // main image:
  var layerInsitu = new Konva.Layer();
  stageInsitu.add(layerInsitu);
  var imageObjInsitu = new Image();
  imageObjInsitu.onload = function () {
    var bginsit = new Konva.Image({
      x: 0,
      y: 0,
      image: imageObjInsitu,
      width: widthinsitu,
      height: heightinsitu,
    });
    layerInsitu.add(bginsit);
    layerInsitu.draw();
  };
  imageObjInsitu.src = '../images/billboards/insitu/<?php echo $billboard_insitu_png; ?>';

  // bill image:
  var layerBB = new Konva.Layer();
  stageInsitu.add(layerBB);
  var imageObjBB = new Image();
  imageObjBB.onload = function () {
    var bbinsit = new Konva.Image({
      x: insitu_pos_x,
      y: insitu_pos_y,
      image: imageObjBB,
      width: insitu_width,
      height: insitu_height,
    });
    // add the shape to the layer
    layerBB.add(bbinsit);
    layerBB.draw();
  };
  imageObjBB.src = '../usercomposits/<?php echo $compositfilename; ?>';
  //imageObjBB.src = '../approvedcomposits/<?php echo $campaignbasename; ?>/<?php echo $billboardcode1; ?>/<?php echo $displayfilename; ?>';
  var iscomplete = 0;
    setTimeout(function(){
      var dataURLInsitu = stageInsitu.toDataURL({ pixelRatio: 1 });
      $.ajax({
        url: "../saveinsitu.php",
        type: "post",
        data: {"data":dataURLInsitu, "insitufilename":'<?php echo $insitufilename; ?>', "idbillboard":'<?php  echo $idbillboard  ?>', "iduser":'<?php  echo $iduser  ?>', "idcampaign":'<?php  echo $idcampaign  ?>', "uniquesession":'<?php  echo $uniquesession  ?>' } ,
        success: function (response) {
          iscomplete = 1;
          console.log('1. ' +response);
        },
        error: function(jqXHR, textStatus, errorThrown) {
          console.log(textStatus, errorThrown);
        },
        async: false
      });
      console.log('2. usercomposits/<?php echo $compositfilename; ?>');
      console.log('3. ' + iscomplete + 'usercomposits/<?php echo $insitufilename; ?>');
      if(iscomplete == 1) {
       window.location.href = "editsubmission.php?id=<?php echo $userid; ?>&idcampaign=<?php echo $idcampaign; ?>?<?php echo date('His');  ?>";
      }
    },2000)

}
</script>

<?php


// Close connection
mysqli_close($link);
/////header("Location: editsubmission.php?id=$userid&idcampaign=$idcampaign");

?>
