<?php
namespace App\helpers;
use App\Models\sanction\Sanction;
use App\Models\comment\Comment;
use Illuminate\Support\Facades\Log;
use Auth;

class commentHelper
{
    public static function addComment($id,$comments, $colVal)
    {
     
        $tbl_hlcomments = new comment;
        $dColVal = $colVal.'_id';
        
        $tbl_hlcomments->comments = $comments;
        $tbl_hlcomments->$dColVal = $id;
        $tbl_hlcomments->updated_by = Auth::user()->email;
        $tbl_hlcomments->created_by = Auth::user()->firstname.' '.Auth::user()->lastname;

       
        $tbl_hlcomments->save();
        // return $tbl_hlcomments;

     
    }

    public static function int_to_words($x)
    {
        $nwords = array("Zero", "One", "Two", "Three", "Four", "Five", "Six", "Seven", "Eight", "Nine", "Ten", "Eleven", "Twelve", "Thirteen", "Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eighteen", "Nineteen", "Twenty", 30 => "Thirty", 40 => "Forty", 50 => "Fifty", 60 => "Sixty", 70 => "Seventy", 80 => "Eighty", 90 => "Ninety" );

        $x = intval($x);

        if($x==0) { $w = 'Zero';  }
        else
        {
            $w = '';
            if($x < 21) { $w .= $nwords[$x]; }
            else if($x < 100)
            {
                $w .= $nwords[10 * floor($x/10)];
                $r = fmod($x, 10);
                if($r > 0) { $w .= ' '. $nwords[$r]; }
            }
            else if($x < 1000)
            {
                $w .= $nwords[floor($x/100)] .' Hundred';
                $r = fmod($x, 100);
                if($r > 0) { $w .= ' And '. int_to_words($r); }
            }
            else if($x < 100000)
            {
                $w .= int_to_words(floor($x/1000)) .' Thousand';
                $r = fmod($x, 1000);
                if($r > 0) { $w .= ' '; if($r < 100) { $w .= 'And '; } $w .= int_to_words($r); }
            }
            else
            {
                $w .= int_to_words(floor($x/100000)) .' Lakh';
                $r = fmod($x, 100000);
                if($r > 0)
                {
                    $w .= ' ';
                    if($r < 100) { $word .= ' And '; }
                    $w .= int_to_words($r);
                }
            }
        }

        return $w;
    }

    public static function int_to_wordsbyts($x)
    {
        $x = $x.'.00';
        $arpt = explode(".",$x);
        $ptone = $arpt[0];
        $pttow = $arpt[1];

        $x = intval($x);
        $no = round($x);
        $point = round($x - $no, 2) * 100;

        $hundred = null;
        $digits_1 = strlen($no);
        $i = 0;
        $str = array();
        $words = array('0' => 'Zero', '1' => 'One', '2' => 'Two',
            '3' => 'Three', '4' => 'Four', '5' => 'Five', '6' => 'Six',
            '7' => 'Seven', '8' => 'Eight', '9' => 'Nine',
            '10' => 'Ten', '11' => 'Eleven', '12' => 'Twelve',
            '13' => 'Thirteen', '14' => 'Fourteen',
            '15' => 'Fifteen', '16' => 'Sixteen', '17' => 'Seventeen',
            '18' => 'Eighteen', '19' =>'Nineteen', '20' => 'Twenty',
            '30' => 'Thirty', '40' => 'Forty', '50' => 'Fifty',
            '60' => 'Sixty', '70' => 'Seventy',
            '80' => 'Eighty', '90' => 'Ninety');
        $digits = array('', 'Hundred', 'Thousand', 'Lakh', 'Crore');
        while ($i < $digits_1) {
            $divider = ($i == 2) ? 10 : 100;
            $x = floor($no % $divider);
            $no = floor($no / $divider);
            $i += ($divider == 10) ? 1 : 2;
            if ($x) {
                $plural = (($counter = count($str)) && $x > 9) ? 's' : null;
                $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
                $str [] = ($x < 21) ? $words[$x] .
                    " " . $digits[$counter] . $plural . " " . $hundred
                    :
                    $words[floor($x / 10) * 10]
                    . " " . $words[$x % 10] . " "
                    . $digits[$counter] . $plural . " " . $hundred;
            } else $str[] = null;
        }
        $str = array_reverse($str);
        $result = implode('', $str);
        if($result==null || $result=="") $result='Zero';

        $pnts = $pttow;

        $points = ($pttow) ?
            "" . $words[$pttow / 10] . " " .
                $words[$pttow = $pttow % 10] : '';

        if($pnts > 0) {
            $w = $result . " And " . $points . " Paise";
        } else {
            $w = $result . "";
        }

        return $w;

    }

}
