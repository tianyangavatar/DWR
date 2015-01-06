<?php
    define('HEXSTARTCOLOR', "00CC33");
    define('HEXENDCOLOR', "999999");
    define("HUNDREDCOLOR", "00CC00");
    define('CHWORDLEN',7);
    define('ENGWORDLEN', 4);
    define('PERCENT', 5);
    /**
    * coding by Yt for static progress chart using html items;
    */
   
    class ProStatChart
    {
        private $start_color;
        private $end_color;
        private $saturationnamesize;
        private $saturationnamecolor;

        function __construct($start_color,$end_color)
        {
            $this->start_color = $start_color;
            $this->end_color = $end_color;
            $this->saturationnamesize=1;
            $this->saturationnamecolor="#000000";
        }

        function GetProgressChart($pro_length,$pro_height,$progress,$border)
        {
            $progress = ($progress>=1.0)?1.0:$progress;
            $length = $pro_length;
            $height = $pro_height;
       
            $textlength = 40;
            $totallen = $length+$textlength;
           
            $str ="<div style='width:".$totallen."px;height:".$height."px;border:".$border."px solid #000000'>";
            $str = $str."<div style='border:1px solid #000000;float:left;display:inline;position:relative;width:"
            .$length."px;height:".$height
            ."px;overflow:hidden'><div style='position:absolute;left:0px;top:0px;background:#"
            ."ffffff".";overflow:hidden;width:100%;text-align:right;height:".$height."'>";
    
            $col = $this->GetHexColor($this->start_color,$this->end_color,$progress);
            $l = $length;
            $h = $height;
            $l = intval($l*$progress);
        
            $progress = $progress*100;

            $n = $h/20;
            for($i=0;$i<$n;$i=$i+1)
            {
                $ii =20;
                $str .="<div style='background:#$col;width:".$l."px;height:"."20"."px;overflow:hidden'>
                <font color='#".$col."'>|</font></div>";
            }
            $str.="</div></div>
            <div style='display:inline;float:right;width:".($textlength-2)."px;height:".$h."px'>$progress%</div></div>";
            return $str;
        }

    //$chart_length for total chart length 100% saturation,$chart_height for total chart height
    //$saturationname for user define 
    //$saturation for percent declare staff work status
    //$progressarray for express the saturation ex "you need to work hard","0-50";"you work so hard","120->"
    function GetSaturationChart($chart_length,$chart_height,$hundredstaturationname,$saturation,$progressarray)
    {
        $ltop = $this->GetLargeSaturationTop($progressarray);
        $saturation = ($saturation>$ltop)?$ltop:$saturation;
        $len = 0;
        foreach ($progressarray as $progress => $progress_text) {
            $len_t = strlen($progress_text);
            if($len < $len_t)
                $len = $len_t;
        }

        $len = (strlen($hundredstaturationname)>$len)?strlen($hundredstaturationname):$len;
        $width = $chart_length + CHWORDLEN*$len; //3px for a word chinease word for 5
        $height = $chart_height;
        $str = "<div style='width:".$width."px;height:".$height."px;border:1px solid #000'>";

        $saturationname = $this->GetSaturationName(intval($saturation*100),$progressarray);
        $strsaturation = intval($saturation*100);

        $saturation_div_width = intval($saturation*$chart_length)+(strlen($saturationname)+PERCENT)*CHWORDLEN;
        $saturation_div_height = intval($chart_height/2);
        $saturation_subdiv_width_chart = intval($saturation*$chart_length);
        $saturation_subdiv_height_chart = intval($chart_height/2);
        $saturation_subdiv_color_chart = $this->GetHexColor(HEXSTARTCOLOR,HEXENDCOLOR,$saturation);
        //dechex(intval( (hexdec(HEXENDCOLOR)-hexdec(HEXSTARTCOLOR))*$saturation + HEXSTARTCOLOR ) );
        $saturation_subdiv_chart_text_color = $saturation_subdiv_color_chart;
        $saturation_subdiv_width_text = (strlen($saturationname)+PERCENT)*CHWORDLEN;
        $saturation_subdiv_height_text = intval($chart_height/2);

        if($saturation_div_width>$width)
        {   
            $width = $saturation_div_width;
            $str = "<div style='width:".$width."px;height:".$height."px;border:1px solid #000'>";
        }

        $saturation_div = "<div style='width:".$saturation_div_width."px;height:".$saturation_div_height."px'>";
        $saturation_subdiv_chart = "<div style='text-align:right;overflow:hidden;float:left;display:inline;width:".$saturation_subdiv_width_chart
        ."px;height:".$saturation_subdiv_height_chart."px;background:#".$saturation_subdiv_color_chart."'>";
        $saturation_subdivchart_text = "<font color='#".$saturation_subdiv_chart_text_color."'>|</font>";
        $saturation_subdiv_text = "<div style='float:right;display:inline;width:"
        .$saturation_subdiv_width_text."px;height:".$saturation_subdiv_height_text."px'>";

        $top_saturationchart = $saturation_div.$saturation_subdiv_chart.$saturation_subdivchart_text."</div>"
        .$saturation_subdiv_text.$strsaturation."%".$saturationname."</div>"."</div>";

        $hundred_saturationwidth = $chart_length + strlen($hundredstaturationname)*CHWORDLEN;
        $hundred_saturationheight = intval($chart_height/2);
        $hundred_saturationwidth_subdiv_chart = $chart_length;
        $hundred_saturationheight_subdiv_chart = intval($chart_height/2);
        $hundred_saturationcolor_subdiv_chart = HUNDREDCOLOR;
        $hundred_saturationtextcolor_subdiv_chart = HUNDREDCOLOR;
        $hundred_saturationwidth_subdiv_text = strlen($hundredstaturationname)*CHWORDLEN;
        $hundred_saturationheight_subdiv_text = intval($chart_height/2);

        $hundredstaturationdiv = "<div style='width:".$hundred_saturationwidth."px;height:".$hundred_saturationheight."px'>";
        $hundredstaturationdiv_subchart = "<div style='text-align:right;overflow:hidden;float:left;display:inline;width:
        ".$hundred_saturationwidth_subdiv_chart."px;height:".$hundred_saturationheight_subdiv_chart."px;background:#".
        $hundred_saturationcolor_subdiv_chart."'>";
        $hundredstaturationdiv_subchart_text = "<font color='#".$hundred_saturationcolor_subdiv_chart."'>|</font>";
        $hundredstaturationdiv_subtext = "<div style='float:right;display:inline;width:"
        .$hundred_saturationwidth_subdiv_text."px;height:".$hundred_saturationheight_subdiv_text."px'>";
        $bottom_saturationchart = $hundredstaturationdiv.$hundredstaturationdiv_subchart.$hundredstaturationdiv_subchart_text."</div>"
        .$hundredstaturationdiv_subtext."<p style='font-size:".$this->saturationnamesize.";color:".$this->saturationnamecolor."'>"
        .$hundredstaturationname."</p></div>"."</div>";
        
        return $str.$top_saturationchart.$bottom_saturationchart."</div>";
     }

     function GetSaturationName($saturation,$progressarray)
     {
         foreach ($progressarray as $progress => $progress_text) {
            $temp_progress = explode("-", $progress);
            $left_v = $temp_progress[0];
            $right_v = $temp_progress[1];
            if($saturation <= $right_v&&$saturation>=$left_v)
                return $progress_text;
        }
     }

     function GetHexColor($startc,$endc,$percent)
     {
        //echo "startc=$startc   $endc";
        $redhex_s = substr($startc, 0,2);
        $greenhex_s = substr($startc, 2,2);
        $bluehex_s = substr($startc, 4,2);

        $reddoc_s = hexdec($redhex_s);
        $greendoc_s = hexdec($greenhex_s);
        $bluedoc_s = hexdec($bluehex_s);

        $redhex_e = substr($endc, 0,2);
        $greenhex_e = substr($endc, 2,2);
        $bluehex_e = substr($endc, 4,2);

        $reddoc_e = hexdec($redhex_e);
        $greendoc_e = hexdec($greenhex_e);
        $bluedoc_e = hexdec($bluehex_e);
        $r_len = abs($reddoc_e-$reddoc_s);
        $g_len = abs($greendoc_e-$greendoc_s);
        $b_len = abs($bluedoc_e-$bluedoc_s);

        $reddoc_s = ($reddoc_s<$reddoc_e)?$reddoc_s:$reddoc_e;
        $reddoc_e = ($reddoc_e>$reddoc_s)?$reddoc_e:$reddoc_s;

        $greendoc_s = ($greendoc_s<$greendoc_e)?$greendoc_s:$greendoc_e;
        $greendoc_e = ($greendoc_e>$greendoc_s)?$greendoc_e:$greendoc_s;

        $bluedoc_s = ($bluedoc_s<$bluedoc_e)?$bluedoc_s:$bluedoc_e;
        $bluedoc_e = ($bluedoc_e>$bluedoc_e)?$bluedoc_e:$bluedoc_s;

        $res_doc_red_doc = $reddoc_s;
        $res_doc_green_doc = $greendoc_s ;
        $res_doc_blue_doc = $bluedoc_s;

        if($r_len>$g_len&&$r_len>$b_len)      
            $res_doc_red_doc = ($reddoc_s + intval($percent*$r_len))%255;
        if($g_len>$r_len&&$g_len>$b_len)
            $res_doc_green_doc = ($greendoc_s + intval($percent*$g_len))%255;
        if($b_len>$r_len&&$b_len>$g_len)
            $res_doc_blue_doc = ($bluedoc_s + intval($percent*$b_len))%255;

        $res_doc_red_hex = dechex($res_doc_red_doc);
        $res_doc_red_hex = (strlen($res_doc_red_hex)==1)?"0".$res_doc_red_hex:$res_doc_red_hex;
        $res_doc_green_hex = dechex($res_doc_green_doc);
        $res_doc_green_hex = (strlen($res_doc_green_hex)==1)?"0".$res_doc_green_hex:$res_doc_green_hex;
        $res_doc_blue_hex = dechex($res_doc_blue_doc);
        $res_doc_blue_hex = (strlen($res_doc_blue_hex)==1)?"0".$res_doc_blue_hex:$res_doc_blue_hex;
        return $res_doc_red_hex.$res_doc_green_hex.$res_doc_blue_hex;
    }
    function GetLargeSaturationTop($progressarray)
    {
         foreach ($progressarray as $progress => $progress_text) {
            $temp_progress = explode("-", $progress);
            $left_v = $temp_progress[0];
            $right_v = $temp_progress[1];
            $res = 0;
            if($res <= $right_v)
                $res = $right_v;
        }
        return floatval($res/100);
    }

    function SetHundredSaturationnamesize($size)
    {
        $this->saturationnamesize=$size;
    }
    function SetHundredSaturationnamecolor($color)
    {
        $this->saturationnamecolor=$color;
    }
 }
?>
