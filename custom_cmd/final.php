

<!DOCTYPE html>
<html lang="en">
    <head>
    <?php
exec("rm /opt/lampp/htdocs/web/alpha_omega/wp-content/uploads/part-00000 2>&1",$output, $return_var);
#echo $output[0];
exec("sudo /usr/local/hadoop/bin/hadoop fs -get /alpha_omega/web_out/part-00000 /opt/lampp/htdocs/web/alpha_omega/wp-content/uploads/ 2>&1",$output, $return_var);


#$fp = fopen('/opt/lampp/htdocs/web/alpha_omega/wp-content/uploads/part-00000','r');
$file = file('/opt/lampp/htdocs/web/alpha_omega/wp-content/uploads/part-00000');
$GLOBALS['states']=array();
$GLOBALS['sales']=array();
foreach($file as $line)
  { 
 #print_r(fgetcsv($file,"\t"));
     $out=preg_split("/[\t]/", $line);
     array_push($states,$out[0]);
     array_push($sales,$out[1]);
}


?>

        <meta charset="utf-8" />
        <title>Sales Report</title>
        <!-- import plugin script -->
        <script src='Chart.min.js'></script>
    </head>
    <body>

   
        <!-- bar chart canvas element -->
        <canvas id="income" width="1100" height="600"></canvas>
          <!-- pie chart canvas element -->
        <canvas id="countries" width="400" height="400"></canvas>
        <script>
            var jArray=<?php echo json_encode($states);?>;
            var jArray2=<?php echo json_encode($sales);?>;
            // line chart data
            var sum=0
            for (var i = 0; i < jArray2.length; i++) {
            sum=sum+parseInt(jArray2[i]);
            }

            
            for (var i = 0; i < jArray2.length; i++) {
            
            jArray2[i]=((jArray2[i]*360)/sum);
            //console.log(jArray2[i]);
            }




function randomColor() {
  return "#000000".replace(/0/g,function(){return (~~(Math.random()*16)).toString(16);});
}
var pieData=[];
for (var i = 0; i < jArray2.length; i++) {
        pieData.push({value: jArray2[i],color: randomColor(),label: jArray[i],labelColor : 'white',
                labelFontSize : '16'})
    
}


/*var pieData = [
                {
                    value: 03,
                    color:randomColor()
                },
                {
                    value : 80,
                    color : randomColor()
                },
                {
                    value : 05,
                    color : randomColor()
                },
                {
                    value : 05,
                    color : randomColor()
                }
            ];*/
            // pie chart options
            var pieOptions = {
                 segmentShowStroke : false,
                 animateScale : true,
                 showAllTooltips: true,
        
            }
            // get pie chart canvas
            var countries= document.getElementById("countries").getContext("2d");
            // draw pie chart
            new Chart(countries).Pie(pieData, pieOptions);
            

var barData = {
    labels : jArray,
    datasets : [
        {
            fillColor : "#48A497",
            strokeColor : "#48A4D1",
            data : jArray2
        },

    ]
}
           // get bar chart canvas
            var income = document.getElementById("income").getContext("2d");
            // draw bar chart
            new Chart(income).Bar(barData);
 


        </script>
    </body>
</html>


